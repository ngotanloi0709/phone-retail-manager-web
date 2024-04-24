<?php

namespace app\utils;

class DataHelper
{
    public static function emailToUsername(string $email): string
    {
        return substr($email, 0, strpos($email, '@'));
    }

    public static function getDisplayStringData(?string $input, bool $isReturnEmptyString = false): string
    {
        if ($isReturnEmptyString) {
            return $input != null && $input != '' ? $input : '';
        }

        return $input != null && $input != '' ? $input : 'Chưa có dữ liệu';
    }

    public static function getDisplayAvatarData(?string $avatar): string
    {
        $defaultAvatar = '/image/user-default-avatar.png';

        if ($avatar == null || $avatar == '') {
            return $defaultAvatar;
        }

        if (!str_starts_with($avatar, 'data:image')) {
            return $defaultAvatar;
        }

        return $avatar;
    }
}