


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UNIFORMS</title>
    <link rel="stylesheet" href="Logs.css">
</head>
<body>
    <!--Start ng new unif add-->
    <div class="add_stock_container" id="add_unif">
        <div class="header_bg">
            <h2>UNIFORM</h2>
            <button  onclick="window.location.href='uniform.php'">&#10005;</button>
        </div>
        
        <form id="uniformForm" method="POST" enctype="multipart/form-data" action="query_insert_unif.php">
            <label for="program_name">Program Name:</label>
            <input type="text" id="program_name" name="program_name" placeholder="Enter program name" required>
            
            <label for="image_unif">Upload Image:</label>
            <input type="file" id="image_unif" name="image_unif" accept="image/*" required>
            
            <label for="uniform_status">Status:</label>
            <select id="uniform_status" name="uniform_status" required>
                <option value="1">Available</option>
                <option value="0">Unavailable</option>
            </select>
            
            <div class="inventory-section">
                <div class="inventory-header">
                    <h3>Inventory Items</h3>
                    <button type="button" class="add-item-btn" onclick="addInventoryItem()">
                        <i class="fas fa-plus"></i> Add Size + Part
                    </button>
                </div>
                
                <div id="inventoryItemsContainer">
                    <div class="empty-message">
                        Click "Add Size + Part" to add inventory items
                    </div>
                </div>
            </div>
            
            <button type="submit" class="submit-btn">
                <i class="fas fa-save"></i> Save Uniform
            </button>
        </form>
    </div>
<!-- End ng unif add-->
    <script>
        let itemIndex = 0;

        function addInventoryItem() {
            const container = document.getElementById('inventoryItemsContainer');
            
            // Remove empty message if it exists
            const emptyMessage = container.querySelector('.empty-message');
            if (emptyMessage) {
                emptyMessage.remove();
            }
            
            // Create new inventory item
            const itemDiv = document.createElement('div');
            itemDiv.className = 'inventory-item';
            itemDiv.setAttribute('data-index', itemIndex);
            
            itemDiv.innerHTML = `
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
                <input type="number" name="inventory[${itemIndex}][quantity]" min="0" required>

                <label>Price:</label>
                <input type="number" step="0.01" name="inventory[${itemIndex}][price]" min="0" required>

                <button type="button" class="remove-button" onclick="removeInventoryItem(this)">❌ Remove</button>
            `;
            
            container.appendChild(itemDiv);
            itemIndex++;
            
            // Focus on the first select of the new item
            const firstSelect = itemDiv.querySelector('select[name*="[part]"]');
            if (firstSelect) {
                firstSelect.focus();
            }
        }

        function removeInventoryItem(button) {
            const itemDiv = button.closest('.inventory-item');
            const container = document.getElementById('inventoryItemsContainer');
            
            if (itemDiv) {
                itemDiv.remove();
                
                // Show empty message if no items left
                if (container.children.length === 0) {
                    container.innerHTML = '<div class="empty-message">Click "Add Size + Part" to add inventory items</div>';
                }
            }
        }

        function close_add() {
            // Add your close functionality here
            document.getElementById('add_unif').style.display = 'none';
            // Or remove the modal from DOM
            // document.getElementById('add_unif').remove();
        }

        // Form validation before submit
        document.getElementById('uniformForm').addEventListener('submit', function(e) {
            const container = document.getElementById('inventoryItemsContainer');
            const inventoryItems = container.querySelectorAll('.inventory-item');
            
            if (inventoryItems.length === 0) {
                e.preventDefault();
                alert('Please add at least one inventory item before saving.');
                return false;
            }
            
            // Additional validation can be added here
            return true;
        });

        // Add first item automatically when page loads (optional)
        window.addEventListener('DOMContentLoaded', function() {
            // Uncomment the line below if you want to add one item by default
            // addInventoryItem();
        });
    </script>
</body>

</html>