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
            $stmt = $db->prepare("SELECT * FROM messages WHERE id = ?");
            $stmt->execute([$data['id']]);

            $data = $stmt->fetch(PDO::FETCH_ASSOC);

            echo json_encode($data);

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
        
        if(isset($data['id'])){
            
        }
        elseif(isset($data['text']) && isset($data['name'])){
            $db = DB::getVar();
            $name = trim($data['name']);
            $text = trim($data['text']);

            $stmt = $db->prepare("INSERT INTO messages VALUES(null, ?, ?)");
            $res = $stmt->execute([$text, $name]);

            echo json_encode(['result' => $res]);

        }
    }

}
