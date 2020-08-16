<!-- 

Website created with php. Includes API for chatting (client: https://github.com/winzmcman/fartuh-chat)
Copyright (C) 2020 Nikita Pavlov
This program is free software: you can redistribute it and/or modify it under the terms of the GNU Affero General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more details.
You should have received a copy of the GNU Affero General Public License along with this program. If not, see http://www.gnu.org/licenses/.
Author's email: nikitafartuh@ukr.net -->

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
            $stmt = $db->prepare("SELECT * FROM messages WHERE id = ?");
            $stmt->execute([trim($data['id'])]);

            $data = $stmt->fetch(PDO::FETCH_ASSOC);

            if($data == false){
                echo json_encode(['result' => 'false']);
            }else{
                echo json_encode($data);
            }

        }
        else{
            $db = DB::getVar();
            $stmt = $db->prepare("SELECT * FROM messages");
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
            echo json_encode(['result' => 'false']);
            exit();
        }

        $login = trim($data['login']);
        $password = trim($data['password']);

        $db = DB::getVar();
        $stmt = $db->prepare("SELECT * FROM users WHERE login = ?");
        $res = $stmt->execute([$login]);

        if($res != true){
            echo json_encode(['result' => 'false', 'error' => 'incorrect login or password']);
            exit();
        }

        $user_data = $stmt->fetch();

        $pass_hash = $user_data['password'];

        $check = password_verify($password, $pass_hash);

        if($check != true){
            echo json_encode(['result' => 'false', 'error' => 'incorrect login or password']);
            exit();
        }

        return $user_data['id'];
    }

}
