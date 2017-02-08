<?php

$data = file_get_contents("php://input");
echo $data;
echo "\r\n";
$_POST = json_decode(file_get_contents('php://input'), true);
$email = $_POST["email"];
echo $email;

//     // DB connection info
//     $host = "cs496osusql.database.windows.net";
//     $user = "Serpins_Login";
//     $pwd = "T3amSerpin$!";
//     $db = "OSU_Capstone";
//     echo "<p>Trying to connect....</p>";
//     try{
//         $conn = new PDO( "sqlsrv:Server= $host ; Database = $db ", $user, $pwd);
//     }
//     catch(Exception $e){
//         die(print_r($e));
//     }
    
//     if($conn)
//     {
      
//     }
    
    
// echo "<p>Done.</p>";
?>
