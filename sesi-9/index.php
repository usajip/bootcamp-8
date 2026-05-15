<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko Online</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <?php include 'template/navbar.php'; ?>
    <div class="container mt-5">
        <h1>Selamat Datang di Toko Online</h1>
        <p>Ini adalah halaman utama toko online kami. Silakan jelajahi produk kami dan temukan penawaran terbaik!</p>

        <!-- Filter Section -->
        <div class="row mb-4">
            <div class="col-md-4">
                <form method="GET" action="">
                    <label for="categoryFilter" class="form-label">Filter berdasarkan Category:</label>
                    <select class="form-select" id="categoryFilter" name="category">
                        <option value="">Semua Category</option>
                        <?php
                            include 'koneksi_db.php';
                            
                            // Ambil semua kategori unik dari database
                            $categoryQuery = mysqli_query($koneksi, "SELECT DISTINCT category FROM products ORDER BY category ASC");
                            
                            while ($categoryData = mysqli_fetch_array($categoryQuery)) {
                                $selected = (isset($_GET['category']) && $_GET['category'] == $categoryData['category']) ? 'selected' : '';
                                echo '<option value="' . $categoryData['category'] . '" ' . $selected . '>' . $categoryData['category'] . '</option>';
                            }
                        ?>
                    </select>
                    <button type="submit" class="btn btn-primary mt-2">Filter</button>
                    <a href="?" class="btn btn-secondary mt-2">Reset</a>
                </form>
                <!-- search -->
                 <div class="mt-4">
                    <form method="GET" action="">
                        <label for="searchQuery" class="form-label">Cari produk:</label>
                        <input type="text" class="form-control" id="searchQuery" name="search" placeholder="Masukkan nama produk...">
                        <button type="submit" class="btn btn-primary mt-2">Cari</button>
                    </form>
                 </div>
            </div>
        </div>

        <div class="row mt-5">
            <?php
                // Buat query berdasarkan filter category
                $query = "SELECT * FROM products";
                
                if (isset($_GET['category']) && !empty($_GET['category'])) {
                    $category = mysqli_real_escape_string($koneksi, $_GET['category']);
                    $query .= " WHERE category = '$category'";
                }

                if(isset($_GET['search']) && !empty($_GET['search'])) {
                    $search = mysqli_real_escape_string($koneksi, $_GET['search']);
                    $query .= (strpos($query, 'WHERE') !== false) ? " AND" : " WHERE";
                    $query .= " name LIKE '%$search%'";
                }
                
                $query = mysqli_query($koneksi, $query);
                
                while ($data = mysqli_fetch_array($query)) {
            ?>
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <img src="images/<?php echo $data['image']; ?>" class="card-img-top mb-3" alt="<?php echo $data['name']; ?>">
                                <sub><?php echo $data['category']; ?></sub>
                                <h5 class="card-title"><?php echo $data['name']; ?></h5>
                                <p class="card-text"><?php echo $data['description']; ?></p>
                                <p class="card-text"><strong>Harga: Rp <?php echo number_format($data['price'], 0, ',', '.'); ?></strong></p>
                                <a href="product_description.php?id=<?php echo $data['id']; ?>" class="btn btn-primary">Lihat Detail</a>
                            </div>
                        </div>
                    </div>
            <?php
                }
            ?>
        </div>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</html>