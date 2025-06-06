<?php
require_once "connection.php";

$order_id = $_GET['id'];
$new_status = 0;

$stmt = $conn->prepare("UPDATE machine SET machine_status = ? WHERE machine_id = ?");
$stmt->bind_param("ii", $new_status, $order_id);

if ($stmt->execute()) {
    echo "<script>
        alert('Machine marked as archived.');
        window.location.href='machine.php';
    </script>";
} else {
    echo "<script>
        alert('Failed to update status.');
        window.history.back();
    </script>";
}

$stmt->close();
$conn->close();
?>
