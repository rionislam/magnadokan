<?php
namespace Core\Services;

class Search{
    public function createCondition($string){
        $string = rtrim($string);
        $keywords = explode(' ', $string);
        $condition = "WHERE ";
        $i = 1;
        foreach($keywords as $keyword){
            $condition .= "`bookName` Like '%{$keyword}%'\nOR `bookTags` Like '%{$keyword}%'\nOR `bookDescription` Like '%{$keyword}%'\nOR `bookWritters` Like '%{$keyword}%'\nOR ";
            $i += 5;
        }
        $condition = substr_replace($condition ,"", -3);
        return $condition;
    }

    public function createOrder($string){
        $string = rtrim($string);
        $keywords = explode(' ', $string);
        $order = "ORDER BY\n
                    CASE\n";
        $i = 1;
        foreach($keywords as $keyword){
            $order .= "WHEN `bookName` Like '{$keyword}' THEN {$i}\n
                        WHEN `bookName` Like '{$keyword}%' THEN ".($i + 1)."\n
                        WHEN `bookName` Like '%{$keyword}%' THEN ".($i + 2)."\n
                        WHEN `bookDescription` LIKE '%{$keyword}%' THEN ".($i + 3)."\n
                        WHEN `bookTags` LIKE '%{$keyword}%' THEN ".($i + 4)."\n";
            $i += 5;
        }
        $order .= " END";
        return $order;
    }
}