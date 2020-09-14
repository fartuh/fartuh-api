<?php

session_start();

unset($_SESSION['login']);

header("Location: https://fartuh.xyz/web");

exit();

?>
