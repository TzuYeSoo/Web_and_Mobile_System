
// add unif modal
function open_add() {
    const modal = document.querySelector('#add_unif');
    const backdrop = document.querySelector('.backdrop');

        if (modal) modal.style.display = 'block';
        if (backdrop) backdrop.style.display = 'block';
}
function close_add() {
    const modal = document.querySelector('#add_unif');
    const backdrop = document.querySelector('.backdrop');

        if (modal) modal.style.display = 'none';
        if (backdrop) backdrop.style.display = 'none';
}

// add stock modal
let stock_pname, stock_quantity, stock_id;
function add_stock(stock_pname, stock_quantity, stock_id) {
    const modal = document.querySelector('#add_stock');
    const backdrop = document.querySelector('.backdrop');

    const id = document.getElementById('stock_id');
    const pname =document.getElementById('stock_pname');
    const quantity =document.getElementById('stock_quantity');

    pname.value = stock_pname;
    quantity.value = stock_quantity;
    id.value = stock_id;

        if (modal) modal.style.display = 'block';
        if (backdrop) backdrop.style.display = 'block';
}

function close_stock() {
    const modal = document.querySelector('#add_stock');
    const backdrop = document.querySelector('.backdrop');

        if (modal) modal.style.display = 'none';
        if (backdrop) backdrop.style.display = 'none';
}

// add edit modal
let pname, price, quantity, unif_id;
function open_edit(pname, price, quantity, unif_id) {
    const modal = document.querySelector('#edit_modal');
    const backdrop = document.querySelector('.backdrop');

    const id = document.getElementById('edit_id');
    const edit_pname = document.getElementById('edit_pname');
    const edit_quantity = document.getElementById('edit_quantity');
    const edit_price = document.getElementById('edit_price');

    id.value = unif_id;
    edit_pname.value = pname;
    edit_quantity.value = quantity;
    edit_price.value = price;

    modal.style.display = 'block';
    backdrop.style.display = 'block';
}

function close_edit() {
    const modal = document.querySelector('#edit_modal');
    const backdrop = document.querySelector('.backdrop');

        if (modal) modal.style.display = 'none';
        if (backdrop) backdrop.style.display = 'none';
}


// open ng logs
function closeLogModal() {
    document.getElementById('backdrop').style.display= 'none';
    document.getElementById("logModal").style.display = "none";
}
function openLogModal(uniformId) {
    document.getElementById('backdrop').style.display = 'block';
    document.getElementById("logModal").style.display = 'block';

    const tbody = document.getElementById("logsBody");
    const nameHeader = document.getElementById("uniformNameHeader");

    tbody.innerHTML = "<tr><td colspan='4'>Loading...</td></tr>";
    nameHeader.innerText = "Loading uniform name...";

    fetch("query_select_uniform_logs.php?uniform_id=" + uniformId)
        .then(response => response.json())
        .then(data => {
            tbody.innerHTML = "";
            if (data.length === 0) {
                tbody.innerHTML = "<tr><td colspan='4'>No movement logs found.</td></tr>";
                nameHeader.innerText = "Uniform not found";
                return;
            }

            // Set uniform name from first row
            nameHeader.innerText = data[0].uniform_name;

            data.forEach(log => {
                const row = `
                    <tr>
                        <td>${log.comapany_name}</td>
                        <td>${log.stock_type}</td>
                        <td>${log.stock_quantity}</td>
                        <td>${log.date_created}</td>
                    </tr>
                `;
                tbody.innerHTML += row;
            });
        })
        .catch(err => {
            console.error(err);
            tbody.innerHTML = "<tr><td colspan='4'>Failed to load logs.</td></tr>";
            nameHeader.innerText = "Error loading uniform";
        });
}

let itemIndex = 0;

function addInventoryItem() {
  const container = document.getElementById('inventoryItemsContainer');
  const item = document.createElement('div');
  item.classList.add('inventory-item');
  item.innerHTML = `
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
    <input type="number" step="0.01" name="inventory[${itemIndex}][price]" required>

    <button type="button" onclick="removeInventoryItem(this)">❌ Remove</button>
  `;
  container.appendChild(item);
  itemIndex++;
}

function removeInventoryItem(button) {
  const item = button.parentNode;
  item.remove();
}





