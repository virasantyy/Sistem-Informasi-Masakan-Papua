<?php
include '../config/database.php';

$query = "SELECT subject, COUNT(*) as count FROM user_feedback GROUP BY subject";
$result = mysqli_query($connect, $query);

$data = [
    'labels' => [],
    'values' => []
];

while ($row = mysqli_fetch_assoc($result)) {
    $data['labels'][] = $row['subject']; 
    $data['values'][] = $row['count'];  
}

header('Content-Type: application/json');
echo json_encode($data);
