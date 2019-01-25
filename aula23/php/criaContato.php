<?php
    require_once("db.php");

    cria_contato($db);

    function cria_contato($db) {
        $callback = $_REQUEST['callback'];
        
        $name = $_REQUEST['name'];
        $email = $_REQUEST['email'];
        
        $stmt = $db->prepare("INSERT INTO Contact (name, email) values (:name, :email)");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $status = $stmt->execute();
        
        header('Content-Type: text/javascript');

        echo $callback . '(' . 
            json_encode(array(
            "success" => $status,
            "contatos" => array(
                "ID" => $db->lastInsertId(),
                "name" => $name,
                "email" => $email
            )
        )) . ');';
    }
?>