<?php
require_once "connection.php";

$order_id = $_POST['order_id'];
$student_name = $_POST['student_name'];
$order_quantity = $_POST['order_quantity'];
$pickup_date = $_POST['pickup_date'];

$stmt = $conn->prepare("UPDATE reservation SET student_name = ?, order_quantity = ?, pickup_date = ? WHERE order_id = ?");
$stmt->bind_param("sisi", $student_name, $order_quantity, $pickup_date, $order_id);

if ($stmt->execute()) {
    echo "<script>
        alert('Reservation updated successfully.');
        window.location.href='reservation.php';
    </script>";
} else {
    echo "<script>
        alert('Failed to update reservation.');
        window.history.back();
    </script>";
}

$stmt->close();
$conn->close();
?>
