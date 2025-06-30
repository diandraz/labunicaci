<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Alat/Bahan</title>
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
                <h1 class="dashboard-title mb-2">Tambah Alat/Bahan</h1>
                <p class="welcome-text mb-3">Menambah stok alat, bahan, atau instrumen laboratorium</p>
                
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
                            <div class="form-group" id="satuanTambahWrapper" style="display: none;">
                                <label>Satuan:</label>
                                <select name="satuan" class="form-control">
                                    <option value="gram">gram</option>
                                    <option value="mililiter">mililiter</option>
                                    <option value="kilogram">kilogram</option>
                                    <option value="liter">liter</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Lokasi:</label>
                                <input type="text" name="lokasi" id="lokasiTambahInput" class="form-control" required list="daftarLokasi">
                                <datalist id="daftarLokasi">
                                    <?php if(isset($lokasi)): ?>
                                        <?php foreach($lokasi as $lok): ?>
                                            <option value="<?= strtolower($lok) ?>"></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
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
            })
            .catch(err => console.error('Error:', err));
    });

    lokasiTambahInput.addEventListener("input", () => {
        lokasiTambahInput.value = lokasiTambahInput.value.toLowerCase();
    });

    namaTambahInput.addEventListener("input", () => {
        namaTambahInput.value = namaTambahInput.value.toLowerCase();
    });
});
</script>

</body>
</html>