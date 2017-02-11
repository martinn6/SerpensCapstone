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

		$stmt = $conn->prepare('SELECT * FROM dbo.UserAccount');
		$stmt->execute();
		$result = $stmt->fetchAll();

		// first set
		$first_row = $stmt->fetch(PDO::FETCH_ASSOC);
		$headers = array_keys($first_row);
		fputcsv($output, $headers); // put the headers
		fputcsv($output, array_values($first_row)); // put the first row

		while ($row = $stmt->fetch(PDO::FETCH_NUM))  {
		fputcsv($output,$row); // push the rest
		}
		fclose($output); 

	}

?>