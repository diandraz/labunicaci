<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Laboratorium</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- AdminLTE -->
    <link rel="stylesheet" href="<?= base_url('adminlte/AdminLTE-3.2.0/plugins/fontawesome-free/css/all.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('adminlte/AdminLTE-3.2.0/dist/css/adminlte.min.css') ?>">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&family=Poppins:wght@400;600&display=swap" rel="stylesheet">

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Custom Style -->
    <style>
       body {
            font-family: 'Poppins', 'Inter', sans-serif;
            background: url('<?= base_url('adminlte/AdminLTE-3.2.0/dist/img/6.jpg') ?>') no-repeat center center fixed !important;
            background-size: cover !important;
        }
        .wrapper, .content-wrapper {
            background: transparent !important;
        }
        .section-title {
            font-size: 1.2rem;
            font-weight: 500;
            border-left: 4px solidrgb(255, 255, 255);
            padding-left: 10px;
            color:rgb(252, 252, 252);
        }
        .dashboard-title {
            font-weight: 600;
            font-size: 1.75rem;
            color:rgb(244, 244, 245);
        }
        .welcome-text {
            color:rgb(244, 244, 245);
        }
        
        /* Sembunyikan ikon pada badge role dan tombol aksi di tabel user */
        .table-user td i,
        .table-user .badge i,
        .table-user .btn i {
            display: none !important;
        }
    </style>
</head>

<body class="hold-transition layout-navbar-fixed layout-top-nav">
<div class="wrapper">


    <!-- Content Wrapper -->
    <div class="wrapper">
    <?= view('partial/header') ?>

    <div class="content-wrapper">
        <div class="content-header">
            <div class="container py-2">
                <h1 class="dashboard-title mb-2">Manajemen Alat dan Bahan</h1>
                <p class="welcome-text mb-3">
                    Manajemen alat dan bahan Laboratorium
                </p>

                <?php if (isset($error_message)): ?>
                    <div class="alert alert-danger"><?= esc($error_message) ?></div>
                <?php endif; ?>

                <?php if (!empty($alerts)): ?>
                    <div class="alert alert-warning">
                        <h5><i class="fas fa-exclamation-triangle me-2"></i> Notifikasi Penting</h5>
                        <?php foreach ($alerts as $alert): ?>
                            <div class="d-flex justify-content-between align-items-center mt-2">
                                <span><?= $alert['icon'] ?> <strong><?= $alert['title'] ?>:</strong> <?= $alert['message'] ?></span>
                                <a href="<?= $alert['link'] ?>" class="btn btn-sm btn-warning"><?= $alert['action'] ?></a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="content">
            <div class="container">
                <!-- Statistik Section -->
                <h4 class="section-title mb-3">Tambahkan Alat</h4>
                <!-- Form Tambah -->
                <div class="card mb-4">
                    <div class="card-body">
                        <form action="<?= base_url('manajemen/tambah') ?>" method="post" id="formTambah">
                            <div class="form-group">
                                <label>Jenis:</label>
                                <select name="jenis" id="jenisTambah" class="form-control" required>
                                    <option value="">-- Pilih Jenis --</option>
                                    <option value="alat">Alat</option>
                                    <option value="bahan">Bahan</option>
                                    <option value="instrumen">Instrumen</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Nama:</label>
                                <input type="text" name="nama" id="namaTambahInput" class="form-control" required list="daftarNama">
                                <datalist id="daftarNama"></datalist>
                            </div>

                            <div class="form-group" id="satuanTambahWrapper">
                                <label>Satuan:</label>
                                <select name="satuan" class="form-control">
                                    <option value="gram">gram</option>
                                    <option value="mililiter">mililiter</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Lokasi:</label>
                                <input type="text" name="lokasi" id="lokasiTambahInput" class="form-control" required list="daftarLokasi">
                                <datalist id="daftarLokasi">
                                    <?php foreach($lokasi as $lok): ?>
                                        <option value="<?= strtolower($lok) ?>"></option>
                                    <?php endforeach; ?>
                                </datalist>
                            </div>

                            <div class="form-group">
                                <label>Jumlah:</label>
                                <input type="number" name="jumlah" step="any" min="0" class="form-control" required>
                            </div>

                            <button type="submit" class="btn btn-success">Tambah</button>
                        </form>
                    </div>
                </div>

                <!-- Statistik Section -->
                <h4 class="section-title mb-3">Kurangi Alat</h4>
                <!-- Form Tambah -->
                <div class="card mb-4">
                    <div class="card-body">
    <form action="<?= base_url('manajemen/kurang') ?>" method="post" id="formKurang">

                            <div class="form-group">
                                <label>Jenis:</label>
                                <select name="jenis" id="jenisKurang" class="form-control" required>
                                    <option value="">-- Pilih Jenis --</option>
                                    <option value="alat">Alat</option>
                                    <option value="bahan">Bahan</option>
                                    <option value="instrumen">Instrumen</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Nama:</label>
                                <select name="nama" id="namaKurang" class="form-control" required>
                                    <option value="">Pilih jenis dulu</option>
                                </select>
                            </div>

                            <div class="form-group" id="satuanKurangWrapper">
                                <label>Satuan:</label>
                                <select name="satuan" id="satuanKurang" class="form-control" required>
                                    <option value="">Pilih nama dulu</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Jumlah:</label>
                                <input type="number" name="jumlah" id="jumlahKurang" min="0" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label>Lokasi:</label>
                                <select name="lokasi" id="lokasiKurang" class="form-control" required>
                                    <option value="">Pilih nama dulu</option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-danger">Kurangi</button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>

<!-- AdminLTE JS -->
<script src="<?= base_url('adminlte/AdminLTE-3.2.0/plugins/jquery/jquery.min.js') ?>"></script>
<script src="<?= base_url('adminlte/AdminLTE-3.2.0/plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
<script src="<?= base_url('adminlte/AdminLTE-3.2.0/dist/js/adminlte.min.js') ?>"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    // === TAMBAH ===
    const jenisTambah = document.getElementById("jenisTambah");
    const satuanTambahWrapper = document.getElementById("satuanTambahWrapper");
    const lokasiTambahInput = document.getElementById("lokasiTambahInput");
    const namaTambahInput = document.getElementById("namaTambahInput");
    const daftarNama = document.getElementById("daftarNama");

    jenisTambah.addEventListener("change", function () {
        satuanTambahWrapper.style.display = (jenisTambah.value === "bahan") ? "block" : "none";
        daftarNama.innerHTML = '';

        const jenis = jenisTambah.value;
        if (!jenis) return;

        fetch(`<?= base_url('api/nama-by-jenis') ?>?jenis=${jenis}`)
            .then(res => res.json())
            .then(data => {
                data.forEach(nama => {
                    const option = document.createElement('option');
                    option.value = nama;
                    daftarNama.appendChild(option);
                });
            });
    });

    lokasiTambahInput.addEventListener("input", () => {
        lokasiTambahInput.value = lokasiTambahInput.value.toLowerCase();
    });

    namaTambahInput.addEventListener("input", () => {
        namaTambahInput.value = namaTambahInput.value.toLowerCase();
    });

    // === KURANGI ===
    const jenisKurang = document.getElementById("jenisKurang");
    const namaKurang = document.getElementById("namaKurang");
    const satuanKurang = document.getElementById("satuanKurang");
    const satuanKurangWrapper = document.getElementById("satuanKurangWrapper");
    const lokasiKurang = document.getElementById("lokasiKurang");
    const jumlahKurang = document.getElementById("jumlahKurang");

    function toggleSatuanKurang() {
        satuanKurangWrapper.style.display = (jenisKurang.value === "bahan") ? "block" : "none";
    }

    jenisKurang.addEventListener("change", function () {
        const jenis = jenisKurang.value;
        toggleSatuanKurang();

        namaKurang.innerHTML = '<option>Memuat...</option>';

        fetch(`<?= base_url('api/nama-by-jenis') ?>?jenis=${jenis}`)
            .then(res => res.json())
            .then(data => {
                namaKurang.innerHTML = '<option value="">-- Pilih Nama --</option>';
                data.forEach(nama => {
                    namaKurang.innerHTML += `<option value="${nama}">${nama}</option>`;
                });

                satuanKurang.innerHTML = '<option value="">Pilih nama dulu</option>';
                lokasiKurang.innerHTML = '<option value="">Pilih nama dulu</option>';
            });
    });

    namaKurang.addEventListener("change", function () {
        const jenis = jenisKurang.value;
        const nama = namaKurang.value;

        if (!nama) return;

        fetch(`<?= base_url('api/detail-item') ?>?jenis=${jenis}&nama=${encodeURIComponent(nama)}`)
            .then(res => res.json())
            .then(item => {
                satuanKurang.innerHTML = '';
                lokasiKurang.innerHTML = '';

                if (jenis === "bahan") {
                    satuanKurang.innerHTML += `<option value="${item.satuan_bahan}">${item.satuan_bahan}</option>`;
                } else {
                    satuanKurang.innerHTML += `<option value="-">-</option>`;
                }

                lokasiKurang.innerHTML += `<option value="${item.lokasi.toLowerCase()}">${item.lokasi.toLowerCase()}</option>`;

                jumlahKurang.max = jenis === "bahan" ? item.jumlah_bahan :
                                   jenis === "alat" ? item.jumlah_alat :
                                   item.jumlah_instrumen;
            });
    });

    toggleSatuanKurang();
});
</script>

</body>
</html>
