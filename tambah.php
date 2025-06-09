<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Sistem Informasi Penjahit</title>
  <link rel="stylesheet" href="css/tambah.css"/>
</head>

<body>
  <?php include 'nav.php' ?>

  <form>
    <h1>Tambah Data</h1>
    <ul>
      <li>
        <label for="nama-pemesan">
          Nama Pemesan
          <input type="text" id="nama-pemesan" name="nama-pemesan" placeholder="Tuliskan Nama Pelanggan"
            autocomplete="off" />
        </label>
      </li>
      <li>
        <label for="nomor-telepon">
          Nomor Telepon
          <input type="text" id="nomor-telepon" name="nomor-telepon" placeholder="Tuliskan Nomor Telepon"
            autocomplete="off" />
        </label>
      </li>
      <li>
        <label for="alamat">
          Alamat
          <input type="text" id="alamat" name="alamat" placeholder="Tuliskan Alamat" autocomplete="off" />
        </label>
      </li>
      <li>
        <label for="jenis-model">
          Jenis Model
          <select id="jenis-model" name="jenis-model" aria-label="Jenis Model">
            <option value="" selected disabled></option>
          </select>
        </label>
      </li>
      <li>
        <label for="quantity">
          Quantity
          <input type="text" id="quantity" name="quantity" class="small" autocomplete="off" />
        </label>
      </li>
      <li>
        <label for="opsi-pengambilan">
          Opsi Pengambilan
          <select id="opsi-pengambilan" name="opsi-pengambilan" aria-label="Opsi Pengambilan">
            <option value="" selected disabled></option>
          </select>
        </label>
      </li>
      <li>
        <label class="ukuran-label" for="ukuran-checkbox">
          <a href="javascript:void(0);" onclick="showPopup()"><span class="ukuran-icon">+</span></a>
          Ukuran<sup>cm</sup>
        </label>
        <div class="ukuran-inputs">
          <ul>
            <li>
              <label for="lingkar-tangan">
                Lingkar Tangan <br>
                <input type="text" id="lingkar-tangan" name="lingkar-tangan" class="small" autocomplete="off" />
              </label>
            </li>
            <li>
              <label for="panjang-lengan-atas">
                Panjang Lengan Atas <br>
                <input type="text" id="panjang-lengan-atas" name="panjang-lengan-atas" class="small"
                  autocomplete="off" />
              </label>
            </li>
            <li>
              <label for="panjang-lengan-bawah">
                Panjang Lengan Bawah <br>
                <input type="text" id="panjang-lengan-bawah" name="panjang-lengan-bawah" class="small"
                  autocomplete="off" />
              </label>
            </li>
            <li>
              <label for="lebar-bahu">
                Lebar Bahu <br>
                <input type="text" id="lebar-bahu" name="lebar-bahu" class="small" autocomplete="off" />
              </label>
            </li>
            <li>
              <label for="lingkar-pinggang">
                Lingkar Pinggang<br>
                <input type="text" id="lingkar-pinggang" name="lingkar-pinggang" class="small" autocomplete="off" />
              </label>
            </li>
          </ul>
        </div>
      </li>
      <li>
          <?php include 'nyoba.php' ?>  <!--gatau kenapa ga bisa-->
      </li>
      <li>
        <label for="catatan" id="label-catatan">
            Catatan
          <textarea id="catatan" name="catatan" rows="3" autocomplete="off"></textarea>
        </label>
      </li>
    </ul>
    <button type="submit" class="sub-but">
      Submit
    </button>
  </form>

  <!-- POP UP WINDOW -->
  <div id="popup-ukuran" style="display:none; position:fixed; top:0; left:0; width:100vw; height:100vh; background:rgba(0,0,0,0.4); z-index:9999; justify-content:center; align-items:center;">
    <div style="background:#fff; padding:24px; border-radius:8px; min-width:300px; position:relative;">
      <button onclick="closePopup()" style="position:absolute; top:8px; right:8px; background:none; border:none; font-size:18px; cursor:pointer;">&times;</button>
      <h3>Tambah Ukuran Baru</h3>
      <?php include 'ukuran.php'?>
      <!-- Tambahkan form atau input lain sesuai kebutuhan -->
    </div>
  </div>
  <script>
    function showPopup() {
      document.getElementById('popup-ukuran').style.display = 'flex';
    }
    function closePopup() {
      document.getElementById('popup-ukuran').style.display = 'none';
    }
    function showDateInput(select) {
        var container = document.getElementById('tanggal-date-container');
        if (select.value === 'manual') {
          container.style.display = 'inline';
          document.getElementById('tanggal-date').focus();
        } else {
          container.style.display = 'none';
          document.getElementById('tanggal-date').value = '';
        }
    }

  </script>
</body>

</html>