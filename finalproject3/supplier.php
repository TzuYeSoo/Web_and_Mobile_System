<?php 
    require_once "connection.php";

    $sql = "SELECT supplier_id, firt_name, last_name, comapany_name, contact, user_status FROM supplier WHERE user_status = 1";

    $result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SUPPLIER</title>
    <link rel="stylesheet" href="dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="uniform.css">
    <link rel="stylesheet" href="style_supplier.css">
</head>
<body>

    
   <div class="backdrop" id="backdrop"></div>
    <!-- Modal for insert new supplier in-->

    <div class="add-stock-container" id="stockin_modal">
        <div class="header_bg">
            <h2>SUPPLIER</h2>
        </div>
        <form class="forms" method="post" action="query_insert_supplier.php" enctype="multipart/form-data">

        <div class="form-grid">
            
           
            <div class="input-fields">
                <input type="text" placeholder="First name" name="firt_name" required>
                <input type="text" placeholder="Last quantity" name="last_name" required>
                <input type="text" placeholder="Company name" name="comapany_name" required>
                <input type="text" placeholder="Contact" name="contact" required>
      
            </div>
            
        </div>
       
        <div class="add-button-container">
            <input type="submit" class="add-button" value="ADD">
        </div>
        </form>
    </div>

    <!-- Modal for insert new supplier in-->
    <div class="add-stock-container" id="edit_supplier_modal">
        <div class="header_bg">
            <h2>SUPPLIER</h2>
        </div>
        <form class="forms-edit" method="post" action="query_edit_supplier.php" >

        <div class="form-grid">
            
           
            <div class="input-fields">
                <input type="hidden" name="supplier_id" id="supplier_id" required>
                <input type="text" placeholder="First name" id="edit_fname" name="edit_fname" required>
                <input type="text" placeholder="Last quantity" id="edit_lname" name="edit_lname" required>
                <input type="text" placeholder="Company name" id="edit_cname" name="edit_cname" required>
                <input type="text" placeholder="Contact" id="edit_contact" name="edit_contact" required>
      
            </div>
            
        </div>
       
        <div class="add-button-container">
            <input type="submit" class="add-button" value="EDIT">
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
                    <h1>Supplier</h1>
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
                            <th></th>
                            <th>First name</th>
                            <th>Last name</th>
                            <th>Company Name</th>
                            <th>contact number</th>
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
                                        <td><?php echo $row['supplier_id']?></td>
                                        <td><?php echo $row['firt_name']?></td>
                                        <td><?php echo $row['last_name']?></td>
                                        <td><?php echo $row['comapany_name']?></td>
                                        <td><?php echo $row['contact']?></td>
                                        <td><?php echo $row['user_status']?></td>
                                        <td>
                                            <center>
                                                <i class="fas fa-pencil-alt" onclick="editSupplier('<?= $row['supplier_id'] ?>', 
                                                                                            '<?= $row['firt_name'] ?>', 
                                                                                            '<?= $row['last_name'] ?>', 
                                                                                            '<?= $row['comapany_name'] ?>',
                                                                                            '<?= $row['contact'] ?>')">
                                                </i>

                                                <a href="query_update_supplier_status.php?id=<?= $row['supplier_id'] ?>&action=1" class="action-icon" title="1" onclick="return confirm('Are you sure you want to cancel this reservation?');">
                                                    <i class="fas fa-times"></i>
                                                </a>
                                            </center>
                                        </td>
                                    </tr>
                                <?php
                            }
                        ?>
                        <!-- Add more rows here -->
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
    <script src="java_supplier.js"></script>
</body>
</html>
