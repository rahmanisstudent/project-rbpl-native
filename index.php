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

            <div class="task-list">
                <h3>Daftar Pekerjaan</h3>
                <div class="task green">Baju dinas Mas Jacobi (3 - 8 Juni 2019) - Finishing</div>
                <div class="task red">Seragam batik Ibu Kus (3 - 8 Juni 2019) - Pemotongan</div>
                <div class="task blue">Dress Mbak Hani (18 - 28 Juni 2019) - Belum dimulai</div>
            </div>

            <a href="tambah.php" class="add-task"> + </a>
        </section>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                height: 480,
                events: [
                    {
                        title: 'Baju dinas Mas Jacobi',
                        start: '2025-06-03',
                        end: '2025-06-08',
                        color: 'green' //dirandom aja ga si, asal warnanya sama yg di kalender sm yg di list
                    },
                    {
                        title: 'Seragam batik Ibu Kus',
                        start: '2025-06-03',
                        end: '2025-06-08',
                        color: 'red'
                    },
                    {
                        title: 'Dress Mbak Hani',
                        start: '2025-06-18',
                        end: '2025-06-28',
                        color: 'blue'
                    }
                ]
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
