<?php
namespace Core\Services;

class Search{
    public function createCondition($string){
        $string = rtrim($string);
        $keywords = explode(' ', $string);
        $condition = "WHERE ";
        $order = "ORDER BY\n
                    CASE\n";
        $i = 1;
        foreach($keywords as $keyword){
            $condition .= "`bookName` Like '%{$keyword}%'\nOR `bookTags` Like '%{$keyword}%'\nOR `bookDescription` Like '%{$keyword}%'\nOR `bookWritters` Like '%{$keyword}%'\nOR ";
            $order .= "WHEN `bookName` Like '{$keyword}' THEN {$i}\n
                        WHEN `bookName` Like '{$keyword}%' THEN ".($i + 1)."\n
                        WHEN `bookName` Like '%{$keyword}%' THEN ".($i + 2)."\n
                        WHEN `bookDescription` LIKE '%{$keyword}%' THEN ".($i + 3)."\n
                        WHEN `bookTags` LIKE '%{$keyword}%' THEN ".($i + 4)."\n";
            $i += 5;
        }
        $condition = substr_replace($condition ,"", -3);
        $condition .= $order." END";
        return $condition;
    }
}