<?php
session_start();
require_once "dbconnect.php";
if($_SESSION['user_name'] == null)
{
	echo json_encode([
		"status"=>false,
		"message"=>"login first"
	]);
	exit;
}
else if($_SERVER['REQUEST_METHOD'] == 'GET')
{
	if(!isset($_GET['recipe_id']))
	{
		echo json_encode([
			"success"=>false,
			"message"=>"give recipe_id in the input field"
		]);
		exit;
	}

	try
	{
		$recipeId = $_GET['recipe_id'];

		$sql = "SELECT * FROM `recipe` WHERE `recipe_id` = ? ";

		$ps = $conn->prepare($sql);
		$ps->bind_param("i",$recipeId);
		$ps->execute();
		$ar = $ps->get_result();
		$result = $ar->fetch_all(MYSQLI_ASSOC);

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
		"status"=>false,
		"message"=>"invalid request"
	]);
}


?>

