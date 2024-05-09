<?php

namespace app\utils;

class ImageHelper
{



    public static function uploadImage(string $file): string
    {
        $newFileName = strtolower(str_replace(" ", "-", $_FILES[$file]['name']));

        if ($newFileName == null) {
            return "/image/product-default-image.png";
        }

        $imgExt = explode('.', $newFileName);
        $imgExt = strtolower(end($imgExt));

        if ($_FILES[$file]['error'] === 0) {
            $imgNameNew = uniqid('', true) . '.' . $imgExt;
            $newFileName = str_replace("." . $imgExt, "", $newFileName);
            $imgDestination = '/../../public/product_images/' . $newFileName . '_' . $imgNameNew;

            $absolutePath = __DIR__ . $imgDestination;
            $_SESSION['logger'][] = $absolutePath;

            if (!is_dir(dirname($absolutePath))) {
                mkdir(dirname($absolutePath), 0755, true);
            }

            move_uploaded_file($_FILES[$file]['tmp_name'], $absolutePath);

            return str_replace('/../../public', '', $imgDestination);
        } else {
            return "/product_images/product-default-image.png";
        }
    }

    public static function getDisplayStringData(?string $input): string
    {
        $absolutePath = $_SERVER['DOCUMENT_ROOT'] . $input;
        if ($input == null) {
            return '/image/product-default-image.png';
        }
        if (!file_exists($absolutePath)) {
            return '/image/product-default-image.png';
        }
        if ($input == '') {
            return '/image/product-default-image.png';
        }
        return $input;
    }
}
