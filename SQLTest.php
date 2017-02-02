<HTML>
<BODY>
	<?php

	$serverName = "tcp:cs496osusql.database.windows.net, 1433";
	$connectionOptions = array("Database" => "OSU_Capstone", 
							   "UID" => "Serpins_Login",
							   "PWD" => "T3amSerpin$!");
							   
	echo "Trying to connect...\n";
	$connection = sqlsrv_connect($serverName, $connectionOptions);
	 
	if($connection === false)
	{
		die(print_r(sqlsrv_errors(), true));
	}
		
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