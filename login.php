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
        <div class="login-form" >
            <h2>Login</h2>
            <form action="index.php" method="post">
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