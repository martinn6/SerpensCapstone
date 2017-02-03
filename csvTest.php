<?php
    // mysql database connection details
    $host = "cs496osusql.database.windows.net";
	 $username = "Serpins_Login";
	 $password = "T3amSerpin$!";
	 $dbname = "OSU_Capstone";


    // open connection to sql database
    try{
		 $conn = new PDO( "sqlsrv:Server= $host ; Database = $db ", $user, $pwd);
	  }
	 catch(Exception $e){
		 die(print_r($e));
	 }
    
    // fetch mysql table rows
    $sql = "SELECT * FROM dbo.Awards";
    $sqlResultesult = sqlsrv_query($conn, $sql);

$csvName = "export.csv"

$fp = fopen(csvName , 'w');

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
    //close the db connection
    mysqli_close($connection);
?>