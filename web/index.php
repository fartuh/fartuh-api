<?php

if(!isset($_COOKIE['login'])){
    if(isset($_COOKIE['password'])){
        unset($_COOKIE['password']);
    }
    require("login.php");
    exit();
}
else{
    require("chat.php");
}
