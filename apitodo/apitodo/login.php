<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') { http_response_code(200); exit(); }
require 'db.php';

$data = json_decode(file_get_contents("php://input"));

$email    = $data->email;
$password = $data->password;

$query = $conn->query("SELECT * FROM users WHERE email = '$email'");

if ($query->num_rows == 1) {
    $user = $query->fetch_assoc();
    if (password_verify($password, $user['password'])) {
        echo json_encode([
            "status" => true,
            "message" => "Login berhasil",
            "user" => [
                "id" => $user['id'],
                "nama" => $user['nama'],
                "email" => $user['email']
            ]
        ]);
    } else {
        echo json_encode(["status" => false, "message" => "Password salah"]);
    }
} else {
    echo json_encode(["status" => false, "message" => "Email tidak ditemukan"]);
}
?>
