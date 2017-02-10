<?php
	// DB connection info
	$host = "cs496osusql.database.windows.net";
	$user = "Serpins_Login";
	$pwd = "T3amSerpin$!";
	$db = "OSU_Capstone";
	echo "<p>Trying to connect....</p>";
	try{
		$conn = new PDO( "sqlsrv:Server= $host ; Database = $db ", $user, $pwd);
	}
	catch(Exception $e){
		die(print_r($e));
	}
	
	if($conn)
	{
		$sql_select = "SELECT * FROM dbo.Awards";
		$stmt = $conn->query($sql_select);
		$awards = $stmt->fetchAll();
		$file_name = "test.csv";
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
		# Close the stream off
        fclose($output);

	}

?>