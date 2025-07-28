<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') { http_response_code(200); exit(); }
include 'db.php';

$user_id = $_GET['user_id'] ?? 1;
$sql = "SELECT * FROM settings WHERE user_id = $user_id LIMIT 1";
$result = $conn->query($sql);
echo json_encode($result->fetch_assoc());