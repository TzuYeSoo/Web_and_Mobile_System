<?php
require_once "connection.php";

$unif_id = $_GET['id'];
$new_status = 0;

$stmt = $conn->prepare("UPDATE uniform SET uniform_status = ? WHERE uniform_id = ?");
$stmt->bind_param("ii", $new_status, $unif_id);

if ($stmt->execute()) {
    echo "<script>
        alert('Uniform marked as archived.');
        window.location.href='uniform.php';
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
