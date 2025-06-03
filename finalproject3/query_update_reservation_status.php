<?php
require_once "connection.php";

$order_id = $_GET['id'] ?? null;
$action = $_GET['action'] ?? null;

if (!$order_id || !in_array($action, ['complete', 'cancel'])) {
    die("Invalid parameters.");
}

$new_status = $action === 'complete' ? 'complete' : 'cancelled';

// First, fetch the uniform_id and quantity for this order
$query = "SELECT uniform_id, order_quantity FROM reservation WHERE order_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $order_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Reservation not found.");
}

$row = $result->fetch_assoc();
$uniform_id = $row['uniform_id'];
$order_quantity = $row['order_quantity'];
$stmt->close();

// Update the reservation status
$update_res = $conn->prepare("UPDATE reservation SET order_status = ? WHERE order_id = ?");
$update_res->bind_param("si", $new_status, $order_id);
$update_success = $update_res->execute();
$update_res->close();

if ($update_success && $action === 'complete') {
    // Reduce the uniform quantity
    $update_uniform = $conn->prepare("UPDATE uniforms SET uniform_quantity = uniform_quantity - ? WHERE uniform_id = ?");
    $update_uniform->bind_param("ii", $order_quantity, $uniform_id);
    $update_uniform->execute();
    $update_uniform->close();
}

if ($update_success) {
    echo "<script>
        alert('Reservation marked as $new_status.');
        window.location.href='reservation.php';
    </script>";
} else {
    echo "<script>
        alert('Failed to update status.');
        window.history.back();
    </script>";
}

$conn->close();
?>
