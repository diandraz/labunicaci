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
            background: url('<?= base_url('adminlte/AdminLTE-3.2.0/dist/img/4.jpg') ?>') no-repeat center center fixed !important;
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
    <?= view('partial/header') ?>

    <div class="content-wrapper">
        <div class="content-header">
            <div class="container py-2">
                <h1 class="dashboard-title mb-2">Daftar Instrumen</h1>
                <p class="welcome-text mb-3">
                    Selamat datang, <strong><?= esc($user_info['nama'] ?? 'User') ?></strong>!
                    <span class="text-muted">(<?= date('l, d F Y') ?>)</span>
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

                <!-- FORM PENCARIAN -->
                <form method="GET" action="/inventory/daftar-instrumen" class="form-inline mb-3">
                    <input type="text" name="search" class="form-control mr-2" placeholder="🔍 Cari nama alat..." value="<?= esc($search ?? '') ?>">
                    <select name="location" class="form-control mr-2">
                        <option value="">📍 Semua Lokasi</option>
                        <?php if (!empty($locations)): ?>
                            <?php foreach ($locations as $loc): ?>
                                <option value="<?= esc($loc) ?>" <?= ($location ?? '') == $loc ? 'selected' : '' ?>>
                                    <?= esc($loc) ?>
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                    <button type="submit" class="btn btn-primary mr-2">🔍 Cari</button>
                    <a href="/inventory/daftar-alat" class="btn btn-secondary">🗑️ Reset</a>
                </form>

                <!-- INFO HASIL PENCARIAN -->
                <?php if (!empty($search) || !empty($location)): ?>
                    <div class="alert alert-info">
                        <strong>📊 Hasil Pencarian:</strong>
                        <?php if (!empty($search)): ?>
                            Nama: "<em><?= esc($search) ?></em>"
                        <?php endif; ?>
                        <?php if (!empty($location)): ?>
                            Lokasi: "<em><?= esc($location) ?></em>"
                        <?php endif; ?>
                        - Ditemukan <strong><?= $totalItems ?? 0 ?></strong> alat
                    </div>
                <?php endif; ?>

                <!-- TABEL DATA -->
                <div class="card">
                    <div class="card-body table-responsive p-0">
                        <table class="table table-bordered table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nama Instrumen</th>
                                    <th>Jumlah</th>
                                    <th>Lokasi</th>
                                    <?php if (session()->get('role') === 'admin'): ?>
                                        <th>Aksi</th>
                                    <?php endif; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($items)): ?>
                                    <?php foreach ($items as $item): ?>
                                        <tr>
                                            <td><?= $item['id_instrumen'] ?></td>
                                            <td><?= esc($item['nama_instrumen']) ?></td>
                                            <td>
                                                <?= $item['jumlah_instrumen'] ?>
                                                <?php if ($item['jumlah_instrumen'] <= 3): ?>
                                                    <span class="text-danger">⚠️</span>
                                                <?php endif; ?>
                                            </td>
                                            <td><?= esc($item['lokasi']) ?></td>
                                            <?php if (session()->get('role') === 'admin'): ?>
                                                <td>
                                                    <button onclick="hapusAlat(<?= $item['id_instrumen'] ?>, '<?= esc($item['nama_instrumen']) ?>')" class="btn btn-danger btn-sm">
                                                        🗑️ Hapus
                                                    </button>
                                                </td>
                                            <?php endif; ?>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="<?= session()->get('role') === 'admin' ? '5' : '4' ?>">
                                            <div class="text-center text-muted">
                                                <?php if (!empty($search) || !empty($location)): ?>
                                                    🔍 Tidak ada alat yang sesuai dengan pencarian
                                                <?php else: ?>
                                                    📦 Tidak ada data alat
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- PAGINATION -->
                <?php if (($totalPages ?? 1) > 1): ?>
                    <div class="mt-3">
                        <?php 
                        $currentPage = $currentPage ?? 1;
                        $searchQuery = !empty($search) ? "&search=" . urlencode($search) : "";
                        $locationQuery = !empty($location) ? "&location=" . urlencode($location) : "";
                        $queryString = $searchQuery . $locationQuery;
                        ?>

                        <nav>
                            <ul class="pagination">
                                <?php if ($currentPage > 1): ?>
                                    <li class="page-item">
                                        <a class="page-link" href="/inventory/daftar-alat?page=<?= $currentPage - 1 ?><?= $queryString ?>">← Sebelumnya</a>
                                    </li>
                                <?php endif; ?>

                                <li class="page-item active">
                                    <span class="page-link">Halaman <?= $currentPage ?> dari <?= $totalPages ?></span>
                                </li>

                                <?php if ($currentPage < $totalPages): ?>
                                    <li class="page-item">
                                        <a class="page-link" href="/inventory/daftar-alat?page=<?= $currentPage + 1 ?><?= $queryString ?>">Selanjutnya →</a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </nav>
                    </div>
                <?php endif; ?>

            </div>
        </div>
    </div>
</div>

<!-- AdminLTE Scripts -->
<script src="<?= base_url('adminlte/AdminLTE-3.2.0/plugins/jquery/jquery.min.js') ?>"></script>
<script src="<?= base_url('adminlte/AdminLTE-3.2.0/plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
<script src="<?= base_url('adminlte/AdminLTE-3.2.0/dist/js/adminlte.min.js') ?>"></script>

<!-- JS Hapus Alat -->
<?php if (session()->get('role') === 'admin'): ?>
<script>
    function hapusAlat(id, nama) {
        if (confirm(`⚠️ Yakin ingin menghapus alat "${nama}"?\n\nData yang dihapus tidak dapat dikembalikan!`)) {
            fetch(`/inventory/hapus-alat/${id}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({ '_method': 'DELETE' })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('✅ Alat berhasil dihapus!');
                    location.reload();
                } else {
                    alert('❌ Error: ' + data.message);
                }
            })
            .catch(error => {
                alert('❌ Terjadi kesalahan saat menghapus data');
                console.error('Error:', error);
            });
        }
    }
</script>
<?php endif; ?>

</body>
</html>
