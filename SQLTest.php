<HTML>
<BODY>
	<?php
	 // DB connection info
	 $host = "cs496osusql.database.windows.net";
	 $user = "Serpins_Login";
	 $pwd = "T3amSerpin$!";
	 $db = "OSU_Capstone";
	 echo "Trying to connect....\n";
	 try{
		 $conn = new PDO( "sqlsrv:Server= $host ; Database = $db ", $user, $pwd);
	  }
	 catch(Exception $e){
		 die(print_r($e));
	 }
	 
	 if($conn)
	 {
		 echo "Connection Established.\n";
	 }
	 
	 
 echo "Done.\n";
 ?>
</BODY>
</HTML>