<?php

namespace app\utils;

class ImageHelper
{


    public static function resizeImage($source, $destination, $targetWidth, $targetHeight)
    {
        list($originalWidth, $originalHeight) = getimagesize($source);
        $newImage = imagecreatetruecolor($targetWidth, $targetHeight);
        $extension = pathinfo($source, PATHINFO_EXTENSION);

        $sourceImage = match ($extension) {
            'jpg', 'jpeg' => imagecreatefromjpeg($source),
            'png' => imagecreatefrompng($source),
            'gif' => imagecreatefromgif($source),
            default => false,
        };

        imagedestroy($newImage);
        if ($sourceImage === false) {
            return false;
        }

        imagecopyresampled($newImage, $sourceImage, 0, 0, 0, 0, $targetWidth, $targetHeight, $originalWidth, $originalHeight);
        imagejpeg($newImage, $destination);
        imagedestroy($newImage);
        imagedestroy($sourceImage);
    }

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

            // Get the absolute path to the destination directory
            $absolutePath = __DIR__ . $imgDestination;

            $_SESSION['logger'][] = $absolutePath;

            // Check if the directory exists, if not, create it
            if (!is_dir(dirname($absolutePath))) {
                mkdir(dirname($absolutePath), 0755, true);
            }

            move_uploaded_file($_FILES[$file]['tmp_name'], $absolutePath);
            self::resizeImage($absolutePath, $absolutePath, 500, 500);

            return str_replace('/../../public', '', $imgDestination);
        } else {
            return "/product_images/product-default-image.png";
        }
    }

    public static function getDisplayStringData(?string $input): string
    {
        $absolutePath = $_SERVER['DOCUMENT_ROOT'] . $input;
        return $input != null && $input != '' && file_exists($absolutePath) ? $input : '/image/product-default-image.png';
    }
}
