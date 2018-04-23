<?php
    include("db.php");
    
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
?>