
  document.addEventListener('DOMContentLoaded', function() {
    const uniformSelect    = document.getElementById('uniformSelect');
    const qtyInput         = document.getElementById('quantityInput');
    const unitPriceInput   = document.getElementById('unitPriceInput');
    const totalPriceInput  = document.getElementById('totalPriceInput');

    function updatePrices() {
      const selectedOption = uniformSelect.selectedOptions[0];
      const unitPrice = parseFloat(selectedOption.dataset.price) || 0;
      const quantity  = parseInt(qtyInput.value, 10) || 0;
      unitPriceInput.value  = unitPrice.toFixed(2);
      totalPriceInput.value = (unitPrice * quantity).toFixed(2);
    }

    uniformSelect.addEventListener('change', updatePrices);
    qtyInput.addEventListener('input', updatePrices);
  });

