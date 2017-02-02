<HTML>
<BODY>
	<?php

	$serverName = "tcp:cs496osusql.database.windows.net, 1433";
	$connectionOptions = array("Database" => "OSU_Capstone", 
							   "UID" => "Serpins_Login",
							   "PWD" => "T3amSerpin$!");
							   
	echo "Trying to connect...\n";
	$conn = sqlsrv_connect($serverName, $connectionOptions);
	 
	if($conn === false)
	{
		die(print_r(sqlsrv_errors(), true));
	}
			

	?>
</BODY>
</HTML>