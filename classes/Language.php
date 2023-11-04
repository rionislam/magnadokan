<?php
namespace App;

class Language extends Dbh{
    public function load(){
        $rows = $this->selectAll('languages');
        if($rows !== false){
            $detailsLogo = file_get_contents(Application::$ROOT_DIR."/imgs/details.svg");
            foreach($rows as $row){
                echo "<div class='row'><div class='name'>".$row['language']."</div><div class='details'>$detailsLogo</div></div>";
            }
        }else{
            echo 'Nothing found!';
        }
        
    }
}