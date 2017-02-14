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
        $stmt = $conn->prepare("IF NOT EXISTS (SELECT * FROM dbo.UserAccount WHERE Email = :xe)
        BEGIN
        INSERT INTO dbo.UserAccount(Email,Password,FullName,UserTypeID)
            values(:em,:pw,:fn, (SELECT UserTypeId FROM dbo.UserTypes WHERE UserType=:ty))
        END");
        try {
             $stmt->execute(array(
                ':xe' => $email,
                ':em' => $email,
                ':pw' => $password,
                ':fn' => $name,
                ':ty' => 'Admin'
            )); 
            printf("Added '" .$name. "' as an admin user.");
        } catch (PDOException $e) {
            if ($e->errorInfo[1] == 1062) {
                printf("Cannot add '" .$name. "' because the email '" .$email. "' already exists.");
            } else {
                die(print_r($stmt->errorInfo()));
            }
        }    
    }
?>
