<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
  http_response_code(200);
  exit();
}

include 'db.php';

$data = json_decode(file_get_contents("php://input"), true);
$id = $data['id'] ?? null;

if ($id !== null) {
  $sql = "DELETE FROM tasks WHERE id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->execute([$id]);

  echo json_encode(["status" => "deleted"]);
} else {
  http_response_code(400);
  echo json_encode(["error" => "Missing task id"]);
}
