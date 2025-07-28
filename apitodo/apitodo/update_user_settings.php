<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') { http_response_code(200); exit(); }
include 'db.php';

$data = json_decode(file_get_contents("php://input"), true);
$user_id = $data['user_id'] ?? 1;
$theme = $data['theme'];
$notifications = $data['notifications'];

$check = $conn->query("SELECT id FROM settings WHERE user_id = $user_id");
if ($check->num_rows > 0) {
    $sql = "UPDATE settings SET theme='$theme', notifications='$notifications' WHERE user_id = $user_id";
} else {
    $sql = "INSERT INTO settings (user_id, theme, notifications) VALUES ($user_id, '$theme', '$notifications')";
}
echo $conn->query($sql) ? json_encode(["success" => true]) : json_encode(["success" => false]);