<?php

$email = $_POST["email"];
$password = $_POST["password"];
$name = $_POST["fName"] $_POST["lName"];
echo $name;
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
    
    if(!($stmt = $conn->prepare("Insert into dbo.UserAccount(Email,Password,FullName,UserTypeID)
    values((?),(?),(?) (SELECT id from UserType where UserType.id=(?)))"))){
        echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
    }
    if(!($stmt->bind_param($email,$passsword,$name,"admin"))){
        echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
    }
    if(!$stmt->execute()){
    if($stmt->errno == 1062){
        echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
    } 
    } else {
        echo "Added '" .$name."'.";
    }  
    $stmt->close();

?>
