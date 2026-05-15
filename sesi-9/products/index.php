<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products Data</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Products Data</h1>
        <p>Berikut adalah data produk yang tersedia di toko online kami.</p>
        <?php if (isset($_GET['status'])): ?>
            <?php if ($_GET['status'] === 'updated'): ?>
                <div class="alert alert-success">Produk berhasil diperbarui.</div>
            <?php elseif ($_GET['status'] === 'deleted'): ?>
                <div class="alert alert-success">Produk berhasil dihapus.</div>
            <?php elseif ($_GET['status'] === 'error'): ?>
                <div class="alert alert-danger">Terjadi kesalahan saat memproses data.</div>
            <?php endif; ?>
        <?php endif; ?>
        <a href="input/form_input.php" class="btn btn-primary mb-3">Tambah Produk</a>
        <table id="productsTable" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Category</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $koneksi = null;
                    include '../koneksi_db.php';
                    if (!($koneksi instanceof mysqli)) {
                        die('Koneksi database tidak valid.');
                    }
                    $query = mysqli_query($koneksi, "SELECT * FROM products");
                    
                    while ($data = mysqli_fetch_array($query)) {
                        echo '<tr>';
                        echo '<td>' . $data['id'] . '</td>';
                        echo '<td>' . $data['name'] . '</td>';
                        echo '<td>' . $data['price'] . '</td>';
                        echo '<td>' . $data['category'] . '</td>';
                        echo '<td>';
                        echo '<a href="../product_description.php?id=' . $data['id'] . '" class="btn btn-info btn-sm me-1">Detail</a>';
                        echo '<a href="edit.php?id=' . $data['id'] . '" class="btn btn-warning btn-sm me-1">Edit</a>';
                        echo '<a href="delete.php?id=' . $data['id'] . '" class="btn btn-danger btn-sm" onclick="return confirm(\'Yakin ingin menghapus produk ini?\')">Delete</a>';
                        echo '</td>';
                        echo '</tr>';
                    }
                ?>
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#productsTable').DataTable({
                pageLength: 5,
                lengthMenu: [5, 10, 25, 50, 100]
            });
        });
    </script>
    
</body>
</html>