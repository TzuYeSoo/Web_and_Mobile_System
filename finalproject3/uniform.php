<?php 
    require_once "connection.php";

    $sql = "SELECT uniform_id, program_name, uniform_status FROM uniforms
    WHERE uniform_status='1'";

    $supplier_sql = "SELECT supplier_id, comapany_name FROM supplier WHERE user_status='1'";

    $result = mysqli_query($conn, $sql);
    $supplier_result = mysqli_query($conn, $supplier_sql);                         
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UNIFORM</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="dashboard.css">
    <link rel="stylesheet" href="uniform.css">
    <link rel="stylesheet" href="style_newunif.css">
    <link rel="stylesheet" href="stockin.css">
    <link rel="stylesheet" href="Logs.css">
</head>
<body>
   <div class="backdrop" id="backdrop"></div>
<!--Start ng new unif add-->
    <div class="add_stock_container" id="add_unif">
        <div class="header_bg">
            <h2>UNIFORM</h2>
            <button  onclick="close_add()">&#10005;</button>
        </div>
        <form id="uniformForm" method="POST" enctype="multipart/form-data" action="query_insert_unif.php">
            <label>Program Name:</label>
            <input type="text" name="program_name" required>

            <label>Upload Image:</label>
            <input type="file" name="image_unif" accept="image/*" required>

            <label>Status:</label>
            <select name="uniform_status" required>
                <option value="1">Available</option>
                <option value="0">Unavailable</option>
            </select>

            <!-- Inventory section -->
            <div id="inventoryItemsContainer"></div>

            <button type="button" onclick="addInventoryItem()">Add Size + Part</button>
            <button type="submit">Save Uniform</button>
        </form>
    </div>
<!-- End ng unif add-->

<!-- Start ng stock-in in -->
    <div class = "stockin_container" id="add_stock">
        <div class="bg_header">
             <h2>Stock In</h2>
              <button class="close-btn" onclick="close_stock()">&#10005;</button>
        </div>
         <form class="forms" method="post" action="query_insert_uniform_logs.php" enctype="multipart/form-data">
        <div class="stockin_grid">
            <h2 >Uniform name</h2>
            <div class="input-fields_stockin">
                <input type="hidden" name="stock_id" id="stock_id" required>
                <input type="text" placeholder="Uniform name" name="stock_pname" id="stock_pname" readonly>
                <input type="number" placeholder="Current Stock" name="stock_quantity" id="stock_quantity" readonly>
                <input type="number" placeholder="To be add stock" name="added_stock" id="added_stock" required>
                <select name="supplier_id" required>
                    <option value="" disabled selected>Supplier</option>
                    <?php 
                        while($row = mysqli_fetch_assoc($supplier_result)) { 
                    ?>
                        <option value="<?php echo $row['supplier_id']; ?>">
                            <?php echo $row['supplier_id'] . '. ' . $row['comapany_name']; ?>
                        </option>
                    <?php 
                        } 
                    ?>  
                </select>
                <input type="date" placeholder="To be add stock" name="date_added" id="date_added" required>
            </div>
            <div class="add_button_containerr">
            <input type="submit" class="add_btn" value="ADD STOCK">
        </div>
        </div>
        </form>
    </div>
<!-- End ng stock in -->

<!-- Start ng edit -->
    <div class="log_stock_container" id="edit_modal">
        <div class="header_bg">
            <h2>UNIFORM</h2>
             <button class="close-btn" onclick="close_edit('modal_logs')">&#10005;</button>
        </div>
        <form class="forms" method="post" action="query_update_unif.php" enctype="multipart/form-data">
        <div class="log_grid">
            <div class="image-upload">
                <div class="image-placeholder"></div>
                <input type="file" name="update_image">
            </div>
            <div class="input-fields_logs">
                <input type="text" placeholder="Program name" name="edit_pname" id="edit_pname" required>
                <input type="number" placeholder="Uniform quantity" name="edit_quantity" id="edit_quantity" required>
                <input type="number" placeholder="Uniform price" name="edit_price" id="edit_price" required>
            </div>
            <div class="edit_checkboxes">

                <div class="checkbox-column">
                    <label>
                        <input type="checkbox" class="item-check"  name="edit_items[]" value="Polo"> Polo
                    </label>
                    <label>
                        <input type="checkbox" class="item-check"  name="edit_items[]" value="Pants"> Pants
                    </label>
                    <label>
                        <input type="checkbox" class="item-check"  name="edit_items[]" value="Necktie"> Neck Tie
                    </label>
                </div>
                <div class="checkbox-column">
                     <label>
                        <input type="checkbox" class="item-check"  name="edit_items[]" value="Blazer"> Blazer
                    </label>
                    <label>
                        <input type="checkbox" class="item-check"  name="edit_items[]" value="Hats"> Hats
                    </label>
                    <label>
                        <input type="checkbox" class="item-check"  name="edit_items[]" value="Necktie"> Neck Tie
                    </label>
                </div>
            </div>
        </div>
        <div class="add_button-container">
            <input type="submit" class="add-btn1" value="EDIT">
        </div>
        </form>
    </div>
<!-- End ng edit -->

<!-- Start ng Uniform logs -->
    <div class="logs-table" id="logModal" style="display: none;"> 
        <div class="logs-header">
            <h2>Stock Movement Logs</h2>
            <h3 id="uniformNameHeader"></h3>
            <button onclick="closeLogModal()">X</button>
        </div>
        <table id="logsTable">
            <thead>
                <tr>
                    <th>Supplier</th>
                    <th>Type</th>
                    <th>Quantity</th>
                    <th>Date</th>
                </tr>
            </thead>
                <tbody id="logsBody">
                    <!-- Logs will be loaded here -->
                </tbody>
        </table>
    </div>

<!-- End ng uniform logs -->
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
                    <h1>Uniform</h1>
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
                            <th>Program name</th>
                            <th>status</th>
                            <th>
                                
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 

                            while($row=mysqli_fetch_assoc($result)){
                                 
                                ?> 
                                    <tr>
                                        <td><?php echo $row['program_name']?></td>
                                        <td><?php echo $row['uniform_status']?></td>
                                        <td>

                                            <a href="query_edit_unif.php?id=<?= $row['uniform_id'] ?>&action=edit" 
                                            class="action-icon" 
                                            title="Edit Uniform"
                                            onclick="return confirm('Do you want to edit this uniform?');">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                            <i class="fas fa-plus-circle" onclick="add_stock()"></i>

                                            <i class="fas fa-clipboard" style="cursor: pointer;" onclick="openLogModal(<?php echo $row['uniform_id']; ?>)"></i>
                                            
                                            <a href="query_update_unif_status.php?id=<?= $row['uniform_id'] ?>&action=1" class="action-icon" title="1" onclick="return confirm('Are you sure you want to remove this uniform?');">
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
                <i class="fas fa-plus-circle" onclick="open_add()"></i>
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

    <script>
        document.getElementById('imageInput').addEventListener('change', function(event) {
                const [file] = event.target.files;
                if (file) {
                    const img = document.getElementById('imagePreview');
                    img.src = URL.createObjectURL(file);
                    img.style.display = 'block';
                }
            });
    </script>




</body>
</html>
