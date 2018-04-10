<?php
//connect to db
include("db.php");

$result = $db->query('SELECT * FROM Contact');

$rows = array('contatos' => array());
foreach($result as $row) {
    $contact['ID']    = $row['ID'];
    $contact['name']  = $row['name'];
    $contact['email'] = $row['email'];
    $rows['contatos'][] = $contact;
}

//JSON
echo json_encode($rows);
?>