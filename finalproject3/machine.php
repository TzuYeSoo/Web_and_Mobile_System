<?php 
    require_once "connection.php";

    $sql = "SELECT machine_id, machine_name, machine_type, machine_quantity, machine_room_no, machine_status, machine_unique_id 
    FROM machine WHERE machine_status = 1";

    $result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MACHINES</title>
    <link rel="stylesheet" href="dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="uniform.css">
    <link rel="stylesheet" href="style_newmachine.css">
    <link rel="stylesheet" href="add_machine.css">
   <link rel="stylesheet" href="edit_machine.css">
    


</head>
<body>


<div class="backdrop" id="backdrop"></div>
    <!-- Modal for stock in-->
<div class = "stockin_container" id="modal_stockin">
        <div class="bg_header">
             <h2>Stock In</h2>
              <button class="close-btn" onclick="closeModal('modal_stockin')">&#10005;</button>
        </div>
         <form class="forms" method="post" action="query_insert_unif.php" enctype="multipart/form-data"></form>
        <div class="stockin_grid">
            <h2 >Uniform name</h2>
            <div class="input-fields_stockin">
                <input type="text" placeholder="Uniform name" name="unif_name">
                <input type="text" placeholder="Uniform quantity" name="unif_quantity">
                <input type="text" placeholder="Uniform program" name="unif_program">
                <select required>
                <option value="" disabled selected>Department</option>
                <option>HR</option>
                <option>Engineering</option>
                <option>Logistics</option>
            </select>
            </div>
            <div class="add_button_containerr">
            <input type="submit" class="add_btn" value="ADD">
        </div>
        </div>

    </div>

    
    <div class="add-stock-container" id="stockin_modal">
        <div class="header_bg">
            <h2>MACHINE</h2>
        </div>
        <form class="forms" method="post" action="query_insert_machine.php" enctype="multipart/form-data">

        <div class="form-grid">
            <div class="input-fields">
                <input type="text" placeholder="Machine name" name="machine_name" required>
                <input type="text" placeholder="Machine type" name="machine_type" required>
                <input type="text" placeholder="Room Number" name="machine_room_no" required>
                <input type="text" placeholder="Machine unique_id" name="machine_unique_id" required>
                <input type="number" placeholder="Machine quantity" name="machine_quantity" required>
            </div>
        </div>
        <div class="add-button-container">
            <input type="submit" class="add-button" value="ADD">
        </div>
        </form>
    </div>

   <div class="edit_stock_container" id="edit_machine">
        <div class="header_bg">
            <h2 class="H2">MACHINE</h2>
        </div>
        <form class="forms-edit" method="post" action="query_edit_machine.php" enctype="multipart/form-data">
_
        <div class="edit_grid">
            <div class="input_fields">
                <input type="hidden" name="machine_id" id="machine_id" required>
                <input type="text" placeholder="Machine name" name="machine_name" id="machine_name" required>
                <input type="text" placeholder="Machine type" name="machine_type" id="machine_type" required>
                <input type="text" placeholder="Room Number" name="machine_room_no" id="machine_room_no" required>
                <input type="text" placeholder="Machine unique_id" name="machine_unique_id" id="machine_unique_id" required>
                <input type="number" placeholder="Machine quantity" name="machine_quantity" id="machine_quantity" required>
            </div>
        </div>
        <div class="add_button_container">
            <input type="submit" class="add_button" value="EDIT">
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
                    <h1>Machine</h1>
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
                <select>
                    <option value="">Clothes part</option>
                    <!-- Add clothes part options here -->
                </select>
            </div>

            <div class="inventory-table">
                <table>
                    <thead>
                        <tr>
                            <th> </th>
                            <th>Machine name</th>
                            <th>Machine Type</th>
                            <th>quantity</th>
                            <th>Room number</th>
                            <th>Status</th>
                            <th>
                                
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 

                            while($row=mysqli_fetch_assoc($result)){

                                ?> 
                                    <tr>
                                        <td><?php echo $row['machine_id']?></td>
                                        <td><?php echo $row['machine_name']?></td>
                                        <td><?php echo $row['machine_type']?></td>
                                        <td><?php echo $row['machine_quantity']?></td>
                                        <td><?php echo $row['machine_room_no']?></td>
                                        <td><?php echo $row['machine_status']?></td>
                                        <td>
                                            <i class="fas fa-pencil-alt" onclick="editMachine('<?= $row['machine_id'] ?>', 
                                                   '<?= $row['machine_name'] ?>', 
                                                   '<?= $row['machine_type'] ?>', 
                                                   '<?= $row['machine_room_no'] ?>',
                                                   '<?= $row['machine_unique_id'] ?>',
                                                   '<?= $row['machine_quantity'] ?>')">
                                            </i>
                                            <i class="fas fa-plus-circle" onclick="editstockin()"></i>
                                            <a href="query_update_machine_status.php?id=<?= $row['machine_id'] ?>&action=1" class="action-icon" title="1" onclick="return confirm('Are you sure you want to cancel this reservation?');">
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

            <button class="add-item-button" onclick="editModal()">
                <i class="fas fa-plus-circle" ></i>
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
    <script src="java_machine.js"></script>
</body>
</html>
