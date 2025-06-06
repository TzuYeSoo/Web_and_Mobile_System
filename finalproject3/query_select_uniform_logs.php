<?php
require_once "connection.php";

$uniform_id = $_GET['uniform_id'] ?? 0;

$sql = "SELECT m.stock_type, m.stock_quantity, m.date_created AS date_created, 
               s.comapany_name, u.program_name AS uniform_name
        FROM uniform_stock_movement m
        JOIN supplier s ON m.supplier_id = s.supplier_id
        JOIN uniforms u ON m.uniform_id = u.uniform_id
        WHERE m.uniform_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $uniform_id);
$stmt->execute();
$result = $stmt->get_result();

$logs = [];
while ($row = $result->fetch_assoc()) {
    $logs[] = $row;
}

echo json_encode($logs);
?>
