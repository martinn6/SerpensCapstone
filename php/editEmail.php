<?php
$newEmail = $_POST["email"];
$oldEmail = $_SESSION["editUserEmail"];
require '../php/connect.php';
if(!empty($_POST)){
	if ($conn){
		$query = "SELECT * FROM dbo.UserAccount WHERE Email = :Email";
		$query_params = array(':Email' => $_POST['email']);
		$stmt = $conn->prepare($query);
		$result = $stmt->execute($query_params) or die();
		$row = $stmt->fetch();
        
        if($row){
                $query = "DELETE FROM dbo.UserAccount WHERE Email = :Email";
                $query_params = array(':Email' => $_POST['email']);
                $stmt = $conn->prepare($query);
                $result = $stmt->execute($query_params) or die();
                $err_msg = "Deleted user with email: $email.";
		} else {
			    $err_msg = "Cannot find user with email: $email.  Try again";
		}
	}
}
echo $err_msg;
?>
