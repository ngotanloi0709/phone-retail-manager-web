<?php

namespace app\repositories;

use Doctrine\DBAL\LockMode;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;

abstract class BaseRepository extends EntityRepository
{
    protected EntityManager $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function find($id, LockMode|int|null $lockMode = null, int|null $lockVersion = null): ?object
    {
        return $this->entityManager->find($this->getEntityClass(), $id);
    }

    public function findAll(): array
    {
        return $this->entityManager->getRepository($this->getEntityClass())->findAll();
    }

    public function findBy(array $criteria, array|null $orderBy = null, int|null $limit = null, int|null $offset = null): array
    {
        return $this->entityManager->getRepository($this->getEntityClass())->findBy($criteria, $orderBy, $limit, $offset);
    }

    public function findOneBy(array $criteria, array|null $orderBy = null): ?object
    {
        return $this->entityManager->getRepository($this->getEntityClass())->findOneBy($criteria);
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function save($entity): void
    {
        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function delete($entity): void
    {
        $this->entityManager->remove($entity);
        $this->entityManager->flush();
    }

    abstract protected function getEntityClass(): string;

    protected function getEntityRepository(): EntityRepository
    {
        return $this->entityManager->getRepository($this->getEntityClass());
    }
}