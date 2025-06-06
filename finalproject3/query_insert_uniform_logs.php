<?php 
require_once "connection.php";

$supplier_id = (int)$_POST['supplier_id'];

$update_stmt = $conn->prepare("UPDATE uniform_inventory SET quantity = ? WHERE inventory_id = ?");
$insert_stmt = $conn->prepare("INSERT INTO uniform_stock_movement (inventory_id, supplier_id, stock_type, stock_quantity, date_created) VALUES (?, ?, ?, ?, ?)");

$reason = "Stock Added";
$success = true;

foreach ($_POST['inventory'] as $inv) {
    $inventory_id = (int)$inv['inventory_id'];
    $current_qty = (int)$inv['quantity'];
    $addStock = (int)$inv['added_stock'];
    $date_added = $inv['date_created'];

    if($addStock !== null && $addStock != 0){

        $new_quantity = $current_qty + $addStock;

        $date_obj = DateTime::createFromFormat('Y-m-d', $date_added);
        $date_formatted = $date_obj ? $date_obj->format('Y-m-d H:i:s') : date('Y-m-d H:i:s');

        // Update quantity
        $update_stmt->bind_param("ii", $new_quantity, $inventory_id);
        if (!$update_stmt->execute()) {
            $success = false;
            break;
        }

        // Insert stock movement log
        $insert_stmt->bind_param("iisis", $inventory_id, $supplier_id, $reason, $addStock, $date_formatted);
        if (!$insert_stmt->execute()) {
            $success = false;
            break;
        }
    }
    
}

$update_stmt->close();
$insert_stmt->close();
$conn->close();

if ($success) {
    echo "<script>
        alert('Stock added successfully.');
        window.location.href = 'uniform.php';
    </script>";
} else {
    echo "<script>
        alert('Failed to add uniform stock.');
        window.history.back();
    </script>";
}

?>
