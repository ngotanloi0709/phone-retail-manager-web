<?php

namespace app\controllers;

use app\services\AuthenticationService;
use League\Plates\Engine;
use app\services\TransactionService;
use app\services\ProductService;
use app\services\CustomerService;
use app\services\TransactionDetailService;
use app\services\Cus;
use Doctrine\Common\Collections\Collection;

class TransactionController extends Controller
{
    private TransactionService $transactionService;
    private ProductService $productService;
    private CustomerService $customerService;

    public function __construct(Engine $engine, AuthenticationService $authenticationService,
                                TransactionService $transactionService, ProductService $productService,
                                CustomerService $customerService, TransactionDetailService $transactionDetailService)
    {
        parent::__construct($engine, $authenticationService);
        $this->transactionService = $transactionService;
        $this->productService = $productService;
        $this->customerService = $customerService;
        $this->transactionDetailService = $transactionDetailService;
    }

    public function index(): void
    {
        $this->render('transaction/transaction');
    }

    public function getTransactionManagement(): void
    {
        $transactions = $this->transactionService->getTransactions();
        $this->render('transaction/transaction_management', ['transactions' => $transactions]);
    }

    public function getTransactionCreate(): void
    {
        $products = $this->productService->getProducts();
        $this->render('transaction/transaction_create', ['products' => $products]);
    }

    public function postTransaction(): void
    {
        $givenMoney = str_replace(",", "", $_POST['total']);
        $givenMoney = (int)$givenMoney;
        $items = new \Doctrine\Common\Collections\ArrayCollection();
        $productIdArray = $_POST['productId'];
        $productQuantityArray = $_POST['productQuantity'];
        $user = $this->authenticationService->getCurrentUser();
        $customer = $this->customerService->getCustomernById($_POST["customerId"]);

        if ($this->transactionService->createTransaction($givenMoney, $items, $user, $customer)) {
            $transactions = $this->transactionService->getTransactions();
            $order = $this->transactionService->getTransactionById($transactions[sizeof($transactions) - 1]->getId());
            for ($i = 0; $i < sizeof($productIdArray); $i++) {
                $product = $this->productService->getProductById($productIdArray[$i]);
                $quantity = $productQuantityArray[$i];
                $item = $this->transactionDetailService->createTransactionDetail($order, $product, $quantity);
                $items->add($item);
            }
            $order->setItems($items);
            
            $_SESSION['alerts'][] = 'Tạo giao dịch thành công';
            header('Location: /transaction/transaction_management');
        } else {
            $_SESSION['alerts'][] = 'Tạo giao dịch thất bại';
            header('Location: /transaction/transaction_create');
        }
    }

    public function getData(): void
    {
        $products = $this->productService->getProducts();
        $customers = $this->customerService->getCustomers();
        $this->render('transaction/get_data', ['products' => $products, 'customers' => $customers]);
    }

    public function getTransactionDetail(): void
    {
        $transactionId = $_GET['transactionId'];
        $transactionDetails = $this->transactionDetailService->getTransactionDetailsByTransactionId($transactionId);
        $this->render('transaction/transaction_detail', ['transactionDetails' => $transactionDetails]);
    }
}