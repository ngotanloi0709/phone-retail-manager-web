<?php

namespace app\repositories;

use app\models\Customer;
use Doctrine\ORM\EntityRepository;

class CustomerRepository extends BaseRepository
{
    public function findByPhone(?string $phone)
    {
        return $this->getEntityRepository()->findOneBy(['phone' => $phone]);
    }

    protected function getEntityClass(): string
    {
        return Customer::class;
    }

    public function findByID(string $id)
    {
        return $this->getEntityRepository()->findOneBy(['id' => $id]);
    }
}