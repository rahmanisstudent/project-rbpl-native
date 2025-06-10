<?php
include 'koneksi.php';

$op = "";
$design_id = "";
$jenis_pakaian = "";
$gambar_design = "";
$deskripsi_design = "";

// dijalankan ketika submit ditekan
if (isset($_POST['submit'])) {
    $jenis_pakaian = $_POST['jenis_pakaian'];
    $gambar_design = $_FILES["gambar_design"]["name"];
    $deskripsi_design = $_POST['deskripsi_design'];

    // untuk upload foto
    if (isset($_FILES["foto"])) {
        $file_name = $_FILES["foto"]["name"];
        $file_tmp = $_FILES["foto"]["tmp_name"];
        $file_type = $_FILES["foto"]["type"];
        $file_size = $_FILES["foto"]["size"];
        $file_error = $_FILES["foto"]["error"];

        if ($file_error === 0) {
            $file_destination = "uploads/" . $design_id . "-" . rand(1, 1000) . "_" . $file_name;
            if (!is_dir("uploads")) {
                mkdir("uploads");
            }
            move_uploaded_file($file_tmp, $file_destination);
            $image = $file_destination;
        } else {
            $error = "Gagal mengunggah file";
        }
    }

    //untuk insert data ke database
    if ($design_id && $jenis_pakaian && $gambar_design && $deskripsi_design) {
        if ($op == 'edit') {
            //jika tidak mengupload gambar maka hapus gambar lama
            if ($image == "") {
                $sqlG = "SELECT gambar_design FROM design WHERE id = '$id'"; // ini berguna pas nanti untuk edit sih, nanti diatur
                $qG = mysqli_query($connect, $sqlG);
                $row = mysqli_fetch_assoc($qG);
                $imagePath = isset($row['image']) ? $row['image'] : '';
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }
            $edit = true;
            $sql = "UPDATE review SET rating='$rating', date='$date', id_resto='$id_resto', nama_resto='$nama_resto', pesan='$pesan', image='$image', user_id='$user_id', edited ='$edit'  WHERE id = $id";
            $query = mysqli_query($connect, $sql);
            if ($query) {
                header("location:detail.php?resto=$id_resto&op=ulasan_edit");
            } else {
                echo "<script>alert('Data gagal diubah');</script>";
            }
        } else {
            $sql = "INSERT INTO design (jenis_pakaian, deskripsi_design, gambar_design,) VALUES ('$jenis_pakaian', '$deskripsi_design', '$gambar_design')";
            $query = mysqli_query($connect, $sql);
            if ($query) {
                header("location:detail.php?resto=$id_resto&op=ulasan_sukses");
            } else {
                echo "<script>alert('Data gagal ditambahkan');</script>";
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
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <!-- CSS -->
    <link rel="stylesheet" href="css/katalog.css">
</head>

<body>
    <?php include 'nav.php'; ?>
    <!-- ini yang buat jadi di tengah-tengah -->
    <div class="container my-4">
        <div class="row row-cols-2 row-cols-md-2 g-4">
            <!-- List desain (output) -->
            <?php
            $sql = "SELECT * FROM design ORDER BY design_id ASC";
            $q = mysqli_query($connect, $sql);
            while ($r = mysqli_fetch_array($q)) { ?>
                <div class="resto-item">
                    <img src="img/grid<?php echo $r['id_resto'] ?>.jpg" alt="restoran">
                    <div class="resto-details">
                        <h3><?php echo $r['jenis_pakaian'] ?></h3>
                        <p style="color: green; font-weight: bold;"><?php echo $r['jenis_pakaian'] ?></p>
                        <p
                            style="color: black; opacity: 0.6; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">
                            <?php echo $r['deskripsi_design'] ?>
                        </p>
                    </div>
                </div>
            <?php } ?>
        </div>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#popupInput">+</button>

        <!-- modal -->
        <div class="modal fade" id="popupInput" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Modal title</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Form input desain -->
                        <form action="" method="POST" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="jenis_pakaian" class="form-label">Jenis pakaian</label>
                                <input type="text" class="form-control" id="jenis_pakaian" name="jenis_pakaian"
                                    placeholder="Contoh: Daster, Dress, dll"
                                    value="<?php echo htmlspecialchars($jenis_pakaian); ?>">
                            </div>

                            <div class="mb-3">
                                <label for="deskripsi_design" class="form-label">Deskripsi desain</label>
                                <textarea class="form-control" id="deskripsi_design" name="deskripsi_design"
                                    rows="3"><?php echo htmlspecialchars($deskripsi_design); ?></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="gambar_design" class="form-label">Input file gambar</label>
                                <input class="form-control" type="file" id="gambar_design" name="gambar_design">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" value="submit">Submit</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO"
        crossorigin="anonymous"></script>
</body>
<!-- Alternatif lain -->
<!-- Yang ini pake dropdown -->
<!-- <div class="btn-group">
<button type="button" class="btn btn-info dropdown-toggle" data-bs-toggle="dropdown"
    aria-expanded="false">
    Jenis Pakaian
</button>
<ul class="dropdown-menu">
    <li><a class="dropdown-item" href="#">Action</a></li>
    <li><a class="dropdown-item" href="#">Another action</a></li>
    <li><a class="dropdown-item" href="#">Something else here</a></li>
    <li>
        <hr class="dropdown-divider">
    </li>
    <li><a class="dropdown-item" href="#">Separated link</a></li>
</ul>
</div> -->

</html>