<?php

class DB
{
    public static function getVar(){
        $pdo = new PDO("mysql:host=localhost;dbname=name;charset=utf8", "user", "password");
        return $pdo;
    }
}
