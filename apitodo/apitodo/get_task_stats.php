<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') { http_response_code(200); exit(); }
include 'db.php';

$type = $_GET['type'] ?? 'daily'; // daily, weekly, category
if ($type == 'daily') {
    $sql = "SELECT task_date, COUNT(*) AS total,
                   SUM(is_done) AS completed FROM tasks GROUP BY task_date";
} elseif ($type == 'weekly') {
    $sql = "SELECT WEEK(task_date) as week, YEAR(task_date) as year,
                   COUNT(*) AS total, SUM(is_done) AS completed
            FROM tasks GROUP BY year, week";
} else {
    $sql = "SELECT category, COUNT(*) AS total,
                   SUM(is_done) AS completed FROM tasks GROUP BY category";
}
$result = $conn->query($sql);
$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}
echo json_encode($data);