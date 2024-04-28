<?php

namespace app\services;

use app\models\Transaction;
use app\models\Product;
use app\models\TransactionDetail;
use app\repositories\TransactionRepository;
use app\repositories\TransactionDetailRepository;
use app\utils\Logger;
use app\utils\AuthenticationValidateHelper;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;

class TransactionDetailService
{
    private TransactionDetailRepository $transactionDetailRepository;
    private TransactionRepository $transactionRepository;

    public function __construct(TransactionDetailRepository $transactionDetailRepository, TransactionRepository $transactionRepository)
    {
        $this->transactionDetailRepository = $transactionDetailRepository;
        $this->transactionRepository = $transactionRepository;
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function createTransactionDetail(Transaction $order, Product $product, int $quantity): TransactionDetail
    {
        $transactionDetail = new TransactionDetail($order, $product, $quantity);
        $this->transactionDetailRepository->save($transactionDetail);
        return $transactionDetail;
    }

    public function getTransactionDetailById(string $id)
    {
        return $this->transactionDetailRepository->findByID($id);
    }

    public function getTransactionDetails()
    {
        return $this->transactionDetailRepository->findAll();
    }
}