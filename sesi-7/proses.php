<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Produk Baru</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $errors = [];

                    // 1. Validasi Nama
                    $nama = trim($_POST['nama']);
                    if (empty($nama) || strlen($nama) < 3) {
                        $errors[] = "Nama produk harus diisi minimal 3 karakter.";
                    }

                    // 2. Validasi Kategori
                    $kategori = $_POST['kategori'] ?? '';
                    if (empty($kategori)) {
                        $errors[] = "Kategori wajib dipilih.";
                    }

                    // 3. Validasi Deskripsi
                    $deskripsi = trim($_POST['deskripsi']);
                    if (empty($deskripsi)) {
                        $errors[] = "Deskripsi tidak boleh kosong.";
                    }

                    // 4. Validasi Gambar
                    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === 0) {
                        $file_size = $_FILES['gambar']['size'];
                        $file_tmp = $_FILES['gambar']['tmp_name'];
                        $file_type = $_FILES['gambar']['type'];
                        $allowed_types = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];

                        if ($file_size > 2000000) { // Limit 2MB
                            $errors[] = "Ukuran gambar maksimal 2MB.";
                        }
                        if (!in_array($file_type, $allowed_types)) {
                            $errors[] = "Format file harus JPG, PNG, atau WEBP.";
                        }
                    } else {
                        $errors[] = "Wajib mengunggah gambar.";
                    }

                    // Output Hasil
                    if (empty($errors)) {
                        // Proses simpan data atau upload file di sini
                        echo "<div class='alert alert-success'>Produk '$nama' berhasil disimpan!</div>";
                    } else {
                        echo "<div class='alert alert-danger'><ul>";
                        foreach ($errors as $error) {
                            echo "<li>$error</li>";
                        }
                        echo "</ul></div>";
                    }
                }else{
                    echo "<div class='alert alert-warning'>Form belum disubmit.</div>";
                }
            ?>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>