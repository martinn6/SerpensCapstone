<?php

$email = $_POST["email"];
echo $email;

    // DB connection info
    $host = "cs496osusql.database.windows.net";
    $user = "Serpins_Login";
    $pwd = "T3amSerpin$!";
    $db = "OSU_Capstone";
    try{
        $conn = new PDO( "sqlsrv:Server= $host ; Database = $db ", $user, $pwd);
    }
    catch(Exception $e){
        echo "\r\n failure";
        die(print_r($e));
    }
    echo "connected\r\n";
    if(!($stmt = $conn->prepare("select userAccount.name from userAccount where UserAccount.email = ?"))){
        echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
    } else {
        echo "prepare success\r\n";
    }
    if(!($stmt->bindParam(1,$email,PDO::PARAM_STR, 50))){
        echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
    } else {
        echo "bind success\r\n";
    }
    if(!$stmt->execute()){
        echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
    } else {
        echo "execute success\r\n";
    }
    $name = $stmt->FullName();
    echo $name;
    $stmt->fetch();
    $stmt->close();
?>
