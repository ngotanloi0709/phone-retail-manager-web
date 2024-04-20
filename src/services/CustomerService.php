<?php

namespace app\services;

use app\models\Transaction;
use app\repositories\CustomerRepository;
use app\utils\Logger;
use app\utils\AuthenticationValidateHelper;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;

class CustomerService
{
    private CustomerRepository $customerRepository;

    public function __construct(CustomerRepository $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */

    public function getCustomernById(string $id)
    {
        return $this->customerRepository->findByID($id);
    }

    public function getCustomers()
    {
        return $this->customerRepository->findAll();
    }
}