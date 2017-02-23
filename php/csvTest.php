<?php
	$table = $_GET['table'];
	$file_name = $_GET['filename'];

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
		header("Last-Modified: " . gmdate("D, d M Y H:i:s",$_GET['timestamp']) . " GMT");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header('Content-Description: File Transfer');
		header("Content-type: text/csv");
		header("Content-Disposition: attachment; filename={$file_name}");
		header("Expires: 0");
		header("Pragma: public");		
        $output = fopen("php://output", "w");
		$stmt = $conn->prepare('SELECT * FROM :table');
		$query_params = array(':table' => $table);
		$stmt->execute();
		$result = $stmt->fetch();
		echo $result;
		foreach($result as $row) {
			fputcsv($output, $row);
		}
        fclose($output);

	}

?>
