<?php 
require_once "connection.php";

$uniform_id = $_POST['stock_id'];
$uniform_quantity = $_POST['stock_quantity'];
$added_stock = $_POST['added_stock'];
$supplier_id = $_POST['supplier_id'];
$date_added = $_POST['date_added']; // Ensure this is in a valid datetime format

$date_obj = DateTime::createFromFormat('Y-m-d', $date_added);
$date_formatted = $date_obj->format('Y-m-d H:i:s');

$new_quantity = $uniform_quantity + $added_stock;
echo "<script> alert('". $new_quantity. "|" .$uniform_id ."')</script>;";

// 1. Update uniforms table
$update_stmt = $conn->prepare("UPDATE uniforms SET uniform_quantity = ? WHERE uniform_id = ?");
$update_stmt->bind_param("ii", $new_quantity, $uniform_id);

if ($update_stmt->execute()) {
    
    // 2. Insert into movement table
    $reason = "Stock Added";
    $insert_stmt = $conn->prepare("INSERT INTO uniform_stock_movement (uniform_id, supplier_id, stock_type, stock_quantity, date_created) VALUES (?, ?, ?, ?, ?)");
    $insert_stmt->bind_param("iisis", $uniform_id, $supplier_id, $reason, $added_stock ,$date_formatted);

    if ($insert_stmt->execute()) {  
        echo "<script>
            alert('Uniform stock updated and movement recorded successfully.');
            window.location.href='uniform.php';
        </script>";
    } else {
        echo "<script>
            alert('Uniform updated, but failed to insert movement record.');
            window.history.back();
        </script>";
    }

    $insert_stmt->close();

} else {
    echo "<script>
        alert('Failed to add uniform stock.');
        window.history.back();
    </script>";
}

$update_stmt->close();
$conn->close();
?>

