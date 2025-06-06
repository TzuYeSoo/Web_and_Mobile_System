<?php
require_once "connection.php";


$machine_name = $_POST['machine_name'];
$machine_type = $_POST['machine_type'];
$machine_room_no = $_POST['machine_room_no'];
$machine_unique_id = $_POST['machine_unique_id'];
$machine_quantity = $_POST['machine_quantity'];
$machine_id = $_POST['machine_id'];

$stmt = $conn->prepare("UPDATE machine SET machine_name = ?, 
                                           machine_type = ?, 
                                           machine_room_no = ?, 
                                           machine_unique_id = ?,
                                           machine_quantity = ?
                                           WHERE machine_id = ?");
                                           
$stmt->bind_param("ssisii", $machine_name, $machine_type, $machine_room_no, $machine_unique_id, $machine_quantity, $machine_id);

if ($stmt->execute()) {
    echo "<script>
        alert('Machine updated successfully. $machine_name');
        window.location.href='machine.php';
    </script>";
} else {
    echo "<script>
        alert('Failed to update machine.');
        window.history.back();
    </script>";
}

$stmt->close();
$conn->close();
?>