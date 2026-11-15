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
else if($_SERVER['REQUEST_METHOD'] == 'GET')
{
	$sql = "SELECT `recipe_id`,`recipe_name`,`recipe_description` ,`user_name` from ( `recipe` ) JOIN (user) WHERE `added_by`=`user`.`user_id` LIMIT 20";
	$ps = $conn->prepare($sql);
	$ps->execute();
	$a = $ps->get_result();
	$arr = $a->fetch_all(MYSQLI_ASSOC);
	echo json_encode([
		"success"=>true,
		"data"=>$arr
	]);
}
else
{
	echo json_encode([
		"success"=>false,
		"message"=>"invalid request"
	]);

}


?>
