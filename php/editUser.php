<?php
header('Location: ../views/admin.html');
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
        die(print_r($stmt->errorInfo()));
    }
    
    if(!($stmt->bindParam(1,$email,PDO::PARAM_STR, 50))){
        die(print_r($stmt->errorInfo()));
    } 

    if(!$stmt->execute()){
       die(print_r($stmt->errorInfo()));
    } 

    $name = $stmt->FullName();
    
    $stmt->fetch();
    $stmt->close();

    print_r($name);
?>