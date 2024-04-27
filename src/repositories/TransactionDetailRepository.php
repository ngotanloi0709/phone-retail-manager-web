<?php

namespace app\repositories;

use app\models\Transaction;
use app\models\TransactionDetail;
use Doctrine\ORM\EntityRepository;

class TransactionDetailRepository extends BaseRepository
{
    protected function getEntityClass(): string
    {
        return TransactionDetail::class;
    }

    public function findByID(string $id)
    {
        return $this->getEntityRepository()->findOneBy(['id' => $id]);
    }
}