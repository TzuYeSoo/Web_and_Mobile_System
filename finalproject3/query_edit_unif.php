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
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="edit_uniform.css">
</head>
<body>
  <div class="main-edit-container">
    <div class="edit-uniform-container">
      <button type="button" class="back-btn" onclick="history.back()">⬅️ Back</button>
      <form method="POST" action="query_update_uniform.php" enctype="multipart/form-data" class="edit-uniform-form">
        <input type="hidden" name="uniform_id" value="<?= $uniform_id ?>">
        <label>Program Name:</label>
        <input type="text" name="program_name" value="<?= $uniform['program_name'] ?>" required>
        <label>Status:</label>
        <select name="uniform_status" required>
          <option value="1" <?= $uniform['uniform_status'] == 1 ? 'selected' : '' ?>>Available</option>
          <option value="0" <?= $uniform['uniform_status'] == 0 ? 'selected' : '' ?>>Unavailable</option>
        </select>
        <label>Current Image:</label>
        <img src="uploads/<?= $uniform['image_unif'] ?>" class="uniform-img-preview"><br>
        <label>Change Image:</label>
        <input type="file" name="image_unif">

        <div class="inventory-container">
          <h3>Inventory Items</h3>
          <div id="inventoryItemsContainer">
            <?php
            $index = 0;
            while ($row = mysqli_fetch_assoc($inventory)) {
            ?>
              <div class="inventory-item">
                <input type="hidden" name="inventory[<?= $index ?>][inventory_id]" value="<?= $row['inventory_id'] ?>">
                <label>Part:</label>
                <select name="inventory[<?= $index ?>][part]" required>
                  <?php
                  $parts = ['Polo', 'Blouse', 'Pants', 'Skirt', 'Neck tie', 'Blazer', 'Hats'];
                  foreach ($parts as $p) {
                    $sel = $row['part'] === $p ? 'selected' : '';
                    echo "<option value='$p' $sel>$p</option>";
                  }
                  ?>
                </select>
                <label>Size:</label>
                <select name="inventory[<?= $index ?>][size]" required>
                  <?php
                  $sizes = ['S', 'M', 'L', 'XL', 'XXL'];
                  foreach ($sizes as $s) {
                    $sel = $row['size'] === $s ? 'selected' : '';
                    echo "<option value='$s' $sel>$s</option>";
                  }
                  ?>
                </select>
                <label>Quantity:</label>
                <input type="number" name="inventory[<?= $index ?>][quantity]" value="<?= $row['quantity'] ?>" readonly>
                <label>Price:</label>
                <input type="number" step="0.01" name="inventory[<?= $index ?>][price]" value="<?= $row['price'] ?>" required>
                <button type="button" class="remove-btn" onclick="removeInventoryItem(this)">❌ Remove</button>
              </div>
            <?php $index++; } ?>
          </div>
          <button type="button" class="add-btn" onclick="addInventoryItem()">➕ Add Size + Part</button>
        </div>
        <button type="submit" class="update-btn">Update Uniform</button>
      </form>
    </div>

  
<script>
let itemIndex = <?= $index ?>;

function addInventoryItem() {
  const container = document.getElementById('inventoryItemsContainer');
  const div = document.createElement('div');
  div.classList.add('inventory-item');
  div.innerHTML = `
    <hr>
    <label>Part:</label>
    <select name="inventory[${itemIndex}][part]" required>
      <option value="Polo">Polo</option>
      <option value="Blouse">Blouse</option>
      <option value="Pants">Pants</option>
      <option value="Skirt">Skirt</option>
      <option value="Neck tie">Neck tie</option>
      <option value="Blazer">Blazer</option>
      <option value="Hats">Hats</option>
    </select>

    <label>Size:</label>
    <select name="inventory[${itemIndex}][size]" required>
      <option value="S">S</option>
      <option value="M">M</option>
      <option value="L">L</option>
      <option value="XL">XL</option>
      <option value="XXL">XXL</option>
    </select>

    <label>Quantity:</label>
    <input type="number" name="inventory[${itemIndex}][quantity]" required>

    <label>Price:</label>
    <input type="number" step="0.01" name="inventory[${itemIndex}][price]" required>

    <button type="button" onclick="removeInventoryItem(this)">❌ Remove</button>
  `;
  container.appendChild(div);
  itemIndex++;
  
}

function removeInventoryItem(button) {
  button.parentNode.remove();
}
</script>
</body>
</html>

