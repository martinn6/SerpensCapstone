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
			$query = '	SELECT 		aws.AwardTypeName AS "Award", count(*) AS "Total"
									,isnull(sum(case when month(ag.CreatedDateTime) = 1 then Qty end), 0) Jan
									,isnull(sum(case when month(ag.CreatedDateTime) = 2 then Qty end), 0) Feb 
									,isnull(sum(case when month(ag.CreatedDateTime) = 3 then Qty end), 0) Mar
									,isnull(sum(case when month(ag.CreatedDateTime) = 4 then Qty end), 0) Apr
									,isnull(sum(case when month(ag.CreatedDateTime) = 5 then Qty end), 0) May
									,isnull(sum(case when month(ag.CreatedDateTime) = 6 then Qty end), 0) Jun
									,isnull(sum(case when month(ag.CreatedDateTime) = 7 then Qty end), 0) Jul
									,isnull(sum(case when month(ag.CreatedDateTime) = 8 then Qty end), 0) Aug
									,isnull(sum(case when month(ag.CreatedDateTime) = 9 then Qty end), 0) Sep
									,isnull(sum(case when month(ag.CreatedDateTime) = 10 then Qty end), 0) Oct
									,isnull(sum(case when month(ag.CreatedDateTime) = 11 then Qty end), 0) Nov
									,isnull(sum(case when month(ag.CreatedDateTime) = 12 then Qty end), 0) Dec
					 	FROM 		[dbo].[AwardsGiven] AS ag
						 JOIN 		[dbo].[Awards] AS aws ON aws.AwardId = ag.AwardId
					  	GROUP BY 	Award
						  ';
		} else if ($table == "ABT") {
			$query = '	SELECT 		aws.AwardTypeName AS "Award", count(*) AS "Count"
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
