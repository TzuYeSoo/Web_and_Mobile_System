<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
header('Content-Type: application/json');

require_once 'connection.php';

try {
    $allItems = [];
    
    // Get low stock uniforms
    $uniformQuery = "
        SELECT 
            CONCAT(program_name, ' - ', uniform_part, ' (', uniform_size, ')') as name,
            uniform_quantity as quantity,
            'Uniform' as category,
            'uniform' as type,
            uniform_status
        FROM uniform 
        WHERE uniform_quantity > 0 
        AND uniform_quantity <= 20
        AND uniform_status = 1
        ORDER BY uniform_quantity ASC
    ";
    
    $uniform_result = $conn->query($uniformQuery);
    if (!$uniform_result) {
        throw new Exception("Error getting uniform stock: " . $conn->error);
    }
    
    if ($uniform_result->num_rows > 0) {
        while ($row = $uniform_result->fetch_assoc()) {
            $allItems[] = [
                'name' => $row['name'],
                'quantity' => (int)$row['quantity'],
                'category' => $row['category'],
                'type' => $row['type']
            ];
        }
    }
    
    // Get machines with low quantity
    $machineQuery = "
        SELECT 
            CONCAT(machine_name, ' - Room ', machine_room_no) as name,
            machine_quantity as quantity,
            'Machine' as category,
            'machine' as type
        FROM machine 
        WHERE machine_quantity > 0 
        AND machine_quantity <= 5
        AND machine_status = 1
        ORDER BY machine_quantity ASC
    ";
    
    $machine_result = $conn->query($machineQuery);
    if (!$machine_result) {
        throw new Exception("Error getting machine stock: " . $conn->error);
    }
    
    if ($machine_result->num_rows > 0) {
        while ($row = $machine_result->fetch_assoc()) {
            $allItems[] = [
                'name' => $row['name'],
                'quantity' => (int)$row['quantity'],
                'category' => $row['category'],
                'type' => $row['type']
            ];
        }
    }
    
    // Get recent consumable log items with low quantities
    $consumableQuery = "
        SELECT 
            item_name as name,
            quantity,
            'Consumable' as category,
            'consumable' as type
        FROM consumable_log 
        WHERE quantity > 0 
        AND quantity <= 15
        ORDER BY date_created DESC, quantity ASC
        LIMIT 10
    ";
    
    $consumable_result = $conn->query($consumableQuery);
    if (!$consumable_result) {
        throw new Exception("Error getting consumable stock: " . $conn->error);
    }
    
    if ($consumable_result->num_rows > 0) {
        while ($row = $consumable_result->fetch_assoc()) {
            $allItems[] = [
                'name' => $row['name'],
                'quantity' => (int)$row['quantity'],
                'category' => $row['category'],
                'type' => $row['type']
            ];
        }
    }
    
    // Sort all items by quantity (lowest first)
    usort($allItems, function($a, $b) {
        if ($a['quantity'] == $b['quantity']) {
            return strcmp($a['name'], $b['name']);
        }
        return $a['quantity'] - $b['quantity'];
    });
    
    // Remove duplicates based on name and keep the one with lowest quantity
    $uniqueItems = [];
    $seenNames = [];
    
    foreach ($allItems as $item) {
        if (!in_array($item['name'], $seenNames)) {
            $uniqueItems[] = $item;
            $seenNames[] = $item['name'];
        }
    }
    
    // Limit to top 10 lowest stock items
    $lowestStock = array_slice($uniqueItems, 0, 10);
    
    echo json_encode([
        'error' => false,
        'items' => $lowestStock,
        'total_count' => count($uniqueItems)
    ]);

} catch (Exception $e) {
    error_log("Error in get_lowest_stock.php: " . $e->getMessage());
    echo json_encode([
        'error' => true,
        'message' => 'Database error occurred'
    ]);
} finally {
    if (isset($conn)) {
        $conn->close();
    }
}
?>