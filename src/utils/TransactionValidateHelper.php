<?php

namespace app\utils;

class TransactionValidateHelper
{
    public static function validateTransactionInformation(
        ?array $productIdArray,
        ?array $productQuantityArray,
        ?int $givenMoney
    ): array
    {
        $errors = [];

        if (empty($productIdArray)) {
            $errors['product'] = 'Không có sản phẩm nào được chọn';
            return $errors;
        }

        if (sizeof($productIdArray) !== sizeof($productQuantityArray)) {
            $errors['product'] = 'Số lượng sản phẩm không khớp';
        }

        if ($givenMoney < 0) {
            $errors['givenMoney'] = 'Số tiền không hợp lệ';
        }

        return $errors;
    }

    public static function isValidPhoneNumber(?string $phone): bool
    {
        return preg_match('/^[0-9]{9,10}$/', $phone) === 1;
    }
}