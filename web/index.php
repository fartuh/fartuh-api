<?php

session_start();
if(!isset($_SESSION['login'])){
    if(isset($_COOKIE['password'])){
        unset($_COOKIE['password']);
    }
    require("login.php");
    exit();
}
else{
    require("chat.php");
}
