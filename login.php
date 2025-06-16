<?php
session_start();
include 'koneksi.php';  // → menyediakan $connect (mysqli)
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Siapkan statement untuk mencegah SQL injection
    $stmt = $connect->prepare("
        SELECT user_id, username, password 
        FROM `user` 
        WHERE username = ?
    ");
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($user = $result->fetch_assoc()) {
        // Bandingkan langsung plaintext password
        if ($password === $user['password']) {
            // Login berhasil: set session dan redirect
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['username'];
            header('Location: index.php');
            exit;
        }
    }

    // Jika gagal login
    $error = 'Username atau password salah!';
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/login.css">
</head>

<body>
    <header>
        <nav>
            <ul class="navbar">
                <h1>Sistem Informasi<br>Manajemen Penjahit</h1>
            </ul>
        </nav>
    </header>
    <div class="container">
        <div class="login-form">
            <h2>Login</h2>
            <?php if ($error): ?>
                <p class="errormsg"><?= htmlspecialchars($error) ?></p>
            <?php endif; ?>
            <form action="" method="post">
                <div class="input-group">
                    <label for="username">Username</label><br>
                    <input id="username" name="username" required>
                </div>
                <div class="input-group">
                    <label for="password">Password</label><br>
                    <input type="password" id="password" name="password" required>
                </div>
                <button type="submit">Login</button>
            </form>
        </div>
    </div>
</body>

</html>