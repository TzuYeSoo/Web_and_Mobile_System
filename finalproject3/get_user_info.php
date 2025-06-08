<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');

require_once 'connection.php';

try {
    session_start();
    
    // Debug information
    if (!isset($_SESSION['user_id'])) {
        throw new Exception('User not logged in. Session data: ' . json_encode($_SESSION));
    }

    $user_id = $conn->real_escape_string($_SESSION['user_id']);

    // Updated query to include profile_image
   $sql = "SELECT user_id, firt_name, last_name, username, position 
        FROM user_account 
        WHERE user_id = '$user_id'";
    
    $result = $conn->query($sql);
    
    if ($result && $result->num_rows > 0) {
        $user_data = $result->fetch_assoc();
        
        
        echo json_encode([
            'success' => true,
            'firt_name' => $user_data['firt_name'],
            'last_name' => $user_data['last_name'],
            'username' => $user_data['username'],
            'position' => $user_data['position'],
            'user_id' => $user_data['user_id'],
        ]);
    } else {
        throw new Exception("User not found. Query: $sql");
    }

} catch (Exception $e) {
    echo json_encode([
        'error' => true,
        'message' => $e->getMessage(),
        'debug_info' => [
            'session_exists' => isset($_SESSION),
            'session_data' => $_SESSION ?? 'No session data'
        ]
    ]);
} finally {
    if (isset($conn)) {
        $conn->close();
    }
}
?>