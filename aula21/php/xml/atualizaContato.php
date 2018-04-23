<?php
    header('Content-type: text/xml');

    include("db.php");
    
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
?>