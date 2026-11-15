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
		$sql = "SELECT `recipe_id`,`recipe_name`,`recipe_description`,`recipe_ingredient` ,`recipe_step`,`user_name` from ( `recipe` ) JOIN (user) ON `added_by`=`user`.`user_id` WHERE `recipe_id` = ?";
		$ps = $conn->prepare($sql);
		$ps->bind_param("i",$recipeId);
		$ps->execute();
		$a = $ps->get_result();
		$arr = $a->fetch_all(MYSQLI_ASSOC);
		$conn->close();
		echo json_encode([
			"success"=>true,
			"data"=>$arr,

		]);

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
