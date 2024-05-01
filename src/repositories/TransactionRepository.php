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

    public function findAllWithDetails()
    {
        $qb = $this->getEntityManager()->createQueryBuilder();

        $qb->select('t', 'td')
            ->from(Transaction::class, 't')
            ->leftJoin('t.transactionDetails', 'td');

        return $qb->getQuery()->getResult();
    }
}