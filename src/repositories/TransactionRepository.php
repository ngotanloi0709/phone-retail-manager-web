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

    public function findAllWithDetails(): array
    {
        $qb = $this->getEntityRepository()->createQueryBuilder('t')
            ->leftJoin('t.items', 'td')
            ->leftJoin('t.user', 'u')
            ->leftJoin('t.customer', 'c')
            ->addSelect('td')
            ->addSelect('u')
            ->addSelect('c');

        return $qb->getQuery()->getResult();
    }
}