<?php
include '../koneksi_db.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
if ($id <= 0 || !is_int($id)) {
    header('Location: index.php?status=error');
    exit();
}

$stmt = mysqli_prepare($koneksi, 'SELECT image FROM products WHERE id = ?');
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$product = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

if (!$product) {
    header('Location: index.php?status=error');
    exit();
}

$delete = mysqli_prepare($koneksi, 'DELETE FROM products WHERE id = ?');
mysqli_stmt_bind_param($delete, 'i', $id);
$success = mysqli_stmt_execute($delete);
mysqli_stmt_close($delete);

if ($success) {
    if (!empty($product['image'])) {
        $imagePath = '../images/' . $product['image'];
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
    }
    mysqli_close($koneksi);
    header('Location: index.php?status=deleted');
    exit();
}

mysqli_close($koneksi);
header('Location: index.php?status=error');
exit();
