<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
  http_response_code(200);
  exit();
}

include 'db.php'; // koneksi ke database

// Ambil data JSON dari body request
$data = json_decode(file_get_contents("php://input"), true);

// Validasi: pastikan ID dikirim
if (!isset($data['id'])) {
  echo json_encode(["status" => "error", "message" => "ID tidak ditemukan"]);
  exit;
}

$id = intval($data['id']); // pastikan tipe integer

// Update status is_done = 1
$query = "UPDATE tasks SET is_done = 1 WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
  echo json_encode(["status" => "success", "message" => "Tugas ditandai selesai"]);
} else {
  echo json_encode(["status" => "error", "message" => "Gagal mengupdate tugas"]);
}
?>
