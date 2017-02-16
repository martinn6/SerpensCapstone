<?
require '../php/connect.php';

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
            if(md5($_POST['password']) === $row['Password']){
				$cred_match = true;
			} else if($_POST['password'] === $row['Password']){
				$cred_match = true;
			}
			
		}
		
		if ($cred_match){
            session_start();
            $_SERVER['admin'] = $row;
			$_SESSION['email'] = $row['Email'];
			$_SESSION['user']  = $row['FullName'];
			// header("Location : ../admin/admin.php"); 
			return false;
		} else {
			$err_msg = "Email/Password does not match. Try again";
		}
	}
	echo $err_msg;
} 
?>