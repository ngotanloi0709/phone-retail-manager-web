<?php

namespace app\repositories;

use app\models\User;

class UserRepository extends BaseRepository
{
    protected function getEntityClass(): string
    {
        return User::class;
    }
}