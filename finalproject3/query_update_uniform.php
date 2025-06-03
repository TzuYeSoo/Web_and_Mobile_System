<?php
require_once "connection.php";

$uniform_id = $_POST['uniform_id'];
$program_name = $_POST['program_name'];
$status = $_POST['uniform_status'];

// === Image Handling ===
$image_sql = '';
if (!empty($_FILES['image_unif']['name'])) {
    $image = $_FILES['image_unif']['name'];
    $target = "uploads/" . basename($image);

    if (!move_uploaded_file($_FILES['image_unif']['tmp_name'], $target)) {
        echo "<script>alert('Failed to upload image.'); window.history.back();</script>";
        exit;
    }

    $image_sql = ", image_unif = ?";
}

// === Update Uniform ===
$sql = "UPDATE uniforms SET program_name = ?, uniform_status = ? $image_sql WHERE uniform_id = ?";
$stmt = $conn->prepare($sql);

if ($image_sql) {
    $stmt->bind_param("ssi", $program_name, $status, $uniform_id);
    $stmt->bind_param("ssi", $program_name, $status, $image, $uniform_id);
} else {
    $stmt->bind_param("ssi", $program_name, $status, $uniform_id);
}

if (!$stmt->execute()) {
    echo "<script>alert('Failed to update uniform info.'); window.history.back();</script>";
    exit;
}
$stmt->close();

// === Inventory Update/Insert ===
$submitted_ids = [];

$inv_stmt = $conn->prepare("UPDATE uniform_inventory SET part = ?, size = ?, quantity = ?, price = ? WHERE inventory_id = ?");
$inv_stmt_insert = $conn->prepare("INSERT INTO uniform_inventory (uniform_id, part, size, quantity, price) VALUES (?, ?, ?, ?, ?)");

foreach ($_POST['inventory'] as $inv) {
    $part = $inv['part'];
    $size = $inv['size'];
    $qty = (int)$inv['quantity'];
    $price = (float)$inv['price'];

    if (isset($inv['inventory_id']) && !empty($inv['inventory_id'])) {
        $inventory_id = $inv['inventory_id'];
        $submitted_ids[] = $inventory_id;

        $inv_stmt->bind_param("ssidi", $part, $size, $qty, $price, $inventory_id);
        if (!$inv_stmt->execute()) {
            echo "<script>alert('Failed to update inventory item.'); window.history.back();</script>";
            exit;
        }

    } else {
        $inv_stmt_insert->bind_param("issid", $uniform_id, $part, $size, $qty, $price);
        if (!$inv_stmt_insert->execute()) {
            echo "<script>alert('Failed to insert new inventory item.'); window.history.back();</script>";
            exit;
        }
    }
}
$inv_stmt->close();
$inv_stmt_insert->close();

// === Delete Removed Inventory Items ===
if (!empty($submitted_ids)) {
    $submitted_ids_str = implode(",", array_map('intval', $submitted_ids));
    $delete_sql = "DELETE FROM uniform_inventory WHERE uniform_id = ? AND inventory_id NOT IN ($submitted_ids_str)";
} else {
    $delete_sql = "DELETE FROM uniform_inventory WHERE uniform_id = ?";
}
$delete_stmt = $conn->prepare($delete_sql);
$delete_stmt->bind_param("i", $uniform_id);
$delete_stmt->execute();
$delete_stmt->close();

// === Success Redirect ===
echo "<script>alert('Uniform updated successfully.'); window.location.href='uniform_list.php';</script>";
exit;
?>
