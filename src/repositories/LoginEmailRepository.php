<?php

namespace app\repositories;

use app\models\LoginEmail;

class LoginEmailRepository extends BaseRepository
{

    protected function getEntityClass(): string
    {
        return LoginEmail::class;
    }

    public function findByEmailAndToken($email, $token)
    {
        return $this->getEntityRepository()->findOneBy(['email' => $email, 'token' => $token]);
    }
}