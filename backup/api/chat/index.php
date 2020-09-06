<?php

require_once('controller.php');
require_once('db.php');

define('METHOD', $_SERVER['REQUEST_METHOD']);

$res = new Controller(METHOD);
switch(METHOD){
    case "GET":
        $res->get();
    break;
    case "POST":
        $res->post();
}
