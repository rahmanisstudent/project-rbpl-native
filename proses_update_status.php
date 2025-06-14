<?php
session_start();
include 'koneksi.php';

// Pastikan request adalah POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Ambil data dari form
    $pesanan_id = $_POST['pesanan_id'];
    $status_baru = $_POST['status'];

    // Validasi data (opsional tapi sangat disarankan)
    if (empty($pesanan_id) || empty($status_baru)) {
        $_SESSION['error_message'] = "Data tidak lengkap.";
        header("Location: detail.php?id=" . $pesanan_id);
        exit();
    }

    try {
        $pdo = new PDO("mysql:host=$hostname;dbname=$database", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Siapkan query UPDATE dengan prepared statements
        $sql = "UPDATE pesanan SET status_pengerjaan = ? WHERE pesanan_id = ?";
        $stmt = $pdo->prepare($sql);

        // Eksekusi query
        if ($stmt->execute([$status_baru, $pesanan_id])) {
            $_SESSION['success_message'] = "Status berhasil diperbarui!";
        } else {
            $_SESSION['error_message'] = "Gagal memperbarui status.";
        }

    } catch (PDOException $e) {
        $_SESSION['error_message'] = "Database error: " . $e->getMessage();
    }

    // Arahkan kembali pengguna ke halaman detail
    header("Location: detail.php?id=" . $pesanan_id);
    exit();

} else {
    // Jika file diakses langsung, arahkan ke halaman utama
    header('Location: index.php');
    exit();
}
?>