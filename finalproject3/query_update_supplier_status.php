<?php
require_once "connection.php";

$supplier_id = $_GET['id'] ?? null;
$new_status = $_GET['action'] ?? null;

if ($supplier_id === null || $new_status === null) {
    echo "<script>
        alert('Missing parameters.');
        window.history.back();
    </script>";
    exit;
}

$stmt = $conn->prepare("UPDATE supplier SET user_status = ? WHERE supplier_id = ?");
$stmt->bind_param("ii", $new_status, $supplier_id);

if ($stmt->execute()) {
    echo "<script>
        alert('Supplier status updated.');
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
