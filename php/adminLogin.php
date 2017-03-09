<?
require '../php/connect.php';

$cred_match = false;

if(!empty($_POST)){
	if ($conn){
		$err_msg = "conn ";
		$query = "SELECT * FROM dbo.UserAccount WHERE IsActive = :Active AND Email = :Email AND 
		UserTypeId = (SELECT UserTypeId FROM dbo.UserTypes WHERE UserType='Admin')";
		$query_params = array(
			':Email' => $_POST['email'],
			':Active' => 1);
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
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
			$adminUser = array ('email' => $row['Email'], 'name' => $row['FullName'], 'user' => $row['UserId']);
			$_SESSION['admin'] = $adminUser;
			return false;
		} else {
			$err_msg = "Email/Password does not match. Try again";
		}
	}
	echo $err_msg;
} 
?>
