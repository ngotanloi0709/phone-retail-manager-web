<?php

namespace app\controllers;

use app\services\AuthenticationService;
use League\Plates\Engine;
use app\services\TransactionService;
use app\services\ProductService;
use app\services\CustomerService;
use app\services\Cus;
use Doctrine\Common\Collections\Collection;

class StatisticsController extends Controller
{
    private CustomerService $customerService;
    private TransactionService $transactionService;
    private ProductService $productService;
    public function __construct(Engine $engine, AuthenticationService $authenticationService,
                                CustomerService $customerService, TransactionService $transactionService,
                                ProductService $productService)
    {
        parent::__construct($engine, $authenticationService);
        $this->customerService = $customerService;
        $this->transactionService = $transactionService;
        $this->productService = $productService;
    }
    public function index(): void
    {
        $transactions = $this->transactionService->getTransactions();
        $this->render('statistics/statistics', ['transactions' => $transactions]);
    }
    public function getData(): void
    {
        $transactions = $this->transactionService->getTransactions();
        $this->render('statistics/getdata', ['transactions' => $transactions]);
    }
}