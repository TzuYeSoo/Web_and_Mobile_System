<?php
    require_once "connection.php";

    $machine_name = $_POST['machine_name'];
    $machine_type = $_POST['machine_type'];
    $machine_room_no = $_POST['machine_room_no'];
    $machine_unique_id = $_POST['machine_unique_id'];
    $machine_quatity = $_POST['machine_quantity'];
    $machine_status = 1;

    $checkQuery = "SELECT * FROM machine WHERE machine_name = ? AND machine_unique_id = ?";
    $checkStmt = $conn->prepare($checkQuery);

    if (!$checkStmt) {
        die("Prepare failed: " . $conn->error);
    }

    $checkStmt->bind_param("ss", $machine_name, $machine_unique_id);
    $checkStmt->execute();
    $result = $checkStmt->get_result();

    if ($result->num_rows > 0) {
        echo "<script>
            alert('This machine already exists.');
            window.history.back();
        </script>";
        exit();
    }

    $checkStmt->close();

    // ✅ Proceed with insert
    $insertQuery = "INSERT INTO machine(machine_name, machine_type, machine_room_no, machine_unique_id, machine_quantity, machine_status) VALUES (?, ?, ?, ?, ?, ?)";
    $insertStmt = $conn->prepare($insertQuery);

    if (!$insertStmt) {                                                 
        die("Prepare failed: " . $conn->error);
    }

    $insertStmt->bind_param("ssisii", $machine_name, $machine_type, $machine_room_no, $machine_unique_id, $machine_quatity, $machine_status);

    if ($insertStmt->execute()) {
        header("Location: machine.php");
        exit();
    } else {
        echo "<script>
            alert('Error: Unable to add machine.');
            window.history.back();
        </script>";
    }

    $insertStmt->close();
    $conn->close();


?>