<?php
namespace App;

class  Writter extends Dbh{
    public function add($name, $file){
        $allowed = array('jpg', 'jpeg', 'png');
        $fileClass = new File;
        $fileName = explode('.',$file['name'])[0];
        $fileName = $fileClass->upload($file, $allowed, 150);


        if($fileName != false){
            $response = $this->createRow('writters', ['`writterName`', '`writterImg`'], 'ss', $name, $fileName);
            if($response !== false){
                return true;
            } 
        }
    }

    public function load(){
        $rows = $this->selectAll('writters');
        if($rows !== false){
            $detailsLogo = file_get_contents(Application::$ROOT_DIR."/imgs/details.svg");
            foreach($rows as $row){
                echo "<div class='row'><div class='icon'><img src='".Application::$HOST."/uploads/".$row['writterImg']."'></div><div class='name'>".$row['writterName']."</div><div class='details'>$detailsLogo</div></div>";
            }
        }else{
            echo 'Nothing found!';
        }
        
    }

    public function loadList($filter = NULL){
        $rows = $this->selectAll('writters');
        if($rows !== false){
            foreach($rows as $row){
                if($filter !== NULL){
                    if(!in_array($row['writterName'], $filter)){
                        echo "<li onclick='selectWritter(this)'>".$row['writterName']."</li>";
                    }
                }else{
                    echo "<li onclick='selectWritter(this)'>".$row['writterName']."</li>";
                }
                
                
            }
        }else{
            echo 'Nothing found!';
        }
    }
}