<?php
// Include database connection
include 'koneksi.php';

// Get the model ID from the URL
$id = isset($_GET['id']) ? $_GET['id'] : 1; // Default to 1 if not set

// Fetch model data from the database
$sql = "SELECT * FROM design WHERE design_id = ?";
$stmt = $connect->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$model = $result->fetch_assoc();
if (!$model) {
    echo "<script>alert('Model not found.'); window.location.href='katalog.php';</script>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Model</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <link rel="stylesheet" href="css/model.css">
</head>

<body>
    <?php include 'nav.php'; ?>

    <div class="container">
        <div class="judul">
            <h5>Model Pakaian</h5>
            <h1>
                <?php echo htmlspecialchars($model['jenis_pakaian']); ?>
            </h1>
        </div>
        <div class="next-prev">
            <a href="model.php?id=<?php echo max(1, $id - 1); ?>" class="previous">&laquo;</a>
            <a href="model.php?id=<?php echo $id + 1; ?>" class="next">&raquo;</a>
        </div>
        <div class="gambar">
            <img src="<?php echo htmlspecialchars($model['gambar_design']); ?>" alt="Dress Pesta" class="model-image">
        </div>
        <div class="templateUkuran">
            <h5>Template Ukuran:</h5>
        </div>
        <div class="deskripsi">
            <h5>Deskripsi Design:</h5>
            <p>
                <?php echo htmlspecialchars($model['deskripsi_design']); ?>
            </p>
        </div>
    </div>

    <!-- Bootstrap JS (wajib untuk modal) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>