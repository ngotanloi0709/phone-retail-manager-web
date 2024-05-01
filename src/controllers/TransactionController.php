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

class TransactionController extends Controller
{
    public function __construct(
        Engine                                    $engine,
        AuthenticationService                     $authenticationService,
        private readonly TransactionService       $transactionService,
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

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function postTransaction(): void
    {
        $createTransactionDTO = new CreateTransactionDTO();
        $createTransactionDTO->fromRequest($_POST);

        if ($this->transactionService->createTransaction($createTransactionDTO)) {
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
}