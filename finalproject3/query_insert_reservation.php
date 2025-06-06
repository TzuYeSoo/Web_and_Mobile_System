<?php
    require_once "connection.php";

    $inventory_id = $_POST['inventory_id'];
    $student_name = $_POST['student_name'];
    $order_quantity = $_POST['order_quantity'];
    $order_total_price = $_POST['order_total_price'];
    $order_status = "reserved";
    $order_date = date('Y-m-d H:i:s', strtotime($_POST['order_date']));
    $pickup_date = date('Y-m-d H:i:s', strtotime($_POST['pickup_date']));
    $user_id = null;


    // ✅ Proceed with insert
    $insertQuery = "INSERT INTO reservation(user_id, inventory_id, order_quantity, order_total_price, order_status, order_date, pickup_date, student_name) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $insertStmt = $conn->prepare($insertQuery);

    if (!$insertStmt) {
        die("Prepare failed: " . $conn->error);
    }

    $insertStmt->bind_param("iiidssss", $user_id, $inventory_id, $order_quantity, $order_total_price, $order_status, $order_date, $pickup_date, $student_name);

    if ($insertStmt->execute()) {
        header("Location: reservation.php");
        exit();
    } else {
        echo "<script>
                alert('Error: Unable to add reservation. " . addslashes($insertStmt->error) . "');
                window.history.back();
            </script>";
    }

    $insertStmt->close();
    $conn->close();


?>