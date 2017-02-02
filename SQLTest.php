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
		 $sql_select = "SELECT * FROM dbo.Awards";
		 $stmt = $conn->query($sql_select);
		 $awards = $stmt->fetchAll();
		 if(count($awards) > 0) {
			 echo "<h2>Awards:</h2>";
			 echo "<table>";
			 echo "<tr><th>AwardId</th>";
			 echo "<th>Award Name</th></tr>";
			foreach($awardss as $award) {
				echo "<tr><td>".$award['AwardId']."</td>";
				echo "<td>".$award['AwardTypeName']."</td></tr>";
			}
			echo "<table>";
		}	
		else {
			echo "<p>No awards found.</p>";
		} 
	 }
	 
	 
	echo "<p>Done.</p>";
 ?>
</BODY>
</HTML>