<?php
$newName = $_POST["name"];
$email = $_POST["oldEmail"];
require '../php/connect.php';
if(!empty($_POST)){
	if ($conn){
		$query = "SELECT * FROM dbo.UserAccount WHERE Email = :Email AND 
		UserTypeId = (SELECT UserTypeId FROM dbo.UserTypes WHERE UserType='Admin')";
		$query_params = array(':Email' => $email);
		$stmt = $conn->prepare($query);
		$result = $stmt->execute($query_params) or die();
		$row = $stmt->fetch();
        
        if($row){
                $query = "UPDATE dbo.UserAccount SET FullName = :Name
				WHERE UserId = :ID";
                $query_params = array(
					':Name' => $newEmail,
					':ID' => $row['UserId']);
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
