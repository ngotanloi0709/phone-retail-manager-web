<?php

namespace app\controllers;

use app\services\AuthenticationService;
use League\Plates\Engine;
use app\services\TransactionService;
use app\services\ProductService;
use app\services\CustomerService;
use Doctrine\Common\Collections\Collection;
use app\dto\EditCustomerInformationDTO;
class CustomerController extends Controller
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
        $customers = $this->customerService->getCustomers();
        $this->render('customer/customer', ['customers' => $customers]);
    }
    public function getTransactionHistory(): void
    {
        if (isset($_GET['customerid'])) {
            $customerId = $_GET['customerid'];
            $customers = $this->customerService->getCustomerByID($customerId);
            $transactions = $customers->getTransactions();
            $this->render("customer/customer_transhistory", ['customers' => $customers,'transactions' => $transactions]);
        }
        else{
            header('Location: /customer');
            return;
        }
    }
    public function editCustomer(): void
    {
        $editCustomerInformationDTO = new EditCustomerInformationDTO();
        $editCustomerInformationDTO->fromRequest($_POST);

        if ($this->customerService->editCustomer($editCustomerInformationDTO)) {
            $_SESSION['alerts'][] = 'Chỉnh sửa thông tin khách hàng thành công';
        } else {
            $_SESSION['alerts'][] = 'Chỉnh sửa thông tin khách hàng thất bại';
        }

        header('Location: /customer');
    }
}