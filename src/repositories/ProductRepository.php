<?php

namespace app\repositories;

use app\models\Product;
use Doctrine\ORM\EntityRepository;

class ProductRepository extends BaseRepository
{
    protected function getEntityClass(): string
    {
        return Product::class;
    }

    public function findByID(string $id)
    {
        return $this->getEntityRepository()->findOneBy(['id' => $id]);
    }

    public function findByBarcode(string $barcode): ?Product
    {
        return $this->getEntityRepository()->findOneBy(['barcode' => $barcode]);
    }

    public function findByName(string $name)
    {
        return $this->getEntityRepository()->createQueryBuilder('p')
            ->where('p.name LIKE :name')
            ->setParameter('name', '%' . $name . '%')
            ->setMaxResults(5)
            ->getQuery()
            ->getResult();
    }

    public function findAllBarcode(?int $barcode): array
    {
        return $this->getEntityRepository()->findBy(['barcode' => $barcode]);
    }
}