<HTML>
<BODY>
	<?php

	$server = "cs496osusql.database.windows.net,1433";
	$username = "Serpins_Login";
	$password = "T3amSerpin$!";
	$database = "OSU_Capstone";
	
	try
	{
		echo "Trying Connection to $server...\n";
		$conn = new PDO("sqlsrv:server=$server ; Database = $database", $username, $password);
	}
	catch(Exception $e)
	{
		echo "Connection Failed.";
		die(print_r($e));
	}

	echo "Done.";
	
	if ($connection)
	{
		$res= mssql_query('SELECT * FROM [OSU_Capstone].[dbo].[Awards]', $connection);
        print_r(mssql_get_last_message());
        $row = mssql_fetch_array($res);

        echo $row[0];

	}	


	?>
</BODY>
</HTML>