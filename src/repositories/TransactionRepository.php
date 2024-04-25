<?php

namespace app\repositories;

use app\models\Transaction;
use Doctrine\ORM\EntityRepository;

class TransactionRepository extends BaseRepository
{
    protected function getEntityClass(): string
    {
        return Transaction::class;
    }

    public function findByID(string $id)
    {
        return $this->getEntityRepository()->findOneBy(['id' => $id]);
    }
}