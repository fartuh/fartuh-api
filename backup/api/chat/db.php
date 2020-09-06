<?php

class DB
{
    public static function getVar(){
        $pdo = new PDO("mysql:host=localhost;dbname=fartuh;charset=utf8", "fartuh", "minekraftmi22");
        return $pdo;
    }
}
