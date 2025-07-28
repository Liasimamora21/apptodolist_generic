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

// Validasi minimal
if (empty($data['title']) || empty($data['task_date'])) {
  echo json_encode(["status" => "error", "message" => "Judul dan tanggal wajib diisi"]);
  exit;
}

// Prevent notice error
$title = $data['title'] ?? '';
$description = $data['description'] ?? '';
$category = $data['category'] ?? '';
$priority = $data['priority'] ?? '';
$time = $data['time'] ?? '';
$location = $data['location'] ?? '';
$task_date = $data['task_date'] ?? '';
$is_done = 0;
$week = $data['week'] ?? null;
$month = $data['month'] ?? null;

$query = "INSERT INTO tasks (title, description, category, priority, time, location, task_date, is_done, week, month)
          VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param("sssssssiii", $title, $description, $category, $priority, $time, $location, $task_date, $is_done, $week, $month);
$stmt->execute();

echo json_encode(["status" => "success"]);
