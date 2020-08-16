<?php

class Controller
{
    protected $method, $data;

    public function __construct($method){
        $this->method = $method;
    }

    public function get(){
        $data = $_GET;

        $user = $this->check($data); 

        if(isset($data['id'])){
            $db = DB::getVar();
            $stmt = $db->prepare("SELECT messages.id,messages.text,messages.sent_at,users.login FROM messages INNER JOIN users ON messages.author_id = users.id WHERE messages.id = ?");
            $stmt->execute([trim($data['id'])]);

            $data = $stmt->fetch(PDO::FETCH_ASSOC);

            if($data == false){
                echo json_encode(['result' => 'false', 'error' => 'not enough data', 'errorcode' => '5']);
            }else{
                echo json_encode($data);
            }

        }
        else{
            $db = DB::getVar();
            $stmt = $db->prepare("SELECT messages.id,messages.text,messages.sent_at,users.login FROM messages INNER JOIN users ON messages.author_id = users.id ORDER BY messages.id DESC LIMIT 10");
            $stmt->execute();

            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

            echo json_encode($data);
        }
    }

    public function post(){
        $data = $_POST;

        $author = $this->check($data);
        
        if(isset($data['id'])){
            
        }
        elseif(isset($data['text'])){
            $db = DB::getVar();
            $text = trim($data['text']);
            date_default_timezone_set('Europe/Moscow');
            $sent_at = date("H:i");

            $stmt = $db->prepare("INSERT INTO messages VALUES(null, ?, ?, ?)");
            $res = $stmt->execute([$text, $author, $sent_at]);

            echo json_encode(['result' => $res]);

        }
    }

    private function check($data){
        if(!isset($data['login']) || !isset($data['password'])){
            echo json_encode(['result' => 'false', 'error' => 'not enough data', 'errorcode' => '5']);
            exit();
        }

        $login = trim($data['login']);
        $password = trim($data['password']);

        $db = DB::getVar();
        $stmt = $db->prepare("SELECT * FROM users WHERE login = ?");
        $res = $stmt->execute([$login]);

        if($res != true){
            echo json_encode(['result' => 'false', 'error' => 'incorrect login or password', 'errorcode' => '3']);
            exit();
        }

        $user_data = $stmt->fetch();

        $pass_hash = $user_data['password'];

        $check = password_verify($password, $pass_hash);

        if($check != true){
            echo json_encode(['result' => 'false', 'error' => 'incorrect login or password', 'errorcode' => '3']);
            exit();
        }

        return $user_data['id'];
    }

}
