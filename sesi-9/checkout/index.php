<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <?php 
        include '../cart/cart.php';
     ?>
    <div class="container mt-5 mb-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1 class="mb-0">Checkout</h1>
        </div>

        <?php if ($cartCount === 0): ?>
            <div class="alert alert-info">Keranjang belanja Anda kosong. Silakan tambahkan produk terlebih dahulu.</div>
            <a href="../index.php" class="btn btn-primary">Lihat Produk</a>
        <?php else: ?>
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Ringkasan Pesanan (<?php echo $cartCount; ?> item)</h5>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Gambar</th>
                                <th>Nama Produk</th>
                                <th class="text-end">Harga</th>
                                <th class="text-center">Jumlah</th>
                                <th class="text-end">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($_SESSION['cart'] as $item): ?>
                                <tr>
                                    <td>
                                        <?php if (!empty($item['image'])): ?>
                                            <img src="../images/<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>" style="max-width: 100px; height: auto;">
                                        <?php else: ?>
                                            <div class="d-flex align-items-center justify-content-center h-100 bg-light text-muted p-3" style="width: 100px; height: 100px;">Tidak ada gambar</div>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo htmlspecialchars($item['name']); ?></td>
                                    <td class="text-end">Rp <?php echo number_format((int) $item['price'], 0, ',', '.'); ?></td>
                                    <td class="text-center"><?php echo isset($item['quantity']) ? (int) $item['quantity'] : 0; ?></td>
                                    <td class="text-end">Rp <?php echo number_format((isset($item['quantity']) ? (int) $item['quantity'] : 0) * (int) $item['price'], 0, ',', '.'); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <!-- Form user Orders data -->
                        <div class="col-md-6">
                            <h5>Data Pemesan</h5>
                            <form action="proses_checkout.php" method="POST">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nama Lengkap</label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                </div>
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Nomor WA</label>
                                    <input type="number" class="form-control" id="phone" name="phone" required>
                                </div>
                                <div class="mb-3">
                                    <label for="address" class="form-label">Alamat Pengiriman</label>
                                    <textarea class="form-control" id="address" name="address" rows="3" required></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Checkout</button>
                            </form>
                        </div>
                        <div class="col-md-6 text-end">
                            <h5>Total Belanja</h5>
                            <h3 class="text-success">Rp <?php echo number_format($cartTotal, 0, ',', '.'); ?></h3>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>