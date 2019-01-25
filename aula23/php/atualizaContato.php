<?php
    require_once("db.php");

    atualiza_contato($db);

    function atualiza_contato($db) {
        $callback = $_REQUEST['callback'];
        $records = parse_str($_REQUEST['records'], $array);
        
        $name = $_REQUEST['nome'];
        $email = $_REQUEST['email'];        
        $id = $array['ID'];
        
        $stmt = $db->prepare("UPDATE Contact SET name = :name, email = :email WHERE ID = :id");
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $status = $stmt->execute();

        header('Content-Type: text/javascript');

        echo $callback . '(' . json_encode(array(
            "success" => $status
        )). ');';
    }
?>