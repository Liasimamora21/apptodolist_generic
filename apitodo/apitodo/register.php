<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') { http_response_code(200); exit(); }
require 'db.php';

$data = json_decode(file_get_contents("php://input"));

$nama     = $data->nama;
$email    = $data->email;
$password = password_hash($data->password, PASSWORD_BCRYPT);

// Cek email sudah terdaftar
$cek = $conn->query("SELECT * FROM users WHERE email = '$email'");
if ($cek->num_rows > 0) {
    echo json_encode(["status" => false, "message" => "Email sudah terdaftar"]);
    exit;
}

$query = $conn->query("INSERT INTO users (nama, email, password) VALUES ('$nama', '$email', '$password')");

if ($query) {
    echo json_encode(["status" => true, "message" => "Registrasi berhasil"]);
} else {
    echo json_encode(["status" => false, "message" => "Gagal mendaftar"]);
}
?>
