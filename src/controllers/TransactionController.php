<?php

namespace app\controllers;

use app\dto\CreateTransactionDTO;
use app\services\AuthenticationService;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use League\Plates\Engine;
use app\services\TransactionService;
use app\services\ProductService;
use app\services\CustomerService;
use app\services\TransactionDetailService;
use app\services\Cus;
use Doctrine\Common\Collections\Collection;
use app\repositories\ProductRepository;
use app\repositories\TransactionRepository;

class TransactionController extends Controller
{
    public function __construct(
        Engine                                    $engine,
        AuthenticationService                     $authenticationService,
        private readonly TransactionService       $transactionService,
        private readonly TransactionDetailService $transactionDetailService,
        private readonly ProductRepository        $productRepository,
        private readonly TransactionRepository    $transactionRepository,
        private readonly ProductService           $productService,
        private readonly CustomerService          $customerService,
    )
    {
        parent::__construct($engine, $authenticationService);
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

    public function getTransactionCheckout(): void
    {
        $products = $this->productService->getProducts();
        $productIdArray = $_GET['productId'];
        $productQuantityArray = $_GET['productQuantity'];
        $this->render('transaction/transaction_checkout', ['products' => $products, 'productIdArray' => $productIdArray,
                                                            'productQuantityArray' => $productQuantityArray]);
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function postTransaction(): void
    {
        $products = $this->productService->getProducts();

        if ($_POST['createNewCustomer'] == 'yes') {
            $this->customerService->createCustomer($_POST['customerPhone']);
            $customer = $this->customerService->getCustomerByPhone($_POST['customerPhone']);
            $customer->setName($_POST['customerName']);
            $customer->setAddress($_POST['customerAddress']);
            $_SESSION['alerts'][] = 'Tạo giao tài khoản khách hàng thành công';
        }

        $createTransactionDTO = new CreateTransactionDTO();
        $createTransactionDTO->fromRequest($_POST);

        if ($this->transactionService->createTransaction($createTransactionDTO)) {
            foreach ($_POST['productId'] as $key => $productId) {
                $product = $this->productService->getProductById($productId);
                $product->setStock($product->getStock() - $_POST['productQuantity'][$key]);
                $this->productRepository->save($product);
            }

            if ($_POST['paymentMethod'] == 'cash') {
                $givenMoney = $_POST['givenMoney'];
                $givenMoney = str_replace(',', '', $givenMoney);
                header("Location: /transaction/transaction_management?paymentMethod=cash&givenMoney=" . $givenMoney);
            }
            else {
                header('Location: /transaction/transaction_management?paymentMethod=card');
            }
            $_SESSION['alerts'][] = 'Tạo đơn hàng thành công';
        } else {
            $_SESSION['alerts'][] = 'Tạo đơn hàng thất bại';
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

    public function getTransactionInvoice(): void
    {
        $transactions = $this->transactionService->getTransactions();
        $this->render('transaction/transaction_invoice', ['transactions' => $transactions]);
    }

    public function cancelTransaction() : void 
    {
        $transaction = $this->transactionService->getTransactionById($_POST['transId']);
        $transaction->setIsCanceled(true);
        $transaction->setGivenMoney(0);
        $this->transactionRepository->save($transaction);
        
        foreach ($transaction->getItems() as $item) {
            $product = $this->productService->getProductById($item->getProduct()->getId());
            $product->setStock($product->getStock() + $item->getQuantity());
            $this->productRepository->save($product);
        }
        echo 'success';
    }
}