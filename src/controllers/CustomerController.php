<?php

namespace app\controllers;

use app\services\AuthenticationService;
use League\Plates\Engine;
use app\services\TransactionService;
use app\services\ProductService;
use app\services\CustomerService;
use Doctrine\Common\Collections\Collection;
use app\dto\EditCustomerInformationDTO;
use app\repositories\ProductRepository;
use app\repositories\TransactionRepository;

class CustomerController extends Controller
{
    private CustomerService $customerService;
    private TransactionService $transactionService;
    private TransactionRepository $transactionRepository;
    private ProductRepository $productRepository;
    private ProductService $productService;
    public function __construct(Engine $engine, AuthenticationService $authenticationService,
                                CustomerService $customerService, TransactionService $transactionService,
                                TransactionRepository $transactionRepository,
                                ProductRepository $productRepository,
                                ProductService $productService)
    {
        parent::__construct($engine, $authenticationService);
        $this->customerService = $customerService;
        $this->transactionService = $transactionService;
        $this->productService = $productService;
        $this->transactionRepository = $transactionRepository;
        $this->productRepository = $productRepository;
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
    public function deleteCustomer(): void
    {
        $customerId = $_POST['id'];

        if ($this->customerService->deleteCustomer($customerId)) {
            $_SESSION['alerts'][] = 'Xóa khách hàng thành công';
        } else {
            $_SESSION['alerts'][] = 'Khách hàng đã mua hàng, không thể xóa';
        }

        header('Location: /customer');
    }
    public function cancelTransaction(): void
    {
        $transaction = $this->transactionService->getTransactionById($_POST['transId']);
        $transaction->setIsCanceled(true);
        $this->transactionRepository->save($transaction);
        
        foreach ($transaction->getItems() as $item) {
            $product = $this->productService->getProductById($item->getProduct()->getId());
            $product->setStock($product->getStock() + $item->getQuantity());
            $this->productRepository->save($product);
        }
        echo 'success';
    }
}