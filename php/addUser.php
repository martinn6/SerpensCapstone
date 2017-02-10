<?php

$email = $_POST["email"];
$password = $_POST["password"];
$name = $_POST["FName"] . ' ' . $_POST["LName"];

    // DB connection info
    $host = "cs496osusql.database.windows.net";
    $user = "Serpins_Login";
    $pwd = "T3amSerpin$!";
    $db = "OSU_Capstone";
    try{
        $conn = new PDO( "sqlsrv:Server= $host ; Database = $db ", $user, $pwd);
    }
    catch(Exception $e){
        die(print_r($e));
    }
    if(!($stmt = $conn->prepare("INSERT INTO dbo.UserAccount(Email,Password,FullName,UserTypeID)
    values(:em,:pw,:fn (SELECT id FROM dbo.UserType WHERE id=Admin))"))){
        die(print_r($stmt->errorInfo()));
    } 
    if(!$stmt->execute(array(
        ':em' => $email,
        ':pw' => $password,
        ':fn' => $name,
    ))){
        if($stmt->errorInfo() == 1062){
        die(printf("Cannot add '" .$name. "' because there is already a user with the email '".$email."'."));
        } else {
            die(print_r($stmt->errorInfo()));
        } 
    } else {
        printf("Added '" .$user. "' as an admin user.");
    }  
    $stmt->close();
    
?>
