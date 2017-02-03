<!DOCTYPE html>
<HTML>
<BODY>
<?php
    echo"<p>Start</p>";
	DB connection info
	$host = "cs496osusql.database.windows.net";
	 $user = "Serpins_Login";
	 $pwd = "T3amSerpin$!";
	 $db = "OSU_Capstone";
	 echo "<p>Trying to connect....</p>";
	 try{
		 $conn = new PDO( "sqlsrv:Server= $host ; Database = $db ", $user, $pwd);
	  }
	 catch(Exception $e){
         echo"<p>fail</p>";
		 die(print_r($e));
	 }
	
	if($conn)
	{
		echo "<p>Connection Established.</p>";
		// fetch mysql table rows
		$sql = "SELECT * FROM dbo.Awards";
		$sqlResultesult = sqlsrv_query($conn, $sql);
		$csvName = "export.csv"
		$fp = fopen(csvName , 'w');
		echo "opened";
		while ($export = odbc_fetch_array($sqlRresult)) {
			if (!isset($headings))
			{
				$headings = array_keys($export);
				fputcsv($fp, $headings, ',', '"');
			}
			fputcsv($fp, $export, ',', '"');
		}
		fclose($fp);
		echo "<p>success</p>";
	}
 ?>
</BODY>
</HTML>