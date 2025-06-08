<?php
session_start();
require_once 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    $sql = "SELECT user_id, username, firt_name, last_name, position 
            FROM user_account 
            WHERE username = ? AND user_password = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        
        // Set all necessary session variables
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['firt_name'] = $user['first_name']; // Fixed typo
        $_SESSION['last_name'] = $user['last_name'];
        $_SESSION['position'] = $user['position'];
        
        // Redirect to dashboard
        header("Location: dashboard.php");
        exit();
    } else {
        // Redirect back to login page with error
        header("Location: Login.html?error=1");
        exit();
    }
    $stmt->close();
} else {
    // If someone tries to access this file directly, redirect to login page
    header("Location: Login.html");
    exit();
}
?>