<?php

session_start();

if(isset($_POST['message']) && $_POST['message'] != ""){
    $curl = curl_init("https://fartuh.xyz/api/chat/index.php");
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, ['login' => trim($_SESSION['login']),'password' => trim($_COOKIE['password']), 'text' => trim($_POST['message'])]);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    $responde = curl_exec($curl);

    $res = json_decode($responde);

    if($res->result == true){
        header("Location: https://fartuh.xyz/web");
        exit();
    }
    else{
        echo $res->error;
    }

}

$login = $_SESSION['login'];
$password = $_COOKIE['password'];

$messages = json_decode(file_get_contents("https://fartuh.xyz/api/chat?login=$login&password=$password"));

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title></title>
</head>
<body>
    <header>

    <a href="https://fartuh.xyz/web/logout.php">Выйти</a>
    </header>
    <div>
        <form action="https://fartuh.xyz/web/chat.php" method="POST">
            <input type="text" name="message">
            <input type="submit" value="Отправить сообщение">
            <input onclick="reload()" type="button" value="Обновить чат">
        </form>
        <?php foreach($messages as $message): ?>
            <p><?= $message->login . ": " . $message->text . ": " . $message->sent_at ?></p>
        <?php endforeach; ?>
    </div>
    <footer>

    </footer>
</body>
<script>
function reload(){
    window.location.reload();
}
</script>
</html>
