<?php
include 'koneksi.php';

try {
    $pdo = new PDO("mysql:host=$hostname;dbname=$database", $username, $password);
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}

// --- Fetch Events ---
// Make sure your table and column names match your database
// The column names must match what FullCalendar expects: title, start, end, color
$sql = "SELECT tanggal_mulai as start, tanggal_selesai as end, CONCAT(jenis_model, ' ', nama_pelanggan) AS title FROM pesanan";
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
            <div id="calendar"></div>
        </section>
        <section class="list">
            <div class="task-list">
                <h3>Daftar Pekerjaan</h3>
                <?php
                // Fetch task list from the database
                $sql = "SELECT pesanan_id, jenis_model, nama_pelanggan, tanggal_mulai, tanggal_selesai, status_pengerjaan FROM pesanan ORDER BY tanggal_mulai DESC";
                $stmt = $pdo->query($sql);

                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    // Format date
                    $start = date('j', strtotime($row['tanggal_mulai']));
                    $end = date('j F Y', strtotime($row['tanggal_selesai']));
                    $dateRange = $start . ' - ' . $end;

                    // Determine task color based on status
                    $colorClass = 'blue';
                    if (stripos($row['status_pengerjaan'], 'Finishing') !== false) {
                        $colorClass = 'green';
                    } elseif (stripos($row['status_pengerjaan'], 'Pemotongan') !== false) {
                        $colorClass = 'red';
                    }
                    ?>
                    <div class="task <?php echo $colorClass; ?>">
                        <a href="detail.php?id=<?php echo htmlspecialchars($row['pesanan_id']); ?>">
                            <?php echo htmlspecialchars($row['jenis_model']) . ' ' . htmlspecialchars($row['nama_pelanggan']) . ' (' . $dateRange . ') - ' . htmlspecialchars($row['status_pengerjaan']); ?>
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
                height: 600,
                // ⬇️ Use PHP to echo the JSON string here ⬇️
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