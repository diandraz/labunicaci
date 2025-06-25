<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pemakaian Alat - Labunica</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="<?= base_url('adminlte/AdminLTE-3.2.0/plugins/fontawesome-free/css/all.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('adminlte/AdminLTE-3.2.0/dist/css/adminlte.min.css') ?>">
    
    <!-- Custom CSS - TANPA MENGUBAH FUNGSI -->
    <link rel="stylesheet" href="<?= base_url('css/global.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/pemakaian.css') ?>">

    <style>
        .hidden { display: none; }
        ul { padding-left: 20px; }
        li { margin-bottom: 5px; }
        .loading { opacity: 0.6; pointer-events: none; }
    </style>
</head>
<body class="hold-transition layout-navbar-fixed layout-top-nav">

<div class="wrapper">

    <!-- Navbar -->
    <?= view('partial/header') ?>

    <!-- Content Wrapper -->
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container">
                <h1 class="m-0">🤝 Peminjaman Alat</h1>
                <p class="text-muted">Ajukan permintaan peminjaman alat dan bahan laboratorium</p>
            </div>
        </div>

        <div class="content">
            <div class="container">

                <!-- Success/Error Messages -->
                <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <i class="fas fa-check-circle"></i> <?= session()->getFlashdata('success') ?>
                    </div>
                <?php endif; ?>
                
                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <i class="fas fa-exclamation-circle"></i> <?= session()->getFlashdata('error') ?>
                    </div>
                <?php endif; ?>

                <!-- FORM KURANGI -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">📝 Form Permintaan</h5>
                    </div>
                    <div class="card-body">
                        <form id="formKurang">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Jenis Item:</label>
                                        <select name="jenis" id="jenisKurang" class="form-control" required>
                                            <option value="">-- Pilih Jenis --</option>
                                            <option value="alat">🔧 Alat</option>
                                            <option value="bahan">🧪 Bahan</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Nama Item:</label>
                                        <select name="nama" id="namaKurang" class="form-control" required disabled>
                                            <option value="">-- Pilih Jenis Dulu --</option>
                                        </select>
                                        <small class="text-muted" id="loadingNama" style="display: none;">
                                            <i class="fas fa-spinner fa-spin"></i> Memuat data...
                                        </small>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div id="satuanKurangWrapper" class="form-group" style="display: none;">
                                        <label>Satuan:</label>
                                        <select id="satuanKurang" class="form-control" disabled>
                                            <option value="">Pilih nama dulu</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Jumlah:</label>
                                        <input type="number" id="jumlahKurang" min="1" class="form-control" placeholder="Masukkan jumlah" required>
                                        <small>Stok tersedia: <span id="stokTersedia">-</span></small>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Lokasi:</label>
                                        <select id="lokasiKurang" class="form-control" required disabled>
                                            <option value="">Pilih nama dulu</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="text-center">
                                <button type="button" onclick="tambahKeReview()" class="btn btn-primary" id="btnTambah" disabled>
                                    <i class="fas fa-plus"></i> Tambah ke Review
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- FORM REVIEW -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">📋 Review Permintaan</h5>
                    </div>
                    <div class="card-body">
                        <div id="tabelReview" class="mb-4">
                            <div class="text-center text-muted py-4">
                                <i class="fas fa-inbox fa-3x mb-3"></i>
                                <p>Belum ada item yang ditambahkan</p>
                            </div>
                        </div>

                        <form action="<?= base_url('pemakaian/submitReview') ?>" method="post" id="formReview">
                            <?= csrf_field() ?>
                            <input type="hidden" name="review_data" id="reviewDataInput">
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Tujuan Pemakaian:</label>
                                        <input type="text" name="tujuan" class="form-control" placeholder="Contoh: Praktikum Kimia Organik" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Pesan Tambahan (Opsional):</label>
                                        <textarea name="pesan" class="form-control" rows="3" placeholder="Catatan atau permintaan khusus..."></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="text-center">
                                <button type="submit" id="submitButton" class="btn btn-success btn-lg" disabled>
                                    <i class="fas fa-paper-plane"></i> Kirim Permintaan
                                </button>
                            </div>
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

<!-- Script Form Logic - TIDAK DIUBAH SAMA SEKALI -->
<script>
// ... script yang sama persis seperti sebelumnya ...
document.addEventListener("DOMContentLoaded", function () {
    console.log('DOM loaded, initializing form...');
    
    const jenisKurang = document.getElementById("jenisKurang");
    const namaKurang = document.getElementById("namaKurang");
    const satuanKurang = document.getElementById("satuanKurang");
    const satuanKurangWrapper = document.getElementById("satuanKurangWrapper");
    const lokasiKurang = document.getElementById("lokasiKurang");
    const jumlahKurang = document.getElementById("jumlahKurang");
    const loadingNama = document.getElementById("loadingNama");
    const stokTersedia = document.getElementById("stokTersedia");
    const btnTambah = document.getElementById("btnTambah");

    // Reset form function
    function resetForm() {
        namaKurang.innerHTML = '<option value="">-- Pilih Jenis Dulu --</option>';
        namaKurang.disabled = true;
        satuanKurang.innerHTML = '<option value="">Pilih nama dulu</option>';
        satuanKurang.disabled = true;
        lokasiKurang.innerHTML = '<option value="">Pilih nama dulu</option>';
        lokasiKurang.disabled = true;
        jumlahKurang.value = '';
        jumlahKurang.removeAttribute('max');
        stokTersedia.textContent = '-';
        btnTambah.disabled = true;
        satuanKurangWrapper.style.display = 'none';
    }

    // Toggle satuan wrapper
    function toggleSatuanKurang() {
        if (jenisKurang.value === "bahan") {
            satuanKurangWrapper.style.display = "block";
        } else {
            satuanKurangWrapper.style.display = "none";
        }
    }

    // Event listener untuk jenis
    jenisKurang.addEventListener("change", function () {
        const jenis = jenisKurang.value;
        console.log('Jenis selected:', jenis);
        
        resetForm();
        toggleSatuanKurang();

        if (!jenis) {
            return;
        }

        // Show loading
        loadingNama.style.display = 'block';
        namaKurang.innerHTML = '<option value="">Memuat...</option>';

        // Fetch nama by jenis
        const url = `<?= base_url('api/nama-by-jenis') ?>?jenis=${encodeURIComponent(jenis)}`;
        console.log('Fetching from URL:', url);

        fetch(url, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => {
            console.log('Response status:', response.status);
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            console.log('Data received:', data);
            loadingNama.style.display = 'none';
            
            namaKurang.innerHTML = '<option value="">-- Pilih Nama --</option>';
            
            if (Array.isArray(data) && data.length > 0) {
                data.forEach(nama => {
                    namaKurang.innerHTML += `<option value="${nama}">${nama}</option>`;
                });
                namaKurang.disabled = false;
            } else {
                namaKurang.innerHTML = '<option value="">Tidak ada data</option>';
            }
        })
        .catch(error => {
            console.error('Error fetching nama:', error);
            loadingNama.style.display = 'none';
            namaKurang.innerHTML = '<option value="">Error loading data</option>';
            alert('❌ Gagal memuat data. Silakan refresh halaman.');
        });
    });

    // Event listener untuk nama
    namaKurang.addEventListener("change", function () {
        const jenis = jenisKurang.value;
        const nama = namaKurang.value;
        
        console.log('Nama selected:', nama);

        // Reset detail fields
        satuanKurang.innerHTML = '<option value="">Memuat...</option>';
        lokasiKurang.innerHTML = '<option value="">Memuat...</option>';
        jumlahKurang.value = '';
        stokTersedia.textContent = 'Memuat...';
        btnTambah.disabled = true;

        if (!nama) {
            satuanKurang.innerHTML = '<option value="">Pilih nama dulu</option>';
            lokasiKurang.innerHTML = '<option value="">Pilih nama dulu</option>';
            stokTersedia.textContent = '-';
            return;
        }

        // Fetch detail item
        const url = `<?= base_url('api/detail-item') ?>?jenis=${encodeURIComponent(jenis)}&nama=${encodeURIComponent(nama)}`;
        console.log('Fetching detail from URL:', url);

        fetch(url, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => {
            console.log('Detail response status:', response.status);
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(item => {
            console.log('Detail data received:', item);
            
            // Clear options
            satuanKurang.innerHTML = '';
            lokasiKurang.innerHTML = '';

            if (jenis === "bahan") {
                // PERBAIKAN: Gunakan satuan_options dari controller dengan proper fallback
                if (item.satuan_options && Array.isArray(item.satuan_options) && item.satuan_options.length > 0) {
                    item.satuan_options.forEach((satuan, index) => {
                        const selected = (satuan === item.satuan_default) ? 'selected' : '';
                        satuanKurang.innerHTML += `<option value="${satuan}" ${selected}>${satuan}</option>`;
                    });
                } else {
                    // Fallback jika tidak ada satuan_options
                    const defaultSatuan = item.satuan_default || 'gram';
                    satuanKurang.innerHTML = `<option value="${defaultSatuan}" selected>${defaultSatuan}</option>`;
                }
                
                jumlahKurang.max = item.jumlah_bahan;
                // Ambil satuan yang dipilih untuk display stok
                const selectedSatuan = satuanKurang.options[satuanKurang.selectedIndex]?.value || item.satuan_default || 'gram';
                stokTersedia.textContent = `${item.jumlah_bahan} ${selectedSatuan}`;
            } else {
                // Untuk alat
                satuanKurang.innerHTML = `<option value="-">-</option>`;
                jumlahKurang.max = item.jumlah_alat;
                stokTersedia.textContent = `${item.jumlah_alat} unit`;
            }

            lokasiKurang.innerHTML = `<option value="${item.lokasi}">${item.lokasi}</option>`;
            
            // Enable fields
            satuanKurang.disabled = false;
            lokasiKurang.disabled = false;
            btnTambah.disabled = false;
        })
        .catch(error => {
            console.error('Error fetching detail:', error);
            satuanKurang.innerHTML = '<option value="">Error loading</option>';
            lokasiKurang.innerHTML = '<option value="">Error loading</option>';
            stokTersedia.textContent = 'Error';
            alert('❌ Gagal memuat detail item.');
        });
    });

    // Initialize
    toggleSatuanKurang();
});

// Review List Management
let reviewList = [];

function renderReview() {
    const container = document.getElementById('tabelReview');
    const inputHidden = document.getElementById('reviewDataInput');
    const submitButton = document.getElementById('submitButton');

    if (reviewList.length === 0) {
        container.innerHTML = `
            <div class="text-center text-muted py-4">
                <i class="fas fa-inbox fa-3x mb-3"></i>
                <p>Belum ada item yang ditambahkan</p>
            </div>`;
        inputHidden.value = '';
        submitButton.disabled = true;
        return;
    }

    let html = '<div class="table-responsive"><table class="table table-hover">';
    html += '<thead><tr><th>Jenis</th><th>Nama</th><th>Jumlah</th><th>Satuan</th><th>Lokasi</th><th>Aksi</th></tr></thead><tbody>';
    
    reviewList.forEach((item, i) => {
        const typeIcon = item.jenis === 'alat' ? '🔧' : '🧪';
        const satuan = item.satuan || (item.jenis === 'alat' ? '-' : 'gram');
        html += `
            <tr>
                <td>${typeIcon} ${item.jenis.toUpperCase()}</td>
                <td><strong>${item.nama}</strong></td>
                <td><span class="badge badge-primary">${item.jumlah}</span></td>
                <td><span class="badge badge-info">${satuan}</span></td>
                <td>${item.lokasi}</td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm" onclick="hapusReview(${i})">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>`;
    });
    
    html += '</tbody></table></div>';
    container.innerHTML = html;
    inputHidden.value = JSON.stringify(reviewList);
    submitButton.disabled = false;
}

function tambahKeReview() {
    const jenis = document.getElementById('jenisKurang').value;
    const nama = document.getElementById('namaKurang').value;
    const jumlah = parseInt(document.getElementById('jumlahKurang').value);
    const lokasi = document.getElementById('lokasiKurang').value;
    const satuan = document.getElementById('satuanKurang').value; // Tambahkan ini

    // Validasi
    if (!jenis || !nama || !jumlah || !lokasi || jumlah <= 0) {
        alert("❌ Semua field harus diisi dengan benar.");
        return;
    }

    // Validasi satuan untuk bahan
    if (jenis === 'bahan' && (!satuan || satuan === '')) {
        alert("❌ Satuan harus dipilih untuk bahan.");
        return;
    }

    const max = parseInt(document.getElementById('jumlahKurang').max || "9999");
    if (jumlah > max) {
        alert(`❌ Jumlah tidak boleh melebihi stok tersedia (${max}).`);
        return;
    }

    // Cek duplikasi
    const existing = reviewList.find(item => 
        item.jenis === jenis && item.nama === nama && item.lokasi === lokasi
    );
    
    if (existing) {
        alert("⚠️ Item dengan nama dan lokasi yang sama sudah ada di review!");
        return;
    }

    // Tambahkan ke review dengan satuan
    const reviewItem = { 
        jenis, 
        nama, 
        jumlah, 
        lokasi,
        satuan: jenis === 'bahan' ? satuan : '-' // Tambahkan satuan
    };
    
    reviewList.push(reviewItem);
    renderReview();

    // Reset form input
    document.getElementById('jumlahKurang').value = '';
    document.getElementById('namaKurang').selectedIndex = 0;
    
    // Trigger change event to reset dependent fields
    document.getElementById('namaKurang').dispatchEvent(new Event('change'));
    
    alert("✅ Item berhasil ditambahkan ke review!");
}

function hapusReview(index) {
    if (confirm('❓ Yakin ingin menghapus item ini dari review?')) {
        reviewList.splice(index, 1);
        renderReview();
    }
}

// Form submit validation
document.getElementById('formReview').addEventListener('submit', function(e) {
    if (reviewList.length === 0) {
        e.preventDefault();
        alert('❌ Silakan tambahkan minimal 1 item untuk direview!');
        return false;
    }
    
    const tujuan = document.querySelector('input[name="tujuan"]').value.trim();
    if (!tujuan) {
        e.preventDefault();
        alert('❌ Tujuan harus diisi!');
        return false;
    }
    
    // Show loading state
    const submitBtn = document.getElementById('submitButton');
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mengirim...';
    submitBtn.disabled = true;
    
    return true;
});
</script>

</body>
</html>
