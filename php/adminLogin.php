<?php
require 'connect.php';

$cred_match = false;

if(!empty($_POST)){
	if ($conn){
		$err_msg = "conn ";
		$query = "SELECT * FROM dbo.UserAccount WHERE Email = :Email";
		$query_params = array(':Email' => $_POST['email']);
		$stmt = $conn->prepare($query);
		$result = $stmt->execute($query_params) or die();
		$row = $stmt->fetch();

		if($row){
			if($_POST['password'] === $row['Password']){
				$err_msg = "match";
				$cred_match = true;
			}
			// if(md5($_POST['password']) === $row['Password']){
			// 	$cred_match = true;
			// }
		}
		
		if ($cred_match){
			$_SESSION['admin'] = $row;
			header("Location : ../admin/admin.php"); 
			die();
		} else {
			$form_email = htmlentities($_POST['email']);
			$err_msg = "Email/Password does not match. Try again";
		}
	}
	echo $err_msg;
} 
?>