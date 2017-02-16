<?php
require 'connect.php';

if(!empty($_POST)){
	if ($conn){
		$err_msg = "conn ";
		$query = "SELECT FullName FROM dbo.UserAccount WHERE Email = :Email";
		$query_params = array(':Email' => $_POST['email']);
		$stmt = $conn->prepare($query);
		$result = $stmt->execute($query_params) or die();
		$row = $stmt->fetch();

		if($row){
            $user = $row['FullName'];
		} else {
            header("Location : ../admin/adminLogin.php"); 
			die();
        }
} 
?>