<?php
	header('Content-type: text/xml');

	include("db.php");
    
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

	echo $xml;
?>