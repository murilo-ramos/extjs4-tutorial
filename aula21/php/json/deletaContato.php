<?php
    include("db.php");
    
    $info = $_POST['contatos'];
    
    $data = json_decode(stripslashes($info));
    
    $id = $data->ID;
    
    $stmt = $db->prepare("DELETE FROM Contact WHERE ID = :id");
    $stmt->bindParam(':id', $id);
    $status = $stmt->execute();
	 
	echo json_encode(array(
		"success" => $status
	));
?>