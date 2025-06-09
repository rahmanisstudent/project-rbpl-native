<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIMP</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css">
    <link rel="stylesheet" href="css/nav.css"/>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
</head>
<body>
    <header>
        <nav>
            <ul class="navbar">
                <li><h1>Sistem Informasi<br>Manajemen Penjahit</h1></li>
                <input type="checkbox" id="check">
                <span class="menu">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="katalog.html">Katalog</a></li>
                    <li><a href="laporan.html">Laporan</a></li>
                    <li><a onclick="alert('Keluar nih ceritanya!')">Logout</a></li>
                    <label for="check" class="close-menu"><i class="icon-close"><img src="css/icon/close.png" width="20px"></i></label>
                </span>
                <label for="check" class="open-menu"><i class="icon-open"><img src="css/icon/burger.png" width="40px"></i></label>
            </ul>
        </nav>
    </header>
</body>