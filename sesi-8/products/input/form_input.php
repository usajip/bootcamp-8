<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Input</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Form Input Produk</h1>
        <form action="proses_input.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="name" class="form-label">Nama Produk</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Harga</label>
                <input type="number" class="form-control" id="price" name="price" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Deskripsi</label>
                <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
            </div>
            <!-- category -->
            <div class="mb-3">
                <label for="category" class="form-label">Kategori</label>
                <select class="form-select" id="category" name="category" required>
                    <option value="">Pilih Kategori</option>
                    <option value="Elektronik">Elektronik</option>
                    <option value="Pakaian">Pakaian</option>
                    <option value="Makanan">Makanan</option>
                </select>
            </div>
            <!-- image -->
            <div class="mb-3">
                <label for="image" class="form-label">Gambar</label>
                <input type="file" class="form-control" id="image" name="image" required>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // add event listener to file input
        document.getElementById('image').addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/jpg', 'image/webp'];
                if (!allowedTypes.includes(file.type)) {
                    alert('Format gambar tidak valid! Hanya JPEG, PNG, GIF, JPG, dan WEBP yang diperbolehkan.');
                    this.value = ''; // reset file input
                } else if (file.size > 1 * 1024 * 1024) { // 1MB
                    alert('Ukuran gambar terlalu besar! Maksimal 1MB.');
                    this.value = ''; // reset file input
                }
            }
        });

        // add event listener to form submit
        document.querySelector('form').addEventListener('submit', function(event) {
            const name = document.getElementById('name').value.trim();
            const price = document.getElementById('price').value.trim();
            const description = document.getElementById('description').value.trim();
            const category = document.getElementById('category').value.trim();
            const image = document.getElementById('image').value.trim();
            if (!name || !price || !description || !category || !image) {
                alert('Semua field harus diisi!');
                event.preventDefault(); // prevent form submission
            }
        });
    </script>
</body>
</html>