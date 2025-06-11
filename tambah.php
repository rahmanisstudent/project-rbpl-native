<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "jahit";

$koneksi = mysqli_connect($host, $user, $pass, $db);
if (!$koneksi) {
    die("Tidak bisa terkoneksi ke database");
}

$nama_pelanggan = "";
$nomor_telepon = "";
$alamat = "";
$jenis_model = "";
$quantity = "";
$opsi_pengambilan = "";
$catatan = "";
$tanggal_mulai = "";
$tanggal_selesai = "";
$status_pengerjaan = "-";
$success = "";
$error = "";

// Proses form jika disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_pelanggan = $_POST['nama_pelanggan'] ?? '';
    $nomor_telepon = $_POST['nomor_telepon'] ?? '';
    $alamat = $_POST['alamat'] ?? '';
    $jenis_model = $_POST['jenis_model'] ?? '';
    $quantity = $_POST['quantity'] ?? '';
    $opsi_pengambilan = $_POST['opsi_pengambilan'] ?? '';
    $catatan = $_POST['catatan'] ?? '';
    $tanggal_mulai = $_POST['tanggal_mulai'] ?? '';
    $tanggal_selesai = $_POST['tanggal_selesai'] ?? '';

    // Ambil data ukuran dari input dinamis
    $ukuran_data = [];
    foreach ($_POST as $key => $value) {
        if (strpos($key, 'ukuran_') === 0) {
            if (isset($value) && $value !== '') {
                $ukuran_name = str_replace('ukuran_', '', $key);
                $ukuran_name_readable = ucwords(str_replace('-', ' ', $ukuran_name));
                $ukuran_data[$ukuran_name_readable] = $value;
            }
        }
    }

    // Convert ukuran_data to a comma-separated string
    $ukuran_string_parts = [];
    foreach ($ukuran_data as $name => $value) {
        $ukuran_string_parts[] = "$name: $value";
    }
    $ukuran_final_string = implode(', ', $ukuran_string_parts);

    // // Simpan ukuran sebagai JSON
    // $ukuran_json = json_encode($ukuran_data);

    // Validasi sederhana
    if (
        empty($nama_pelanggan) ||
        empty($nomor_telepon) ||
        empty($alamat) ||
        empty($jenis_model) ||
        empty($quantity) ||
        empty($opsi_pengambilan) ||
        empty($tanggal_mulai) ||
        empty($tanggal_selesai)
    ) {
        $error = "Semua field wajib diisi.";
    } else {
        // Query insert ke tabel pesanan (ganti nama tabel & kolom sesuai kebutuhan)
        $sql = "INSERT INTO pesanan 
            (nama_pelanggan, nomor_telepon, alamat, jenis_model, quantity, opsi_pengambilan, ukuran, catatan, tanggal_mulai, tanggal_selesai, status_pengerjaan)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = mysqli_prepare($koneksi, $sql);
        if ($stmt) {
            mysqli_stmt_bind_param(
                $stmt,
                "ssssissssss",
                $nama_pelanggan,
                $nomor_telepon,
                $alamat,
                $jenis_model,
                $quantity,
                $opsi_pengambilan,
                $ukuran_final_string, // Use the final string of ukuran
                $catatan,
                $tanggal_mulai,
                $tanggal_selesai,
                $status_pengerjaan
            );
            if (mysqli_stmt_execute($stmt)) {
                $success = "Data pesanan berhasil ditambahkan.";
                // Reset form value
                $nama_pelanggan = $nomor_telepon = $alamat = $jenis_model = $quantity = $opsi_pengambilan = $catatan = $tanggal_mulai = $tanggal_selesai = "";
            } else {
                $error = "Gagal menambah data: " . mysqli_error($koneksi);
            }
            mysqli_stmt_close($stmt);
        } else {
            $error = "Gagal menyiapkan statement: " . mysqli_error($koneksi);
        }
    }
}
?>
<?php if ($success): ?>
    <div class="success"><?php echo $success; ?></div>
<?php endif; ?>
<?php if ($error): ?>
    <div class="error"><?php echo $error; ?></div>
<?php endif; ?>

<html lang="en">

<head>

    <meta charset="UTF-8" />

    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Sistem Informasi Penjahit</title>

    <link rel="stylesheet" href="css/tambah.css" />
    <link rel="stylesheet" href="css/nyoba.css">
</head>

<body>
    <?php include 'nav.php' ?>
    <form action="" method="POST">
        <h1>Tambah Data</h1>
        <ul>
            <li>
                <label for="nama-pemesan">
                    Nama Pemesan
                    <input type="text" id="nama-pemesan" name="nama_pelanggan" placeholder="Tuliskan Nama Pelanggan"
                        autocomplete="off" value="<?php echo $nama_pelanggan; ?>" />
                </label>
            </li>
            <li>
                <label for="nomor-telepon">
                    Nomor Telepon
                    <input type="number" id="nomor-telepon" name="nomor_telepon" placeholder="Tuliskan Nomor Telepon"
                        autocomplete="off" value="<?php echo $nomor_telepon; ?>" />
                </label>
            </li>
            <li>
                <label for="alamat">
                    Alamat
                    <input type="text" id="alamat" name="alamat" placeholder="Tuliskan Alamat" autocomplete="off"
                        value="<?php echo $alamat; ?>" />
                </label>
            </li>
            <li>
                <label for="jenis-model">
                    Jenis Model
                    <select id="jenis-model" name="jenis_model" aria-label="Jenis Model">
                        <?php
                        $query = "SELECT jenis_pakaian FROM design";
                        $result = mysqli_query($koneksi, $query);
                        while ($row = mysqli_fetch_assoc($result)) { ?>
                            <option value="<?php echo htmlspecialchars($row['jenis_pakaian']); ?>" <?php if ($jenis_model == $row['jenis_pakaian'])
                                   echo "selected"; ?>>
                                <?php echo htmlspecialchars($row['jenis_pakaian']); ?>
                            </option>
                        <?php } ?>
                    </select>
                </label>
            </li>
            <li>
                <label for="quantity">
                    Quantity
                    <input type="number" id="quantity" name="quantity" class="small" autocomplete="off"
                        value="<?php echo $quantity; ?>" />
                </label>
            </li>
            <li>
                <label for="opsi-pengambilan">
                    Opsi Pengambilan
                    <select id="opsi-pengambilan" name="opsi_pengambilan" aria-label="Opsi Pengambilan">
                        <option value="Ambil di tempat" <?php if ($opsi_pengambilan == "Ambil di tempat")
                            echo "selected"; ?>>Ambil di
                            tempat</option>
                        <option value="Pesanan diantar" <?php if ($opsi_pengambilan == "Pesanan diantar")
                            echo "selected"; ?>>Pesanan
                            diantar</option>
                    </select>
                </label>
            </li>
            <li>
                <label class="ukuran-label" for="ukuran-checkbox">
                    <a href="javascript:void(0);" onclick="showPopup()"><span class="ukuran-icon">+</span></a>
                    Ukuran <sup>(cm)</sup>
                </label>
                <div class="ukuran-inputs">
                    <ul id="ukuran-list">
                    </ul>
                </div>
            </li>
            <li>
                <?php include 'pilih_tanggal.php'; ?>
            </li>
            <li>
                <label for="catatan" id="label-catatan">
                    Catatan
                    <textarea id="catatan" name="catatan" rows="3" autocomplete="off"><?php echo $catatan; ?></textarea>
                </label>
            </li>
        </ul>
        <button type="submit" class="sub-but">
            Submit
        </button>
    </form>

    <div id="popup-ukuran"
        style="display:none; position:fixed; top:0; left:0; width:100vw; height:100vh; background:rgba(0,0,0,0.4); z-index:9999; justify-content:center; align-items:center;">
        <div style="background:#fff; padding:24px; border-radius:8px; min-width:300px; position:relative;">
            <button onclick="closePopup()"
                style="position:absolute; top:8px; right:8px; background:none; border:none; font-size:18px; cursor:pointer;">&times;</button>
            <h3>Tambah Ukuran Baru</h3>
            <div id="ukuran-buttons-container">
                <button type="button" class="ukuran-button">Lingkar Tangan</button>
                <button type="button" class="ukuran-button">Panjang Lengan Atas</button>
                <button type="button" class="ukuran-button">Panjang Lengan Bawah</button>
                <button type="button" class="ukuran-button">Lingkar Perut</button>
                <button type="button" class="ukuran-button">Lingkar Pinggang</button>
                <button type="button" class="ukuran-button">Panjang Bahu</button>
                <button type="button" class="ukuran-button">Lingkar Bahu</button>
                <button type="button" class="ukuran-button">Lingkar Paha</button>
                <button type="button" class="ukuran-button">Panjang Paha</button>
                <button type="button" class="ukuran-button">Panjang Kaki</button>
                <button type="button" class="ukuran-button">Lingkar Kaki</button>
            </div>
        </div>
    </div>


    <script>
        function showPopup() {
            document.getElementById('popup-ukuran').style.display = 'flex';
        }

        function closePopup() {
            document.getElementById('popup-ukuran').style.display = 'none';
        }

        document.addEventListener('DOMContentLoaded', function () {
            const ukuranButtons = document.querySelectorAll('.ukuran-button');
            const ukuranList = document.getElementById('ukuran-list');
            const addedUkuran = new Set(); // To keep track of already added ukuran types

            ukuranButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const ukuranName = this.textContent;
                    const inputId = ukuranName.toLowerCase().replace(/\s/g, '-'); // Create a unique ID for the input

                    // Check if the input field already exists to prevent duplicates
                    if (addedUkuran.has(ukuranName)) {
                        console.log(`${ukuranName} is already added.`);
                        closePopup();
                        return;
                    }

                    // Create list item
                    const listItem = document.createElement('li');
                    listItem.className = 'ukuran-input-item'; // Add a class for styling if needed

                    // Create label
                    const label = document.createElement('label');
                    label.htmlFor = inputId;
                    label.textContent = ukuranName;

                    // Create input field
                    const input = document.createElement('input');
                    input.type = 'number'; // Assuming size will be a number (cm)
                    input.id = inputId;
                    input.name = `ukuran_${inputId}`; // Unique name for PHP processing (e.g., ukuran_lingkar-tangan)
                    input.className = 'small';
                    input.placeholder = `Masukkan ${ukuranName} (cm)`;
                    input.autocomplete = 'off';

                    // Create remove button
                    const removeButton = document.createElement('button');
                    removeButton.type = 'button';
                    removeButton.textContent = 'x';
                    removeButton.className = 'remove-ukuran-button';
                    removeButton.onclick = function () {
                        ukuranList.removeChild(listItem);
                        addedUkuran.delete(ukuranName); // Remove from the set
                    };

                    // Append elements
                    listItem.appendChild(label);
                    listItem.appendChild(input);
                    listItem.appendChild(removeButton); // Add the remove button
                    ukuranList.appendChild(listItem);

                    addedUkuran.add(ukuranName); // Add to the set of added ukuran

                    closePopup(); // Close the popup after adding the input
                });
            });
        });
    </script>
</body>

</html>