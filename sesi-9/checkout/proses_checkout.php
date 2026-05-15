<?php
session_start();
include '../koneksi_db.php';
if (!($koneksi instanceof mysqli)) {
    die('Koneksi database tidak valid.');
}
if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cart = $_SESSION['cart'] ?? [];
    if (empty($cart)) {
        header('Location: index.php?status=empty');
        exit();
    }

    //validasi data checkout (name, phone, address)
    $name = $_POST['name'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $address = $_POST['address'] ?? '';

    if (empty($name) || empty($phone) || empty($address)) {
        header('Location: index.php?status=invalid');
        exit();
    }

    //input orders data (user_name, phone, address, total_price)
    $input = mysqli_prepare($koneksi, "INSERT INTO orders (user_name, phone, address, total_price) VALUES (?, ?, ?, ?)");
    $totalPrice = 0;
    mysqli_stmt_bind_param($input, 'sssi', $name, $phone, $address, $totalPrice);
    mysqli_stmt_execute($input);
    $orderId = mysqli_stmt_insert_id($input);
    mysqli_stmt_close($input);

    foreach ($cart as $item) {
        $total += $item['price'] * $item['quantity'];
        // Validasi input data ke order_items table (order_id, product_id, quantity, total_price, product_name)
        $itemInput = mysqli_prepare($koneksi, "INSERT INTO order_items (order_id, product_id, quantity, total_price, product_name) VALUES (?, ?, ?, ?, ?)");
        $itemTotalPrice = $item['price'] * $item['quantity'];
        mysqli_stmt_bind_param($itemInput, 'iiiss', $orderId, $item['id'], $item['quantity'], $itemTotalPrice, $item['name']);
        mysqli_stmt_execute($itemInput);
        mysqli_stmt_close($itemInput);
    }

    // update total_price di orders table
    $updateOrder = mysqli_prepare($koneksi, "UPDATE orders SET total_price = ? WHERE id = ?");
    mysqli_stmt_bind_param($updateOrder, 'ii', $total, $orderId);
    mysqli_stmt_execute($updateOrder);
    mysqli_stmt_close($updateOrder);

    // Hapus keranjang setelah checkout
    unset($_SESSION['cart']);

    header('Location: invoice.php?order_id=' . $orderId);
    exit();
}