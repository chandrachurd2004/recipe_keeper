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
	if(!isset($_POST['recipe_name']) && !isset($_POST['recipe_description'])  && !isset($_POST['recipe_step']) && !isset($_POST['map']) && !isset($_POST['recipe_ingredient']))
	{
		echo json_encode([
			"status"=>false,
			"message"=>"give nessacary details"
		]);
		exit;
	}
	$recipeName = $_POST['recipe_name'];
	$recipeDescription = $_POST['recipe_description'];
	$recipeStep = $_POST['recipe_step'];
	$map = explode(',',$_POST['map']);
	$recipeIngredient = $_POST['recipe_ingredient'];
	//map must have data like    1,2,3,4
	//send data in json via js 
	

	$sql = "INSERT INTO `recipe`( `recipe_name`, `recipe_description`, `recipe_step`, `added_by`, `recipe_ingredient`) VALUES (?,?,?,?,?)";
	$ps = $conn->prepare($sql);
	$ps->bind_param("sssis",$recipeName,$recipeDescription ,  $recipeStep , $_SESSION['user_id'],$recipeIngredient);
	$r = $ps->execute();
	$newId =  $ps->insert_id;


	foreach ($map as $m)
	{
		$i = (int) $m;

		$sql = "INSERT INTO `recpe_level_3_catagorization_map`(`recipe_id`, `category3_id`) VALUES (?,?)";
		$ps = $conn->prepare($sql);
		$ps->bind_param("ii",$newId,$i);
		$r = $ps->execute();
		if(!$r)
		{
			echo json_encode([
				"success"=>false,
				"message"=>"failed to map"
			]);
			break;
		}

	}

	echo json_encode([
		"success"=>true,
		"message"=>"inserted recipe successfully"

	]);

	exit;


}
else
{
	echo json_encode([
		"success"=>false,
		"message"=>"invalid request"
	]);
}

?>
