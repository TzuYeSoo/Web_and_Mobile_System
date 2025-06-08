    
    
    let supplier_id, firt_name, last_name, comapany_name, contact;

    function editSupplier(supplier_id, firt_name, last_name, comapany_name, contact){

        const edit_modal = document.getElementById("edit_supplier");
        const backdrop = document.getElementById("backdrop");
        
        const id = document.getElementById("supplier_id");
        const fname = document.getElementById("edit_fname");
        const lname = document.getElementById("edit_lname");
        const cname = document.getElementById("edit_cname");
        const cnum = document.getElementById("edit_contact");

        id.value = supplier_id;
        fname.value = firt_name;
        lname.value = last_name;
        cname.value = comapany_name;
        cnum.value = contact;

        edit_modal.style.display = 'block';
        backdrop.style.display = 'block';
    }
    function closeEdit(){
        const edit_modal = document.getElementById("edit_supplier");
        const backdrop = document.getElementById("backdrop");

        edit_modal.style.display = 'none';
        backdrop.style.display = 'none';
    }
    // start ng add supplier

    function addSupplier(){

        const edit_modal = document.getElementById("add_supplier");
        const backdrop = document.getElementById("backdrop");

        edit_modal.style.display = 'block';
        backdrop.style.display = 'block';
    }

    function closeSupplier(){

        const edit_modal = document.getElementById("add_supplier");
        const backdrop = document.getElementById("backdrop");

        edit_modal.style.display = 'none';
        backdrop.style.display = 'none';
    }

    function currentSupplier(){

        const current = document.getElementById('current_supplier');
        const history = document.getElementById('history_supplier');

        current.style.display = 'block';
        history.style.display = 'none';

    }
    
    function historySupplier(){
        
        const current = document.getElementById('current_supplier');
        const history = document.getElementById('history_supplier');

        current.style.display = 'none';
        history.style.display = 'block';
    }