<?php
    include("db.php");
    
    $info = $_POST['contatos'];
    
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
?>