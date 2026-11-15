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
	if(!isset($_POST['recipe_id']) &&  !isset($_POST['recipe_name']) && !isset($_POST['recipe_description'])  && !isset($_POST['recipe_step']) && !isset($_POST['map']) && !isset($_POST['recipe_ingredient']))
	{
		echo json_encode([
			"status"=>false,
			"message"=>"give nessacary details"
		]);
		exit;
	}
	$recipeId = $_POST['recipe_id'];
	$recipeName = $_POST['recipe_name'];
	$recipeDescription = $_POST['recipe_description'];
	$recipeStep = $_POST['recipe_step'];
	$map = explode(',',$_POST['map']);
	$recipeIngredient = $_POST['recipe_ingredient'];
	//map must have data like    1,2,3,4
	//send data in json via js 
	

	$sql = "UPDATE `recipe` SET `recipe_name`=?,`recipe_description`=? ,`recipe_step`=? ,`recipe_ingredient`=?  WHERE `recipe_id` = ?";
	$ps = $conn->prepare($sql);
	$ps->bind_param("ssssi",$recipeName,$recipeDescription ,  $recipeStep , $recipeIngredient,$recipeId);
	$r = $ps->execute();

	$sql = "DELETE FROM `recpe_level_3_catagorization_map` WHERE `recipe_id` = ?";
	$ps1 = $conn->prepare($sql);
	$ps1->bind_param("i",$recipeId);
	$ps1->execute();

	foreach ($map as $m)
	{
		$i = (int) $m;

		$sql = "INSERT INTO `recpe_level_3_catagorization_map`(`recipe_id`, `category3_id`) VALUES (?,?)";
		$ps = $conn->prepare($sql);
		$ps->bind_param("ii",$recipeId,$i);
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
		"message"=>"recipe updated successfully"

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
