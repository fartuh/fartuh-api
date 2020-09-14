<?php

session_start();

unset($_SESSION['login']);
unset($_COOKIE['password']);

header("Location: https://fartuh.xyz/web");

exit();

?>
