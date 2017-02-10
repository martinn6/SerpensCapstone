json_encode($result);<?php

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
    if(!($stmt = $conn->prepare("select UserAccount.id where UserAccount.email = ?"))){
        echo "Prepare failed: "  . $stmt->errorCode() . " " . $stmt->errorInfo();
        return;
    } 
    if(!($stmt->bindParam(1,$email,PDO::PARAM_STR, 50))){
        echo"Bind failed: "  . $stmt->errorCode() . " " . $stmt->errorInfo();
        return;
    } 
    if(!$stmt->execute()){
        echo "Execute failed: "  . $stmt->errorCode() . " " . $stmt->errorInfo();
        return
    } 
    if(!$stmt->bindResult($id)){
        echo "Bind Failed";
        return;
    } 
    $stmt->fetch();
    $stmt->close();


    // if($conn)
    // {
    //     $sql_select = "DELETE FROM dbo.UserAccount where UserAccount.Email = '".$email."'";
    //     $stmt = $conn->query($sql_select);
    //     $result = $stmt->fetchAll();
    //     echo json_encode($result);
    //     //return json_encode($result);
    //     return $result;

    //     if ($result['UserID'] === NULL) {
    //         return false;
    //     } else {
    //         return $result;
    //     }
    // }
?>
