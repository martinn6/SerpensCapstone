<?php

$email = $_POST["email"];
$password = $_POST["password"];
$name = $_POST["FName"] . ' ' . $_POST["LName"];

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
    if ($conn){
        $stm = $conn->prepare("SELECT COUNT(*) FROM dbo.UserAccount WHERE Email = :em");
        $stm->execute(array(':em' => $email));
        $result = $stm->fetchObject();
        if ($result->total > 0) {
            die(printf("Cannot add '" .$name. "' because the email '" .$email. "' already exists."));
        }
        $stmt = $conn->prepare("INSERT INTO dbo.UserAccount(Email,Password,FullName,UserTypeID)
            values(:em,:pw,:fn, (SELECT UserTypeId FROM dbo.UserTypes WHERE UserType=:ty))");
        try {
             $stmt->execute(array(
                ':em' => $email,
                ':pw' => $password,
                ':fn' => $name,
                ':ty' => 'Admin'
            )); 
        } catch (PDOException $e) {
            if ($e->errorInfo[1] == 1062) {
                die(printf("Cannot add '" .$name. "' because the email '" .$email. "' already exists."));
            } else {
                die(print_r($stmt->errorInfo()));
            }
        }
        printf("Added '" .$name. "' as an admin user.");
    }
?>
