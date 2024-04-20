<?php

namespace app\repositories;

use app\models\User;

class UserRepository extends BaseRepository
{
    protected function getEntityClass(): string
    {
        return User::class;
    }

    public function findByEmail(string $email)
    {
        return $this->getEntityRepository()->findOneBy(['email' => $email]);
    }

    public function findByUsername(string $username)
    {
        return $this->getEntityRepository()->findOneBy(['username' => $username]);
    }
}