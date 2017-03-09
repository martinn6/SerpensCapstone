<?php
$newName = $_POST["name"];
$oldEmail = $_POST["oldEmail"];
require '../php/connect.php';
if(!empty($_POST)){
	if ($conn){
		$query = "SELECT * FROM dbo.UserAccount WHERE IsActive = 1 AND Email = :Email AND 
		UserTypeId = (SELECT UserTypeId FROM dbo.UserTypes WHERE UserType='Admin')";
		$query_params = array(':Email' => $oldEmail);
		$stmt = $conn->prepare($query);
		$result = $stmt->execute($query_params) or die();
		$row = $stmt->fetch();
		$ID = $row['UserId'];
        
        if($row){
                $new_query = "UPDATE dbo.UserAccount SET FullName = :Name
				WHERE UserId = :ID";
                $new_query_params = array(
					':Name' => $newName,
					':ID' => $ID);
                $new_stmt = $conn->prepare($new_query);
                $new_result = $new_stmt->execute($new_query_params) or die();
				if($new_result){
					if (session_status() == PHP_SESSION_NONE) {
							session_start();
					}
					if ($_SESSION['admin']['user'] == $ID){
						$_SESSION['admin']['name'] = $newName;
					}
					$_SESSION['editUser']['editName'] = $newName;
					return false;
				} else {
					$err_msg = "error updating user with email: $oldEmail";
				}
		} else {
			    $err_msg = "Cannot find user with email: $oldEmail.  Try again";
		}
	}
}
echo $err_msg;
?>
