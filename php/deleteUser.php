<?php
$email = $_POST["email"];
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
                $query = "DELETE FROM dbo.UserAccount WHERE UserId = :ID";
                $query_params = array(':ID' => $row['UserId']);
                $stmt = $conn->prepare($query);
                $result = $stmt->query($query_params) or die();
			if ($result){
				return false;
			} else {
				$err_msg = "Error deleting user with email: $email.";
			}
		} else {
			    $err_msg = "Cannot find user with email: $email.  Try again";
		}
	}
}
echo $err_msg;
?>
