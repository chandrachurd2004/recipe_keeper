<?php
//to login a user
require_once "dbconnect.php";
if($_SERVER['REQUEST_METHOD'] == 'POST')
{
	if(!isset($_POST['user_email']))
	{
		echo json_encode([
			"success" => true,
			"message" => "email not provided"
		]);
		exit;
	}
	if(!isset($_POST['user_password']))
	{
		echo json_encode([
			"success" => true,
			"message" => "password not provided"
		]);
		exit;
	}
	$email = $_POST['user_email'];
	$pass = $_POST['user_password'];

	try
	{
		$sql = "SELECT * from `user` where `user_email` = ?";
		$ps = $conn->prepare($sql);
		$ps->bind_param("s",$email);
		$rs = $ps->execute();
		$r = $ps->get_result();
		$arr = $r->fetch_assoc();
		if(password_verify($pass, $arr['user_password']))
		{
			session_start();
			$_SESSION['user_id'] = $arr['user_id'];
			$_SESSION['user_name'] = $arr['user_name'];
			setcookie("user_name",$_SESSION['user_name']);
			echo json_encode([
				"success"=>true,
				"message"=>"login successfull"
			]);
		}
		else{

			echo json_encode([
				"success"=>false,
				"message"=>"invalid id and password entered"
			]);
		}
		$conn->close();

	}
	catch(mysqli_sql_exception $se)
	{
		echo json_encode([
			"success"=>true,
			"message" => "sql exception ".$se->getMessage()
		]);
	}

}
else{
	echo json_encode([
		"success" =>false,
		"message"=>"invalid request"
	]);
}

?>
