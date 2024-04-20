<?php

namespace app\repositories;

use app\models\Customer;
use Doctrine\ORM\EntityRepository;

class CustomerRepository extends BaseRepository
{
    protected function getEntityClass(): string
    {
        return Customer::class;
    }

    public function findByID(string $id)
    {
        return $this->getEntityRepository()->findOneBy(['id' => $id]);
    }
}