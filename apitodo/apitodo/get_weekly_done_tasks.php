<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
  http_response_code(200); exit();
}

include 'db.php'; // koneksi database

// Ambil hanya yang sudah selesai dan punya data week + month
$result = mysqli_query($conn, "SELECT * FROM tasks WHERE is_done = 1 AND week IS NOT NULL AND month IS NOT NULL ORDER BY id DESC");

$data = [];
while ($row = mysqli_fetch_assoc($result)) {
  $data[] = $row;
}

echo json_encode($data);
?>
