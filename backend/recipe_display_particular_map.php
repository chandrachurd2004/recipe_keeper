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
else if($_SERVER['REQUEST_METHOD'] == 'POST')
{
	if(!isset($_POST['recipe_id']))
	{
		echo json_encode([
			"success"=>false,
			"message"=>"give recipe_id in the input field"
		]);
		exit;
	}

	try
	{
		$recipeId = (int) $_POST['recipe_id'];
		$sql = "SELECT `catagory3_name` FROM `recpe_level_3_catagorization_map` as t1 JOIN `Level_3_catagorization` as t2 ON t1.category3_id = t2.catagory3_id WHERE `recipe_id` = ? " ;
		$ps = $conn->prepare($sql);
		$ps->bind_param("i",$recipeId);
		$ps->execute();
		$ar = $ps->get_result();
		$result = $ar->fetch_all(MYSQLI_ASSOC);

		$conn->close();
		echo json_encode([
			"success"=>true,
			"data"=>$result,
			"row" => $ps->num_rows
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

