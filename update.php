<?php
session_start();
include 'connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

// Prevent caching
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

$user_id = $_SESSION['user_id'];
$id = $_GET['id'] ?? null;
$type = $_GET['type'] ?? null;
$data = null;

if ($id && $type) {
    $id = mysqli_real_escape_string($conn, $id);
    if ($type === 'supplier') {
        $sql = "SELECT * FROM suppliers WHERE id='$id' AND user_id='$user_id'";
        $query = mysqli_query($conn, $sql);
        $data = mysqli_fetch_assoc($query);
    } elseif ($type === 'order') {
        $sql = "SELECT * FROM orders WHERE id='$id' AND user_id='$user_id'";
        $query = mysqli_query($conn, $sql);
        $data = mysqli_fetch_assoc($query);
        
        // Fetch suppliers for dropdown if updating order
        $sql_suppliers = "SELECT * FROM suppliers WHERE user_id = '$user_id' ORDER BY created_at DESC";
        $query_suppliers = mysqli_query($conn, $sql_suppliers);
        $suppliers = mysqli_fetch_all($query_suppliers, MYSQLI_ASSOC);
    }
}

if (!$data) {
    header("Location: dashboard.php?error=Item not found");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update <?php echo ucfirst($type); ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="dashboard-page">
    <div class="main-container" style="justify-content: center; align-items: center; padding-top: 50px; overflow-y: auto;">
        <div class="card" style="width: 100%; max-width: 600px;">
            <h2>Update <?php echo ucfirst($type); ?></h2>
            
            <?php if ($type === 'supplier'): ?>
            <form action="actions.php" method="POST">
                <input type="hidden" name="id" value="<?php echo $data['id']; ?>">
                <div class="form-group">
                    <label>Supplier Name</label>
                    <input type="text" name="supplier_name" value="<?php echo htmlspecialchars($data['supplier_name']); ?>" required>
                </div>
                <div class="form-group">
                    <label>Contact Number</label>
                    <input type="tel" name="contact_number" value="<?php echo htmlspecialchars($data['contact_number']); ?>">
                </div>
                <div class="form-group">
                    <label>Address</label>
                    <textarea name="address" rows="3"><?php echo htmlspecialchars($data['address']); ?></textarea>
                </div>
                <div style="display: flex; gap: 10px;">
                    <button type="submit" name="update_supplier" class="btn">Update Supplier</button>
                    <a href="dashboard.php" class="btn" style="background-color: #6c757d; text-decoration: none; text-align: center;">Cancel</a>
                </div>
            </form>
            <?php elseif ($type === 'order'): ?>
            <form action="actions.php" method="POST">
                <input type="hidden" name="id" value="<?php echo $data['id']; ?>">
                <div class="form-group">
                    <label>Supplier Name</label>
                    <select name="supplier_name" required>
                        <option value="">Select Supplier</option>
                        <?php foreach ($suppliers as $supplier): ?>
                            <option value="<?php echo htmlspecialchars($supplier['supplier_name']); ?>" <?php echo ($data['supplier_name'] == $supplier['supplier_name']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($supplier['supplier_name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Item Name</label>
                    <input type="text" name="item_name" value="<?php echo htmlspecialchars($data['item_name']); ?>" required>
                </div>
                <div class="form-group">
                    <label>Amount (per item)</label>
                    <input type="number" name="amount_per_item" value="<?php echo $data['amount_per_item']; ?>" step="0.01" required>
                </div>
                <div class="form-group">
                    <label>Quantity</label>
                    <input type="number" name="quantity" value="<?php echo $data['quantity']; ?>" required>
                </div>
                <div style="display: flex; gap: 10px;">
                    <button type="submit" name="update_order" class="btn">Update Order</button>
                    <a href="dashboard.php" class="btn" style="background-color: #6c757d; text-decoration: none; text-align: center;">Cancel</a>
                </div>
            </form>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>