<?php
require_once "connection.php";

$supplier_id = $_POST['supplier_id'];
$edit_fname = $_POST['edit_fname'];
$edit_lname = $_POST['edit_lname'];
$edit_cname = $_POST['edit_cname'];
$edit_contact = $_POST['edit_contact'];

$stmt = $conn->prepare("UPDATE supplier SET firt_name = ?, last_name = ?, comapany_name = ?, contact = ? WHERE supplier_id = ?");
$stmt->bind_param("sssss", $edit_fname, $edit_lname, $edit_cname, $edit_contact, $supplier_id);

if ($stmt->execute()) {
    echo "<script>
        alert('Supplier updated successfully.');
        window.location.href='supplier.php';
    </script>";
} else {
    echo "<script>
        alert('Failed to update supplier.');
        window.history.back();
    </script>";
}

$stmt->close();
$conn->close();
?>
