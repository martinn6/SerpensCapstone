<?php
$email = $_POST["email"];
require '../php/connect.php';
if(!empty($_POST)){
	if ($conn){
		$query = "SELECT * FROM dbo.UserAccount WHERE IsActive = 1 AND Email = :Email AND 
		UserTypeId = (SELECT UserTypeId FROM dbo.UserTypes WHERE UserType='Admin')";
		$query_params = array(':Email' => $_POST['email']);
		$stmt = $conn->prepare($query);
		$result = $stmt->execute($query_params) or die();
		$row = $stmt->fetch();
		$ID = $row['UserId'];
        $echo $row;
        if($row){
                $query_delete = "UPDATE dbo.UserAccount SET IsActive = "0" WHERE UserId = :ID";
                $query_params_delete = array(':ID' => $ID);
                $stmt_delete = $conn->prepare($query_delete);
                $rslt = $stmt_delete->execute($query_params_delete) or die();
			if ($stmt_delete->rowCount() > 0){
				$err_msg = $stmt_delete->rowCount();
				$echo $rslt;
				// return false;
			} else {
				$err_msg = "Error deleting user with email: $email.";
			}
		} else {
			    $err_msg = "Cannot find user with email: $email.  Try again";
		}
	} else {
		$err_msg = "CONN error"
	}
}else {
		$err_msg = "Post error"
}
echo $err_msg;
?>
