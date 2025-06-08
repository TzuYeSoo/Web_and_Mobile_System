<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');

require_once 'connection.php';

try {
    $response = array();

    // Get total uniform count
    $uniform_sql = "SELECT COUNT(*) as total FROM uniform";
    $uniform_result = $conn->query($uniform_sql);
    if (!$uniform_result) {
        throw new Exception("Error getting uniform count: " . $conn->error);
    }
    $response['uniform_count'] = $uniform_result->fetch_assoc()['total'];

    // Get total machine count
    $machine_sql = "SELECT COUNT(*) as total FROM machine";
    $machine_result = $conn->query($machine_sql);
    if (!$machine_result) {
        throw new Exception("Error getting machine count: " . $conn->error);
    }
    $response['machine_count'] = $machine_result->fetch_assoc()['total'];

    // Get total reservation count
    $reservation_sql = "SELECT COUNT(*) as total FROM reservation";
    $reservation_result = $conn->query($reservation_sql);
    if (!$reservation_result) {
        throw new Exception("Error getting reservation count: " . $conn->error);
    }
    $response['reservation_count'] = $reservation_result->fetch_assoc()['total'];

    echo json_encode($response);

} catch (Exception $e) {
    echo json_encode([
        'error' => true,
        'message' => $e->getMessage()
    ]);
} finally {
    if (isset($conn)) {
        $conn->close();
    }
}
?> 