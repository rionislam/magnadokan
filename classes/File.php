<?php
namespace App;

class File extends Dbh{
    
    public function upload($file, $allowed, $width = NULL){
        new Application;
        $fileName = $file['name'];
        $fileError = $file['error'];
        $fileTmpName = $file['tmp_name'];
        $extention = explode('.', $fileName);
        $extention = strtolower(end($extention));
        if(in_array($extention,$allowed)){
            if ($fileError == 0) {
                $fileNewName = md5($fileName).time();
                $fileNewName = $fileNewName.'.'.$extention;
                $fileDestination = Application::$ROOT_DIR."/uploads/".$fileNewName;
                if($width !== NULL && $width !== '' && $width !== 'null'){
                    $this->resizeImg($file, $fileDestination, $width);
                }else{
                    move_uploaded_file($fileTmpName, $fileDestination);
                }
                
                return $fileNewName;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    protected function resizeImg($file, $fileDestination, $width){
        $fileType = $file['type'];
        $fileTmpName = $file['tmp_name'];
        if($fileType == 'image/jpeg'){
            $img = imagecreatefromjpeg($fileTmpName);
            list($imgWidth, $imgHeight) = getimagesize($fileTmpName);
            $aspectRatio = $imgHeight/$imgWidth;
            $height = $width*$aspectRatio;
            $img = imagescale($img, $width, $height);
            imagejpeg($img, $fileDestination, 100);
            
        }else if($fileType == 'image/png'){
            $img = imagecreatefrompng($fileTmpName);
            list($imgWidth, $imgHeight) = getimagesize($fileTmpName);
            $aspectRatio = $imgHeight/$imgWidth;
            $height = $width*$aspectRatio;
            $img = imagescale($img, $width, $height);
            imagesavealpha($img, true);

            imagepng($img, $fileDestination, 100);
        }
    }

    public function secure($fileName, $bookName){
        $fileUniqueId = uniqid();
        $this->createRow('files', ['fileName', 'fileUniqueId', 'bookName'], 'sss', $fileName, $fileUniqueId, $bookName);
        return $fileUniqueId;
    }

    public function download($fileUniqueId){
        $row = $this->get($fileUniqueId);
        $fileName = $row['fileName'];
        header('Cache-Control: public');
        header('Content-Description: File Transfer');
        header("Content-Disposition: attachment; filename={$row['bookName']}");
        header("Content-Type: App\Application/octet-stream");
        readfile("../uploads/{$fileName}");

    }

    public function get($fileUniqueId){
        $sql = "SELECT * FROM `files` WHERE `fileUniqueId`='{$fileUniqueId}'";
        $row = $this->getRows($sql)[0];
        return $row;
    }
}