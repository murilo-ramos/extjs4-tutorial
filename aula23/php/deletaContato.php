<?php
    require_once("db.php");

    deleta_contato($db);

    function deleta_contato($db) {
        $callback = $_REQUEST['callback'];
        $records = parse_str($_REQUEST['records'], $array);

        $id = $array['ID'];        
        
        $stmt = $db->prepare("DELETE FROM Contact WHERE ID = :id");
        $stmt->bindParam(':id', $id);
        $status = $stmt->execute();

        header('Content-Type: text/javascript');
        
        echo $callback . '(' . json_encode(array(
            "success" => $status
        )) . ');';
    }
?>