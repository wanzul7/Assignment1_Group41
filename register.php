<?php
session_start();

$host = "localhost";
$db = "online-bookstore";
$user = "root";
$pass = "";
$conn = new mysqli($host, $user, $pass, $db);

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    if (empty($name) || empty($email) || empty($password)) {
        $error = "Please fill in all fields.";
    } elseif ($password !== $confirm_password) {
        $error = "Passwords do not match.";
    } else {
        $stmt = $conn->prepare("SELECT user_id FROM Users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        
        if ($stmt->num_rows > 0) {
            $error = "Email already registered.";
        } else {
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            $role = 'user';
            $insert = $conn->prepare("INSERT INTO Users (name, email, password_hash, role) VALUES (?, ?, ?, ?)");
            $insert->bind_param("ssss", $name, $email, $password_hash, $role);

            if ($insert->execute()) {
                $success = "Registration successful. You can now <a href='login.php'>login</a>.";
            } else {
                $error = "Something went wrong. Please try again.";
            }
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register - BookVerse</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <div class="nav-container">
        <h1 class="logo">BookVerse</h1>
        <nav>
            <ul>
                <li><a href="login.php">Login</a></li>
                <li><a href="register.php">Register</a></li>
            </ul>
        </nav>
    </div>
</header>

<main class="book-container">
    <h2>Register an Account</h2>

    <?php if ($error): ?>
        <p style="color: red;"><?= $error ?></p>
    <?php elseif ($success): ?>
        <p style="color: green;"><?= $success ?></p>
    <?php endif; ?>

    <form method="post" style="max-width: 400px; margin: auto;">
        <div style="margin-bottom: 10px;">
            <label>Name:</label><br>
            <input type="text" name="name" required style="width: 100%; padding: 10px;">
        </div>
        <div style="margin-bottom: 10px;">
            <label>Email:</label><br>
            <input type="email" name="email" required style="width: 100%; padding: 10px;">
        </div>
        <div style="margin-bottom: 10px;">
            <label>Password:</label><br>
            <input type="password" name="password" required style="width: 100%; padding: 10px;">
        </div>
        <div style="margin-bottom: 10px;">
            <label>Confirm Password:</label><br>
            <input type="password" name="confirm_password" required style="width: 100%; padding: 10px;">
        </div>
        <button type="submit" style="padding: 10px 20px;">Register</button>
    </form>
</main>

<footer>
    <p>&copy; <?php echo date("Y"); ?> BookVerse. All rights reserved.</p>
</footer>

</body>
</html>
