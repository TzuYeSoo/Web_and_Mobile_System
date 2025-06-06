<?php

include 'connection.php';
$uniform_id = $_GET['id'];

$uniform = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM uniforms WHERE uniform_id = $uniform_id"));
$inventory = mysqli_query($conn, "SELECT * FROM uniform_inventory WHERE uniform_id = $uniform_id");
$supplier = mysqli_query($conn, "SELECT supplier_id, comapany_name, contact FROM supplier WHERE user_status ='1' ");
?>
<div style="margin-top: 20px;">
    <button type="button" onclick="history.back()">⬅️ Back</button>
</div>

<form method="POST" action="query_insert_uniform_logs.php" enctype="multipart/form-data">
  <input type="hidden" name="uniform_id" value="<?= $uniform_id ?>">

  <label>Program Name:</label>
  <input type="text" name="program_name" value="<?= $uniform['program_name'] ?>" required>

  <label>Status:</label>
  <select name="uniform_status" required>
    <option value="1" <?= $uniform['uniform_status'] == 1 ? 'selected' : '' ?>>Available</option>
    <option value="0" <?= $uniform['uniform_status'] == 0 ? 'selected' : '' ?>>Unavailable</option>
  </select>

  <label>Current Image:</label>
  <img src="uploads/<?= $uniform['image_unif'] ?>" width="100"><br>
  <label>Change Image:</label>
  <input type="file" name="image_unif">

  <h3>Inventory Items</h3>
  <label>Supplier:</label>
    <select name="supplier_id" required>
        <option value="">-- Select Supplier --</option>
        <?php 
        while ($row = mysqli_fetch_assoc($supplier)) {
            echo '<option value="' . $row['supplier_id'] . '">' . htmlspecialchars($row['comapany_name']) . '</option>';
        }
        ?>
    </select>


  <div id="inventoryItemsContainer">
    <?php
    $index = 0;
    while ($row = mysqli_fetch_assoc($inventory)) {
    ?>
      <div class="inventory-item">
        <input type="hidden" name="inventory[<?= $index ?>][inventory_id]" value="<?= $row['inventory_id'] ?>">

        <label>Part:</label>
        <input type="text" name="inventory[<?= $index ?>][part]" value="<?= $row['part'] ?>" readonly>

        <label>Size:</label>
        <input type="text" name="inventory[<?= $index ?>][size]" value="<?= $row['size'] ?>" readonly>

        <label>Price:</label>
        <input type="number" name="inventory[<?= $index ?>][price]" value="<?= $row['price'] ?>" readonly>

        <label>Quantity:</label>
        <input type="number" name="inventory[<?= $index ?>][quantity]" value="<?= $row['quantity'] ?>" readonly>

        <label>Added Stock:</label>
        <input type="number" name="inventory[<?= $index ?>][added_stock]" value="0" required>

        <label>Date of stock in:</label>
        <input type="date" name="inventory[<?= $index ?>][date_created]">

      </div>
    <?php $index++; } ?>
  </div>
  <button type="submit">ADD STOCK</button>
</form>
