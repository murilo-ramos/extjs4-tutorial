<?php
//connect to db
include("db.php");

$result = $db->query('SELECT * FROM Contact');

$xml = '<?xml version="1.0" encoding="iso-8859-1" ?>';
$xml.="<contatos>";

$rows = array();
foreach($result as $row) {
    $xml.= "<contato>";
    $xml.=     "<id>"    . $row['ID']    . "</id>";
    $xml.=     "<nome>"  . $row['name']  . "</nome>";
    $xml.=     "<email>" . $row['email'] . "</email>";
    $xml.= "</contato>";
}

$xml.="</contatos>";

echo $xml;
?>