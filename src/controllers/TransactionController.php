<?php

namespace app\controllers;

use app\services\AuthenticationService;
use League\Plates\Engine;
use app\services\TransactionService;
use app\services\ProductService;
use app\services\CustomerService;
use app\services\Cus;
use Doctrine\Common\Collections\Collection;

class TransactionController extends Controller
{
    private TransactionService $transactionService;
    private ProductService $productService;
    private CustomerService $customerService;

    public function __construct(Engine $engine, AuthenticationService $authenticationService,
                                TransactionService $transactionService, ProductService $productService,
                                CustomerService $customerService)
    {
        parent::__construct($engine, $authenticationService);
        $this->transactionService = $transactionService;
        $this->productService = $productService;
        $this->customerService = $customerService;
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
        $givenMoney = $_POST['total'];
        // $items = $_POST['items'];
        // khuc na`y Chi chua hieu lam, co can dung collection chua item khong a?
        $items = new \Doctrine\Common\Collections\ArrayCollection();
        $user = $_SESSION['user'];
        $customer = $this->customerService->getCustomernById($_POST["customerId"]);

        if ($this->transactionService->createTransaction($givenMoney, $items, $user, $customer)) {
            $_SESSION['alerts'][] = 'Tạo giao dịch thành công';
            header('Location: /getTransactionManagement');
        } else {
            $_SESSION['alerts'][] = 'Tạo giao dịch thất bại';
            header('Location: /getTransactionCreate');
        }
    }

    public function getData(): void
    {
        $products = $this->productService->getProducts();
        $customers = $this->customerService->getCustomers();
        $this->render('transaction/get_data', ['products' => $products, 'customers' => $customers]);
    }
}