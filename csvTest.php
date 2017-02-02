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
    $result = sqlsrv_query($conn, $sql);

if (!$result) die ('Couldn\'t fetch records');

$headers = array();

foreach (sqlsrv_field_metadata($result) as $fieldMetadata) {
    $headers[] = $fieldMetadata['Name'];
}

$fp = fopen('php://output', 'w');
if ($fp && $result) {
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="export.csv"');
    header('Pragma: no-cache');
    header('Expires: 0');
    fputcsv($fp, $headers);
    while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_NUMERIC)) {
        fputcsv($fp, array_values($row));
    }
    die;
}

    //close the db connection
    mysqli_close($connection);
?>