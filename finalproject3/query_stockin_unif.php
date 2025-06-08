<?php
 
include 'connection.php';
$uniform_id = $_GET['id'];

$uniform = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM uniforms WHERE uniform_id = $uniform_id"));
$inventory = mysqli_query($conn, "SELECT * FROM uniform_inventory WHERE uniform_id = $uniform_id");
$stock_movements = mysqli_query($conn, "SELECT comapany_name, stock_type, stock_quantity, date_created FROM uniforms as u
      INNER JOIN uniform_inventory as ui ON u.uniform_id = ui.uniform_id
      INNER JOIN uniform_stock_movement as usm ON ui.inventory_id = usm.inventory_id 
      LEFT JOIN supplier as s ON usm.supplier_id = s.supplier_id
      WHERE u.uniform_id = $uniform_id");

$uniform = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM uniforms WHERE uniform_id = $uniform_id"));
$inventory = mysqli_query($conn, "SELECT * FROM uniform_inventory WHERE uniform_id = $uniform_id");
$supplier = mysqli_query($conn, "SELECT supplier_id, comapany_name, contact FROM supplier WHERE user_status ='1' ");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="edit_stock.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <button type="button" class="back-btn" onclick="history.back()">
                <span>←</span> Back
            </button>
            <h1 style="font-size: 1.75rem; font-weight: 700; color: var(--text-primary);">Uniform Inventory Stockin</h1>
        </div>

        <form method="POST" action="query_insert_uniform_logs.php" enctype="multipart/form-data" class="main-form">
            <input type="hidden" name="uniform_id" value="1">

            <div class="form-section">
                <h2 class="section-title">Program Details</h2>
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Program Name:</label>
                        <input type="text" name="program_name" value="BSBA" class="form-input" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Status:</label>
                        <select name="uniform_status" class="form-select status-available" required>
                            <option value="1" selected>Available</option>
                            <option value="0">Unavailable</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Current Image:</label>
                        <img src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAwIiBoZWlnaHQ9IjEwMCIgdmlld0JveD0iMCAwIDEwMCAxMDAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjxyZWN0IHdpZHRoPSIxMDAiIGhlaWdodD0iMTAwIiBmaWxsPSIjRjNGNEY2Ii8+CjxwYXRoIGQ9Ik0zNSA2NUw1MCA1MEw2NSA2NUgzNVoiIGZpbGw9IiM5Q0EzQUYiLz4KPGNpcmNsZSBjeD0iNDAiIGN5PSI0MCIgcj0iNSIgZmlsbD0iIzlDQTNBRiIvPgo8L3N2Zz4K" alt="Current uniform image" class="current-image" width="100">
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Change Image:</label>
                        <div class="file-input-wrapper">
                            <input type="file" name="image_unif" class="file-input">
                            <div class="file-input-label">
                                <span>📁</span> Choose File
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-section">
                <h2 class="section-title">Supplier Selection</h2>
                <div class="form-group">
                    <label class="form-label">Supplier:</label>
                    <select name="supplier_id" class="form-select" required>
                        <option value="">-- Select Supplier --</option>
                        <option value="1">Leveling City</option>
                        <option value="2">J&M Company</option>
                        <option value="3">ABC Uniforms Inc.</option>
                    </select>
                </div>
            </div>

            <div class="inventory-section">
                <h2 class="section-title">Inventory Items</h2>
                <div class="inventory-grid">
                    <!-- Polo Item -->
                    <div class="inventory-item">
                        <input type="hidden" name="inventory[0][inventory_id]" value="1">
                        <div class="inventory-header">
                            <span class="part-name">Polo</span>
                            <span class="stock-badge stock-high">In Stock</span>
                        </div>
                        
                        <div class="inventory-details">
                            <div class="detail-item">
                                <span class="detail-label">Size</span>
                                <span class="detail-value">S</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">Price</span>
                                <span class="detail-value">₱250.00</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">Current Stock</span>
                                <span class="detail-value">58 pcs</span>
                            </div>
                        </div>
                        
                        <input type="hidden" name="inventory[0][part]" value="Polo">
                        <input type="hidden" name="inventory[0][size]" value="S">
                        <input type="hidden" name="inventory[0][price]" value="250.00">
                        <input type="hidden" name="inventory[0][quantity]" value="58">
                        
                        <div class="stock-input-group">
                            <div class="form-group">
                                <label class="form-label">Added Stock:</label>
                                <input type="number" name="inventory[0][added_stock]" value="0" class="form-input" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Date of Stock In:</label>
                                <input type="date" name="inventory[0][date_created]" class="form-input">
                            </div>
                        </div>
                    </div>

                    <!-- Polo Item (M) -->
                    <div class="inventory-item">
                        <input type="hidden" name="inventory[1][inventory_id]" value="2">
                        <div class="inventory-header">
                            <span class="part-name">Polo</span>
                            <span class="stock-badge stock-medium">Medium Stock</span>
                        </div>
                        
                        <div class="inventory-details">
                            <div class="detail-item">
                                <span class="detail-label">Size</span>
                                <span class="detail-value">M</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">Price</span>
                                <span class="detail-value">₱250.00</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">Current Stock</span>
                                <span class="detail-value">36 pcs</span>
                            </div>
                        </div>
                        
                        <input type="hidden" name="inventory[1][part]" value="Polo">
                        <input type="hidden" name="inventory[1][size]" value="M">
                        <input type="hidden" name="inventory[1][price]" value="250.00">
                        <input type="hidden" name="inventory[1][quantity]" value="36">
                        
                        <div class="stock-input-group">
                            <div class="form-group">
                                <label class="form-label">Added Stock:</label>
                                <input type="number" name="inventory[1][added_stock]" value="0" class="form-input" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Date of Stock In:</label>
                                <input type="date" name="inventory[1][date_created]" class="form-input">
                            </div>
                        </div>
                    </div>

                    <!-- Polo Item (L) -->
                    <div class="inventory-item">
                        <input type="hidden" name="inventory[2][inventory_id]" value="3">
                        <div class="inventory-header">
                            <span class="part-name">Polo</span>
                            <span class="stock-badge stock-medium">Medium Stock</span>
                        </div>
                        
                        <div class="inventory-details">
                            <div class="detail-item">
                                <span class="detail-label">Size</span>
                                <span class="detail-value">L</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">Price</span>
                                <span class="detail-value">₱250.00</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">Current Stock</span>
                                <span class="detail-value">36 pcs</span>
                            </div>
                        </div>
                        
                        <input type="hidden" name="inventory[2][part]" value="Polo">
                        <input type="hidden" name="inventory[2][size]" value="L">
                        <input type="hidden" name="inventory[2][price]" value="250.00">
                        <input type="hidden" name="inventory[2][quantity]" value="36">
                        
                        <div class="stock-input-group">
                            <div class="form-group">
                                <label class="form-label">Added Stock:</label>
                                <input type="number" name="inventory[2][added_stock]" value="0" class="form-input" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Date of Stock In:</label>
                                <input type="date" name="inventory[2][date_created]" class="form-input">
                            </div>
                        </div>
                    </div>

                    <!-- Neck Tie Item -->
                    <div class="inventory-item">
                        <input type="hidden" name="inventory[3][inventory_id]" value="4">
                        <div class="inventory-header">
                            <span class="part-name">Neck Tie</span>
                            <span class="stock-badge stock-low">Low Stock</span>
                        </div>
                        
                        <div class="inventory-details">
                            <div class="detail-item">
                                <span class="detail-label">Size</span>
                                <span class="detail-value">L</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">Price</span>
                                <span class="detail-value">₱250.00</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">Current Stock</span>
                                <span class="detail-value">11 pcs</span>
                            </div>
                        </div>
                        
                        <input type="hidden" name="inventory[3][part]" value="Neck tie">
                        <input type="hidden" name="inventory[3][size]" value="L">
                        <input type="hidden" name="inventory[3][price]" value="250.00">
                        <input type="hidden" name="inventory[3][quantity]" value="11">
                        
                        <div class="stock-input-group">
                            <div class="form-group">
                                <label class="form-label">Added Stock:</label>
                                <input type="number" name="inventory[3][added_stock]" value="0" class="form-input" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Date of Stock In:</label>
                                <input type="date" name="inventory[3][date_created]" class="form-input">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div style="text-align: center; margin: 2rem 0;">
                <button type="submit" class="submit-btn">Add Stock</button>
            </div>
        </form>

  <div class="stock-movement-section">
      <h3>Stock Movement</h3>
      <table class="stock-table">
        <thead>
          <tr>
            <th>Stock Type</th>
            <th>Stock Quantity</th>
            <th>Supplier</th>
            <th>Date</th>
          </tr>
        </thead>
        <tbody>
          <?php
          while($row=mysqli_fetch_assoc($stock_movements)){
          ?>
            <tr>
              <td><?php echo $row['stock_type']?></td>
              <td><?php echo $row['stock_quantity']?></td>
              <td><?php echo $row['comapany_name']?></td>
              <td><?php echo $row['date_created']?></td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
</body>
</html>

</form>
