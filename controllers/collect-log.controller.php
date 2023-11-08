<?php
require $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';
use App\Application;
new Application;

if($_SERVER['REQUEST_METHOD'] == 'PUT'){
  
    $log = new App\Log;
    $data = json_decode(file_get_contents('php://input'));
    if($data->event == 'impression'){
        $log->collectImpression($data->bookId, $data->bookCategory);
       
    }
}
