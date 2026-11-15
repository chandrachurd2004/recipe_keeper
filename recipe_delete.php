<?php
session_start();
require_once "dbconnect.php";
if($_SESSION['user_name'] == null)
{
	echo json_encode([
		"success"=>false,
		"message"=>"login first"
	]);
	exit;
}
else if($_SERVER['REQUEST_METHOD'] == 'POST')
{
	if(!isset($_POST['recipe_id']))
	{
		echo json_encode([
			"success"=>false,
			"message"=>"include recipe id field"
		]);
	}
	try
	{
		$recipeId = (int) $_POST['recipe_id'];
		$sql = "DELETE FROM `recipe` WHERE `recipe_id` = ?";
		$ps = $conn->prepare($sql);
		$ps->bind_param("i",$recipeId);
		$r = $ps->execute();
		$ps->close();

		if($r)
		{
			$sql ="DELETE FROM `recpe_level_3_catagorization_map` WHERE `recipe_id` =?";
			$ps1 = $conn->prepare($sql);
			$ps1->bind_param("i",$recipeId);
			$ps1->execute();
			$conn->close();

			echo json_encode([
				"success"=>true,
				"data"=>"deleted successfully",
			]);
		}
		else
		{

			echo json_encode([
				"success"=>false,
				"message"=>"unable to delete"
			]);

		}

	}
	catch(mysqli_sql_exception $se)
	{
		echo json_encode([
			"success"=>false,
			"message"=>$se->getMessage()
		]);
	}
	catch(exception $e)
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
