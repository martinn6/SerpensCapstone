<HTML>
<BODY>
<?php

$server = "cs496osusql.database.windows.net";
$username = "Serpins_Login";
$password = "T3amSerpin$!";
$database = "OSU_Capstone";
try
{
	echo "Trying Connection...";
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