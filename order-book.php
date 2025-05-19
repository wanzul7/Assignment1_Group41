<?php
session_start();
require 'db.php'; // your DB connection

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['book_id'])) {
    $user_id = $_SESSION['user_id'];
    $book_id = $_POST['book_id'];
    $price = $_POST['price'];
    $quantity = 1;
    $total_price = $price * $quantity;
    $date = date('Y-m-d');

    try {
        // Insert order
        $stmt = $pdo->prepare("INSERT INTO Orders (user_id, date, total_price) VALUES (?, ?, ?)");
        $stmt->execute([$user_id, $date, $total_price]);
        $order_id = $pdo->lastInsertId();

        // Insert order item
        $stmt = $pdo->prepare("INSERT INTO Order_items (order_id, book_id, quantity) VALUES (?, ?, ?)");
        $stmt->execute([$order_id, $book_id, $quantity]);

        // Show success alert then redirect to index.php
        echo "<script>
            alert('Order placed successfully!');
            window.location.href = 'index.php';
        </script>";
        exit;

    } catch (Exception $e) {
        echo "Error ordering book: " . $e->getMessage();
    }
}
?>
