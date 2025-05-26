<!DOCTYPE html>
<html lang="id">
<body>
    <?php include 'nav.php' ?>

    <section class="main">
        <h2 style="text-align: center; margin-top: 20px;">Kalender Pekerjaan Penjahit</h2>
        <div id="calendar"></div>

        <div class="task-list">
            <h3>Daftar Pekerjaan</h3>
            <div class="task green">Baju dinas Mas Amba (3 - 8 Juni 2019) - Finishing</div>
            <div class="task red">Seragam batik Ibu Kus (3 - 8 Juni 2019) - Pemotongan</div>
            <div class="task blue">Dress Mbak Hani (18 - 28 Juni 2019) - Belum dimulai</div>
        </div>

        <a href="tambah.html"><div class="add-task">+</div></a>
    </section>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                events: [
                    {
                        title: 'Baju dinas Mas Amba',
                        start: '2025-06-03',
                        end: '2025-06-08',
                        color: 'green'
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
