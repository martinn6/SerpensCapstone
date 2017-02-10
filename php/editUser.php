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
    if(!($stmt = $conn->prepare("select userAccount.name from userAccount where UserAccount.email = ?"))){
        echo "Prepare failed: "  . $stmt->errorCode() . " " . $stmt->errorInfo();
        return;
    }
    
    if(!($stmt->bindParam(1,$email,PDO::PARAM_STR, 50))){
        echo "Bind failed: "  . $stmt->errorCode() . " " . $stmt->errorInfo();
        return;
    } 

    if(!$stmt->execute()){
       return "Execute failed: "  . $stmt->errorCode() . " " . $stmt->errorInfo();
       return;
    } 

    $name = $stmt->FullName();
    
    $stmt->fetch();
    $stmt->close();

    echo $name;
?>
