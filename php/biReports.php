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
			$query = '	SELECT TOP 5 ua.FullName as "User", 
									count(ag.AwardId) as "Count" 
					  	FROM 		[dbo].[AwardsGiven] AS ag
						JOIN 		[dbo].[UserAccount] AS ua ON ua.UserID = ag.AwardGivenByUserId
						WHERE		ua.IsActive = 1 AND
									ag.IsDeleted = 0
						GROUP BY 	ua.FullName
						ORDER BY	Count DESC
						';
		// } else if ($table == "ABUGforCSV") {
		// 	$query = '	SELECT		ua.FullName as "User", 
		// 							ag.AwardedToFullName as "Award Given To"
		// 			  	FROM 		[dbo].[AwardsGiven] AS ag
		// 				WHERE		ua.IsActive = 1						  
		// 				JOIN 		[dbo].[UserAccount] AS ua ON ua.UserID = ag.AwardGivenByUserId
		// 				GROUP BY 	ua.FullName
		// 				';
		} else if ($table == "ABM") {
			$query = '	SELECT 		-- CONVERT(varchar(2),  ag.AwardedDate, 101) as "Month",
									CONCAT(CONVERT(varchar(2),  ag.AwardedDate, 101), CONVERT(varchar(3),  ag.AwardedDate, 0)) as "Month",
									count(*) AS "Total"
  					 	FROM 		[dbo].[AwardsGiven] AS ag
						WHERE		ag.IsDeleted = 0
						-- GROUP BY	CONVERT(varchar(2),  ag.AwardedDate, 101)
						GROUP BY   	CONCAT(CONVERT(varchar(2),  ag.AwardedDate, 101), CONVERT(varchar(3),  ag.AwardedDate, 0))
						';
		// } else if ($table == "ABMforCSV") {
		// 	$query = '	SELECT 		"Award Month" = datename(m, ag.AwardedDate),  
		// 							ag.AwardedToFullName as "Award Given To",
		// 							ua.FullName as "User"
  		// 			 	FROM 		[dbo].[AwardsGiven] AS ag
		// 				JOIN 		[dbo].[UserAccount] AS ua ON ua.UserID = ag.AwardGivenByUserId
		// 				WHERE		ag.IsDeleted = 0
  		// 			  	GROUP BY 	datename(m, ag.AwardedDate)
		// 				';
		} else if ($table == "ABT") {
			$query = '	SELECT 		aws.AwardTypeName AS "Award", 
									count(*) AS "Count"
					 	FROM 		[dbo].[AwardsGiven] AS ag
						JOIN 		[dbo].[Awards] AS aws ON aws.AwardId = ag.AwardId
						WHERE		ag.IsDeleted = 0						
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
