    
    
    let supplier_id, firt_name, last_name, comapany_name, contact;

    function editSupplier(supplier_id, firt_name, last_name, comapany_name, contact){

        const edit_modal = document.getElementById("edit_supplier_modal");
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
