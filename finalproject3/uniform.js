// add unif modal
function open_add() {
    const modal = document.getElementById('add_unif');
    const backdrop = document.getElementById('backdrop');
    modal.style.display = 'block';
    backdrop.style.display = 'block';
}

function close_add() {
    const modal = document.getElementById('add_unif');
    const backdrop = document.getElementById('backdrop');
    modal.style.display = 'none';
    backdrop.style.display = 'none';
}

// add stock modal
let stock_pname, stock_quantity, stock_id;
function add_stock(stock_pname, stock_quantity, stock_id) {
    const modal = document.getElementById('add_stock');
    const backdrop = document.getElementById('backdrop');
    modal.style.display = 'block';
    backdrop.style.display = 'block';

    const id = document.getElementById('stock_id');
    const pname =document.getElementById('stock_pname');
    const quantity =document.getElementById('stock_quantity');

    pname.value = stock_pname;
    quantity.value = stock_quantity;
    id.value = stock_id;
}

function close_stock() {
    const modal = document.getElementById('add_stock');
    const backdrop = document.getElementById('backdrop');
    modal.style.display = 'none';
    backdrop.style.display = 'none';
}

// add edit modal
let pname, price, quantity, unif_id;
function open_edit(pname, price, quantity, unif_id) {
    const modal = document.getElementById('edit_modal');
    const backdrop = document.getElementById('backdrop');
    modal.style.display = 'block';
    backdrop.style.display = 'block';

    const id = document.getElementById('edit_id');
    const edit_pname = document.getElementById('edit_pname');
    const edit_quantity = document.getElementById('edit_quantity');
    const edit_price = document.getElementById('edit_price');

    id.value = unif_id;
    edit_pname.value = pname;
    edit_quantity.value = quantity;
    edit_price.value = price;
}

function close_edit(modalId) {
    const modal = document.getElementById(modalId);
    const backdrop = document.getElementById('backdrop');
    modal.style.display = 'none';
    backdrop.style.display = 'none';
}

// open ng logs
function closeLogModal() {
    const modal = document.getElementById('logModal');
    const backdrop = document.getElementById('backdrop');
    modal.style.display = 'none';
    backdrop.style.display = 'none';
}

function openLogModal(uniformId) {
    const modal = document.getElementById('logModal');
    const backdrop = document.getElementById('backdrop');
    
    // Fetch logs for the uniform
    fetch(`get_uniform_logs.php?uniform_id=${uniformId}`)
        .then(response => response.json())
        .then(data => {
            const logsBody = document.getElementById('logsBody');
            logsBody.innerHTML = '';

            data.forEach(log => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${log.supplier_name}</td>
                        <td>${log.stock_type}</td>
                        <td>${log.stock_quantity}</td>
                        <td>${log.date_created}</td>
                `;
                logsBody.appendChild(row);
            });
            
            modal.style.display = 'block';
            backdrop.style.display = 'block';
        })
        .catch(error => {
            console.error('Error fetching logs:', error);
            alert('Error loading logs. Please try again.');
        });
}



function removeInventoryItem(button) {
    const itemDiv = button.closest('.inventory-item');
    itemDiv.remove();
}

// Filter Functions
document.addEventListener('DOMContentLoaded', function() {
    const programFilter = document.getElementById('programFilter');
    const statusFilter = document.getElementById('statusFilter');
    const table = document.querySelector('.inventory-table table tbody');
    
    function filterTable() {
        const programValue = programFilter.value.toLowerCase();
        const statusValue = statusFilter.value;
        
        const rows = table.getElementsByTagName('tr');
        
        for (let row of rows) {
            const programCell = row.cells[0].textContent.toLowerCase();
            const statusCell = row.cells[1].textContent;
            
            const programMatch = !programValue || programCell.includes(programValue);
            const statusMatch = !statusValue || statusCell === statusValue;
            
            row.style.display = programMatch && statusMatch ? '' : 'none';
        }
    }
    
    programFilter.addEventListener('change', filterTable);
    statusFilter.addEventListener('change', filterTable);
});

// Close modals when clicking outside
document.addEventListener('click', function(event) {
    const backdrop = document.getElementById('backdrop');
    if (event.target === backdrop) {
        const modals = document.querySelectorAll('.add-stock-container, .logs-table');
        modals.forEach(modal => {
            modal.style.display = 'none';
        });
        backdrop.style.display = 'none';
    }
});





