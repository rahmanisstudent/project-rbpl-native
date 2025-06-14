<?php
// Selalu mulai session di awal jika nanti butuh untuk notifikasi
session_start();
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
                        <a onclick="alert('Pop-up detail pakaian akan muncul di sini.')">
                            <h3 class="detail-pakaian">Detail Pakaian</h3>
                        </a>
                    </div>
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
</body>

</html>