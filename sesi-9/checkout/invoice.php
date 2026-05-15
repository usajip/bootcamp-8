<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <?php 
        include '../template/navbar.php'; 
     ?>
    <?php 
        include '../koneksi_db.php';
        // Ambil data dari data order berdasarkan ID yang dikirim melalui URL
        if (!isset($_GET['order_id']) || !is_numeric($_GET['order_id'])) {
            die('ID order tidak valid.');
        }
        $orderId = (int) $_GET['order_id'];
        $orderQuery = mysqli_prepare($koneksi, 'SELECT id, user_name, phone, address, total_price, status FROM orders WHERE id = ?');
        mysqli_stmt_bind_param($orderQuery, 'i', $orderId);
        mysqli_stmt_execute($orderQuery);
        $orderResult = mysqli_stmt_get_result($orderQuery);
        if (mysqli_num_rows($orderResult) === 0) {
            die('Order tidak ditemukan.');
        }
        $order = mysqli_fetch_assoc($orderResult);
        // Ambil data order items berdasarkan order_id
        $itemsQuery = mysqli_prepare($koneksi, 'SELECT product_name, total_price, quantity FROM order_items WHERE order_id = ?');
        mysqli_stmt_bind_param($itemsQuery, 'i', $orderId);
        mysqli_stmt_execute($itemsQuery);
        $itemsResult = mysqli_stmt_get_result($itemsQuery);
        $orderItems = [];
        while ($row = mysqli_fetch_assoc($itemsResult)) {
            $orderItems[] = $row;
        }
        mysqli_stmt_close($orderQuery);
        mysqli_stmt_close($itemsQuery);
        mysqli_close($koneksi);
    ?>
    <div class="container mt-5">
        <h1 class="mb-4">Invoice Order #<?php echo $order['id']; ?></h1>
        <!-- status order -->
         <div class="mb-4">
            <h4>Status Order</h4>
            <?php if ($order['status'] === 'pending'): ?>
                <span class="badge text-bg-warning">Pending</span>
            <?php elseif ($order['status'] === 'paid'): ?>
                <span class="badge text-bg-success">Paid</span>
            <?php elseif ($order['status'] === 'cancelled'): ?>
                <span class="badge text-bg-danger">Cancelled</span>
            <?php else: ?>
                <span class="badge text-bg-secondary"><?php echo htmlspecialchars($order['status']); ?></span>
            <?php endif; ?>
        </div>
        <div class="mb-4">
            <h4>Customer Information</h4>
            <p><strong>Name:</strong> <?php echo htmlspecialchars($order['user_name']); ?></p>
            <p><strong>Phone:</strong> <?php echo htmlspecialchars($order['phone']); ?></p>
            <p><strong>Address:</strong> <?php echo htmlspecialchars($order['address']); ?></p>
        </div>
        <div class="mb-4">
            <h4>Order Details</h4>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orderItems as $item): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($item['product_name']); ?></td>
                            <td>Rp <?php echo number_format((int) $item['total_price'] / (int) $item['quantity'], 0, ',', '.'); ?></td>
                            <td><?php echo (int) $item['quantity']; ?></td>
                            <td>Rp <?php echo number_format((int) $item['total_price'], 0, ',', '.'); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <h4 class="text-end">Total Amount: Rp <?php echo number_format((int) $order['total_price'], 0, ',', '.'); ?></h4>
            <!-- Info pembayaran -->
            <div class="alert alert-info mt-4">
                <h5>Informasi Pembayaran</h5>
                <p>Silakan lakukan pembayaran ke rekening berikut:</p>
                <ul>
                    <li><strong>Bank:</strong> Bank ABC</li>
                    <li><strong>Nomor Rekening:</strong> 1234567890</li>
                    <li><strong>Atas Nama:</strong> Toko Online XYZ</li>
                </ul>
                <p>Setelah melakukan pembayaran, silakan konfirmasi ke nomor WA: 081234567890 dengan menyertakan bukti pembayaran.</p>
                <!-- Tombol konfirmasi pembayaran ke whatsapp -->
                <a href="https://wa.me/081234567890?text=Konfirmasi%20Pembayaran%20Order%20<?php echo $order['id']; ?>" class="btn btn-success" target="_blank">Konfirmasi Pembayaran</a>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>