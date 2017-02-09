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
        return "\r\n failure";
        die(print_r($e));
    }
    echo "connected\r\n";
    if(!($stmt = $conn->prepare("select userAccount.name from userAccount where UserAccount.email = ?"))){
        return "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
    }
    
    if(!($stmt->bindParam(1,$email,PDO::PARAM_STR, 50))){
        return "Bind failed: "  . $stmt->errno . " " . $stmt->error;
    } 

    if(!$stmt->execute()){
       return "Execute failed: "  . $stmt->errno . " " . $stmt->error;
    } 

    $name = $stmt->FullName();
    
    $stmt->fetch();
    $stmt->close();

    return $name;
?>
