<?php
session_start();
include 'connect.php';

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    // --- ADD SUPPLIER ---
    if (isset($_POST['add_supplier'])) {
        $name = mysqli_real_escape_string($conn, $_POST['supplier_name']);
        $contact = mysqli_real_escape_string($conn, $_POST['contact_number']);
        $address = mysqli_real_escape_string($conn, $_POST['address']);

        $sql = "INSERT INTO suppliers (user_id, supplier_name, contact_number, address) VALUES ('$user_id', '$name', '$contact', '$address')";
        $query = mysqli_query($conn, $sql);
        
        if ($query) {
            // History
            $action = 'Supplier Added'; $details = "Added supplier: $name"; $status = 'Success';
            $sql = "INSERT INTO history (user_id, action_type, details, status) VALUES ('$user_id', '$action', '$details', '$status')";
            $query = mysqli_query($conn, $sql);            
            header("Location: dashboard.php?msg=Supplier added successfully");
        } else {
            header("Location: dashboard.php?error=Failed to add supplier");
        }
    }
    // --- CREATE ORDER ---
     elseif (isset($_POST['create_order'])) {
        $supplier = mysqli_real_escape_string($conn, $_POST['supplier_name']);
        $item = mysqli_real_escape_string($conn, $_POST['item_name']);
        $amount = (float)$_POST['amount_per_item'];
        $qty = (int)$_POST['quantity'];
        $total = $amount * $qty;

        $sql = "INSERT INTO orders (user_id, supplier_name, item_name, amount_per_item, quantity, total_amount) VALUES ('$user_id', '$supplier', '$item', '$amount', '$qty', '$total')";
        $query = mysqli_query($conn, $sql);
        
        if ($query) {
            // History
            $action = 'Order Created'; $details = "Order for $supplier: $item (x$qty)"; $status = 'Completed';
            $sql = "INSERT INTO history (user_id, action_type, details, status) VALUES ('$user_id', '$action', '$details', '$status')";
            $query = mysqli_query($conn, $sql);

            header("Location: dashboard.php?msg=Order placed successfully");
        } else {
            header("Location: dashboard.php?error=Failed to place order");
        }

    // --- DELETE SUPPLIER ---
    } elseif (isset($_POST['delete_supplier'])) {
        $id = (int)$_POST['id'];
        $sql = "DELETE FROM suppliers WHERE id='$id' AND user_id='$user_id'";
        if (mysqli_query($conn, $sql)) {
             header("Location: dashboard.php?msg=Supplier deleted successfully");
        } else {
             header("Location: dashboard.php?error=Failed to delete supplier");
        }

    // --- DELETE ORDER ---
    } elseif (isset($_POST['delete_order'])) {
        $id = (int)$_POST['id'];
        $sql = "DELETE FROM orders WHERE id='$id' AND user_id='$user_id'";
        if (mysqli_query($conn, $sql)) {
             header("Location: dashboard.php?msg=Order deleted successfully");
        } else {
             header("Location: dashboard.php?error=Failed to delete order");
        }

    // --- UPDATE SUPPLIER ---
    } elseif (isset($_POST['update_supplier'])) {
        $id = (int)$_POST['id'];
        $name = mysqli_real_escape_string($conn, $_POST['supplier_name']);
        $contact = mysqli_real_escape_string($conn, $_POST['contact_number']);
        $address = mysqli_real_escape_string($conn, $_POST['address']);

        $sql = "UPDATE suppliers SET supplier_name='$name', contact_number='$contact', address='$address' WHERE id='$id' AND user_id='$user_id'";
        if (mysqli_query($conn, $sql)) {
             header("Location: dashboard.php?msg=Supplier updated successfully");
        } else {
             header("Location: dashboard.php?error=Failed to update supplier");
        }

    // --- UPDATE ORDER ---
    } elseif (isset($_POST['update_order'])) {
        $id = (int)$_POST['id'];
        $supplier = mysqli_real_escape_string($conn, $_POST['supplier_name']);
        $item = mysqli_real_escape_string($conn, $_POST['item_name']);
        $amount = (float)$_POST['amount_per_item'];
        $qty = (int)$_POST['quantity'];
        $total = $amount * $qty;

        $sql = "UPDATE orders SET supplier_name='$supplier', item_name='$item', amount_per_item='$amount', quantity='$qty', total_amount='$total' WHERE id='$id' AND user_id='$user_id'";
        if (mysqli_query($conn, $sql)) {
             header("Location: dashboard.php?msg=Order updated successfully");
        } else {
             header("Location: dashboard.php?error=Failed to update order");
        }
    }
}
?>