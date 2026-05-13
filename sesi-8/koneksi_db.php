<?php
    $host = "localhost";
    $username = "root";
    $password = "new_password";
    $database = "bootcamp8";

    $koneksi = mysqli_connect($host, $username, $password, $database);

    if (!$koneksi) {
        die("Koneksi gagal: " . mysqli_connect_error());
    }
    //echo "Koneksi berhasil!";
?>

<!-- mysqli version -->
<?php
// $servername = "localhost";
// $username = "root";
// $password = "";
// $dbname = "nama_database";

// // Membuat koneksi
// $conn = new mysqli($servername, $username, $password, $dbname);

// // Cek koneksi
// if ($conn->connect_error) {
//     die("Koneksi gagal: " . $conn->connect_error);
// }
// echo "Koneksi Berhasil (OOP)";
?>


<!-- PDO version -->
<?php
// $servername = "localhost";
// $username = "root";
// $password = "";
// $dbname = "nama_database";

// try {
//     $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
//     // Set mode error PDO ke exception
//     $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//     echo "Koneksi Berhasil (PDO)";
// } catch(PDOException $e) {
//     echo "Koneksi gagal: " . $e->getMessage();
// }

// // input data ke database menggunakan PDO
// try {
//     $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
//     // Set mode error PDO ke exception
//     $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//     $sql = "INSERT INTO users (name, email) VALUES ('John Doe', 'john@example.com')";
//     $conn->exec($sql);
//     echo "Data berhasil ditambahkan";
// } catch(PDOException $e) {
//     echo "Error: " . $e->getMessage();
// }
?>
