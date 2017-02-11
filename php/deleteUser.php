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
        try {
            $stmt->execute(array('email' => $email));
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $name = $result['FullName'];
        } catch (PDOException $e) {
            if ($e->errorInfo[1] == 1054) {
                die(printf("Cannot find user with email '" .$email. "'."));
            } else {
                die(print_r($stmt->errorInfo()));
            }
        }
        $stmt = $conn->prepare('DELETE FROM dbo.UserAccount WHERE email = :email');
        try {
            $stmt->execute(array('email' => $email));
        } catch (PDOException $e) {
            if ($e->errorInfo[1] == 1054) {
                die(printf("Cannot find user with email '" .$name. "'."));
            } else {
                die(print_r($stmt->errorInfo()));
            }
        }
        printf("Deleted '" .$email. "' from the database. ");
    }

?>
