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
		if ($table = "users") {
			$stmt = $conn->prepare('SELECT FullName, UserName, Password FROM dbo.UserAccount');
		} else if ($table = "EOM") {
			$stmt = $conn->prepare(
			'SELECT dbo.UserAccount.FullName, 
					dbo.Awards.AwardTypeName,
					dbo.AwardGiven.AwardedDate,
					dbo.AwardGiven.AwardURL
					FROM dbo.UserAccount
					WHERE dbo.Awards.AwardTypeName = "Employee of the Month"
			INNER JOIN dbo.AwardGiven on dbo.UserAccount.UserId=dbo.AwardGiven.AwardedToUserId
			INNER JOIN dbo.Awards on dbo.AwardGiven.AwardId=dbo.Awards.AwardId');
		} else if ($table = "EOY") {
			$stmt = $conn->prepare(
			'SELECT dbo.UserAccount.FullName, 
					dbo.Awards.AwardTypeName,
					dbo.AwardGiven.AwardedDate,
					dbo.AwardGiven.AwardURL
					FROM dbo.UserAccount
					WHERE dbo.Awards.AwardTypeName = "Employee of the Month"
			INNER JOIN dbo.AwardGiven on dbo.UserAccount.UserId=dbo.AwardGiven.AwardedToUserId
			INNER JOIN dbo.Awards on dbo.AwardGiven.AwardId=dbo.Awards.AwardId');

		}
		
		$query_params = array(':table' => $table);
		$result = $stmt->execute($query_params) or die();
		foreach($result as $row) {
			fputcsv($output, $row);
		}
        fclose($output);

	}

?>
