<?php
    header('Content-type: text/xml');

    include("db.php");
    
    $dom = new DOMDocument();
	$dom->loadXML(file_get_contents('php://input'));
	$contatos = simplexml_import_dom($dom);
    
    error_log($dom->saveXML());

    $id = $contatos->contato->ID;
    
    $stmt = $db->prepare("DELETE FROM Contact WHERE ID = :id");
    $stmt->bindParam(':id', $id);
    $status = $stmt->execute();
	 
	$xml = '<?xml version="1.0" encoding="iso-8859-1" ?>';
	$xml.= "<contatos>";
	$xml.= "    <success>".$status."</success>";
	$xml.= "</contatos>";

	echo $xml;
?>