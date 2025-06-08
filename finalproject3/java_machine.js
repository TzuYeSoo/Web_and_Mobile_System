    
    
    let machine_id, machine_name, machine_type, machine_room_no, machine_unique_id, machine_quantity;

    function editMachine(machine_id, machine_name, machine_type, machine_room_no, machine_unique_id, machine_quantity){

        const edit_modal = document.getElementById("edit_machine");
        const backdrop = document.getElementById("backdrop");
        
        const id = document.getElementById("machine_id");
        const mname = document.getElementById("machine_name");
        const mt = document.getElementById("machine_type");
        const mrn = document.getElementById("machine_room_no");
        const mud = document.getElementById("machine_unique_id");
        const mq = document.getElementById("machine_quantity");

        id.value = machine_id;
        mname.value = machine_name;
        mt.value = machine_type;
        mrn.value = machine_room_no;
        mud.value = machine_unique_id;
        mq.value = machine_quantity;

        edit_modal.style.display = 'block';
        backdrop.style.display = 'block';
    }

    function closEdit(){

        const edit_modal = document.getElementById("edit_machine");
        const backdrop = document.getElementById("backdrop");

        edit_modal.style.display = 'none';
        backdrop.style.display = 'none';
    }

    function addMachine(){

        const edit_modal = document.getElementById("add_machine");
        const backdrop = document.getElementById("backdrop");

        edit_modal.style.display = 'block';
        backdrop.style.display = 'block';
    }

    function closeMachine(){

        const edit_modal = document.getElementById("add_machine");
        const backdrop = document.getElementById("backdrop");

        edit_modal.style.display = 'none';
        backdrop.style.display = 'none';
    }

    // table function

    function archive(){
        const active = document.getElementById('activemachine');
        const history = document.getElementById('historymachine');

        active.style.display = 'none';
        history.style.display = 'block';
    }

    function active(){
        const active = document.getElementById('activemachine');
        const history = document.getElementById('historymachine');

        active.style.display = 'block';
        history.style.display = 'none';
    }
