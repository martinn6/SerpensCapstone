<?php
$table = $_POST['table'];
require '../php/connect.php';
if(!empty($_POST)){
	if($conn)
	{
		if ($table == "users") {
			$query = '	SELECT 		* 
						FROM 		[dbo].[UserAccount] AS ua';
		} else if ($table == "awards") {
			$query = '	SELECT 		* 
						FROM 		[dbo].[AwardsGiven] AS ag';
		} else if ($table == "userTypes") {
			$query = '	SELECT 		* 
						FROM 		[dbo].[UserTypes] AS ut';
		} else if ($table == "awardTypes") {
			$query = '	SELECT 		* 
						FROM 		[dbo].[Awards] AS at';
		} else if ($table == "UBT") {
			$query = '	SELECT 		ut.UserType as "Type", 
									count(*) as "Count" 
					  	FROM 		[dbo].[UserAccount] AS ua
						JOIN 		[dbo].[UserTypes] AS ut ON ut.UserTypeId = ua.UserTypeId
						WHERE		ua.IsActive = 1
						GROUP BY 	ut.UserType
						';
		} else if ($table == "ABUG") {
			$query = '	SELECT 		ua.FullName as "User", 
									count(ag.AwardId) as "Count" 
					  	FROM 		[dbo].[AwardsGiven] AS ag
						JOIN 		[dbo].[UserAccount] AS ua ON ua.UserID = ag.AwardGivenByUserId
						WHERE		ua.IsActive = 1
						GROUP BY 	ua.FullName
						';
		} else if ($table == "ABM") {
			$query = '	SELECT 		Month = datename(m, ag.AwardedDate), 
									count(*) AS "Total"
  					 	FROM 		[dbo].[AwardsGiven] AS ag
  					  	GROUP BY 	datename(m, ag.AwardedDate)
						';
		} else if ($table == "ABT") {
			$query = '	SELECT 		aws.AwardTypeName AS "Award", 
									count(*) AS "Count"
					 	FROM 		[dbo].[AwardsGiven] AS ag
						JOIN 		[dbo].[Awards] AS aws ON aws.AwardId = ag.AwardId
					  	GROUP BY 	aws.AwardTypeName
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
