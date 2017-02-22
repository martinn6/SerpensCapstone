<?php
$newPassword = md5($_POST["password"]);
$email = $_POST["oldEmail"];
require '../php/connect.php';
if(!empty($_POST)){
	if ($conn){
		$query = "SELECT * FROM dbo.UserAccount WHERE Email = :Email AND 
		UserTypeId = (SELECT UserTypeId FROM dbo.UserTypes WHERE UserType='Admin')";
		$query_params = array(':Email' => $_POST['email']);
		$stmt = $conn->prepare($query);
		$result = $stmt->execute($query_params) or die();
		$row = $stmt->fetch();
        
        if($row){
                $new_query = "UPDATE dbo.UserAccount SET Password = :Password
				WHERE UserId = :ID";
                $new_query_params = array(
					':Email' => $newPassword,
					':ID' => $row['UserId'])
                $new_stmt = $conn->prepare($new_query);
                $new_result = $new_stmt->execute($new_query_params) or die();
				if($new_result) {
					return false;
				} else {
					$err_msg = "error updating user with email: $oldEmail";
				}
		} else {
			    $err_msg = "Cannot find user with email: $email.  Try again";
		}
	}
}
echo $err_msg;
?>
