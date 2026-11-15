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
if($_SERVER['REQUEST_METHOD'] == 'POST')
{
	if(!isset($_POST['recipe_name']))
	{
		echo json_encode([
			"success"=>false,
			"message"=>"include recipe name in json object"
		]);
	}
	try
	{
		$recipeName = $_POST['recipe_name'];
		$sql = "SELECT * FROM recipe WHERE recipe_name LIKE'%$recipeName%'";
		$ps = $conn->prepare($sql);
		$r = $ps->execute();
		$arr = $ps->get_result();
		$a = $arr->fetch_all(MYSQLI_ASSOC);


		echo json_encode([
			"success"=>true,
			"data"=>$a
		]);
	}
	catch (mysqli_sql_exception $se)
	{
		echo json_encode([
			"status"=>false,
			"message"=> $se->getMessage()
		]);
	}
	catch(exception $e)
	{
		echo json_encode([
			"status"=>false,
			"message"=> $e->getMessage()
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
