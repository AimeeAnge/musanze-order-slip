<?php
session_start();
include 'connect.php';

// Security: Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

// Prevent caching so users can't view the page after logging out using the back button
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

$user_id = $_SESSION['user_id'];
$full_name = $_SESSION['full_name'];

// Fetch Suppliers for List and Dropdown
$sql = "SELECT * FROM suppliers WHERE user_id = '$user_id' ORDER BY created_at DESC";
$query = mysqli_query($conn, $sql);
$result = mysqli_fetch_all($query, MYSQLI_ASSOC);
$suppliers = $result;

// Fetch Orders
$sql = "SELECT * FROM orders WHERE user_id = '$user_id' ORDER BY created_at DESC";
$query = mysqli_query($conn, $sql);
$result = mysqli_fetch_all($query, MYSQLI_ASSOC);
$orders = $result;

// Fetch History
$sql = "SELECT * FROM history WHERE user_id = '$user_id' ORDER BY created_at DESC LIMIT 10";
$query = mysqli_query($conn, $sql);
$result = mysqli_fetch_all($query, MYSQLI_ASSOC);
$history = $result;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="dashboard-page">

    <header>
        <div class="header-left">
            <button class="menu-toggle" onclick="toggleSidebar()">☰</button>
            <span class="welcome-text">Welcome, <?php echo htmlspecialchars($full_name); ?></span>
        </div>
        <a href="logout.php" class="logout-btn">Logout</a>
    </header>

    <div class="main-container">
        <div class="overlay" onclick="toggleSidebar()"></div>
        
        <aside class="sidebar">
            <div class="sidebar-title">Dashboard</div>
            <nav>
                <a href="#add-supplier" class="nav-link active" onclick="navigate(event, 'add-supplier')">Add Supplier</a>
                <a href="#create-order" class="nav-link" onclick="navigate(event, 'create-order')">Create Order</a>
                <a href="#create-receipt" class="nav-link" onclick="navigate(event, 'create-receipt')">Create Receipt</a>
                <a href="#history" class="nav-link" onclick="navigate(event, 'history')">History</a>
            </nav>
        </aside>

        <main class="content">
            <!-- Feedback Messages -->
            <?php if (isset($_GET['msg'])): ?>
                <div style="background: #d4edda; color: #155724; padding: 10px; margin-bottom: 20px; border-radius: 5px;">
                    <?php echo htmlspecialchars($_GET['msg']); ?>
                </div>
            <?php endif; ?>
            <?php if (isset($_GET['error'])): ?>
                <div style="background: #f8d7da; color: #721c24; padding: 10px; margin-bottom: 20px; border-radius: 5px;">
                    <?php echo htmlspecialchars($_GET['error']); ?>
                </div>
            <?php endif; ?>

            <!-- Add Supplier Section -->
            <div id="add-supplier" class="section active">
                <div class="card">
                    <h2>Add Supplier</h2>
                    <form action="actions.php" method="POST">
                        <div class="form-group">
                            <label>Supplier Name</label>
                            <input type="text" name="supplier_name" placeholder="Enter supplier name" required>
                        </div>
                        <div class="form-group">
                            <label>Contact Number</label>
                            <input type="tel" name="contact_number" placeholder="Enter contact number">
                        </div>
                        <div class="form-group">
                            <label>Address</label>
                            <textarea name="address" rows="2" placeholder="Enter address"></textarea>
                        </div>
                        <button type="submit" name="add_supplier" class="btn">Save Supplier</button>
                    </form>
                </div>

                <div class="card">
                    <h2>Musanze Market Supplier List</h2>
                    <div class="form-group">
                        <input type="text" id="supplier-search" placeholder="Search suppliers..." onkeyup="filterTable('supplier-search', 'supplier-table-body')">
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Contact</th>
                                <th>Address</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="supplier-table-body">
                            <?php foreach ($suppliers as $supplier): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($supplier['supplier_name']); ?></td>
                                <td><?php echo htmlspecialchars($supplier['contact_number']); ?></td>
                                <td><?php echo htmlspecialchars($supplier['address']); ?></td>
                                <td>
                                    <a href="update.php?type=supplier&id=<?php echo $supplier['id']; ?>" class="action-btn btn-edit" style="text-decoration: none; display: inline-block;">Update</a>
                                    <form action="actions.php" method="POST" style="display:inline;">
                                        <input type="hidden" name="id" value="<?php echo $supplier['id']; ?>">
                                        <button type="submit" name="delete_supplier" class="action-btn btn-delete" onclick="return confirm('Are you sure you want to delete this supplier?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Create Order Section -->
            <div id="create-order" class="section">
                <div class="card">
                    <h2>Create Order</h2>
                    <form action="actions.php" method="POST">
                        <div class="form-group">
                            <label>Supplier Name</label>
                            <select name="supplier_name" required>
                                <option value="">Select Supplier</option>
                                <?php foreach ($suppliers as $supplier): ?>
                                    <option value="<?php echo htmlspecialchars($supplier['supplier_name']); ?>">
                                        <?php echo htmlspecialchars($supplier['supplier_name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Item Name</label>
                            <input type="text" name="item_name" placeholder="Item name" required>
                        </div>
                        <div class="form-group">
                            <label>Amount (per item)</label>
                            <input type="number" name="amount_per_item" placeholder="0.00" step="0.01" required>
                        </div>
                        <div class="form-group">
                            <label>Quantity</label>
                            <input type="number" name="quantity" placeholder="0" required>
                        </div>
                        <div style="display: flex; gap: 10px;">
                            <button type="submit" name="create_order" class="btn">Place Order</button>
                            <button type="button" class="btn btn-secondary" onclick="navigate(event, 'create-receipt')">Generate Receipt</button>
                        </div>
                    </form>
                </div>

                <div class="card">
                    <h2>Musanze Market Order List</h2>
                    <div class="form-group">
                        <input type="text" id="order-search" placeholder="Search orders..." onkeyup="filterTable('order-search', 'order-table-body')">
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Supplier</th>
                                <th>Item</th>
                                <th>Quantity</th>
                                <th>Total</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="order-table-body">
                            <?php foreach ($orders as $order): ?>
                            <tr>
                                <td>#<?php echo $order['id']; ?></td>
                                <td><?php echo htmlspecialchars($order['supplier_name']); ?></td>
                                <td><?php echo htmlspecialchars($order['item_name']); ?></td>
                                <td><?php echo $order['quantity']; ?></td>
                                <td><?php echo number_format($order['total_amount'], 2); ?></td>
                                <td>
                                    <a href="update.php?type=order&id=<?php echo $order['id']; ?>" class="action-btn btn-edit" style="text-decoration: none; display: inline-block;">Update</a>
                                    <form action="actions.php" method="POST" style="display:inline;">
                                        <input type="hidden" name="id" value="<?php echo $order['id']; ?>">
                                        <button type="submit" name="delete_order" class="action-btn btn-delete" onclick="return confirm('Are you sure you want to delete this order?')">Delete</button>
                                    </form>
                                    <button class="action-btn btn-receipt" 
                                        data-id="<?php echo $order['id']; ?>"
                                        data-supplier="<?php echo htmlspecialchars($order['supplier_name']); ?>"
                                        data-item="<?php echo htmlspecialchars($order['item_name']); ?>"
                                        data-qty="<?php echo $order['quantity']; ?>"
                                        data-price="<?php echo $order['amount_per_item']; ?>"
                                        data-total="<?php echo $order['total_amount']; ?>"
                                        data-date="<?php echo date('Y-m-d', strtotime($order['created_at'])); ?>"
                                        onclick="loadReceipt(event, this)">Receipt</button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Create Receipt Section -->
            <div id="create-receipt" class="section">
                <div class="receipt-layout">
                    <!-- Filter Side -->
                    <div class="card receipt-filter">
                        <h2>Find Receipt</h2>
                        <div class="form-group">
                            <label>Quick Filter</label>
                            <div style="display: flex; gap: 5px; margin-bottom: 10px;">
                                <button class="btn" style="padding: 8px; font-size: 0.9rem; flex: 1;">Today</button>
                                <button class="btn" style="padding: 8px; font-size: 0.9rem; flex: 1;">Yesterday</button>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Select Date</label>
                            <input type="date">
                        </div>
                        <button class="btn" style="width: 100%;">Search Receipts</button>
                    </div>
                    
                    <!-- Receipt Display (Static for now, dynamic requires AJAX or page reload logic) -->
                    <div class="card receipt-display">
                        <h2>Receipt View</h2>
                        <div class="receipt-preview" id="printable-receipt">
                            <h3 style="text-align: center; border-bottom: 1px dashed #000; padding-bottom: 10px;">MUSANZE MARKET ORDER SLIP</h3>
                            <p><strong>Date:</strong> <span id="receipt-date"></span></p>
                            <p><strong>Supplier:</strong> <span id="receipt-supplier"></span></p>
                            <p><strong>Order ID:</strong> <span id="receipt-id"></span></p>
                            <hr style="border-top: 1px dashed #ccc;">
                            <div style="display: flex; justify-content: space-between;">
                                <span id="receipt-item"></span>
                                <span id="receipt-price"></span>
                            </div>
                            <hr style="border-top: 1px dashed #ccc;">
                            <div style="display: flex; justify-content: space-between; font-weight: bold;">
                                <span>TOTAL</span>
                                <span id="receipt-total"></span>
                            </div>
                        </div>
                        
                        <div class="receipt-actions">
                            <button class="btn" onclick="window.print()">Print</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- History Section -->
            <div id="history" class="section">
                <div class="card">
                    <h2>Musanze Market Activity History</h2>
                    <table>
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Action</th>
                                <th>Details</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($history as $log): ?>
                            <tr>
                                <td><?php echo date('Y-m-d', strtotime($log['created_at'])); ?></td>
                                <td><?php echo htmlspecialchars($log['action_type']); ?></td>
                                <td><?php echo htmlspecialchars($log['details']); ?></td>
                                <td style="color: green;"><?php echo htmlspecialchars($log['status']); ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    <script src="js/dashboard.js"></script>
</body>
</html>