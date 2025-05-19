<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Online Bookstore</title>
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

                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <section class="banner">
        <div class="banner-text">
            <h2>Welcome to BookVerse</h2>
            <p>Discover, Read, and Buy Books Online</p>
        </div>
    </section>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> BookVerse. All rights reserved.</p>
    </footer>

    <script src="script.js"></script>
</body>
</html>
