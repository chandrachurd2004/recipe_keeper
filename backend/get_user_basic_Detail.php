<?php
session_start();
header('Content-Type: application/json');

// Check if session variables exist
if (isset($_SESSION['user_id']) && isset($_SESSION['user_name'])) {
    echo json_encode([
        "success" => true,
        "user_id" => $_SESSION['user_id'],
        "user_name" => $_SESSION['user_name']
    ]);
} else {
    echo json_encode([
        "success" => false,
        "user_id" => null,
        "user_name" => null
    ]);
}
exit;
?>
