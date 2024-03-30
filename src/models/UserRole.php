<?php

namespace app\models;

enum UserRole: string
{
    case ADMIN = 'admin';
    case USER = 'user';
}