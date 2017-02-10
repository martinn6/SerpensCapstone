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
		header("Content-Type: text/csv");
        header("Content-Disposition: attachment; filename=$file_name");
        # Disable caching - HTTP 1.1
        header("Cache-Control: no-cache, no-store, must-revalidate");
        # Disable caching - HTTP 1.0
        header("Pragma: no-cache");
        # Disable caching - Proxies
        header("Expires: 0");
        # Start the ouput
        $output = fopen("php://output", "w");
		 if(count($awards) > 0) {
			foreach($awards as $award) {
				fputcsv($output, $row);
			}
		}	
		# Close the stream off
        fclose($output);

	}

?>