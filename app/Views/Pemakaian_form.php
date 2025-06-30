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
            background: url('<?= base_url('adminlte/AdminLTE-3.2.0/dist/img/5.jpg') ?>') no-repeat center center fixed !important;
            background-size: cover !important;
        }
        .wrapper, .content-wrapper {
            background: transparent !important;
        }
        .section-title {
            font-size: 1.2rem;
            font-weight: 500;
            border-left: 4px solid rgb(255, 255, 255);
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
    <?= view('partial/header') ?>

    <div class="content-wrapper">
        <div class="content-header">
            <div class="container py-2">
                <h1 class="dashboard-title mb-2">Pemakaian Alat dan bahan</h1>
                <p class="welcome-text mb-3">
                    Halaman peminjaman alat dan bahan
                </p>
            </div>
        </div>

        <div class="content">
            <div class="container">

                <!-- Success/Error Messages -->
                <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <?= session()->getFlashdata('success') ?>
                    </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <?= session()->getFlashdata('error') ?>
                    </div>
                <?php endif; ?>

                <!-- FORM KURANGI -->
                <h1 class="section-title mb-3">Form Pemakaian</h1>
                <div class="card mb-4">
                    <div class="card-body">
                        <form id="formKurang">
                            <div class="form-group">
                                <label>Jenis:</label>
                                <select name="jenis" id="jenisKurang" class="form-control" required>
                                    <option value="">-- Pilih Jenis --</option>
                                    <option value="alat">Alat</option>
                                    <option value="bahan">Bahan</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Nama:</label>
                                <select name="nama" id="namaKurang" class="form-control" required>
                                    <option value="">-- Pilih Jenis Dulu --</option>
                                </select>
                            </div>

                            <div id="satuanKurangWrapper" class="form-group">
                                <label>Satuan:</label>
                                <select id="satuanKurang" class="form-control" disabled>
                                    <option value="">Pilih nama dulu</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Jumlah:</label>
                                <input type="number" id="jumlahKurang" min="1" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label>Lokasi:</label>
                                <select id="lokasiKurang" class="form-control" required>
                                    <option value="">Pilih nama dulu</option>
                                </select>
                            </div>

                            <button type="button" onclick="tambahKeReview()" class="btn btn-primary">Tambah ke Review</button>
                        </form>
                    </div>
                </div>

                <!-- FORM REVIEW -->
                 <h1 class="section-title mb-3">Review Pemakaian</h1>
                <div class="card">
                    <div class="card-body">
                        <form action="<?= base_url('pemakaian/submitReview') ?>" method="post" id="formReview">
                            <?= csrf_field() ?>
                            <input type="hidden" name="review_data" id="reviewDataInput">
                            <div id="tabelReview"></div>

                            <div class="form-group">
                                <label>Tujuan:</label>
                                <input type="text" name="tujuan" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label>Pesan:</label>
                                <textarea name="pesan" class="form-control" rows="3"></textarea>
                            </div>

                            <button type="submit" id="submitButton" class="btn btn-success" disabled>Submit Semua</button>
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

<!-- Script Form Logic -->
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

    if (jenisKurang) {
        jenisKurang.addEventListener("change", function () {
            const jenis = jenisKurang.value;
            toggleSatuanKurang();

            namaKurang.innerHTML = '<option value="">Memuat...</option>';

            if (!jenis) {
                namaKurang.innerHTML = '<option value="">-- Pilih Jenis Dulu --</option>';
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
                    jumlahKurang.value = '';
                    jumlahKurang.removeAttribute('max');
                })
                .catch(error => {
                    console.error('Error:', error);
                    namaKurang.innerHTML = '<option value="">Error loading data</option>';
                });
        });
    }

    if (namaKurang) {
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
                        jumlahKurang.max = item.jumlah_bahan;
                    } else {
                        satuanKurang.innerHTML += `<option value="-">-</option>`;
                        jumlahKurang.max = item.jumlah_alat;
                    }

                    lokasiKurang.innerHTML += `<option value="${item.lokasi}">${item.lokasi}</option>`;
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        });
    }

    toggleSatuanKurang();
});

let reviewList = [];

function renderReview() {
    const container = document.getElementById('tabelReview');
    const inputHidden = document.getElementById('reviewDataInput');
    const submitButton = document.getElementById('submitButton');

    if (reviewList.length === 0) {
        container.innerHTML = '<p>Belum ada data ditambahkan.</p>';
        inputHidden.value = '';
        submitButton.disabled = true;
        return;
    }

    let html = '<ul>';
    reviewList.forEach((item, i) => {
        html += `<li><strong>${item.jenis}</strong>: [${item.nama}, ${item.jumlah}, ${item.lokasi}]
                 <button type="button" class="btn btn-danger btn-sm ml-2" onclick="hapusReview(${i})">❌</button></li>`;
    });
    html += '</ul>';

    container.innerHTML = html;
    inputHidden.value = JSON.stringify(reviewList);
    submitButton.disabled = false;
}

function tambahKeReview() {
    const jenis = document.getElementById('jenisKurang').value;
    const nama = document.getElementById('namaKurang').value;
    const jumlah = parseInt(document.getElementById('jumlahKurang').value);
    const lokasi = document.getElementById('lokasiKurang').value;

    if (!jenis || !nama || !jumlah || !lokasi || jumlah <= 0) {
        alert("Semua field harus diisi dengan benar.");
        return;
    }

    const max = parseInt(document.getElementById('jumlahKurang').max || "9999");
    if (jumlah > max) {
        alert(`Jumlah tidak boleh melebihi stok (${max}).`);
        return;
    }

    reviewList.push({ jenis, nama, jumlah, lokasi });
    renderReview();

    // Reset form
    document.getElementById('jumlahKurang').value = '';
    document.getElementById('namaKurang').selectedIndex = 0;
    document.getElementById('lokasiKurang').selectedIndex = 0;
    document.getElementById('satuanKurang').innerHTML = '<option value="">Pilih nama dulu</option>';
}

function hapusReview(index) {
    reviewList.splice(index, 1);
    renderReview();
}
</script>

</body>
</html>
