<?php

$email = $_POST["email"];
$password = md5($_POST["password"]);
$name = $_POST["name"];
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
                $err_msg = "Cannot add user because $email already is an admin user.";
		} else {
            $query = "INSERT INTO dbo.UserAccount (UserTypeId, Email, FullName, Password) "
                . "VALUES ((SELECT UserTypeId FROM dbo.UserTypes WHERE UserType='Admin'), :Email, :FullName, :Password)";
			$query_params = array(
				':Email' => $email,
				':FullName' => $name,
				':Password' => $password
			);
			$stmt = $conn->prepare($query);
			$stmt->execute($query_params) or die();
            $scs_msg = "$name was added as an admin user";
            echo $scs_msg;
            return;
		}
	}
}
echo $err_msg;
return;
?>
