<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Sistem Informasi Penjahit</title>
    <!-- <link rel="stylesheet" href="css/tambah.css"/> -->
</head>
<body>
  <?php include 'nav.php' ?>

  <form>
    <h1>Tambah Data</h1>
    <ul>
      <li>
        <label for="nama-pemesan">
          Nama Pemesan
          <input
            type="text"
            id="nama-pemesan"
            name="nama-pemesan"
            placeholder="Tuliskan Nama Pelanggan"
            autocomplete="off"
          />
        </label>
      </li>
      <li>
        <label for="nomor-telepon">
          Nomor Telepon
          <input
            type="text"
            id="nomor-telepon"
            name="nomor-telepon"
            placeholder="Tuliskan Nomor Telepon"
            autocomplete="off"
          />
        </label>
      </li>
      <li>
        <label for="alamat">
          Alamat
          <input
            type="text"
            id="alamat"
            name="alamat"
            placeholder="Tuliskan Alamat"
            autocomplete="off"
          />
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
          <input
            type="text"
            id="quantity"
            name="quantity"
            class="small"
            autocomplete="off"
          />
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
          <span class="ukuran-icon">+</span>
          Ukuran<sup>cm</sup>
        </label>
        <div class="ukuran-inputs">
          <ul>
            <li>
              <label for="lingkar-tangan">
                Lingkar Tangan
                <input
                  type="text"
                  id="lingkar-tangan"
                  name="lingkar-tangan"
                  class="small"
                  autocomplete="off"
                />
              </label>
            </li>
            <li>
              <label for="panjang-lengan-atas">
                Panjang Lengan Atas
                <input
                  type="text"
                  id="panjang-lengan-atas"
                  name="panjang-lengan-atas"
                  class="small"
                  autocomplete="off"
                />
              </label>
            </li>
            <li>
              <label for="panjang-lengan-bawah">
                Panjang Lengan Bawah
                <input
                  type="text"
                  id="panjang-lengan-bawah"
                  name="panjang-lengan-bawah"
                  class="small"
                  autocomplete="off"
                />
              </label>
            </li>
            <li>
              <label for="lebar-bahu">
                Lebar Bahu
                <input
                  type="text"
                  id="lebar-bahu"
                  name="lebar-bahu"
                  class="small"
                  autocomplete="off"
                />
              </label>
            </li>
            <li>
              <label for="lingkar-pinggang">
                Lingkar Pinggang
                <input
                  type="text"
                  id="lingkar-pinggang"
                  name="lingkar-pinggang"
                  class="small"
                  autocomplete="off"
                />
              </label>
            </li>
          </ul>
        </div>
      </li>
      <li>
        <label for="tanggal-pengerjaan">
          Pilih Tanggal Pengerjaan
          <select id="tanggal-pengerjaan" name="tanggal-pengerjaan" aria-label="Pilih Tanggal Pengerjaan">
            <option value="" selected disabled></option>
          </select>
        </label>
      </li>
      <li>
        <label for="catatan" style="display: block; margin-top: 8px; color: #a3b0d1; font-size: 14px; line-height: 18px;">
          Catatan
          <textarea id="catatan" name="catatan" rows="3" autocomplete="off"></textarea>
        </label>
      </li>
    </ul>
  </form>
</body>
</html>