<?php 
/*
Website created with php. Includes API for chatting (client: https://github.com/winzmcman/fartuh-chat)
Copyright (C) 2020 Nikita Pavlov
This program is free software: you can redistribute it and/or modify it under the terms of the GNU Affero General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more details.
You should have received a copy of the GNU Affero General Public License along with this program. If not, see http://www.gnu.org/licenses/.
Author's email: nikitafartuh@ukr.net
*/

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
        setcookie('login', trim($_POST['login']), time()+60*60*24*14);
        setcookie('password', trim($_POST['password']), time()+60*60*24*326*14);
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
