
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


  function addReservation(){

    const modal = document.getElementById('add_resrvation');
    const backdrop = document.getElementById('backdrop');

    modal.style.display = 'block';
    backdrop.style.display = 'block';

  }

  function closeRservation(){

    const modal = document.getElementById('add_resrvation');
    const backdrop = document.getElementById('backdrop');

    modal.style.display = 'none';
    backdrop.style.display = 'none';
  }
// table data changing
  function cancelRervation(){

    const reserved = document.getElementById("current_reservation");
    const cancel = document.getElementById("cancel_reservation");
    const complete = document.getElementById("complete_reservation");

    cancel.style.display = 'block';
    reserved.style.display = 'none';
    complete.style.display = 'none';

  }

  function completeReservation(){

    const reserved = document.getElementById("current_reservation");
    const cancel = document.getElementById("cancel_reservation");
    const complete = document.getElementById("complete_reservation");

    cancel.style.display = 'none';
    reserved.style.display = 'none';
    complete.style.display = 'block';
  }

  function reservedReservation(){

    const reserved = document.getElementById("current_reservation");
    const cancel = document.getElementById("cancel_reservation");
    const complete = document.getElementById("complete_reservation");

    cancel.style.display = 'none';
    reserved.style.display = 'block';
    complete.style.display = 'none';
  }