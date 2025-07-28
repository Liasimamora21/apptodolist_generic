<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') { http_response_code(200); exit(); }
include 'db.php';

$data = json_decode(file_get_contents("php://input"), true);
$id = $data['id'];
$new_date = $data['task_date'];
$sql = "UPDATE tasks SET task_date = '$new_date' WHERE id = $id";
echo $conn->query($sql) ? json_encode(["success" => true]) : json_encode(["success" => false]);