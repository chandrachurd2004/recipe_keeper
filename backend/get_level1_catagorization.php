<?php
session_start();
//to get level1 catagrozation
require_once "dbconnect.php";
if($_SESSION['user_name'] == null)
{
	echo json_encode([
		"success"=>false,
		"message"=>"login first"
	]);
	exit;
}
$sql = "SELECT * FROM `Level_1_catagorization`";

$ps = $conn->prepare($sql);
$r = $ps->execute();
$a = $ps->get_result();
$result = $a->fetch_all(MYSQLI_ASSOC);

echo json_encode([
	"success"=>true,
	"data"=>$result
]);
?>
