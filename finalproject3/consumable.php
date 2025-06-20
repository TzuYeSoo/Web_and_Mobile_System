<?php 
    require_once "connection.php";

    $sql = "SELECT log_id, teacher_name, item_name, quantity, date_created FROM consumable_log";

    $result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CONSUMABLE</title>
    <link rel="stylesheet" href="dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="uniform.css">
    <link rel="stylesheet" href="style_consumable.css">
</head>
<body>
    <div class="backdrop" id="backdrop"></div>
    <!-- Modal for stock in-->

    <div class="add-stock-container" id="add_consumable">
        <div class="header_bg">
            <h2>CONSUMABLE</h2>
            <button class="close-btn"  onclick="closeConsumable()">&#10005;</button>
        </div>
        <form class="forms" method="post" action="query_insert_consumable.php" enctype="multipart/form-data">

        <div class="form-grid">
            
           
            <div class="input-fields">
                <input type="text" placeholder="Teacher name" name="teacher_name" required>
                <input type="text" placeholder="Item name" name="item_name" required>
                <input type="text" placeholder="quantity" name="quantity" required>
                <input type="datetime-local" name="date_created" required>
      
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
                <a href="dashboard.php" class="nav-item">
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
                    <h1>Consumable</h1>
                </div>
                <div class="user-account">
                    <img src="alden.png" alt="User" class="avatar">
                    <span>user account</span>
                </div>
            </header>

          

            <div class="inventory-table">
                <table>
                    <thead>
                        <tr>
                            <th></th>
                            <th>teacher name</th>
                            <th>item name</th>
                            <th>quantity</th>
                            <th>date created</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            while($row=mysqli_fetch_assoc($result)){
                                ?> 
                                    <tr>
                                        <td><?php echo $row['log_id']?></td>
                                        <td><?php echo $row['teacher_name']?></td>
                                        <td><?php echo $row['item_name']?></td>
                                        <td><?php echo $row['quantity']?></td>
                                        <td><?php echo $row['date_created']?></td>
                                    </tr>
                                <?php
                            }
                        
                        ?>
                    </tbody>
                </table>
            </div>

            <button class="add-item-button">
                <i class="fas fa-plus-circle" onclick="addConsumable()"></i>
            </button>

        </main>

        <div id="addStockModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <div id="addStockForm"></div>
            </div>  
        </div>

    <script src="dashboard.js"></script>
    <script src="java_consumable.js"></script>
</body>
</html>
