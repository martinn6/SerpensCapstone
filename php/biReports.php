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
			$query = '	SELECT 		Month = datename(m, ag.CreatedDateTime), count(*) AS "Total"
  					 	FROM 		[dbo].[AwardsGiven] AS ag
  					  	GROUP BY 	datename(m, ag.CreatedDateTime)
						  ';
		} else if ($table == "ABT") {
			$query = '	SELECT 		aws.AwardTypeName AS "Award", count(*) AS "Count"
					 	FROM 		[dbo].[AwardsGiven] AS ag
						JOIN 		[dbo].[Awards] AS aws ON aws.AwardId = ag.AwardId
					  	GROUP BY 	aws.AwardTypeName
						  ';
		} else if ($table == "Atest") {
			$query = '	count(*) AS "Total",
    Count(CASE MONTH(ag.CreatedDateTime) WHEN 1 THEN ag.AwardId END) AS Jan,
    Count(CASE MONTH(ag.CreatedDateTime) WHEN 2 THEN ag.AwardId END) AS Feb,
    Count(CASE MONTH(ag.CreatedDateTime) WHEN 3 THEN ag.AwardId END) AS Mar,
    Count(CASE MONTH(ag.CreatedDateTime) WHEN 4 THEN ag.AwardId END) AS Apr,
    Count(CASE MONTH(ag.CreatedDateTime) WHEN 5 THEN ag.AwardId END) AS May,
    Count(CASE MONTH(ag.CreatedDateTime) WHEN 6 THEN ag.AwardId END) AS Jun,
    Count(CASE MONTH(ag.CreatedDateTime) WHEN 7 THEN ag.AwardId END) AS Jul,
    Count(CASE MONTH(ag.CreatedDateTime) WHEN 8 THEN ag.AwardId END) AS Aug,
    Count(CASE MONTH(ag.CreatedDateTime) WHEN 9 THEN ag.AwardId END) AS Sep,
    Count(CASE MONTH(ag.CreatedDateTime) WHEN 10 THEN ag.AwardId END) AS Oct,
    Count(CASE MONTH(ag.CreatedDateTime) WHEN 11 THEN ag.AwardId END) AS Nov,
    Count(CASE MONTH(ag.CreatedDateTime) WHEN 12 THEN ag.AwardId END) AS Dec
FROM dbo].[AwardsGiven] AS ag
GROUP BY datename(m, ag.CreatedDateTime)
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
