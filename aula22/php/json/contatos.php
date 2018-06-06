<?php
    require_once("db.php");

    $request_type = $_SERVER['REQUEST_METHOD'];

    switch ($request_type) {
		case 'GET':
            lista_contatos($db);
			break;
		
		case 'POST':
            cria_contato($db);
			break;
		case 'PUT':
            atualiza_contato($db);
			break;
        case 'DELETE':
            deleta_contato($db);
			break;		
    }
    
    function lista_contatos($db) {
        $result = $db->query('SELECT * FROM Contact');

        $rows = array();
        foreach($result as $row) {
            $contact['ID']    = $row['ID'];
            $contact['name']  = $row['name'];
            $contact['email'] = $row['email'];
            $rows[] = $contact;
        }
        
        echo json_encode($rows);
    }

    function cria_contato($db) {
        $info = $_POST['contatos'];
    
        $data = json_decode(stripslashes($info));
        
        $name  = $data->name;
        $email = $data->email;
        
        $stmt = $db->prepare("INSERT INTO Contact (name, email) values (:name, :email)");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $status = $stmt->execute();
        
        echo json_encode(array(
            "success" => $status,
            "contatos" => array(
                "ID" => $db->lastInsertId(),
                "name" => $nome,
                "email" => $email
            )
        ));
    }

    function atualiza_contato($db) {
        parse_str(file_get_contents("php://input"), $post_vars);

        $info = $post_vars['contatos'];
    
        $data = json_decode(stripslashes($info));
        
        $name  = $data->name;
        $email = $data->email;
        $id    = $data->ID;
        
        
        $stmt = $db->prepare("UPDATE Contact SET name = :name, email = :email WHERE ID = :id");
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $status = $stmt->execute();
         
        echo json_encode(array(
            "success" => $status
        ));
    }

    function deleta_contato($db) {
        parse_str(file_get_contents("php://input"), $post_vars);

        $info = $post_vars['contatos'];
    
        error_log("delete id $info");

        $data = json_decode(stripslashes($info));
        
        $id = $data->ID;

        
        
        $stmt = $db->prepare("DELETE FROM Contact WHERE ID = :id");
        $stmt->bindParam(':id', $id);
        $status = $stmt->execute();
        
        echo json_encode(array(
            "success" => $status
        ));
    }
?>