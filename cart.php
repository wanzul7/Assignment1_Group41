<?php
session_start();

// Initialize cart
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Add to cart
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    $book_id = $_POST['book_id'];
    $found = false;

    foreach ($_SESSION['cart'] as &$item) {
        if ($item['id'] == $book_id) {
            $item['quantity'] += 1;
            $found = true;
            break;
        }
    }

    if (!$found) {
        $_SESSION['cart'][] = [
            'id' => $book_id,
            'title' => $_POST['title'],
            'price' => $_POST['price'],
            'image' => $_POST['image'],
            'quantity' => 1
        ];
    }

    // Redirect to prevent form resubmission
    header("Location: cart.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Cart</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <div class="nav-container">
        <h1 class="logo">BookVerse</h1>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                    <li><a href="browse-books.php">Browse Books</a></li>
                    <li><a href="cart.php">Cart</a></li>
                    <li><a href="#">Contact</a></li>
                    <li><a href="login.php">Login</a></li>
            </ul>
        </nav>
    </div>
</header>

<main class="book-container">
    <h2>Your Shopping Cart</h2>
    <?php if (empty($_SESSION['cart'])): ?>
        <p>Your cart is empty.</p>
    <?php else: ?>
        <div class="book-grid">
            <?php
            $grand_total = 0;
            foreach ($_SESSION['cart'] as $item):
                $total = $item['price'] * $item['quantity'];
                $grand_total += $total;
            ?>
                <div class="book-card">
                    <img src="<?= $item['image'] ?>" alt="<?= $item['title'] ?>">
                    <h3><?= $item['title'] ?></h3>
                    <p>Price: RM <?= $item['price'] ?></p>
                    <p>Quantity: <?= $item['quantity'] ?></p>
                    <p>Total: RM <?= number_format($total, 2) ?></p>
                </div>
            <?php endforeach; ?>
        </div>
        <h3>Total Amount: RM <?= number_format($grand_total, 2) ?></h3>
    <?php endif; ?>
</main>

<footer>
    <p>&copy; <?php echo date("Y"); ?> BookVerse. All rights reserved.</p>
</footer>

</body>
</html>
