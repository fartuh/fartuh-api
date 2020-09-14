<?php

session_start();
if(isset($_SESSION['login'])){
    header("Location: https://fartuh.xyz/web");
    exit();
}

if(isset($_POST['login']) && isset($_POST['password'])){
    $curl = curl_init("https://fartuh.xyz/api/users/index.php");
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, ['login' => trim($_POST['login']),'password' => trim($_POST['password'])]);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    $responde = curl_exec($curl);

    $res = json_decode($responde);

    if($res->result == true){
        $_SESSION['login'] = trim($_POST['login']);
        header("Location: https://fartuh.xyz/web/");
        exit();
    }
    else{
        echo $res->error;
    }
}

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title></title>
</head>
<body>
    <form action="https://fartuh.xyz/web/login.php" method="POST">
        <label>Логин<input type="text" name="login"></label>
        <label>Пароль<input type="text" name="password"></label>
        <input type="submit">
    </form>
</body>
</html>
