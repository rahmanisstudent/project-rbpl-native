<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    // Belum login → arahkan ke form login
    header('Location: login.php');
    exit;
}

include 'koneksi.php';

try {
    $pdo = new PDO("mysql:host=$hostname;dbname=$database", $username, $password);
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}


$sql = "SELECT tanggal_mulai as start, DATE_ADD(tanggal_selesai, INTERVAL 1 DAY) as end, CONCAT(jenis_model, ' ', nama_pelanggan) AS title, CONCAT('#', Warna) as color FROM pesanan";
$stmt = $pdo->query($sql);

$events = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Convert the PHP array into a JSON string
$events_json = json_encode($events);
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kalender Pekerjaan</title>
    <link rel="stylesheet" href="css/index.css">
</head>

<body>
    <?php include 'nav.php' ?>

    <div class="container">
        <section class="main">
            <h1>Kalender Pekerjaan Penjahit</h1>
            <?php if (isset($_SESSION['success_message'])) {
                echo '<div class="success">' . htmlspecialchars($_SESSION['success_message']) . '</div>';
                unset($_SESSION['success_message']);
            }
            ?>
            <div id="calendar"></div>
        </section>



        <section class="list">
            <div class="task-list">
                <h3 style="margin-bottom: 30px;">Daftar Pekerjaan</h3>
                <?php
                // Fetch task list from the database
                $sql = "SELECT pesanan_id, jenis_model, nama_pelanggan, tanggal_mulai, tanggal_selesai, status_pengerjaan, Warna FROM pesanan ORDER BY tanggal_mulai ASC";
                $stmt = $pdo->query($sql);

                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    // Format date
                    $start = date('j', strtotime($row['tanggal_mulai']));
                    $end = date('j F Y', strtotime($row['tanggal_selesai']));
                    $dateRange = $start . ' - ' . $end;

                    ?>
                    <div class="task">
                        <a href="detail.php?id=<?php echo htmlspecialchars($row['pesanan_id']); ?>"
                            style="text-decoration: none;">
                            <div style="display: flex; align-items: center; justify-content: space-between;">
                                <div style="display: flex; align-items: center;">
                                    <div class="status" style="margin-right: 10px;">
                                        <span class="dot"
                                            style="color: #<?php echo htmlspecialchars($row['Warna']); ?>;">&#9679</span>
                                    </div>
                                    <div class="isiKiri">
                                        <h3 class="judulPesanan">
                                            <?php echo htmlspecialchars($row['jenis_model']) . ' ' . htmlspecialchars($row['nama_pelanggan']); ?>
                                        </h3>
                                        <p class="tanggal">
                                            <?php echo htmlspecialchars($dateRange); ?>
                                        </p>
                                    </div>
                                </div>
                                <div class="isiKanan">
                                    <p class="statusPengerjaan">
                                        <?php echo htmlspecialchars($row['status_pengerjaan']); ?>
                                    </p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <?php
                }
                ?>
            </div>
            <a href="tambah.php" class="add-task"> + </a>
        </section>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                width: 500,
                height: 550,

                events: <?php echo $events_json; ?>
            });
            calendar.render();
        });

        document.querySelector('.menu-icon').addEventListener('click', function () {
            var sidebar = document.getElementById('sidebar');
            sidebar.style.width = sidebar.style.width === '250px' ? '0' : '250px';
        });
    </script>
</body>

</html>