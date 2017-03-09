<?php
$table = $_POST['table'];
require '../php/connect.php';
if(!empty($_POST)){
	if($conn)
	{
		if ($table == "users") {
			$query = '	SELECT 		* 
						FROM 		dbo.UserAccount';
		} else if ($table == "EOM") {
			$query = '	SELECT 		dbo.UserAccount.FullName, 
									dbo.Awards.AwardTypeName,
									dbo.AwardsGiven.AwardedDate,
									dbo.AwardsGiven.AwardURL
					  	FROM 		dbo.UserAccount
						WHERE 		dbo.Awards.AwardTypeName = "Employee of the Month"
						JOIN		dbo.AwardsGiven on dbo.UserAccount.UserId = dbo.AwardsGiven.AwardedToUserId
						JOIN 		dbo.Awards on dbo.AwardGiven.AwardId = dbo.Awards.AwardId';
		} else if ($table == "EOY") {
			$query = '	SELECT 		dbo.UserAccount.FullName, 
									dbo.Awards.AwardTypeName,
									dbo.AwardsGiven.AwardedDate,
									dbo.AwardsGiven.AwardURL
						FROM 		dbo.UserAccount
						WHERE 		dbo.Awards.AwardTypeName = "Employee of the Month"
						INNER JOIN 	dbo.AwardGiven on dbo.UserAccount.UserId=dbo.AwardsGiven.AwardedToUserId
						INNER JOIN 	dbo.Awards on dbo.AwardGiven.AwardId=dbo.Awards.AwardId';
		} else if ($table == "ABM") {
			$query = '	SELECT 		* --count(*)
					 	FROM 		[dbo].[AwardsGiven] AS ag
					  	-- GROUP BY 	MONTHNAME(ag.CreatedDateTime)
						  ';
		} else if ($table == "ABT") {
			$query = '	SELECT 		* --count(*)
					 	FROM 		[dbo].[Awards] AS a
					  	-- GROUP BY 	a.AwardTypeName
						  ';
		}
		
	
		$stmt = $conn->prepare($query);
		$result = $stmt->execute() or die();

		$array = $stmt->fetchAll( PDO::FETCH_ASSOC );
		$json=json_encode($array);
		header('Content-type: application/json');
		echo $json;
		die();
	}
}

?>
