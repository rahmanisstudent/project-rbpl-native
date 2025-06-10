<?php
include 'koneksi.php'; // Pastikan file ini ada dan koneksi ke DB berhasil

$op = ""; // Untuk operasi edit/insert
$design_id = "";
$jenis_pakaian = "";
$gambar_design = "";
$deskripsi_design = "";
$success = "";
$error = "";

// Ambil design_id jika ada di URL (untuk edit)
if (isset($_GET['op']) && $_GET['op'] == 'edit' && isset($_GET['id'])) {
    $op = 'edit';
    $design_id = $_GET['id'];
    $sql_get = "SELECT * FROM design WHERE design_id = '$design_id'";
    $q_get = mysqli_query($connect, $sql_get);
    if ($r_get = mysqli_fetch_array($q_get)) {
        $jenis_pakaian = $r_get['jenis_pakaian'];
        $gambar_design = $r_get['gambar_design']; // Nama gambar yang sudah ada
        $deskripsi_design = $r_get['deskripsi_design'];
    } else {
        $error = "Data desain tidak ditemukan.";
    }
}

// dijalankan ketika submit ditekan
if (isset($_POST['submit'])) {
    $jenis_pakaian = $_POST['jenis_pakaian'];
    $deskripsi_design = $_POST['deskripsi_design'];

    $image_path = ""; // Inisialisasi path gambar

    // Untuk upload foto
    if (isset($_FILES["gambar_design"]) && $_FILES["gambar_design"]["error"] === 0) {
        $file_name = $_FILES["gambar_design"]["name"];
        $file_tmp = $_FILES["gambar_design"]["tmp_name"];
        $file_type = $_FILES["gambar_design"]["type"];
        $file_size = $_FILES["gambar_design"]["size"];

        $ext = pathinfo($file_name, PATHINFO_EXTENSION);
        $new_file_name = uniqid() . '_' . time() . '.' . $ext; // Nama unik untuk file
        $file_destination = "uploads/" . $new_file_name;

        if (!is_dir("uploads")) {
            mkdir("uploads");
        }

        if (move_uploaded_file($file_tmp, $file_destination)) {
            $image_path = $file_destination;
        } else {
            $error = "Gagal mengunggah file gambar.";
        }
    } else {
        // Jika tidak ada file baru diunggah, gunakan gambar lama jika ada (untuk edit)
        if ($op == 'edit' && !empty($gambar_design)) {
            $image_path = $gambar_design; // Gunakan path gambar yang sudah ada di database
        }
    }

    // Validasi input
    if (empty($jenis_pakaian) || empty($deskripsi_design) || empty($image_path)) {
        $error = "Pastikan semua data terisi dan gambar telah diunggah.";
    } else {
        if ($op == 'edit') {
            // Hapus gambar lama jika ada gambar baru diunggah
            if (!empty($_FILES["gambar_design"]["name"]) && !empty($gambar_design) && file_exists($gambar_design)) {
                unlink($gambar_design);
            }

            $sql = "UPDATE design SET jenis_pakaian=?, deskripsi_design=?, gambar_design=? WHERE design_id=?";
            $stmt = mysqli_prepare($connect, $sql);
            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "sssi", $jenis_pakaian, $deskripsi_design, $image_path, $design_id);
                if (mysqli_stmt_execute($stmt)) {
                    $success = "Data desain berhasil diubah.";
                    // Refresh data setelah update untuk menampilkan yang terbaru di form edit
                    $sql_get = "SELECT * FROM design WHERE design_id = '$design_id'";
                    $q_get = mysqli_query($connect, $sql_get);
                    if ($r_get = mysqli_fetch_array($q_get)) {
                        $jenis_pakaian = $r_get['jenis_pakaian'];
                        $gambar_design = $r_get['gambar_design'];
                        $deskripsi_design = $r_get['deskripsi_design'];
                    }
                } else {
                    $error = "Data gagal diubah: " . mysqli_error($connect);
                }
                mysqli_stmt_close($stmt);
            } else {
                $error = "Gagal menyiapkan statement UPDATE: " . mysqli_error($connect);
            }
        } else { // Operasi INSERT
            $sql = "INSERT INTO design (jenis_pakaian, deskripsi_design, gambar_design) VALUES (?, ?, ?)";
            $stmt = mysqli_prepare($connect, $sql);
            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "sss", $jenis_pakaian, $deskripsi_design, $image_path);
                if (mysqli_stmt_execute($stmt)) {
                    $success = "Data desain berhasil ditambahkan.";
                    // Reset form setelah sukses insert
                    $jenis_pakaian = "";
                    $gambar_design = "";
                    $deskripsi_design = "";
                } else {
                    $error = "Data gagal ditambahkan: " . mysqli_error($connect);
                }
                mysqli_stmt_close($stmt);
            } else {
                $error = "Gagal menyiapkan statement INSERT: " . mysqli_error($connect);
            }
        }
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Katalog</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <link rel="stylesheet" href="css/katalog.css">
</head>

<body>
    <?php include 'nav.php'; ?>
    <div class="container my-4">
        <?php
        if ($error) {
            echo '<div class="alert alert-danger" role="alert">' . $error . '</div>';
        }
        if ($success) {
            echo '<div class="alert alert-success" role="alert">' . $success . '</div>';
        }
        ?>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <?php
            $sql = "SELECT * FROM design ORDER BY design_id ASC";
            $q = mysqli_query($connect, $sql);
            while ($r = mysqli_fetch_array($q)) { ?>
                <div class="col">
                    <div class="card h-100 resto-item">
                        <img src="<?php echo htmlspecialchars($r['gambar_design']); ?>" class="card-img-top"
                            alt="Desain Pakaian">
                        <div class="card-body resto-details">
                            <h5 class="card-title"><?php echo htmlspecialchars($r['jenis_pakaian']); ?></h5>
                            <p class="card-text text-success fw-bold"><?php echo htmlspecialchars($r['jenis_pakaian']); ?>
                            </p>
                            <p class="card-text text-dark opacity-75 text-truncate"
                                style="-webkit-line-clamp: 2; display: -webkit-box; -webkit-box-orient: vertical;">
                                <?php echo htmlspecialchars($r['deskripsi_design']); ?>
                            </p>
                            <div class="d-flex justify-content-between mt-3">
                                <a href="?op=edit&id=<?php echo $r['design_id']; ?>" class="btn btn-warning btn-sm"
                                    data-bs-toggle="modal" data-bs-target="#popupInput">Edit</a>
                                <a href="?op=delete&id=<?php echo $r['design_id']; ?>" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Apakah Anda yakin ingin menghapus desain ini?')">Delete</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
        <button type="button" class="btn btn-primary mt-4" data-bs-toggle="modal" data-bs-target="#popupInput"
            onclick="resetModalForm()">+</button>

        <div class="modal fade" id="popupInput" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah/Edit Desain</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="POST" enctype="multipart/form-data" id="designForm">
                            <input type="hidden" name="op" id="opInput" value="<?php echo htmlspecialchars($op); ?>">
                            <input type="hidden" name="design_id" id="designIdInput"
                                value="<?php echo htmlspecialchars($design_id); ?>">
                            <div class="mb-3">
                                <label for="jenis_pakaian_modal" class="form-label">Jenis pakaian</label>
                                <input type="text" class="form-control" id="jenis_pakaian_modal" name="jenis_pakaian"
                                    placeholder="Contoh: Daster, Dress, dll"
                                    value="<?php echo htmlspecialchars($jenis_pakaian); ?>">
                            </div>

                            <div class="mb-3">
                                <label for="deskripsi_design_modal" class="form-label">Deskripsi desain</label>
                                <textarea class="form-control" id="deskripsi_design_modal" name="deskripsi_design"
                                    rows="3"><?php echo htmlspecialchars($deskripsi_design); ?></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="gambar_design_modal" class="form-label">Input file gambar</label>
                                <input class="form-control" type="file" id="gambar_design_modal" name="gambar_design">
                                <?php if (!empty($gambar_design) && $op == 'edit') { ?>
                                    <small class="form-text text-muted">Gambar saat ini: <a
                                            href="<?php echo htmlspecialchars($gambar_design); ?>" target="_blank">Lihat
                                            Gambar</a></small>
                                <?php } ?>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO"
        crossorigin="anonymous"></script>

    <script>
        // Fungsi untuk mereset form modal saat tombol tambah (+) ditekan
        function resetModalForm() {
            document.getElementById('designForm').reset();
            document.getElementById('staticBackdropLabel').innerText = 'Tambah Desain Baru';
            document.getElementById('opInput').value = ''; // Clear op for new entry
            document.getElementById('designIdInput').value = ''; // Clear ID for new entry
        }

        // JavaScript untuk mengisi form modal saat tombol edit ditekan
        document.addEventListener('DOMContentLoaded', function () {
            var exampleModal = document.getElementById('popupInput');
            exampleModal.addEventListener('show.bs.modal', function (event) {
                var button = event.relatedTarget; // Tombol yang memicu modal
                var op = button.getAttribute('data-bs-op'); // Ambil nilai op dari tombol (jika ada)
                var designId = button.getAttribute('data-bs-id'); // Ambil design_id dari tombol (jika ada)

                var modalTitle = exampleModal.querySelector('.modal-title');
                var jenisPakaianInput = exampleModal.querySelector('#jenis_pakaian_modal');
                var deskripsiDesignTextarea = exampleModal.querySelector('#deskripsi_design_modal');
                var opInput = exampleModal.querySelector('#opInput');
                var designIdInput = exampleModal.querySelector('#designIdInput');

                if (op === 'edit' && designId) {
                    modalTitle.textContent = 'Edit Desain';
                    opInput.value = 'edit';
                    designIdInput.value = designId;

                    // Ambil data dari server (AJAX) atau langsung dari PHP jika sudah ada
                    // Untuk contoh ini, kita akan mengisi dari PHP yang sudah ada di scope global
                    <?php
                    // Ini akan dijalankan saat halaman dimuat, bukan saat modal dibuka
                    // Solusi terbaik adalah menggunakan AJAX untuk mengambil data saat edit
                    // Untuk saat ini, kita bisa memanfaatkan data yang sudah ada di PHP jika modal dibuka melalui tombol edit
                    // Atau, buat tombol edit mengarahkan ke halaman ini dengan parameter op=edit&id=X
                    ?>
                    // Jika Anda mengklik tombol edit, URL akan berubah dan PHP akan mengisi variabel
                    // Contoh ini mengasumsikan Anda mengklik tombol edit yang memicu modal
                    // Jika Anda ingin mengisi modal secara dinamis tanpa reload halaman, Anda perlu AJAX.
                    // Di sini, kita akan mengisi modal dari variabel PHP jika $op adalah 'edit'
                    if ('<?php echo $op; ?>' === 'edit' && '<?php echo $design_id; ?>' === designId) {
                        jenisPakaianInput.value = '<?php echo htmlspecialchars($jenis_pakaian); ?>';
                        deskripsiDesignTextarea.value = '<?php echo htmlspecialchars($deskripsi_design); ?>';
                        // Untuk gambar, Anda mungkin perlu menampilkan placeholder atau nama file jika tidak ada unggahan baru
                    } else {
                        // Untuk tombol tambah atau jika ID tidak cocok
                        resetModalForm();
                    }
                } else {
                    modalTitle.textContent = 'Tambah Desain Baru';
                    opInput.value = '';
                    designIdInput.value = '';
                    // Bersihkan form saat membuka modal untuk tambah baru
                    jenisPakaianInput.value = '';
                    deskripsiDesignTextarea.value = '';
                }
            });
        });
    </script>
</body>

</html>