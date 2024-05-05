<?php

namespace app\services;

use app\dto\CreateTransactionDTO;
use app\models\Transaction;
use app\repositories\TransactionDetailRepository;
use app\repositories\TransactionRepository;
use app\utils\TransactionValidateHelper;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Exception;

class TransactionService
{
    public function __construct(
        private readonly TransactionRepository    $transactionRepository,
        private readonly TransactionDetailRepository $transactionDetailRepository,
        private readonly AuthenticationService    $authenticationService,
        private readonly CustomerService          $customerService,
        private readonly ProductService           $productService,
        private readonly TransactionDetailService $transactionDetailService,
    )
    {
        //
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function createTransaction(CreateTransactionDTO $createTransactionDTO): bool
    {
        try {
            $customerPhone = $createTransactionDTO->getCustomerPhone();

            $user = $this->authenticationService->getCurrentUser();
            $customer = $this->customerService->getCustomerByPhone($customerPhone);
            $givenMoney = $createTransactionDTO->getGivenMoney();
            $productIdArray = $createTransactionDTO->getProductIdArray();
            $productQuantityArray = $createTransactionDTO->getProductQuantityArray();

            if ($user === null) {
                $_SESSION['alerts'][] = 'Người dùng không tồn tại, vui lòng đăng nhập!';
                return false;
            }

            if ($customer === null && TransactionValidateHelper::isValidPhoneNumber($customerPhone)) {
                $customer = $this->customerService->createCustomer($customerPhone);
            }

            if ($customer === null) {
                $_SESSION['alerts'][] = 'Số điện thoại không hợp lệ';
                return false;
            }

            $error = TransactionValidateHelper::validateTransactionInformation($productIdArray, $productQuantityArray, $givenMoney);

            if (!empty($error)) {
                $_SESSION['alerts'][] = $error['product'];
                return false;
            }

            $transaction = new Transaction($givenMoney, $user, $customer);
            $this->transactionRepository->save($transaction);

            for ($i = 0; $i < sizeof($productIdArray); $i++) {
                $product = $this->productService->getProductById($productIdArray[$i]);
                $quantity = $productQuantityArray[$i];
                $this->transactionDetailService->createTransactionDetail($transaction, $product, $quantity);
            }
        } catch (Exception $e) {
            return false;
        }

        return true;
    }

    public function getTransactionById(string $id)
    {
        return $this->transactionRepository->findByID($id);
    }

    public function getTransactions(): array
    {
        return $this->transactionRepository->findAll();
    }


    public function getTransactionsByUserId(string $userId): array
    {
        return $this->transactionRepository->findByIdWithDetails($userId);
    }
}