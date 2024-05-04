<?php

namespace app\services;

use app\models\Customer;
use app\models\Transaction;
use app\repositories\CustomerRepository;
use app\utils\Logger;
use app\utils\AuthenticationValidateHelper;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use app\dto\EditCustomerInformationDTO;
use Exception;
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
    public function getCustomerByID(string $id)
    {
        return $this->customerRepository->findByID($id);
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
    /**
     * @throws ORMException
     */
    public function editCustomer(EditCustomerInformationDTO $editCustomerInformationDTO): bool
    {
        try {
            $customer = $this->customerRepository->find($editCustomerInformationDTO->getId());

            if ($customer == null) {
                $_SESSION['alerts'][] = 'Khách hàng không tồn tại';
                return false;
            }

            $customer->setName($editCustomerInformationDTO->getName());
            $customer->setPhone($editCustomerInformationDTO->getPhone());
            $customer->setAddress($editCustomerInformationDTO->getAddress());
            $customer->setEmail($editCustomerInformationDTO->getEmail());

            $this->customerRepository->save($customer);


            
        } catch (Exception $e) {
            return false;
        }

        return true;
    }
}