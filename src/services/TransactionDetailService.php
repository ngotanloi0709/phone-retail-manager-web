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

    public function __construct(
        private readonly TransactionDetailRepository $transactionDetailRepository,
    )
    {
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function createTransactionDetail(Transaction $transaction, Product $product, int $quantity): TransactionDetail
    {
        $transactionDetail = new TransactionDetail($transaction, $product, $quantity);
        $this->transactionDetailRepository->save($transactionDetail);
        return $transactionDetail;
    }
}