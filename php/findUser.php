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
    
    if($conn)
    {
        //$sql_select = "SELECT * FROM dbo.UserAccount where Email = '".$email."'";
        $sql_select = "SELECT * FROM dbo.UserAccount";
        $stmt = $conn->query($sql_select);
        $result = $stmt->fetchAll();
        return $result;

        if ($result['FullName'] === NULL) {
            return false;
        } else {
            return $result;
        }
    }
?>
