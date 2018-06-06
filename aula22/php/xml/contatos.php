<?php
    header('Content-type: text/xml');
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

        $xml = '<?xml version="1.0" encoding="iso-8859-1" ?>';
        $xml.="<contatos>";

        $rows = array();
        foreach($result as $row) {
            $xml.= "<contato>";
            $xml.=     "<ID>"    . $row['ID']    . "</ID>";
            $xml.=     "<name>"  . $row['name']  . "</name>";
            $xml.=     "<email>" . $row['email'] . "</email>";
            $xml.= "</contato>";
        }

        $xml.="</contatos>";

        echo $xml;
    }

    function cria_contato($db) {
        $dom = new DOMDocument();
        $dom->loadXML(file_get_contents('php://input'));
        $contatos = simplexml_import_dom($dom);
        
        $name  = $contatos->contato->name;
        $email = $contatos->contato->email;
        
        $stmt = $db->prepare("INSERT INTO Contact (name, email) values (:name, :email)");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $status = $stmt->execute();
        
        $xml = '<?xml version="1.0" encoding="iso-8859-1" ?>';
        $xml.= "<contatos>";
        $xml.= "<success>".$status."</success>";	
        $xml.=   "<contato>";
        $xml.=      "<ID>".$db->lastInsertId()."</ID>";
        $xml.=      "<name>".$name."</name>";
        $xml.=      "<email>".$email."</email>";
        $xml.=   "</contato>";
        $xml.= "</contatos>";
    }

    function atualiza_contato($db) {
        $dom = new DOMDocument();
        $dom->loadXML(file_get_contents('php://input'));
        $contatos = simplexml_import_dom($dom);
    
        $name  = $contatos->contato->name;
        $email = $contatos->contato->email;
        $id    = $contatos->contato->ID;
        
        $stmt = $db->prepare("UPDATE Contact SET name = :name, email = :email WHERE ID = :id");
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $status = $stmt->execute();
         
        $xml = '<?xml version="1.0" encoding="iso-8859-1" ?>';
        $xml.= "<contatos>";
        $xml.= "  <success>".$status."</success>";
        $xml.= "</contatos>";
        
        echo $xml;
    }

    function deleta_contato($db) {
        $dom = new DOMDocument();
        $dom->loadXML(file_get_contents('php://input'));
        $contatos = simplexml_import_dom($dom);

        $id = $contatos->contato->ID;
        
        $stmt = $db->prepare("DELETE FROM Contact WHERE ID = :id");
        $stmt->bindParam(':id', $id);
        $status = $stmt->execute();
        
        $xml = '<?xml version="1.0" encoding="iso-8859-1" ?>';
        $xml.= "<contatos>";
        $xml.= "    <success>".$status."</success>";
        $xml.= "</contatos>";

        echo $xml;
    }
?>