<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    // Belum login → arahkan ke form login
    header('Location: login.php');
    exit;
}
include 'koneksi.php';

$op = ""; // Untuk operasi edit/insert/delete
$design_id = "";
$jenis_pakaian = "";
$gambar_design = "";
$deskripsi_design = "";
$success = "";
$error = "";

// --- Handle DELETE Operation ---
if (isset($_GET['op']) && $_GET['op'] == 'delete') {
    $design_id_to_delete = $_GET['id'];
    // Yang ini kayaknya untuk ngambil alamat gambar deh
    $sql_get_image = "SELECT gambar_design FROM design WHERE design_id = ?";
    $stmt_get_image = mysqli_prepare($connect, $sql_get_image);
    if ($stmt_get_image) {
        mysqli_stmt_bind_param($stmt_get_image, "i", $design_id_to_delete);
        mysqli_stmt_execute($stmt_get_image);
        mysqli_stmt_bind_result($stmt_get_image, $image_path_to_delete);
        mysqli_stmt_fetch($stmt_get_image);
        mysqli_stmt_close($stmt_get_image);

        // Hapus dari database
        $sql_delete = "DELETE FROM design WHERE design_id = ?";
        $stmt_delete = mysqli_prepare($connect, $sql_delete);
        if ($stmt_delete) {
            mysqli_stmt_bind_param($stmt_delete, "i", $design_id_to_delete);
            if (mysqli_stmt_execute($stmt_delete)) {
                // Ini menghapus gambarnya dari uploads/
                if (!empty($image_path_to_delete) && file_exists($image_path_to_delete)) {
                    unlink($image_path_to_delete);
                }
                $success = "Data desain berhasil dihapus.";
            } else {
                $error = "Data gagal dihapus: " . mysqli_error($connect);
            }
            mysqli_stmt_close($stmt_delete);
        } else {
            $error = "Gagal menyiapkan statement DELETE: " . mysqli_error($connect);
        }
    } else {
        $error = "Gagal menyiapkan statement untuk mengambil gambar: " . mysqli_error($connect);
    }
    // Ngebersihin URL
    header("Location: katalog.php?success=" . urlencode($success) . "&error=" . urlencode($error));
    exit();
}

// ceking status sukses atau error
if (isset($_GET['success'])) {
    $success = $_GET['success'];
}
if (isset($_GET['error'])) {
    $error = $_GET['error'];
}



// Ambil data untuk diedit berdasarkan design_id (untuk edit)
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

// Dijalankan untuk edit/insert
if (isset($_POST['submit'])) {
    $op = $_POST['op'] ?? '';
    $design_id = $_POST['design_id'] ?? '';

    $jenis_pakaian = $_POST['jenis_pakaian'];
    $deskripsi_design = $_POST['deskripsi_design'];

    $image_path = "";

    // Untuk ambil alamat gambar lama (kayak yang di atas)
    if ($op == 'edit' && empty($_FILES["gambar_design"]["name"])) {
        $sql_get_old_image = "SELECT gambar_design FROM design WHERE design_id = ?";
        $stmt_get_old_image = mysqli_prepare($connect, $sql_get_old_image);
        if ($stmt_get_old_image) {
            mysqli_stmt_bind_param($stmt_get_old_image, "i", $design_id);
            mysqli_stmt_execute($stmt_get_old_image);
            mysqli_stmt_bind_result($stmt_get_old_image, $old_image);
            mysqli_stmt_fetch($stmt_get_old_image);
            mysqli_stmt_close($stmt_get_old_image);
            $image_path = $old_image;
        }
    }

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
    }


    // Validasi input
    if (empty($jenis_pakaian) || empty($deskripsi_design) || empty($image_path)) {
        $error = "Pastikan semua data terisi dan gambar telah diunggah.";
    } else {
        if ($op == 'edit') {
            // Hapus gambar lama jika ada gambar baru diunggah
            if (!empty($_FILES["gambar_design"]["name"]) && !empty($gambar_design) && file_exists($gambar_design)) {
                unlink($gambar_design); //baris yang bertanggung jawab untuk menghapus gambar di uploads/
            }

            $sql = "UPDATE design SET jenis_pakaian=?, deskripsi_design=?, gambar_design=? WHERE design_id=?";
            $stmt = mysqli_prepare($connect, $sql);
            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "sssi", $jenis_pakaian, $deskripsi_design, $image_path, $design_id);
                if (mysqli_stmt_execute($stmt)) {
                    $success = "Data desain berhasil diubah.";

                    // Ngebersihin URL
                    header("Location: katalog.php?success=" . urlencode($success));
                    exit();
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

                    // Ngebersihin URL
                    $jenis_pakaian = "";
                    $gambar_design = "";
                    $deskripsi_design = "";
                    header("Location: katalog.php?success=" . urlencode($success));
                    exit();
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
        <h1>Katalog Model</h1>
        <?php
        if ($error) {
            echo '<div class="alert alert-danger" role="alert">' . $error . '</div>';
        }
        if ($success) {
            echo '<div class="alert alert-success" role="alert">' . $success . '</div>';
        }
        ?>
        <div class="row mx-auto row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <?php
            $sql = "SELECT * FROM design ORDER BY design_id ASC";
            $q = mysqli_query($connect, $sql);
            while ($r = mysqli_fetch_array($q)) { ?>
                <div class="col">
                    <div class="card mx-auto h-100 resto-item">
                        <a href="model.php?id=<?php echo $r['design_id']; ?>"> <!-- Link ke detail.php -->
                            <img src="<?php echo htmlspecialchars($r['gambar_design']); ?>" class="card-img-top"
                                alt="Desain Pakaian">
                        </a>
                        <div class="card-body resto-details">
                            <a href="model.php?id=<?php echo $r['design_id']; ?>"> <!-- Link ke detail.php -->
                                <h5 class="card-title text-truncate"><?php echo htmlspecialchars($r['jenis_pakaian']); ?>
                                </h5>
                                <p class="card-text text-light opacity-75 text-truncate">
                                    <?php echo htmlspecialchars($r['deskripsi_design']); ?>
                                </p>
                            </a>
                            <div class="d-flex justify-content-between mt-3">
                                <button type="button" id="edit" class="btn btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#popupInput" data-bs-op="edit"
                                    data-bs-id="<?php echo $r['design_id']; ?>"
                                    data-jenis-pakaian="<?php echo htmlspecialchars($r['jenis_pakaian']); ?>"
                                    data-deskripsi-design="<?php echo htmlspecialchars($r['deskripsi_design']); ?>"
                                    data-gambar-design="<?php echo htmlspecialchars($r['gambar_design']); ?>">
                                    Edit
                                </button>
                                <a href="?op=delete&id=<?php echo $r['design_id']; ?>" id="delete" class="btn btn-sm"
                                    onclick="return confirm('Apakah Anda yakin ingin menghapus desain ini?')">Delete</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>

        <div class="modal fade" id="popupInput" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel"></h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="POST" enctype="multipart/form-data" id="designForm">
                            <input type="hidden" name="op" id="opInput">
                            <input type="hidden" name="design_id" id="designIdInput">
                            <div class="mb-3">
                                <label for="jenis_pakaian_modal" class="form-label">Jenis pakaian</label>
                                <input type="text" class="form-control" id="jenis_pakaian_modal" name="jenis_pakaian"
                                    placeholder="Contoh: Daster, Dress, dll" required>
                            </div>

                            <div class="mb-3">
                                <label for="deskripsi_design_modal" class="form-label">Deskripsi desain</label>
                                <textarea class="form-control" id="deskripsi_design_modal" name="deskripsi_design"
                                    rows="3" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="gambar_design_modal" class="form-label">Input file gambar</label>
                                <input class="form-control" type="file" id="gambar_design_modal" name="gambar_design">
                                <small class="form-text text-muted" id="current_image_text" style="display:none;">Gambar
                                    saat ini: <a href="#" target="_blank" id="current_image_link">Lihat
                                        Gambar</a></small>
                                <small class="form-text text-muted" id="image_required_text">Gambar wajib
                                    diunggah.</small>
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

        <div class="add-task" data-bs-toggle="modal" data-bs-target="#popupInput" data-bs-op="insert">
            <p>+</p>
        </div>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO"
        crossorigin="anonymous"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var popupInputModal = document.getElementById('popupInput');
            var modalTitle = popupInputModal.querySelector('.modal-title');
            var opInput = popupInputModal.querySelector('#opInput');
            var designIdInput = popupInputModal.querySelector('#designIdInput');
            var jenisPakaianInput = popupInputModal.querySelector('#jenis_pakaian_modal');
            var deskripsiDesignTextarea = popupInputModal.querySelector('#deskripsi_design_modal');
            var gambarDesignInput = popupInputModal.querySelector('#gambar_design_modal');
            var currentImageText = popupInputModal.querySelector('#current_image_text');
            var currentImageLink = popupInputModal.querySelector('#current_image_link');
            var imageRequiredText = popupInputModal.querySelector('#image_required_text');

            popupInputModal.addEventListener('show.bs.modal', function (event) {
                var button = event.relatedTarget;
                var op = button.getAttribute('data-bs-op'); // JS yang ngambil op = edit/insert

                // Reset form di modal
                document.getElementById('designForm').reset();
                currentImageText.style.display = 'none';
                gambarDesignInput.required = true; // Diwajibin untuk input gambar
                imageRequiredText.style.display = 'block';


                if (op === 'edit') {
                    modalTitle.textContent = 'Edit Desain';
                    opInput.value = 'edit';

                    // Ambil data dari atribut button
                    var designId = button.getAttribute('data-bs-id');
                    var jenisPakaian = button.getAttribute('data-jenis-pakaian');
                    var deskripsiDesign = button.getAttribute('data-deskripsi-design');
                    var gambarDesign = button.getAttribute('data-gambar-design');

                    designIdInput.value = designId;
                    jenisPakaianInput.value = jenisPakaian;
                    deskripsiDesignTextarea.value = deskripsiDesign;

                    // Ini ngasihin nilai (link gambar) untuk nanti di display di bawahnya poupedit
                    if (gambarDesign) {
                        currentImageLink.href = gambarDesign;
                        currentImageText.style.display = 'block';
                        gambarDesignInput.required = false; // Ini sebenernya perlu gaperlu sih....
                        imageRequiredText.style.display = 'none';
                    } else {
                        gambarDesignInput.required = true; // Ini juga perlu gaperlu sihh kyaknya...
                        imageRequiredText.style.display = 'block';
                    }

                } else {
                    // Handling, dijadiin op-nya insert
                    modalTitle.textContent = 'Tambah Desain Baru';
                    opInput.value = 'insert';
                    designIdInput.value = '';
                }
            });
        });
    </script>
</body>

</html>