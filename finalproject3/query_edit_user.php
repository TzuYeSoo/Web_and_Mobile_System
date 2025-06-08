<?php 
    session_start();
    require_once 'connection.php';

    
    $user_id = $_POST['user_id'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $edit_fname = $_POST['fname'];
    $edit_lname = $_POST['lname'];

    $stmt = $conn->prepare("UPDATE user_account SET firt_name = ?, last_name = ?, username = ?, user_password = ? WHERE user_id = ?");
    $stmt->bind_param("sssss", $edit_fname, $edit_lname, $username, $password, $user_id );

    if ($stmt->execute()) {
        echo "<script>
            alert('Admin updated successfully.');
            window.location.href='dashboard.php';
        </script>";
    } else {
        echo "<script>
            alert('Failed to update admin.');
            window.history.back();
        </script>";
    }

    $stmt->close();
    $conn->close();


?>