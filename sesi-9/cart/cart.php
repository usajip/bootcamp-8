<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];
        
        if ($action === 'update_quantity') {
            $productId = isset($_POST['product_id']) ? (string) $_POST['product_id'] : null;
            $quantity = isset($_POST['quantity']) ? (int) $_POST['quantity'] : 0;
            
            if ($productId && isset($_SESSION['cart'][$productId])) {
                if ($quantity > 0) {
                    $_SESSION['cart'][$productId]['quantity'] = $quantity;
                } else {
                    unset($_SESSION['cart'][$productId]);
                }
            }
            header('Location: index.php?status=updated');
            exit();
        }
        
        if ($action === 'delete_item') {
            $productId = isset($_POST['product_id']) ? (string) $_POST['product_id'] : null;
            
            if ($productId && isset($_SESSION['cart'][$productId])) {
                unset($_SESSION['cart'][$productId]);
            }
            header('Location: index.php?status=deleted');
            exit();
        }
        
        if ($action === 'clear_cart') {
            $_SESSION['cart'] = [];
            header('Location: index.php?status=cleared');
            exit();
        }
    }
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