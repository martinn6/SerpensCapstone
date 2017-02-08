<?php

$email = $_POST["email"];
echo $email;

    // DB connection info
    $host = "cs496osusql.database.windows.net";
    $user = "Serpins_Login";
    $pwd = "T3amSerpin$!";
    $db = "OSU_Capstone";
    echo "\r\n Trying to connect....\r\n";
    try{
        $conn = new PDO( "sqlsrv:Server= $host ; Database = $db ", $user, $pwd);
    }
    catch(Exception $e){
        echo "\r\n CONNECTION ERROR\r\n";
        die(print_r($e));
    }
    
    if($conn)
    {
      $sql_select = "SELECT * FROM dbo.UserAccount where email = '".$email."'";
		 $stmt = $conn->query($sql_select);
		 $user = $stmt->fetchAll();
         echo $user;
    }
    
    
echo "Done.";
?>
