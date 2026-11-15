<?php
session_start();
echo json_encode([
	"success" => true,
	"user_id" => $_SESSION['user_id'],
	"user_name" => $_SESSION['user_name'],
]);
?>
