<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Browse Books</title>
    <link rel="stylesheet" href="style.css">
    <script>
        function confirmOrder(form) {
            if (confirm("Are you sure you want to order this book?")) {
                form.submit();
            }
        }
    </script>
</head>
<body>

<header>
    <div class="nav-container">
        <h1 class="logo">BookVerse</h1>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="browse-books.php">Browse Books</a></li>
                <?php if (!isset($_SESSION['user_id'])): ?>

                    <li><a href="logout.php">Logout</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
</header>

<main class="book-container">
    <h2>Available Books</h2>
    <div class="book-grid">
        <?php
        // Sample books data including all needed attributes
        $books = [
            [
                'book_id' => 1,
                'title' => 'The Hunger Games',
                'author' => 'Suzanne Collins',
                'genre' => 'Dystopian',
                'price' => 29,
                'stock' => 10,
                'image' => 'images/book1.jpeg'
            ],
            [
                'book_id' => 2,
                'title' => 'Halo Epitaph',
                'author' => 'Various',
                'genre' => 'Science Fiction',
                'price' => 50,
                'stock' => 5,
                'image' => 'images/book2.jpg'
            ],
            [
                'book_id' => 3,
                'title' => 'Twilight',
                'author' => 'Stephenie Meyer',
                'genre' => 'Romance',
                'price' => 25,
                'stock' => 7,
                'image' => 'images/book3.jpg'
            ],
        ];

        foreach ($books as $book): ?>
            <div class="book-card">
                <img src="<?= htmlspecialchars($book['image']) ?>" alt="<?= htmlspecialchars($book['title']) ?>">
                <h3><?= htmlspecialchars($book['title']) ?></h3>
                <p><strong>Author:</strong> <?= htmlspecialchars($book['author']) ?></p>
                <p><strong>Genre:</strong> <?= htmlspecialchars($book['genre']) ?></p>
                <p><strong>Price:</strong> RM <?= number_format($book['price'], 2) ?></p>
                <p><strong>Stock:</strong> <?= intval($book['stock']) ?></p>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <?php if ($book['stock'] > 0): ?>
                        <form method="post" action="order-book.php" onsubmit="event.preventDefault(); confirmOrder(this);">
                            <input type="hidden" name="book_id" value="<?= intval($book['book_id']) ?>">
                            <input type="hidden" name="price" value="<?= floatval($book['price']) ?>">
                            <button type="submit">Order this Book</button>
                        </form>
                    <?php else: ?>
                        <p style="color: red;"><em>Out of Stock</em></p>
                    <?php endif; ?>
                <?php else: ?>
                    <p><a href="login.php">Login to Order</a></p>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
</main>

<footer>
    <p>&copy; <?= date("Y"); ?> BookVerse. All rights reserved.</p>
</footer>

</body>
</html>
