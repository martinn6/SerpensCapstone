<HTML>
<BODY>
	<?php

	$server = "cs496osusql.database.windows.net,1433";
	$username = "Serpins_Login";
	$password = "T3amSerpin$!";
	$database = "OSU_Capstone";
	
	try
	{
		echo "Trying Connection to $server...";
		$conn = new PDO("sqlsrv:server=$server ; Database = $database", $username, $password);
	}
	catch(Exception $e)
	{
		echo "Connection Failed.";
		die(print_r($e));
	}

	echo "Done.";


	?>
</BODY>
</HTML>