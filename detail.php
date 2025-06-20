<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    // Belum login → arahkan ke form login
    header('Location: login.php');
    exit;
}
// Selalu mulai session di awal jika nanti butuh untuk notifikasi
include 'koneksi.php';

// 1. Validasi Input ID dari URL
// Pastikan ID ada dan tidak kosong
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Error: ID Pesanan tidak ditemukan.");
}
$id = $_GET['id'];

try {
    $pdo = new PDO("mysql:host=$hostname;dbname=$database", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}

// 2. Gunakan Prepared Statements untuk Keamanan (Mencegah SQL Injection)
$sql = "SELECT * FROM pesanan WHERE pesanan_id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);

// 3. Ambil data, dan cek apakah pesanan ditemukan
$design = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$design) {
    die("Pesanan dengan ID '$id' tidak ditemukan.");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pesanan - <?php echo htmlspecialchars($design['pesanan_id']); ?></title>
    <link rel="stylesheet" href="css/detail.css">
</head>

<body>
    <?php include 'nav.php'; ?>
    <div class="container">
        <h1>Detail Pesanan</h1>

        <form action="proses_update_status.php" method="POST">
            <input type="hidden" name="pesanan_id" value="<?php echo htmlspecialchars($design['pesanan_id']); ?>">

            <div class="parent">
                <div class="div1">
                    <label for="ID">ID Pesanan</label>
                    <h3><?php echo htmlspecialchars($design['pesanan_id']); ?></h3>
                </div>
                <div class="div2">
                    <label for="status">Status Pengerjaan</label>
                    <select id="status" name="status">
                        <option value="-" <?php if ($design['status_pengerjaan'] == '-')
                            echo 'selected'; ?>>-</option>
                        <option value="Pemotongan" <?php if ($design['status_pengerjaan'] == 'Pemotongan')
                            echo 'selected'; ?>>
                            Pemotongan</option>
                        <option value="Penjahitan" <?php if ($design['status_pengerjaan'] == 'Penjahitan')
                            echo 'selected'; ?>>
                            Penjahitan</option>
                        <option value="Finishing" <?php if ($design['status_pengerjaan'] == 'Finishing')
                            echo 'selected'; ?>>
                            Finishing</option>
                        <option value="Selesai" <?php if ($design['status_pengerjaan'] == 'Selesai')
                            echo 'selected'; ?>>Selesai
                        </option>
                    </select>
                </div>
                <div class="div3">
                    <label for="Nama Pemesan">Nama Pemesan</label>
                </div>
                <div class="div4">
                    <h3><?php echo htmlspecialchars($design['nama_pelanggan']); ?></h3>
                </div>
                <div class="div5">
                    <label for="Nomor Telepon">No. Telepon</label>
                </div>
                <div class="div6">
                    <h3><?php echo htmlspecialchars($design['nomor_telepon']); ?></h3>
                </div>
                <div class="div5ii">
                    <label for="Quantity">Quantity</label>
                </div>
                <div class="div6ii">
                    <h3><?php echo htmlspecialchars($design['quantity']); ?></h3>
                </div>
                <div class="div7">
                    <label for="tanggal pemesanan">Tanggal Mulai</label>
                    <div class="kotakan">
                        <h3><?php echo date('d M Y', strtotime($design['tanggal_mulai'])); ?></h3>
                    </div>
                </div>
                <div class="div8">
                    <label for="tanggal pemesanan">Tanggal Selesai</label>
                    <div class="kotakan">
                        <h3><?php echo date('d M Y', strtotime($design['tanggal_selesai'])); ?></h3>
                    </div>
                </div>
                <div class="div9">
                    <div class="kotakan">
                        <a style="text-decoration: none;" href="javascript:void(0);" onclick="showPopupDetailPakaian()">
                            <h3 class="detail-pakaian">Detail Pakaian</h3>
                        </a>
                    </div>
                </div>
                <div class="div3ii">
                    <label for="pengambilan">Pengambilan</label>
                </div>
                <div class="div4ii">
                    <select id="opsi_pengambilan" name="opsi_pengambilan">
                        <option value="Pesanan diantar" <?php if ($design['opsi_pengambilan'] == 'Pesanan diantar')
                            echo 'selected'; ?>>Pesanan diantar
                        </option>
                        <option value="Ambil di tempat" <?php if ($design['opsi_pengambilan'] == 'Ambil di tempat')
                            echo 'selected'; ?>>
                            Ambil di tempat
                        </option>
                    </select>
                </div>
                <div class="div10">
                    <label for="alamat">Alamat</label>
                    <div class="kotakan">
                        <p><?php echo nl2br(htmlspecialchars($design['alamat'])); ?></p>
                    </div>
                </div>
                <div class="div11">
                    <label for="catatan">Catatan Pelanggan</label>
                    <div class="kotakan">
                        <p><?php echo nl2br(htmlspecialchars($design['catatan'])); ?></p>
                    </div>
                </div>
            </div>
            <div class="tombol">
                <a href="index.php" style="text-decoration:none;">
                    <button type="button" class="kembali">KEMBALI</button>
                </a>
                <button type="submit" class="simpan">SIMPAN</button>
            </div>
        </form>
    </div>

    <?php
    // Ambil data design terkait pesanan
    $designData = null;
    if (!empty($design['jenis_model'])) {
        // 'jenis_model' di pesanan adalah foreign key ke design.jenis_pakaian
        $sqlDesign = "SELECT * FROM design WHERE jenis_pakaian = ?";
        $stmtDesign = $pdo->prepare($sqlDesign);
        $stmtDesign->execute([$design['jenis_model']]);
        $designData = $stmtDesign->fetch(PDO::FETCH_ASSOC);
    }
    ?>
    <div id="popup-detail"
        style="display:none; position:fixed; top:0; left:0; width:100vw; height:100vh; background:rgba(0,0,0,0.4); z-index:9999; justify-content:center; align-items:center;">
        <div class="popup-content">
            <span class="close" onclick="closePopupDetailPakaian()">&times;</span>
            <h2>Detail Pakaian</h2>
            <div class="detail-pakaian-content">
                <?php if ($designData): ?>
                    <img src="<?php echo htmlspecialchars($designData['gambar_design']); ?>" alt="Gambar Pakaian"
                        class="pakaian-image">
                    <div class="pakaian-info">
                        <h3><?php echo htmlspecialchars($designData['jenis_pakaian']); ?></h3>
                        <p style="word-break: break-word; text-align: justify;">
                            <?php echo nl2br(htmlspecialchars($designData['deskripsi_design'])); ?></p>
                        <h3>Ukuran</h3>
                        <ul>
                            <?php
                            if (isset($design['ukuran']) && !empty($design['ukuran'])) {
                                // Asumsi format: "Panjang Tangan:60,Panjang Kaki:90,Lingkar Dada:100"
                                $ukuranList = explode(',', $design['ukuran']);
                                $jenisUkuran = [];
                                $besarUkuran = [];

                                foreach ($ukuranList as $item) {
                                    $parts = explode(':', $item, 2);
                                    if (count($parts) == 2) {
                                        $jenis = trim($parts[0]);
                                        $besar = trim($parts[1]);
                                        $jenisUkuran[] = $jenis;
                                        $besarUkuran[] = $besar;
                                    }
                                }
                                if (count($jenisUkuran) > 0) {
                                    echo '<div style="display:flex; justify-content:space-between; align-items:flex-start;">';
                                    // Jenis ukuran di kiri
                                    echo '<div>';
                                    echo '<ul style="list-style:none;">';
                                    foreach ($jenisUkuran as $jenis) {
                                        echo '<li>' . htmlspecialchars($jenis) . '</li>';
                                    }
                                    echo '</ul></div>';

                                    // Besar ukuran di kanan
                                    echo '<div style="text-align:right;">';
                                    echo '<ul style="list-style:none;">';
                                    foreach ($besarUkuran as $besar) {
                                        echo '<li>' . htmlspecialchars($besar) . ' <span style="font-size:smaller;">cm</span></li>';
                                    }
                                    echo '</ul></div>';
                                    echo '</div>';
                                } else {
                                    echo '<p>Tidak ada data ukuran.</p>';
                                }
                            } else {
                                echo '<p>Tidak ada data ukuran.</p>';
                            }
                            ?>
                        </ul>
                    </div>
                <?php else: ?>
                    <p>Data design tidak ditemukan.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script>
        function showPopupDetailPakaian() {
            document.getElementById('popup-detail').style.display = 'flex';
        }

        function closePopupDetailPakaian() {
            document.getElementById('popup-detail').style.display = 'none';
        }
    </script>
</body>

</html>