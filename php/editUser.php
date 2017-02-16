<?php

$email = $_POST["email"];
require '../php/connect.php';
$cred_match = false;

if(!empty($_POST)){
	if ($conn){
		$query = "SELECT * FROM dbo.UserAccount WHERE Email = :Email";
		$query_params = array(':Email' => $_POST['email']);
		$stmt = $conn->prepare($query);
		$result = $stmt->execute($query_params) or die();
		$row = $stmt->fetch();
        
        	if($row){
        		if ($cred_match){
            			if (session_status() == PHP_SESSION_NONE) {
                			session_start();
				}
			$_SESSION['editUserEmail'] = $row['Email'];
			$_SESSION['editUserName']  = $row['FullName'];
			// header("Location : ../admin/admin.php"); 
			return false;
			} else {
				$err_msg = "cred error";
			}
		} else {
			$err_msg = "Cannot find user. Try again";
		}
	} else {
		$err_msg = "conn error";
	}
} else {
	$err_msg = "post error";
}
echo $err_msg;
?>
