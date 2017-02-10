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
    if(!($stmt = $conn->prepare('select name from UserAccount where email = :email'))){
        die(print_r($stmt->errorInfo()));
    }
    
    if(!($stmt->bindParam(:email,$email,PDO::PARAM_STR, 50))){
        die(print_r($stmt->errorInfo()));
    } 

    if(!$stmt->execute()){
       die(print_r($stmt->errorCode()));
    } 

    $name = $stmt->FullName();
    
    $stmt->fetch();
    $stmt->close();

    print_r($name);
?>
