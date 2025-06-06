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


</head>
<body>
   <div class="backdrop" id="backdrop"></div>

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
                                 $status = 'Available';
                                ?> 
                                    <tr>
                                        <td><?php echo $row['program_name']?></td>
                                        <td><?php echo $status ?></td>
                                        <td>

                                                                                        <!-- Edit Uniform Icon -->
                                            <a href="query_edit_unif.php?id=<?= $row['uniform_id'] ?>&action=edit" 
                                            class="action-icon" 
                                            title="Edit Uniform">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>

                                            <!-- Add Stock Icon -->
                                            <a href="query_stockin_unif.php?id=<?= $row['uniform_id'] ?>" 
                                            class="action-icon" 
                                            title="Add Stock">
                                                <i class="fas fa-plus-circle"></i>
                                            </a>

                                            <!-- logs to -->
                                            <i class="fas fa-clipboard" style="cursor: pointer;" 
                                            onclick="openLogModal(<?php echo $row['uniform_id']; ?>)"></i>
                                            
                                            <!-- Remove to to -->
                                            <a href="query_update_unif_status.php?id=<?= $row['uniform_id'] ?>&action=1" 
                                            class="action-icon" title="1" 
                                            onclick="return confirm('Are you sure you want to remove this uniform?');">
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

            <button class="add-item-button" onclick="window.location.href='query_unif_add.php'">
                <i class="fas fa-plus-circle"></i>
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
