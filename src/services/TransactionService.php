<?php

namespace app\services;

use app\models\Transaction;
use app\repositories\TransactionRepository;
use app\utils\Logger;
use app\utils\AuthenticationValidateHelper;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;

class TransactionService
{
    private TransactionRepository $transactionRepository;

    public function __construct(TransactionRepository $transactionRepository)
    {
        $this->transactionRepository = $transactionRepository;
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function createTransaction(int $givenMoney, $items, $user, $customer): bool
    {
        $transaction = new Transaction($givenMoney, $items, $user, $customer);

        $this->transactionRepository->save($transaction);

        return true;
    }

    public function getTransactionById(string $id)
    {
        return $this->transactionRepository->findByID($id);
    }

    public function getTransactions()
    {
        return $this->transactionRepository->findAll();
    }
}