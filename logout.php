<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_logout'])) {
    // Destroy session
    session_unset();
    session_destroy();

    // Redirect immediately to login.php (with a thank you alert)
    echo "<script>
        alert('Thank you for browsing!');
        window.location.href = 'login.php';
    </script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Logout</title>
</head>
<body>

<form id="logoutForm" method="post" action="logout.php" style="display:none;">
    <input type="hidden" name="confirm_logout" value="1" />
</form>

<script>
    if (confirm('Are you sure you want to log out?')) {
        document.getElementById('logoutForm').submit();
    } else {
        window.location.href = 'index.php'; // Cancel -> back home
    }
</script>

</body>
</html>
