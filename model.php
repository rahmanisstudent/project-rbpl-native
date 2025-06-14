<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Model</title>
    <link rel="stylesheet" href="css/model.css">
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
            <a href="editModel.php?id=1" class="edit">Edit</a>
            <a href="hapusModel.php?id=1" class="hapus">Hapus</a>
        </div>

    </div>
</body>
</html>