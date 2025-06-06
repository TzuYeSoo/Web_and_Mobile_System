<?php
require_once "connection.php";

if (!isset($_GET['id'])) {
    die("Missing reservation ID.");
}

$order_id = $_GET['id'];

$query = "SELECT * FROM reservation WHERE order_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $order_id);
$stmt->execute();
$result = $stmt->get_result();
$reservation = $result->fetch_assoc();
$stmt->close();

if (!$reservation) {
    die("Reservation not found.");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Reservation</title>
</head>
<body>
    <h2>Edit Reservation</h2>
    <form method="post" action="query_update_reservation.php">
        <input type="hidden" name="order_id" value="<?= $reservation['order_id'] ?>">

        <label>Student Name:</label>
        <input type="text" name="student_name" value="<?= htmlspecialchars($reservation['student_name']) ?>" required><br>

        <label>Quantity:</label>
        <input type="number" name="order_quantity" value="<?= $reservation['order_quantity'] ?>" required><br>

        <label>Pickup Date:</label>
        <input type="datetime-local" name="pickup_date" value="<?= date('Y-m-d\TH:i', strtotime($reservation['pickup_date'])) ?>" required><br>

        <input type="submit" value="Update">
    </form>
</body>
</html>
