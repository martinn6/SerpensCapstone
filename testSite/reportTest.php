<!DOCTYPE html>
<HTML>
<BODY>
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
		echo "<p>Connection Established.</p>";
		// fetch mysql table rows
		$sql = "SELECT * FROM dbo.Awards";
		$sqlResult = sqlsrv_query($conn, $sql);
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
	 
	 
	echo "<p>Done.</p>";
 ?>
</BODY>
</HTML>