<?php


setcookie('login', '', time()-10);
setcookie('password', '', time()-10);

header("Location: https://fartuh.xyz/web");

exit();

?>
