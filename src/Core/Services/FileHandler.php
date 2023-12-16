<?php
namespace Core\Services;

use Core\Application;
use Core\Models\File;
use Core\Utilities\ImageHandler;

class FileHandler extends File{
    public function storeImage($file, $width = NULL, $height = NULL, $subFolder = NULL){
        $fileName = $file['name'];
        $fileError = $file['error'];
        $fileTmpName = $file['tmp_name'];
        $extention = explode('.', $fileName);
        $extention = strtolower(end($extention));
        $allowed = ['jpg', 'jpeg', 'png', 'JPG', 'JPEG', 'PNG'];
        if(in_array($extention,$allowed)){
            if ($fileError == 0) {
                $fileNewName = md5($fileName).time();
                $fileNewName = $fileNewName.'.'.$extention;
                $fileDestination = Application::$ROOT_DIR."/uploads/{$subFolder}".$fileNewName;
                if($width !== NULL || $height != NULL){
                    ImageHandler::resizeImage($file, $fileDestination, $width, $height);
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

    public function use($fileName){
        $this->changeStatus("WHERE `fileName`='{$fileName}'", 'used');
    }

    // public function download($fileUniqueId){
    //     $row = $this->get($fileUniqueId);
    //     $fileName = $row['fileName'];
    //     header('Cache-Control: public');
    //     header('Content-Description: File Transfer');
    //     header("Content-Disposition: attachment; filename={$row['bookName']}");
    //     header("Content-Type: App\Application/octet-stream");
    //     readfile("../uploads/{$fileName}");

    // }
}