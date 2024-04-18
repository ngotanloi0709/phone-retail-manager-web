<?php

namespace app\controllers;

use app\services\AuthenticationService;
use League\Plates\Engine;
use app\services\TransactionService;
use app\services\ProductService;

class TransactionController extends Controller
{
    private TransactionService $transactionService;
    private ProductService $productService;

    public function __construct(Engine $engine, AuthenticationService $authenticationService, TransactionService $transactionService, ProductService $productService)
    {
        parent::__construct($engine, $authenticationService);
        $this->transactionService = $transactionService;
        $this->productService = $productService;
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

    public function getSuggestion(): void
    {
        $products = $this->productService->getProducts();
        $_SESSION['logger'][] = "Hello";
        $this->render('transaction/get_suggestion', ['products' => $products]);
    }
}