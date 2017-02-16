<?php

$email = $_POST["email"];
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
            $cred_match = true;
        }
        if ($cred_match){
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
			$_SESSION['editUserEmail'] = $row['Email'];
			$_SESSION['editUserName']  = $row['FullName'];
			// header("Location : ../admin/admin.php"); 
			return false;
		} else {
			$err_msg = "Cannot find user. Try again";
		}
	}
	echo $err_msg;
    }
}
//         $stm = $conn->prepare("SELECT COUNT(*) FROM dbo.UserAccount WHERE Email = :em");
//         $stm->execute(array(':em' => $email));
//         $total = $stm->fetchColumn(); 
//         if ($total == 0) {
//             die(printf("Cannot find user with email '" .$email. "'."));
//         }
//         $stmt = $conn->prepare('SELECT FullName,Email FROM dbo.UserAccount WHERE Email = :email');
//         try {
//             $stmt->execute(array('email' => $email));
//             $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
//             $name = $result['FullName'];
//         } catch (PDOException $e) {
//             if ($e->errorInfo[1] == 1054) {
//                 printf("Cannot find user with email '" .$email. "'.");
//             } else {
//                 die(print_r($stmt->errorInfo()));
//             }
//         }
//         $ret = array('email'=>$email,'name'=>$name);
//         print_r($ret);
//         print_r(json_encode($result));
//     }
?>
