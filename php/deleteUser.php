<?php

$email = $_POST["email"];

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
    if(!($stmt = $conn->prepare("SELECT id FROM dbo.UserAccount WHERE email = :email"))){
        die(print_r($stmt->errorInfo()));
    } 
    if(!($stmt->bindParam(:email, $email, PDO::PARAM_STR, 50))){
        die(print_r($stmt->errorInfo()));
    } 
    if(!$stmt->execute()){
        die(print_r($stmt->errorInfo()));
    } 
    
    $stmt->fetch();
    $stmt->close();

?>
