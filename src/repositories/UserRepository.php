<?php

namespace app\repositories;

use app\models\User;
use Doctrine\ORM\EntityRepository;

class UserRepository extends BaseRepository
{
    public function findByEmail(string $email)
    {
        return $this->getEntityClass()->findOneBy(['email' => $email]);
    }

    protected function getEntityClass(): EntityRepository
    {
        return $this->entityManager->getRepository(User::class);
    }
}