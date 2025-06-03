<?php
require_once "connection.php";

$order_id = $_GET['id'];
$new_status = 0;

$stmt = $conn->prepare("UPDATE supplier SET user_status = ? WHERE supplier_id = ?");
$stmt->bind_param("ii", $new_status, $order_id);

if ($stmt->execute()) {
    echo "<script>
        alert('Supplier marked as archived.');
        window.location.href='supplier.php';
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
