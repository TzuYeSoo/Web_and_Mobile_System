<?php 
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    require_once "connection.php";

    $sql = "SELECT order_id, uniform_id, student_name, order_quantity, order_total_price, order_status, order_date, pickup_date FROM reservation WHERE order_status = 'reserved'";
    $unifquery = "SELECT uniform_name, uniform_id, uniform_price FROM uniforms";

    $result = mysqli_query($conn, $sql);
    $resultunif = mysqli_query($conn, $unifquery);

    if (!$result) {
        die("Reservation query failed: " . mysqli_error($conn));
        }
    if (!$resultunif) {
        die("Uniform query failed: " . mysqli_error($conn));    
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RESERVATIONS</title>
    <link rel="stylesheet" href="dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="uniform.css">
    <link rel="stylesheet" href="style_reservation.css">
</head>
<body>
    <div class="backdrop" id="backdrop"></div>
    <!-- Modal for stock in-->

    <div class="add-stock-container" id="stockin_modal">
        <div class="header_bg">
            <h2>UNIFORM</h2>
        </div>
        <form class="forms" method="post" action="query_insert_reservation.php" enctype="multipart/form-data">

        <div class="form-grid">
            <div class="input-fields">
                <input type="text" placeholder="Student name" name="student_name" required>
                <select name="uniform_id" id="uniformSelect" required>
                    <option value="" disabled selected>Select Uniform</option>
                    <?php while($row = mysqli_fetch_assoc($resultunif)): ?>
                        <option 
                        value="<?= htmlspecialchars($row['uniform_id']) ?>". 
                        data-price="<?= htmlspecialchars($row['uniform_price']) ?>"
                        >
                        <?= htmlspecialchars($row['uniform_name']) ?> 
                        (₱<?= number_format($row['uniform_price'], 2) ?>)
                        </option>
                    <?php endwhile; ?>
                </select>
                <!-- Quantity -->
                <input type="number" name="order_quantity" id="quantityInput" placeholder="Quantity" min="1" value="1" required/>

                <!-- Unit Price (read-only) -->
                <input type="text" name="unit_price" id="unitPriceInput" placeholder="Unit Price" readonly />

                <!-- Total Price (will be submitted as order_total_price) -->
                <input type="text" name="order_total_price" id="totalPriceInput" placeholder="Total Price" readonly />
                <input type="datetime-local" name="order_date" required />
                <input type="datetime-local" name="pickup_date" required />
            </div>
            
        </div>
       
        <div class="add-button-container">
            <input type="submit" class="add-button" value="ADD">
        </div>
        </form>
    </div>

    <div class="container">
        <nav class="sidebar" id="sidebar">
            <div class="hamburger">
                <i class="fas fa-bars"></i>
            </div>
            <div class="nav-items">
                <a href="dashboard.html" class="nav-item">
                    <i class="fas fa-home"></i>
                    <span>Dashboard</span>
                </a>
                <div class="nav-item dropdown active">
                    <i class="far fa-folder-open"></i>
                    <span>Inventory</span>
                    <i class="fas fa-chevron-down arrow"></i>
                    <div class="dropdown-content">
                        <a href="uniform.php" class="dropdown-item">
                            <i class="fas fa-shirt"></i>
                            <span>Uniform</span>
                        </a>
                        <a href="machine.php" class="dropdown-item">
                            <i class="fas fa-industry"></i>
                            <span>Machine</span>
                        </a>
                        <a href="consumable.php" class="dropdown-item">
                            <i class="fas fa-shopping-cart"></i>
                            <span>Consumable</span>
                        </a>
                    </div>
                </div>
                <a href="reservation.php" class="nav-item">
                    <i class="fas fa-calendar-check"></i>
                    <span>Reservation</span>
                </a>
                <a href="supplier.php" class="nav-item active">
                    <i class="fas fa-truck-fast"></i>
                    <span>Supplier</span>
                </a>
                <a href="#" class="nav-item logout">
                    <i class="fas fa-right-from-bracket"></i>
                    <span>Logout</span>
                </a>
            </div>
        </nav>

        <main class="main-content">
            
             <header>
                <div class="logo-section">
                    <img src="stilogo.png" alt="STI Logo" class="logo">
                    <h1>Reservation</h1>
                </div>
                <div class="user-account">
                    <img src="alden.png" alt="User" class="avatar">
                    <span>user account</span>
                </div>
            </header>

            <div class="filter-dropdowns">
                <select>
                    <option value="">Program</option>
                    <!-- Add program options here -->
                </select>
                <select>
                    <option value="">Size</option>
                    <!-- Add size options here -->
                </select>
            </div>

            <div class="inventory-table">
                <table>
                    <thead>
                        <tr>
                            <th> </th>
                            <th>Uniform</th>
                            <th>Student</th>
                            <th>Quantity</th>
                            <th>Total Price</th>
                            <th>Order date</th>
                            <th>Pickup date</th>
                            <th>Order Status</th>
                            <th>
                                
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            while($row=mysqli_fetch_assoc($result)){
                                ?> 
                                    <tr>
                                        <td><?php echo $row['order_id']?></td>
                                        <td><?php echo $row['uniform_id']?></td>
                                        <td><?php echo $row['student_name']?></td>
                                        <td><?php echo $row['order_quantity']?></td>
                                        <td><?php echo $row['order_total_price']?></td>
                                        <td><?php echo $row['order_status']?></td>
                                        <td><?php echo $row['order_date']?></td>
                                        <td><?php echo $row['pickup_date']?></td>
                                        <td>
                                            <!-- Edit Icon -->
                                            <a href="query_edit_reservation.php?id=<?= $row['order_id'] ?>" class="action-icon" title="Edit">
                                                <i class="fas fa-pen-to-square"></i>
                                            </a>

                                            <!-- Complete Action -->
                                            <a href="query_update_reservation_status.php?id=<?= $row['order_id'] ?>&action=complete" class="action-icon" title="Complete">
                                                <i class="fas fa-check"></i>
                                            </a>

                                            <!-- Cancel Action -->
                                            <a href="query_update_reservation_status.php?id=<?= $row['order_id'] ?>&action=cancel" class="action-icon" title="Cancel" 
                                                onclick="return confirm('Are you sure you want to cancel this reservation?');">
                                                <i class="fas fa-times"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php
                            }
                        
                        ?>
                    </tbody>
                </table>
            </div>

            <button class="add-item-button">
                <i class="fas fa-plus-circle" onclick="editModal()"></i>
            </button>

        </main>

        <div id="addStockModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <div id="addStockForm"></div>
            </div>
        </div>

    <script src="dashboard.js"></script>
    <script src="uniform.js"></script>
    <script src="java_totalprice.js"></script>
    
</body>
</html>
