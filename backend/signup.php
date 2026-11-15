<?php

require_once "dbconnect.php";
// to signup or register a new user
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
	// Make sure $conn is defined and connected to your database beforehand
	// e.g., $conn = new mysqli($host, $user, $pass, $dbname);

	if (!isset($_POST['user_name']) || trim($_POST['user_name']) === '')
	{
		echo json_encode([
			"success" => false,
			"message" => "did not provide username"
		]);
		exit;
	}
	else if (!isset($_POST['user_email']) || trim($_POST['user_email']) === '')
	{
		echo json_encode([
			"success" => false,
			"message" => "did not provide user email"
		]);
		exit;
	}
	else if (!isset($_POST['user_password']) || trim($_POST['user_password']) === '')
	{
		echo json_encode([
			"success" => false,
			"message" => "did not provide password"
		]);
		exit;
	}

	$name = $_POST['user_name'];
	$email = $_POST['user_email'];
	$pass = $_POST['user_password'];
	$hashedPassword = password_hash($pass, PASSWORD_DEFAULT);

	try
	{

		$sql = "INSERT INTO `user` (`user_name`, `user_email`, `user_password`) VALUES (?, ?, ?)";

		$ps =$conn->prepare($sql);
		$ps->bind_param("sss", $name, $email, $hashedPassword);
		$rs = $ps->execute();
		if ($rs)
		{
			echo json_encode([
				"success" => true,
				"message" => "user added successfully"
			]);
		}

		$conn->close();

	}
	catch (mysqli_sql_exception $se)
	{
		// Handle duplicate email or other SQL errors gracefully
		echo json_encode([
			"success" => false,
			"message" => "Database error: " . $se->getMessage()
		]);
	}
	catch (Exception $e)
	{
		echo json_encode([
			"success" => false,
			"message" => $e->getMessage()
		]);
	}
}
else
{
	echo json_encode([
		"success" => false,
		"message" => "Invalid request method"
	]);
}
?>


