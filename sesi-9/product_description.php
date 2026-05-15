<?php
session_start();
$koneksi = null;
include 'koneksi_db.php';
if (!($koneksi instanceof mysqli)) {
    die('Koneksi database tidak valid.');
}

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$product = null;
$rekomendasi = [];
$error = '';

if ($id > 0 || is_int($id)) {
    $stmt = mysqli_prepare($koneksi, 'SELECT id, name, price, description, category, image FROM products WHERE id = ?');
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $product = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);

    if (!$product) {
        $error = 'Produk tidak ditemukan.';
    }
} else {
    $error = 'ID produk tidak valid.';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart']) && $product) {
    $quantity = isset($_POST['quantity']) ? (int) $_POST['quantity'] : 1;
    if ($quantity < 1) {
        $quantity = 1;
    }

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    $productId = (string) $product['id'];
    if (isset($_SESSION['cart'][$productId])) {
        $_SESSION['cart'][$productId]['quantity'] += $quantity;
    } else {
        $_SESSION['cart'][$productId] = [
            'id' => (int) $product['id'],
            'name' => $product['name'],
            'price' => (int) $product['price'],
            'image' => $product['image'],
            'quantity' => $quantity
        ];
    }

    header('Location: product_description.php?id=' . $product['id'] . '&added=1');
    exit();
}

if ($product) {
    $rekomStmt = mysqli_prepare(
        $koneksi,
        'SELECT id, name, price, image FROM products WHERE category = ? AND id != ? ORDER BY id DESC LIMIT 4'
    );
    mysqli_stmt_bind_param($rekomStmt, 'si', $product['category'], $id);
    mysqli_stmt_execute($rekomStmt);
    $rekomResult = mysqli_stmt_get_result($rekomStmt);
    while ($row = mysqli_fetch_assoc($rekomResult)) {
        $rekomendasi[] = $row;
    }
    mysqli_stmt_close($rekomStmt);
}

$cartCount = 0;
$cartTotal = 0;
if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        $itemQty = isset($item['quantity']) ? (int) $item['quantity'] : 0;
        $itemPrice = isset($item['price']) ? (int) $item['price'] : 0;
        $cartCount += $itemQty;
        $cartTotal += $itemQty * $itemPrice;
    }
}

mysqli_close($koneksi);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Description</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <?php include 'template/navbar.php'; ?>
    <div class="container mt-5 mb-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1 class="mb-0">Product Description</h1>
            <a href="cart/index.php" class="btn btn-info">
                <i class="badge text-bg-primary">🛒 Keranjang (<?php echo $cartCount; ?>)</i>
            </a>
        </div>

        <?php if (isset($_GET['added']) && $_GET['added'] === '1'): ?>
            <div class="alert alert-success">Produk berhasil ditambahkan ke keranjang.</div>
        <?php endif; ?>

        <?php if ($error !== ''): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
        <?php else: ?>
            <div class="card mb-4">
                <div class="row g-0">
                    <div class="col-md-4">
                        <?php if (!empty($product['image'])): ?>
                            <img src="images/<?php echo htmlspecialchars($product['image']); ?>" class="img-fluid rounded-start" alt="<?php echo htmlspecialchars($product['name']); ?>">
                        <?php else: ?>
                            <div class="d-flex align-items-center justify-content-center h-100 bg-light text-muted p-3">Tidak ada gambar</div>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($product['name']); ?></h5>
                            <p class="card-text"><?php echo nl2br(htmlspecialchars($product['description'])); ?></p>
                            <p class="card-text mb-1"><strong>Harga:</strong> Rp <?php echo number_format((int) $product['price'], 0, ',', '.'); ?></p>
                            <p class="card-text"><strong>Kategori:</strong> <?php echo htmlspecialchars($product['category']); ?></p>

                            <form method="POST" class="row g-2 align-items-end">
                                <div class="col-auto">
                                    <label for="quantity" class="form-label mb-1">Qty</label>
                                    <input type="number" class="form-control" id="quantity" name="quantity" min="1" value="1" required>
                                </div>
                                <div class="col-auto">
                                    <button type="submit" name="add_to_cart" value="1" class="btn btn-success">Tambah ke Keranjang</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">Ringkasan Keranjang</div>
                <div class="card-body">
                    <?php if ($cartCount === 0): ?>
                        <p class="text-muted mb-0">Keranjang masih kosong.</p>
                    <?php else: ?>
                        <ul class="list-group mb-3">
                            <?php foreach ($_SESSION['cart'] as $item): ?>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span><?php echo htmlspecialchars($item['name']); ?> (x<?php echo (int) $item['quantity']; ?>)</span>
                                    <span>Rp <?php echo number_format(((int) $item['price']) * ((int) $item['quantity']), 0, ',', '.'); ?></span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                        <p class="mb-0"><strong>Total:</strong> Rp <?php echo number_format($cartTotal, 0, ',', '.'); ?></p>
                    <?php endif; ?>
                </div>
            </div>

            <h3 class="mb-3">Rekomendasi Produk (Kategori <?php echo htmlspecialchars($product['category']); ?>)</h3>
            <div class="row g-3">
                <?php if (count($rekomendasi) === 0): ?>
                    <div class="col-12">
                        <div class="alert alert-info mb-0">Belum ada rekomendasi lain di kategori ini.</div>
                    </div>
                <?php else: ?>
                    <?php foreach ($rekomendasi as $item): ?>
                        <div class="col-md-3 col-sm-6">
                            <div class="card h-100">
                                <?php if (!empty($item['image'])): ?>
                                    <img src="images/<?php echo htmlspecialchars($item['image']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($item['name']); ?>">
                                <?php else: ?>
                                    <div class="d-flex align-items-center justify-content-center bg-light text-muted" style="height: 160px;">No Image</div>
                                <?php endif; ?>
                                <div class="card-body d-flex flex-column">
                                    <h6 class="card-title"><?php echo htmlspecialchars($item['name']); ?></h6>
                                    <p class="card-text mb-3">Rp <?php echo number_format((int) $item['price'], 0, ',', '.'); ?></p>
                                    <a href="product_description.php?id=<?php echo (int) $item['id']; ?>" class="btn btn-outline-primary btn-sm mt-auto">Lihat Detail</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>