<?php
require_once 'connection.php';

$sql = "SELECT category, COUNT(*) as total FROM inventory GROUP BY category";
$result = mysqli_query($conn, $sql);

$data = [];
$labels = [];

while ($row = mysqli_fetch_assoc($result)) {
    $labels[] = $row['category'];
    $data[] = $row['total'];
}

echo json_encode([
    'labels' => $labels,
    'data' => $data
]);
?>
