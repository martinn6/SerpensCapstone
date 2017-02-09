<?php

$email = $_POST["email"];
$password = $_POST["password"];
$name = $_POST["fName"] $_POST["lName"];
echo $name;
    // DB connection info
    $host = "cs496osusql.database.windows.net";
    $user = "Serpins_Login";
    $pwd = "T3amSerpin$!";
    $db = "OSU_Capstone";
    try{
        $conn = new PDO( "sqlsrv:Server= $host ; Database = $db ", $user, $pwd);
    }
    catch(Exception $e){
        return "\r\n failure";
        die(print_r($e));
    }
    echo "connected\r\n";
    if(!($stmt = $conn->prepare("Insert into UserAccount(Email,Password,FullName,UserTypeID)
    values(:em,:pw,:fn (SELECT id from UserType where UserType.id=:ut))"))){
        return "Prepare failed: "  . $stmt->errorCode() . " " . $stmt->errorInfo();
    } else {
        return "prepare success\r\n";
    }
    if(!$stmt->execute(array(
        ':em' => $email,
        ':pw' => $password,
        ':fn' => $name,
        ':ut' => 'Admin'
    ))){
        if($stmt->errno == 1062){
        return "Cannot add '" .$name. "' because there is already a user with the email '".$email."'.";
        } else {
            return "Execute failed: "  . $stmt->errorCode() . " " . $stmt->errorInfo();;
        } 
    } else {
        return "Added '" .$user. "' as an admin user.";
    }  
    $stmt->close();
    
?>
