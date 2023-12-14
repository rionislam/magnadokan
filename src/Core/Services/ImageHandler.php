<?php

namespace Core\Services;

class ImageHandler{
    public static function resizeImage($file, $fileDestination, $width, $height, $crop = false){
        $fileType = $file['type'];
        $fileTmpName = $file['tmp_name'];
        list($imgWidth, $imgHeight) = getimagesize($fileTmpName);
        $aspectRatio = $imgHeight / $imgWidth;

        if ($crop) {
            if ($imgWidth > $imgHeight) {
                $imgWidth = ceil($imgWidth - ($imgWidth * abs($aspectRatio - $width / $height)));
            } else {
                $imgHeight = ceil($imgHeight - ($imgHeight * abs($aspectRatio - $width / $height)));
            }
            $newWidth = $width;
            $newHeight = $height;
        } else {
            if ($height / $width > $aspectRatio) {
                $newWidth = intval($height / $aspectRatio);
                $newHeight = $height;
            } else {
                $newHeight = intval($width * $aspectRatio);
                $newWidth = $width;
            }
        }

        if ($fileType == 'image/jpeg') {
            $src = imagecreatefromjpeg($fileTmpName);
        } else if ($fileType == 'image/png') {
            $src = imagecreatefrompng($fileTmpName);
            imagealphablending($src, true);
            imagesavealpha($src, true);
        }

        $img = imagecreatetruecolor($newWidth, $newHeight);

        if ($fileType == 'image/png') {
            imagealphablending($img, false);
            imagesavealpha($img, true);
        }

        imagecopyresampled($img, $src, 0, 0, 0, 0, $newWidth, $newHeight, $imgWidth, $imgHeight);

        if ($fileType == 'image/jpeg') {
            imagejpeg($img, $fileDestination);
        } else if ($fileType == 'image/png') {
            imagepng($img, $fileDestination);
        }

        imagedestroy($src);
        imagedestroy($img);
    }
}