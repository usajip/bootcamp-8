<?php
include '../koneksi_db.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($id <= 0 || !is_int($id)) {
    header('Location: index.php?status=error');
    exit();
}

$stmt = mysqli_prepare($koneksi, 'SELECT * FROM products WHERE id = ?');
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$product = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

$categoryQuery = mysqli_query($koneksi, "SELECT DISTINCT category FROM products ORDER BY category ASC");

if (!$product) {
    header('Location: index.php?status=error');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $price = trim($_POST['price'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $category = trim($_POST['category'] ?? '');
    $imageName = $product['image'];

    if (empty($name) || $price === '' || $description === '' || $category === '') {
        header('Location: edit.php?id=' . $id . '&status=error');
        exit();
    }

    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/jpg', 'image/webp'];
        if (!in_array($_FILES['image']['type'], $allowedTypes, true)) {
            header('Location: edit.php?id=' . $id . '&status=error');
            exit();
        }

        if ($_FILES['image']['size'] > 1 * 1024 * 1024) {
            header('Location: edit.php?id=' . $id . '&status=error');
            exit();
        }

        $targetDir = '../images/';
        $fileExtension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $newFileName = uniqid('', true) . '.' . $fileExtension;
        $targetFile = $targetDir . $newFileName;

        if (!move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
            header('Location: edit.php?id=' . $id . '&status=error');
            exit();
        }

        if (!empty($product['image'])) {
            $oldImagePath = $targetDir . $product['image'];
            if (file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }
        }

        $imageName = $newFileName;
    }

    $update = mysqli_prepare($koneksi, 'UPDATE products SET name = ?, price = ?, description = ?, category = ?, image = ? WHERE id = ?');
    mysqli_stmt_bind_param($update, 'sisssi', $name, $price, $description, $category, $imageName, $id);

    if (mysqli_stmt_execute($update)) {
        mysqli_stmt_close($update);
        mysqli_close($koneksi);
        header('Location: index.php?status=updated');
        exit();
    }

    mysqli_stmt_close($update);
    mysqli_close($koneksi);
    header('Location: index.php?status=error');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Edit Produk</h1>
        <?php if (isset($_GET['status']) && $_GET['status'] === 'error'): ?>
            <div class="alert alert-danger">Data tidak valid atau gagal memperbarui produk.</div>
        <?php endif; ?>
        <form action="edit.php?id=<?php echo $id; ?>" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="name" class="form-label">Nama Produk</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Harga</label>
                <input type="number" class="form-control" id="price" name="price" value="<?php echo htmlspecialchars($product['price']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Deskripsi</label>
                <textarea class="form-control" id="description" name="description" rows="3" required><?php echo htmlspecialchars($product['description']); ?></textarea>
            </div>
            <div class="mb-3">
                <label for="category" class="form-label">Kategori</label>
                <select class="form-select" id="category" name="category" required>
                    <option value="">Pilih Kategori</option>
                    <?php foreach ($categoryQuery as $cat): ?>
                        <option value="<?php echo htmlspecialchars($cat['category']); ?>" <?php echo $product['category'] === $cat['category'] ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($cat['category']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Gambar Saat Ini</label><br>
                <?php if (!empty($product['image'])): ?>
                    <img src="../images/<?php echo htmlspecialchars($product['image']); ?>" alt="Current Image" style="max-width: 200px; height: auto;" class="mb-2">
                <?php else: ?>
                    <p class="text-muted mb-2">Tidak ada gambar.</p>
                <?php endif; ?>
                <label for="image" class="form-label">Ubah Gambar (Opsional)</label>
                <input type="file" class="form-control" id="image" name="image">
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="index.php" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</body>
</html>
