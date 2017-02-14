<?php

$email = $_POST["email"];

    // DB connection info
    $host = "cs496osusql.database.windows.net";
    $user = "Serpins_Login";
    $pwd = "T3amSerpin$!";
    $db = "OSU_Capstone";
    try{
        $conn = new PDO( "sqlsrv:Server= $host ; Database = $db ", $user, $pwd);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch(Exception $e){
        die(print_r($e));
    }

    if ($conn)
    { 
        $stm = $conn->prepare("SELECT COUNT(*) FROM dbo.UserAccount WHERE Email = :em");
        $stm->execute(array(':em' => $email));
        $total = $stm->fetch(PDO::FETCH_NUM);
        if ($total = 0) {
            die(printf("Cannot find user with email '" .$email. "'."));
        }
        
        try {
            $stmt = $conn->prepare('DELETE FROM dbo.UserAccount WHERE email = :email');
            $stmt->execute(array('email' => $email));
        } catch (PDOException $e) {
            if ($e->errorInfo[1] == 1054) {
                die(printf("Cannot find user with email '" .$email. "'."));
            } else {
                die(print_r($stmt->errorInfo()));
            }
        }
        printf("Deleted '" .$email. "' from the database. ");
    }

?>
