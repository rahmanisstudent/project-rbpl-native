<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pesanan</title>
    <link rel="stylesheet" href="css/detail.css">
</head>
<body>
    <?php include 'nav.php'; ?>
    <div class="container">
        <h1>Detail Pesanan</h1>
        <div class="parent">
            <div class="div1">
                <label for="ID">ID Pesanan</label>
                <h3>DC004</h3>
            </div>
            <div class="div2">
                <label for="status">Status</label>
                <select id="status" name="status">
                    <option value="-">-</option>
                    <option value="Pemotongan">Pemotongan</option>
                    <option value="Penjahitan">Penjahitan</option>
                    <option value="Finishing">Finishing</option>
                    <option value="Selesai">Selesai</option>
                </select>
            </div>
            <div class="div3">
                <label for="Nama Pemesan">Nama Pemesan</label>
            </div>
            <div class="div4">
                <h3>Ibu Walidi</h3>
            </div>
            <div class="div5">
                <label for="Nomor Telepon">No. Telepon</label>
            </div>
            <div class="div6">
                <h3>08123456789</h3>
            </div>
            <div class="div7">
                <label for="tanggal pemesanan">Tanggal Pemesanan</label>
                <div class="kotakan">
                    <h3>12 Jun 2025</h3>
                </div>
            </div>
            <div class="div8">
                <label for="tanggal pemesanan">Tanggal Pemesanan</label>
                <div class="kotakan">
                    <h3>23 Jun 2025</h3>
                </div>
            </div>
            <div class="div9">
                <div class="kotakan">
                    <a onclick="alert('Keluar pop up ceritanya')">
                        <h3 class="detail-pakaian">
                            Detail Pakaian
                        </h3>
                    </a>
                </div>
            </div>
            <div class="div10">
                <label for="alamat">Alamat</label>
                <div class="kotakan">
                    <p>Jl. Jalan 18, RT 8, RW 71</p>
                </div>
            </div>
            <div class="div11">
                <label for="catatan">Catatan Pelanggan</label>
                <div class="kotakan">
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. sfasdfsasfsgawegwegwegwega</p>
                </div>
            </div>
        </div>
        <div class="tombol">
            <button class="batal">
                <a href="index.php">BATAL</a>
            </button>
            <button class="simpan">
                <a href="index.php">SIMPAN</a>
            </button>
        </div>
    </div>
    
</body>
</html>