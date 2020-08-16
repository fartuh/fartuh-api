<?php

class Controller
{
    protected $method, $data;

    public function __construct($method){
        $this->method = $method;
    }

    public function get(){
        $data = $_GET;

        if(isset($data['id'])){
            $db = DB::getVar();
            $stmt = $db->prepare("SELECT id,login,status FROM users WHERE id = ?");
            $stmt->execute([trim($data['id'])]);

            $data = $stmt->fetch(PDO::FETCH_ASSOC);

            if($data == false){
                echo json_encode(['result' => 'false', 'error' => 'id does not exist', 'errorcode' => '4']);
            }else{
                echo json_encode($data);
            }

        }
        else{
            $db = DB::getVar();
            $stmt = $db->prepare("SELECT id,login,status FROM users");
            $stmt->execute();

            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

            echo json_encode($data);
        }
    }

    public function post(){
        $data = $_POST;
        
        if(isset($data['id'])){
            
        }
        elseif(isset($data['login']) && isset($data['password'])){
            $db = DB::getVar();

            $password = trim($data['password']);

            if(strlen($password) < 6){
                echo json_encode(["result" => false, 'error' => "password is too short", "errorcode" => "1"]);
                exit();
            }

            $login = trim($data['login']);
            $status = 'user';
            $password = password_hash($password, PASSWORD_BCRYPT);
            $reg_ip = $_SERVER['REMOTE_ADDR'];

            $stmt = $db->prepare("SELECT id FROM users WHERE login = ?");
            $stmt->execute([$login]);
            $result = $stmt->fetch();
            if(isset($result['id'])){
                $r = $this->check($data);
                if($r == false){
                    echo json_encode(['result' => false, 'error' => 'User already registered', 'errorcode' => '2']);
                }
                else{
                    echo json_encode(['result' => true]);
                }
                exit();
            }

            $stmt = $db->prepare("INSERT INTO users VALUES(null, ?, ?, ?, ?)");
            $res = $stmt->execute([$login, $status, $password, $reg_ip]);

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
            return false;
        }

        $user_data = $stmt->fetch();

        $pass_hash = $user_data['password'];

        $check = password_verify($password, $pass_hash);

        if($check != true){
            return false;
        }

        return $user_data['id'];
    }

}
