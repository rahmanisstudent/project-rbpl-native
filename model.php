<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Model</title>
    <link rel="stylesheet" href="css/model.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
</head>
<body>
    <?php include 'nav.php'; ?>

    <div class="container">
        <div class="judul">
            <h3>Model Pakaian</h3>
            <h1>Dress Pesta</h1>
        </div>
        <div class="next-prev">
            <a href="model.php?id=1" class="previous">&laquo;</a>
            <a href="model.php?id=2" class="next">&raquo;</a>
        </div>
        <div class="gambar">
            <img src="uploads/6849b08ad576f_1749659786.png" alt="Dress Pesta" class="model-image">
        </div>
        <div class="templateUkuran">
            <H4>Template Ukuran:</H4>
        </div>
        <div class="catatan">
            <H4>Deskripsi Design:</H4>
            <p class="deskripsi">
                Lorem ipsum dolor, sit amet consectetur adipisicing elit. Adipisci, quam provident quaerat ea placeat doloremque officiis vitae illo assumenda explicabo aliquid ex, voluptatem nam eveniet facilis voluptates. Sunt, distinctio quidem?
            </p>
        </div>
        <div class="aksi">

            <!-- INI MANGGIL POPUPNYA NYONTEK DARI KATALOG.PHP, CUMA MASI BELOM BENER BENER JADI, PLIS LIAT INI, JADIKAN MAN PLISS -->
             
            <a type="button" data-bs-toggle="modal" data-bs-target="#popupInput" data-bs-op="edit" class="edit">Edit</a>
            <a href="hapusModel.php?id=1" class="hapus">Hapus</a>
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