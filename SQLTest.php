<HTML>
<BODY>
	<?php
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
 echo "Done.\n";
 ?>
</BODY>
</HTML>