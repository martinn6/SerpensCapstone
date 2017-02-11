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
    if ($conn)
    {
        $stmt = $conn->prepare('SELECT FullName FROM dbo.UserAccount WHERE email = :email');
		$stmt->execute(array('email' => $email));
    
        $result = $stmt->fetchAll();
        print_r($result);
    }
?>
