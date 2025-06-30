<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kurangi Alat/Bahan</title>
    <!-- PERBAIKAN: Gunakan versi Bootstrap yang konsisten -->
    <link rel="stylesheet" href="<?= base_url('adminlte/AdminLTE-3.2.0/plugins/fontawesome-free/css/all.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('adminlte/AdminLTE-3.2.0/dist/css/adminlte.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('adminlte/AdminLTE-3.2.0/plugins/bootstrap/css/bootstrap.min.css') ?>">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body { 
            font-family: 'Poppins', 'Inter', sans-serif; 
            background: url('<?= base_url('adminlte/AdminLTE-3.2.0/dist/img/5.jpg') ?>') no-repeat center center fixed !important; 
            background-size: cover !important; 
            position: relative; 
        }
        body::before { 
            content: ''; 
            position: fixed; 
            top: 0; 
            left: 0; 
            width: 100%; 
            height: 100%; 
            background-color: rgba(0, 0, 0, 0.5); 
            z-index: -1; 
        }
        .wrapper, .content-wrapper { 
            background: transparent !important; 
        }
        .dashboard-title { 
            font-weight: 600; 
            font-size: 1.75rem; 
            color: rgb(244, 244, 245); 
        }
        .welcome-text { 
            color: rgb(244, 244, 245); 
        }
    </style>
</head>
<body class="hold-transition layout-navbar-fixed layout-top-nav">
<div class="wrapper">
    <?= view('partial/header') ?>
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container py-2">
                <h1 class="dashboard-title mb-2">Kurangi Alat/Bahan</h1>
                <p class="welcome-text mb-3">Mengurangi stok alat, bahan, atau instrumen laboratorium</p>
                
                <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?= session()->getFlashdata('success') ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?= session()->getFlashdata('error') ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="content">
            <div class="container">
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
                            <div class="form-group" id="satuanKurangWrapper" style="display: none;">
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

<!-- PERBAIKAN: Scripts dalam urutan yang benar -->
<script src="<?= base_url('adminlte/AdminLTE-3.2.0/plugins/jquery/jquery.min.js') ?>"></script>
<script src="<?= base_url('adminlte/AdminLTE-3.2.0/plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
<script src="<?= base_url('adminlte/AdminLTE-3.2.0/dist/js/adminlte.min.js') ?>"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {
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
        
        if (!jenis) {
            namaKurang.innerHTML = '<option value="">Pilih jenis dulu</option>';
            return;
        }

        fetch(`<?= base_url('api/nama-by-jenis') ?>?jenis=${jenis}`)
            .then(res => res.json())
            .then(data => {
                namaKurang.innerHTML = '<option value="">-- Pilih Nama --</option>';
                data.forEach(nama => {
                    namaKurang.innerHTML += `<option value="${nama}">${nama}</option>`;
                });
                satuanKurang.innerHTML = '<option value="">Pilih nama dulu</option>';
                lokasiKurang.innerHTML = '<option value="">Pilih nama dulu</option>';
            })
            .catch(err => {
                console.error('Error:', err);
                namaKurang.innerHTML = '<option value="">Error loading data</option>';
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
            })
            .catch(err => {
                console.error('Error:', err);
            });
    });

    toggleSatuanKurang();
});
</script>

</body>
</html>