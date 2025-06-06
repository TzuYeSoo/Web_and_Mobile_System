function addConsumable(){
    const modal = document.getElementById('add_consumable');
    const backdrop = document.getElementById('backdrop');

    modal.style.display = 'block';
    backdrop.style.display = 'block';

}

function closeConsumable(){
    const modal = document.getElementById('add_consumable');
    const backdrop = document.getElementById('backdrop');

    modal.style.display = 'none';
    backdrop.style.display = 'none';

}