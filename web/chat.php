<?php



if(isset($_POST['message']) && $_POST['message'] != ""){
    $curl = curl_init("https://fartuh.xyz/api/chat/index.php");
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, ['login' => trim($_COOKIE['login']),'password' => trim($_COOKIE['password']), 'text' => trim($_POST['message'])]);
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

$login = $_COOKIE['login'];
$password = $_COOKIE['password'];

$messages = array_reverse(json_decode(file_get_contents("https://fartuh.xyz/api/chat?login=$login&password=$password")));

$count = 9;

?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <link rel="stylesheet" href="assets/chat.css">
    <title>Чат fartuh.xyz</title>
</head>
<body>
    <header>
        <a href="https://fartuh.xyz">Главная</a>
        <a href="https://fartuh.xyz/web/logout.php">Выйти</a>
    </header>
    <div class="box">
        <p class="online">Онлайн пользователей: 0</p>
        <div class="chat">
            <?php foreach($messages as $message): ?>
                <p id="msg<?= $count ?>"><b><?= $message->login . "</b>: " . $message->text . ": " . $message->sent_at ?></p>
                <?php $count -= 1 ?>
            <?php endforeach; ?>
        </div>
        <form action="#" method="POST">
            <input id="message" type="text" name="message" placeholder="Текст сообщения..." required>
            <input onclick="sent()" type="button" value="Отправить сообщение">
        </form>
    </div>
    <footer>

    </footer>
</body>
<script src="assets/jquery.min.js"></script>
<script>
function update(){
    jQuery.get("https://fartuh.xyz/api/chat?login=<?= $_SESSION['login'] ?>&password=<?= $_COOKIE['password']?>", function(data, status){
        data = JSON.parse(data);
        for(i = 0; i <= data.length - 1; i++){
            msg = document.getElementById("msg" + i);
            msg.innerHTML = "<b>" + data[i].login + "</b>: " + data[i].text + ": " + data[i].sent_at;
        }

}); 
}

function online(){
    jQuery.get("https://fartuh.xyz/api/chat/online", function(data, status){
        data = JSON.parse(data);
        online = document.getElementsByClassName("online")[0];
        online.innerHTML = "Онлайн пользователей: " + data.online;
    });
}

online();

setInterval(update, 2000);
setInterval(online, 4000);

function sent(){
    jQuery.post("https://fartuh.xyz/api/chat/index.php", {login: "<?= $_SESSION['login']?>", password: "<?= $_COOKIE['password']?>", text: document.getElementById("message").value}, function(data, status){
        update();
        document.getElementById("message").value = "";
});
}

</script>
</html>
