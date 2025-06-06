<?php
    require_once "connection.php";

    $firt_name = $_POST['firt_name'];
    $last_name = $_POST['last_name'];
    $comapany_name = $_POST['comapany_name'];
    $contact = $_POST['contact'];
    $user_status = 1;

    $checkQuery = "SELECT * FROM supplier WHERE comapany_name = ? AND firt_name = ? AND last_name = ? AND contact = ?";
    $checkStmt = $conn->prepare($checkQuery);

    if (!$checkStmt) {
        die("Prepare failed: " . $conn->error);
    }

    $checkStmt->bind_param("ssss", $comapany_name, $firt_name, $last_name, $contact);
    $checkStmt->execute();
    $result = $checkStmt->get_result();

    if ($result->num_rows > 0) {
        // Use JavaScript alert and redirect
        echo "<script>
            alert('This company already exists.');
            window.history.back();
        </script>";
        exit();
    }

    $checkStmt->close();

    // ✅ Proceed with insert
    $insertQuery = "INSERT INTO supplier(firt_name, last_name, comapany_name, contact, user_status) VALUES (?, ?, ?, ?, ?)";
    $insertStmt = $conn->prepare($insertQuery);

    if (!$insertStmt) {
        die("Prepare failed: " . $conn->error);
    }

    $insertStmt->bind_param("ssssi", $firt_name, $last_name, $comapany_name, $contact, $user_status);

    if ($insertStmt->execute()) {
        header("Location: supplier.php");
        exit();
    } else {
        echo "<script>
            alert('Error: Unable to add supplier.');
            window.history.back();
        </script>";
    }

    $insertStmt->close();
    $conn->close();


?>