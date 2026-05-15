<?php include 'cart.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <?php if (file_exists('../template/navbar.php')): ?>
        <?php include '../template/navbar.php'; ?>
    <?php endif; ?>

    <div class="container mt-5 mb-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1 class="mb-0">Keranjang Belanja</h1>
            <a href="../index.php" class="btn btn-secondary">Kembali ke Beranda</a>
        </div>

        <?php if (isset($_GET['status'])): ?>
            <?php if ($_GET['status'] === 'updated'): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    Quantity produk berhasil diperbarui.
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php elseif ($_GET['status'] === 'deleted'): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    Produk berhasil dihapus dari keranjang.
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php elseif ($_GET['status'] === 'cleared'): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    Keranjang berhasil dikosongkan.
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>
        <?php endif; ?>

        <?php if ($cartCount === 0): ?>
            <div class="alert alert-info">Keranjang belanja Anda kosong. Silakan tambahkan produk terlebih dahulu.</div>
            <a href="../index.php" class="btn btn-primary">Lihat Produk</a>
        <?php else: ?>
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Daftar Produk Keranjang (<?php echo $cartCount; ?> item)</h5>
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
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($_SESSION['cart'] as $productId => $item): ?>
                                <tr>
                                    <td style="width: 80px;">
                                        <?php if (!empty($item['image'])): ?>
                                            <img src="../images/<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>" class="img-fluid rounded" style="max-height: 80px;">
                                        <?php else: ?>
                                            <div class="bg-light text-muted d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">No Image</div>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <strong><?php echo htmlspecialchars($item['name']); ?></strong>
                                    </td>
                                    <td class="text-end">
                                        Rp <?php echo number_format((int) $item['price'], 0, ',', '.'); ?>
                                    </td>
                                    <td class="text-center">
                                        <form method="POST" action="index.php" class="d-inline-block" style="width: 120px;">
                                            <div class="input-group input-group-sm">
                                                <input type="hidden" name="action" value="update_quantity">
                                                <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($productId); ?>">
                                                <input type="number" class="form-control text-center" name="quantity" value="<?php echo (int) $item['quantity']; ?>" min="1" required>
                                                <button type="submit" class="btn btn-outline-secondary btn-sm">OK</button>
                                            </div>
                                        </form>
                                    </td>
                                    <td class="text-end">
                                        Rp <?php echo number_format(((int) $item['price']) * ((int) $item['quantity']), 0, ',', '.'); ?>
                                    </td>
                                    <td class="text-center">
                                        <form method="POST" action="index.php" class="d-inline-block">
                                            <input type="hidden" name="action" value="delete_item">
                                            <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($productId); ?>">
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus produk ini dari keranjang?');">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-6">
                    <a href="../products/index.php" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Lanjutkan Belanja
                    </a>
                </div>
                <div class="col-md-6 text-end">
                    <form method="POST" action="index.php" class="d-inline-block">
                        <input type="hidden" name="action" value="clear_cart">
                        <button type="submit" class="btn btn-outline-danger" onclick="return confirm('Yakin ingin mengosongkan seluruh keranjang?');">Kosongkan Keranjang</button>
                    </form>
                </div>
            </div>

            <div class="card bg-light">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5>Ringkasan Belanja</h5>
                            <p class="mb-1">Total Item: <strong><?php echo $cartCount; ?></strong></p>
                        </div>
                        <div class="col-md-6 text-end">
                            <h5>Total Belanja</h5>
                            <h3 class="text-success">Rp <?php echo number_format($cartTotal, 0, ',', '.'); ?></h3>
                            <a href="../checkout/index.php" class="btn btn-success btn-lg mt-2">Lanjut ke Checkout</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>