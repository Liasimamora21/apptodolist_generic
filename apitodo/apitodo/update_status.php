<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') { http_response_code(200); exit(); }
include 'db.php';

$data = json_decode(file_get_contents("php://input"));
$sql = "UPDATE tasks SET is_done = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$data->is_done, $data->id]);

echo json_encode(["status" => "updated"]);