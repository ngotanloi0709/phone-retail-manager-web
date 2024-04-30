<?php

namespace app\services;

use app\models\Customer;
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

    public function getCustomers(): array
    {
        return $this->customerRepository->findAll();
    }

    public function getCustomerByPhone(?string $phone)
    {
        return $this->customerRepository->findByPhone($phone);
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function createCustomer(?string $customerPhone): Customer
    {
        $customer = $this->customerRepository->findByPhone($customerPhone);

        if ($customer === null) {
            $customer = new Customer($customerPhone);
            $this->customerRepository->save($customer);
        }

        return $customer;
    }
}