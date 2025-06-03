<?php
require_once "connection.php";

// Validate required POST data
if (empty($_POST['program_name']) || empty($_POST['uniform_status']) || empty($_POST['inventory'])) {
    echo "<script>alert('Missing required data.'); window.history.back();</script>";
    exit;
}

$program = $_POST['program_name'];
$status = $_POST['uniform_status'];

// Handle image
$image = $_FILES['image_unif']['name'];
$target = "uploads/" . basename($image);
if (!move_uploaded_file($_FILES['image_unif']['tmp_name'], $target)) {
    echo "<script>alert('Failed to upload image.'); window.history.back();</script>";
    exit;
}

// Insert into uniforms table
$stmt = $conn->prepare("INSERT INTO uniforms (program_name, image_unif, uniform_status) VALUES (?, ?, ?)");
$stmt->bind_param("ssi", $program, $image, $status);

if (!$stmt->execute()) {
    echo "<script>alert('Failed to insert uniform.'); window.history.back();</script>";
    exit;
}

$uniform_id = $stmt->insert_id;
$stmt->close();

// Prepare inventory insert
$inv_stmt = $conn->prepare("INSERT INTO uniform_inventory (uniform_id, part, size, quantity, price) VALUES (?, ?, ?, ?, ?)");
$inv_stmt->bind_param("issid", $uniform_id, $part, $size, $qty, $price);

foreach ($_POST['inventory'] as $inv) {
    $part = $inv['part'];
    $size = $inv['size'];
    $qty = (int)$inv['quantity'];
    $price = (float)$inv['price'];

    if (!$inv_stmt->execute()) {
        echo "<script>alert('Failed to insert inventory item.'); window.history.back();</script>";
        $inv_stmt->close();
        exit;
    }
}

$inv_stmt->close();

echo "<script>alert('Uniform added successfully!'); window.location.href='uniform.php';</script>";
exit;
?>
