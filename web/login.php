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
        setcookie('password', trim($_POST['password']), time()+60*60*24*326);
        header("Location: https://fartuh.xyz/web/");
        exit();
    }
    else{
        echo "<script>alert('$res->error')</script>";
    }
}

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/login.css">
    <title>Онлайн чат fartuh</title>
</head>
<body>
    <header>
        <a href="https://fartuh.xyz">Главная</a>
    </header>

    <form class="box" action="https://fartuh.xyz/web/login.php" method="POST">
        <h1>Вход</h1>
        <input type="text" name="login" placeholder="Логин" required>
        <input type="text" name="password" placeholder="Пароль" required>
        <input type="submit" value="Войти">
        <p>*Для регистрации придумайте логин и пароль (не меньше 6 символов), а для входа введите существующие.</p>
    </form>
</body>
</html>
