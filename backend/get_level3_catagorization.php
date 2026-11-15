<?php
session_start();
//to get level2 catagrozation
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
else if($_SERVER['REQUEST_METHOD'] == 'GET')
{
	if(!isset($_GET['l2_id']))
	{
		echo json_encode([
			"success"=>false,
			"message"=>"enter l2_id in the get request"
		]);
		exit;
	}

	try{

		$id = $_GET['l2_id'];
		$sql = "SELECT catagory3_id , catagory3_name FROM `Level_3_catagorization` WHERE `category2_id` = ?";
		$ps = $conn->prepare($sql);
		$ps->bind_param("i",$id);
		$r = $ps->execute();
		$a = $ps->get_result();
		$result = $a->fetch_all(MYSQLI_ASSOC);
		$conn->close();

		echo json_encode([
			"success"=>true,
			"data"=>$result
		]);
	}
	catch(mysqli_sql_exception $se){
		echo json_encode([
			"status"=>false,
			"message" => $se->getMessage()
		]);
	}
	catch(exception $e)
	{
		echo json_encode([
			"status"=>false,
			"message" => $e->getMessage()
		]);
	}
}
else
{

	echo json_encode([
		"success" => false,
		"message"=> "invalid request"
	]);
}
?>
