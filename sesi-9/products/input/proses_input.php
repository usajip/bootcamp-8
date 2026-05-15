<?php
    include '../../koneksi_db.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = $_POST['name'];
        $price = $_POST['price'];
        $description = $_POST['description'];
        $category = $_POST['category'];

        // validasi input
        if (empty($name) || empty($price) || empty($description) || empty($category)) {
            echo "Semua field harus diisi!";
            exit();
        }

        // image validation
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'image/jpg', 'image/webp'];
            if (!in_array($_FILES['image']['type'], $allowed_types)) {
                echo "Format gambar tidak valid! Hanya JPEG, PNG, GIF, JPG, dan WEBP yang diperbolehkan.";
                exit();
            }

            // validasi ukuran file (maks 1MB)
            if ($_FILES['image']['size'] > 1 * 1024 * 1024) {
                echo "Ukuran gambar terlalu besar! Maksimal 1MB.";
                exit();
            }

            // simpan gambar ke folder images
            $target_dir = "../../images/";
            // change file name to avoid conflicts
            $file_extension = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
            $new_file_name = uniqid() . "." . $file_extension; // generate unique file name example: 5f2c9e8b9a1c3.jpg

            $target_file = $target_dir . $new_file_name;
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                echo "Gambar " . htmlspecialchars($new_file_name) . " berhasil diunggah.";
            } else {
                echo "Maaf, terjadi kesalahan saat mengunggah gambar.";
                exit();
            }
        } else {
            echo "Gambar harus diunggah!";
            exit();
        }

        $sql = "INSERT INTO products (name, price, description, category, image) VALUES ('$name', '$price', '$description', '$category', '$new_file_name')";

        if (mysqli_query($koneksi, $sql)) {
            echo "Produk berhasil ditambahkan!";
            header("Location: form_input.php");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($koneksi);
        }
    }

    mysqli_close($koneksi);
?>