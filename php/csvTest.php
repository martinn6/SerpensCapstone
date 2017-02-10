<?php

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
		$stmt = $conn->prepare('SELECT * FROM ?');
		$stmt->bindParam(1, $_GET['MyTable'], PDO::PARAM_STR, 25);
		$stmt->execute();
		$awards = $stmt->fetchAll();
		$file_name = $_GET['title'];
		header("Last-Modified: " . gmdate("D, d M Y H:i:s",$_GET['timestamp']) . " GMT");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header('Content-Description: File Transfer');
		header("Content-type: text/csv");
		header("Content-Disposition: attachment; filename={$file_name}");
		header("Expires: 0");
		header("Pragma: public");
        $output = fopen("php://output", "w");
		 if(count($awards) > 0) {
			foreach($awards as $award) {
				fputcsv($output, $award);
			}
		}	
        fclose($output);

	}

?>