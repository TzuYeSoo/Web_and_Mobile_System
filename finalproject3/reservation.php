<?php 
    require_once "connection.php";

    $sql = "SELECT reservation_id, part, size, program_name, ui.inventory_id, student_name, order_quantity, order_total_price, order_status, order_date, pickup_date FROM reservation as r
    INNER JOIN uniform_inventory as ui ON ui.inventory_id = r.inventory_id
    INNER JOIN uniforms as u ON ui.uniform_id = u.uniform_id
    WHERE order_status = 'reserved'";


    $complete = "SELECT reservation_id, part, size, program_name, ui.inventory_id, student_name, order_quantity, order_total_price, order_status, order_date, pickup_date FROM reservation as r
    INNER JOIN uniform_inventory as ui ON ui.inventory_id = r.inventory_id
    INNER JOIN uniforms as u ON ui.uniform_id = u.uniform_id
    WHERE order_status = 'complete'";

    $cancel = "SELECT reservation_id, part, size, program_name, ui.inventory_id, student_name, order_quantity, order_total_price, order_status, order_date, pickup_date FROM reservation as r
    INNER JOIN uniform_inventory as ui ON ui.inventory_id = r.inventory_id
    INNER JOIN uniforms as u ON ui.uniform_id = u.uniform_id
    WHERE order_status = 'cancelled'";

    $unifquery = "SELECT inventory_id, program_name, quantity, price, size, part FROM uniforms as ui
     INNER JOIN uniform_inventory as u ON ui.uniform_id = u.uniform_id WHERE uniform_status = '1' ";

    $result = mysqli_query($conn, $sql);
    $resultunif = mysqli_query($conn, $unifquery);
    $resultcancel = mysqli_query($conn, $cancel);
    $resultcomplete = mysqli_query($conn, $complete);

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
<!-- Modal for reservation -->

    <div class="add-stock-container" id="add_resrvation">
        <div class="header_bg">
            <h2>UNIFORM</h2>
            <button  onclick="closeRservation()">&#10005;</button>
        </div>
        <form class="forms" method="post" action="query_insert_reservation.php" enctype="multipart/form-data">

        <div class="form-grid">
            <div class="input-fields">
                <input type="text" placeholder="Student name" name="student_name" required>
                <select name="inventory_id" id="uniformSelect" required>
                    <option value="" disabled selected>Select Uniform</option>
                    <?php while($row = mysqli_fetch_assoc($resultunif)): ?>
                        <option 
                        value="<?= htmlspecialchars($row['inventory_id']) ?>".
                        data-price="<?= htmlspecialchars($row['price']) ?>"
                        >
                        <?= htmlspecialchars($row['program_name']) ?> 
                        <?= htmlspecialchars($row['size']) ?>
                        <?= htmlspecialchars($row['part']) ?>
                        (₱<?= number_format($row['price'], 2) ?>)
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
<!-- End for reservation -->
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
            
                        <a href="uniform.php" class="nav-item">
                            <i class="fas fa-shirt"></i>
                            <span>Uniform</span>
                        </a>
                        <a href="machine.php" class="nav-item">
                            <i class="fas fa-industry"></i>
                            <span>Machine</span>
                        </a>
                       
                        <a href="consumable.php" class="nav-item">
                            <i class="fas fa-shopping-cart"></i>
                            <span>Consumable</span>
                        </a>
                    
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

            <div class="table-changer">
                <button onclick="reservedReservation()"> Reserved </button>
                <button onclick="completeReservation()"> Complete </button>
                <button onclick="cancelRervation()"> Cancel </button>
            </div>

            <div class="inventory-table" id="current_reservation">
                <table>
                    <thead>
                        <tr>
                            <th> </th>
                            <th>Uniform</th>
                            <th>Part</th>
                            <th>Size</th>
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
                                        <td><?php echo $row['reservation_id']?></td>
                                        <td><?php echo $row['program_name']?></td>
                                        <td><?php echo $row['part']?></td>
                                        <td><?php echo $row['size']?></td>
                                        <td><?php echo $row['student_name']?></td>
                                        <td><?php echo $row['order_quantity']?></td>
                                        <td><?php echo $row['order_total_price']?></td>
                                        <td><?php echo $row['order_status']?></td>
                                        <td><?php echo $row['order_date']?></td>
                                        <td><?php echo $row['pickup_date']?></td>
                                        <td>
                                            <!-- Edit Icon -->
                                            <a href="query_edit_reservation.php?id=<?= $row['reservation_id'] ?>" class="action-icon" title="Edit">
                                                <i class="fas fa-pen-to-square"></i>
                                            </a>

                                            <!-- Complete Action -->
                                            <a href="query_update_reservation_status.php?id=<?= $row['reservation_id'] ?>&action=complete" class="action-icon" title="Complete">
                                                <i class="fas fa-check"></i>
                                            </a>

                                            <!-- Cancel Action -->
                                            <a href="query_update_reservation_status.php?id=<?= $row['reservation_id'] ?>&action=cancel" class="action-icon" title="Cancel" 
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
<!-- compelte -->
            <div class="inventory-table" id="complete_reservation">
                <table>
                    <thead>
                        <tr>
                            <th> </th>
                            <th>Uniform</th>
                            <th>Part</th>
                            <th>Size</th>
                            <th>Student</th>
                            <th>Quantity</th>
                            <th>Total Price</th>
                            <th>Order date</th>
                            <th>Pickup date</th>
                            <th>Order Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            while($row=mysqli_fetch_assoc($resultcomplete)){
                                ?> 
                                    <tr>
                                        <td><?php echo $row['reservation_id']?></td>
                                        <td><?php echo $row['program_name']?></td>
                                        <td><?php echo $row['part']?></td>
                                        <td><?php echo $row['size']?></td>
                                        <td><?php echo $row['student_name']?></td>
                                        <td><?php echo $row['order_quantity']?></td>
                                        <td><?php echo $row['order_total_price']?></td>
                                        <td><?php echo $row['order_status']?></td>
                                        <td><?php echo $row['order_date']?></td>
                                        <td><?php echo $row['pickup_date']?></td>
                                    </tr>
                                <?php
                            }
                        
                        ?>
                    </tbody>
                </table>
            </div>
<!-- end of compelte -->
<!-- start of cancel -->
                            <div class="inventory-table" id="cancel_reservation">
                <table>
                    <thead>
                        <tr>
                            <th> </th>
                            <th>Uniform</th>
                            <th>Part</th>
                            <th>Size</th>
                            <th>Student</th>
                            <th>Quantity</th>
                            <th>Total Price</th>
                            <th>Order date</th>
                            <th>Pickup date</th>
                            <th>Order Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            while($row=mysqli_fetch_assoc($resultcancel)){
                                ?> 
                                    <tr>
                                        <td><?php echo $row['reservation_id']?></td>
                                        <td><?php echo $row['program_name']?></td>
                                        <td><?php echo $row['part']?></td>
                                        <td><?php echo $row['size']?></td>
                                        <td><?php echo $row['student_name']?></td>
                                        <td><?php echo $row['order_quantity']?></td>
                                        <td><?php echo $row['order_total_price']?></td>
                                        <td><?php echo $row['order_status']?></td>
                                        <td><?php echo $row['order_date']?></td>
                                        <td><?php echo $row['pickup_date']?></td>
                                    </tr>
                                <?php
                            }
                        
                        ?>
                    </tbody>
                </table>
            </div>
<!-- end of cancel -->
            <button class="add-item-button">
                <i class="fas fa-plus-circle" onclick="addReservation()"></i>
            </button>

        </main>

        <div id="addStockModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <div id="addStockForm"></div>
            </div>
        </div>

    <script src="dashboard.js"></script>
    <script src="java_totalprice.js"></script>
    
</body>
</html>
