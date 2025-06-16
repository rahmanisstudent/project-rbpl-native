<?php
session_start();
include 'koneksi.php';

try {
    $pdo = new PDO("mysql:host=$hostname;dbname=$database", $username, $password);

    // --- Fetch Data for Chart ---
    $sql = "SELECT jenis_model, COUNT(*) as jumlah FROM pesanan GROUP BY jenis_model";
    $stmt = $pdo->query($sql);
    $dataPoints = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $dataPoints[] = ["y" => (int) $row['jumlah'], "label" => $row['jenis_model']];
    }
    // --- End of Data Fetch ---

    if (empty($dataPoints)) {
        $dataPoints = [
            ["y" => 0, "label" => "Tidak ada data"]
        ];
    }
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}

if (isset($_SESSION['success_message'])) {
    echo '<div class="success">'
        . htmlspecialchars($_SESSION['success_message']) . '</div>';
    unset($_SESSION['success_message']);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan</title>
    <link rel="stylesheet" href="css/laporan.css">
    <script>
        window.onload = function () {

            var chart = new CanvasJS.Chart("chartContainer", {
                animationEnabled: true,
                theme: "light2",
                backgroundColor: "transparent",
                title: {
                    text: "Penjualan Model",
                    fontColor: "#ffffff"
                },
                axisY: {
                    labelFontColor: "#08ffad",
                    titleFontColor: "#ffffff"
                },
                axisX: {
                    labelFontColor: "#08ffad",
                    labelFontSize: 11,
                    labelWrap: true,
                    labelAngle: -45,
                    labelMaxWidth: 50,
                    labelFormatter: function (e) {
                        if (window.innerWidth < 450) {
                            return "";
                        }
                        return e.label;
                    }
                },
                data: [{
                    type: "column",
                    color: "#ffffff",
                    yValueFormatString: "#,##0.##",
                    dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
                }],
                toolTip: {
                    backgroundColor: "#475581",
                    fontColor: "#ffffff",
                    borderColor: "#ffffff"
                }
            });
            chart.render();

        }
    </script>
</head>

<body>
    <?php include 'nav.php'; ?>

    <div class="container">
        <h1>Laporan</h1>
        <div class="parent">

            <div class="div1">
                <div class="chart">
                    <div id="chartContainer" style="height: 370px; width: 100%;"></div>
                </div>
            </div>

            <div class="div2">
                <div class="circle">
                    <p>
                        <?php
                        // Hitung total pesanan yang sudah selesai dikerjakan
                        $stmtSelesai = $pdo->query("SELECT COUNT(*) as total_selesai FROM pesanan WHERE status_pengerjaan = 'Selesai'");
                        $rowSelesai = $stmtSelesai->fetch(PDO::FETCH_ASSOC);
                        echo $rowSelesai['total_selesai'];
                        ?>
                        <br>
                        Selesai
                    </p>
                </div>
            </div>

            <div class="div3">
                <h3>DEADLINE TERDEKAT</h3>
                <div class="wrapper">
                    <div class="hari">
                        <?php
                        // Cari pesanan dengan tanggal_selesai terdekat dari hari ini dan belum selesai
                        $stmtDeadline = $pdo->prepare("SELECT pesanan_id, nama_pelanggan, jenis_model, tanggal_selesai FROM pesanan WHERE tanggal_selesai >= CURDATE() AND status_pengerjaan != 'Selesai' ORDER BY tanggal_selesai ASC LIMIT 1");
                        $stmtDeadline->execute();
                        $pesananTerdekat = $stmtDeadline->fetch(PDO::FETCH_ASSOC);

                        // Hitung sisa hari untuk deadline terdekat
                        $hariTersisa = 0;
                        if ($pesananTerdekat) {
                            $tanggalSelesai = new DateTime($pesananTerdekat['tanggal_selesai']);
                            $hariTersisa = $tanggalSelesai->diff(new DateTime())->days;
                        }
                        echo $hariTersisa;
                        ?>
                    </div>
                    <div class="tersisa">
                        <p>Hari<br>Tersisa</p>
                    </div>
                    <?php
                    // Cari pesanan dengan tanggal_selesai terdekat dari hari ini dan belum selesai
                    if ($pesananTerdekat) {
                        ?>
                        <div class="pemilik">
                            <a href="detail.php?id=<?php echo htmlspecialchars($pesananTerdekat['pesanan_id']); ?>">
                                <h4><?php echo htmlspecialchars($pesananTerdekat['pesanan_id']); ?></h4>
                                <p><?php echo htmlspecialchars($pesananTerdekat['nama_pelanggan']); ?></p>
                                <p><?php echo htmlspecialchars($pesananTerdekat['jenis_model']); ?></p>
                            </a>
                        </div>
                        <?php
                    } else {
                        ?>
                        <div class="pemilik">
                            <p>Tidak ada deadline terdekat</p>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>

        <div class="div4">
            <h2>Last Order</h2>
            <ul>
                <!-- <a href="detail.php?id=IS823">
                    <li class="item">
                        <div class="info">
                            Ibu Kus
                            <div class="status">
                                <span class="status-text">Pemotongan</span>
                            </div>
                        </div>
                        <div class="date">3 Juni 2025</div>
                    </li>
                </a>
                <a href="detail.php?id=IS824">
                    <li class="item">
                        <div class="info">
                            Ibu Kus
                            <div class="status">
                                <span class="status-text">Pemotongan</span>
                            </div>
                        </div>
                        <div class="date">3 Juni 2025</div>
                    </li>
                </a>
                <a href="detail.php?id=IS825">
                    <li class="item">
                        <div class="info">
                            Ibu Kus
                            <div class="status">
                                <span class="status-text">Pemotongan</span>
                            </div>
                        </div>
                        <div class="date">3 Juni 2025</div>
                    </li>
                </a> -->

                <?php
                // Fetch last 5 orders
                $sqlLastOrders = "SELECT pesanan_id, nama_pelanggan, jenis_model, tanggal_selesai, status_pengerjaan FROM pesanan ORDER BY tanggal_selesai DESC LIMIT 5";
                $stmtLastOrders = $pdo->query($sqlLastOrders);
                while ($row = $stmtLastOrders->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                    <a href="detail.php?id=<?php echo htmlspecialchars($row['pesanan_id']); ?>">
                        <li class="item">
                            <div class="info">
                                <?php echo htmlspecialchars($row['nama_pelanggan']); ?>
                                <div class="status">
                                    <span
                                        class="status-text"><?php echo htmlspecialchars($row['status_pengerjaan']); ?></span>
                                </div>
                            </div>
                            <div class="date"><?php echo htmlspecialchars($row['tanggal_selesai']); ?></div>
                        </li>
                    </a>
                    <?php
                }
                ?>

            </ul>
        </div>
    </div>
    </div>

    <script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
</body>

</html>