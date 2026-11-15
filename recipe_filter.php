<?php
session_start();

require_once "dbconnect.php";

if($_SESSION['user_name'] == null)
{
	echo json_encode([
		"success"=>false,
		"message"=>"login first"
	]);
	session_destroy();
	exit;
}
else if($_SERVER['REQUEST_METHOD'] == 'POST')
{
	if( !isset($_POST['map']) )
	{
		echo json_encode([
			"status"=>false,
			"message"=>"give nessacary details",
		]);
		exit;
	}
	$map = explode(',',$_POST['map']);
	//map must have data like    1,2,3,4
	//send data in json via js 
	
	$sql = "SELECT * FROM ";
	$i = 1;

	try
	{
		$flag = 0 ; 
		foreach($map as $m)
		{
			if($flag == 0 )
			{
				$sql = $sql." ( SELECT r1.`recipe_id`,`recipe_name`,`recipe_description`,`recipe_step`,`recipe_ingredient`,`added_by` FROM `recipe` as r1 JOIN `recpe_level_3_catagorization_map` AS r2 ON r1.`recipe_id`= r2.`recipe_id` JOIN `Level_3_catagorization` as r3 on r2.`category3_id` = r3.`catagory3_id` WHERE r3.catagory3_id = ".$m.") AS t".$i." ";
				$flag = 1;
			}
			else
			{
				$s = $i - 1;
				$sql = $sql."join ( SELECT r1.`recipe_id`,`recipe_name`,`recipe_description`,`recipe_step`,`recipe_ingredient`,`added_by` FROM `recipe` as r1 JOIN `recpe_level_3_catagorization_map` AS r2 ON r1.`recipe_id`= r2.`recipe_id` JOIN `Level_3_catagorization` as r3 on r2.`category3_id` = r3.`catagory3_id` WHERE r3.catagory3_id = ".$m.") AS t".$i." on t".$s.".recipe_id = t".$i.".recipe_id ";
			}
			$i = $i + 1;
		}

		$ps = $conn->prepare($sql);
		$ps->execute();
		$r = $ps->get_result();
		$result = $r->fetch_all(MYSQLI_ASSOC);
		$conn->close();
		echo json_encode([
			"success"=>true,
			"data"=>$result
		]);

	}
	catch(mysqli_sql_exception $se)
	{
		echo json_encode([
			"success"=>false,
			"message"=>$se->getMessage()
		]);
	}
	catch (exception $e)
	{
		echo json_encode([
			"success"=>false,
			"message"=>$e->getMessage()
		]);

	}


}
else
{
	echo json_encode([
		"success"=>false,
		"message"=>"invalid request"
	]);
}

?>
