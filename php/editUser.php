<?php

$email = $_POST["email"];
require '../php/connect.php';

if(!empty($_POST)){
	if ($conn){
		$query = "SELECT * FROM dbo.UserAccount WHERE Email = :Email";
		$query_params = array(':Email' => $_POST['email']);
		$stmt = $conn->prepare($query);
		$result = $stmt->execute($query_params) or die();
		$row = $stmt->fetch();
        
        	if($row){
	        	if (session_status() == PHP_SESSION_NONE) {
                		session_start();
			}
			$_SESSION['editUserEmail'] = $row['Email'];
			$_SESSION['editUserName']  = $row['FullName'];
			return false;
		} else {
			$err_msg = "Cannot find user with email: $email.  Try again";
		}
	}
}
echo $err_msg;
?>
