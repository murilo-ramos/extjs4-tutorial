<?php
    require_once("db.php");
    
    $callback = $_REQUEST['callback'];

    lista_contatos($db);
    
    function lista_contatos($db) {
        $result = $db->query('SELECT * FROM Contact');

        $rows = array();
        foreach($result as $row) {
            $contact['ID']    = $row['ID'];
            $contact['name']  = $row['name'];
            $contact['email'] = $row['email'];
            $rows[] = $contact;
        }
        
        header('Content-Type: text/javascript');
	    
        echo $callback . '(' . json_encode($rows) . ');';
    }
?>