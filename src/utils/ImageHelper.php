<?php

namespace app\utils;

class ImageHelper
{


    public static function resizeImage($source, $destination, $targetWidth, $targetHeight)
    {
        list($originalWidth, $originalHeight) = getimagesize($source);
        $newImage = imagecreatetruecolor($targetWidth, $targetHeight);
        $extension = pathinfo($source, PATHINFO_EXTENSION);

        switch ($extension) {
            case 'jpg':
            case 'jpeg':
                $sourceImage = imagecreatefromjpeg($source);
                break;
            case 'png':
                $sourceImage = imagecreatefrompng($source);
                break;
            case 'gif':
                $sourceImage = imagecreatefromgif($source);
                break;
            default:
                $sourceImage = false;
                break;
        }

        imagedestroy($newImage);
        if ($sourceImage === false) {
            return false;
        }

        imagecopyresampled($newImage, $sourceImage, 0, 0, 0, 0, $targetWidth, $targetHeight, $originalWidth, $originalHeight);
        imagejpeg($newImage, $destination);
        imagedestroy($newImage);
        imagedestroy($sourceImage);
    }

    public static function uploadImage(string $file)
    {
        $newFileName = $_FILES[$file]['name'];

        if ( $newFileName == null && empty($newFileName)) {
            return "../public/product_images/product-default-image.png";
        } else {
            $newFileName = strtolower(str_replace(" ", "-", $newFileName));
        }

        $imgExt = explode('.', $newFileName);
        $imgExt = strtolower(end($imgExt));

        if ($_FILES[$file]['error'] === 0) {
            $imgNameNew = uniqid('', true) . '.' . $imgExt;
            $newFileName = str_replace("." . $imgExt, "", $newFileName);
            $imgDestination = '../public/product_images/' . $newFileName . '_' . $imgNameNew;
            move_uploaded_file($_FILES[$file]['tmp_name'], $imgDestination);
            self::resizeImage($imgDestination, $imgDestination, 500, 500);
            return $imgDestination;
        } else {
            return "../public/product_images/product-default-image.png";
        }
    }

    public static function getDisplayStringData(?string $input): string
    {
        return $input != null && $input != '' ? $input : '../public/image/product-default-image.png';
    }
}
