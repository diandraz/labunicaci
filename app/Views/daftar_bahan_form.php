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
        }
        .section-title {
            font-size: 1.2rem;
            font-weight: 500;
            border-left: 4px solid #343a40;
            padding-left: 10px;
            color: #343a40;
        }
        .dashboard-title {
            font-weight: 600;
            font-size: 1.75rem;
            color: #343a40;
        }
        .welcome-text {
            color: #6c757d;
        }
    </style>
</head>

<body class="hold-transition layout-navbar-fixed layout-top-nav">

<div class="wrapper">
    <?= view('partial/header') ?>

    <div class="content-wrapper">
        <div class="content-header">
            <div class="container py-2">
                <h1 class="dashboard-title mb-2">Daftar Bahan</h1>
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

                <form method="GET" action="/inventory/daftar-bahan" class="mb-3">
                    <div class="form-row">
                        <div class="col-md-5 mb-2">
                            <input type="text" name="search" class="form-control" placeholder="🔍 Cari nama bahan..." value="<?= esc($search ?? '') ?>">
                        </div>
                        <div class="col-md-4 mb-2">
                            <select name="location" class="form-control">
                                <option value="">📍 Semua Lokasi</option>
                                <?php if (!empty($locations)): ?>
                                    <?php foreach ($locations as $loc): ?>
                                        <option value="<?= esc($loc) ?>" <?= ($location ?? '') == $loc ? 'selected' : '' ?>><?= esc($loc) ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                        <div class="col-md-3 mb-2">
                            <button type="submit" class="btn btn-primary">🔍 Cari</button>
                            <a href="/inventory/daftar-bahan" class="btn btn-secondary">🗑️ Reset</a>
                        </div>
                    </div>
                </form>

                <?php if (!empty($search) || !empty($location)): ?>
                    <div class="alert alert-info">
                        <strong>📊 Hasil Pencarian:</strong>
                        <?php if (!empty($search)): ?>Nama: "<em><?= esc($search) ?></em>"<?php endif; ?>
                        <?php if (!empty($location)): ?> Lokasi: "<em><?= esc($location) ?></em>"<?php endif; ?>
                        - Ditemukan <strong><?= $totalItems ?? 0 ?></strong> bahan
                    </div>
                <?php endif; ?>

                <div class="card">
                    <div class="card-body table-responsive p-0">
                        <table class="table table-bordered table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nama Bahan</th>
                                    <th>Jumlah</th>
                                    <th>Satuan</th>
                                    <th>Lokasi</th>
                                    <?php if (session()->get('role') === 'admin'): ?>
                                        <th>🔧 Aksi</th>
                                    <?php endif; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($items)): ?>
                                    <?php foreach ($items as $item): ?>
                                        <tr>
                                            <td><?= $item['id_bahan'] ?></td>
                                            <td><?= esc($item['nama_bahan']) ?></td>
                                            <td>
                                                <?= $item['jumlah_bahan'] ?>
                                                <?php if ($item['jumlah_bahan'] <= 10): ?>
                                                    <span class="text-danger ml-1">⚠️</span>
                                                <?php endif; ?>
                                            </td>
                                            <td><?= esc($item['satuan_bahan']) ?></td>
                                            <td><?= esc($item['lokasi']) ?></td>
                                            <?php if (session()->get('role') === 'admin'): ?>
                                                <td>
                                                    <button onclick="hapusBahan(<?= $item['id_bahan'] ?>, '<?= esc($item['nama_bahan']) ?>')" class="btn btn-sm btn-danger">
                                                        🗑️ Hapus
                                                    </button>
                                                </td>
                                            <?php endif; ?>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="<?= session()->get('role') === 'admin' ? '6' : '5' ?>" class="text-center text-muted">
                                            <?php if (!empty($search) || !empty($location)): ?>
                                                🔍 Tidak ada bahan yang sesuai dengan pencarian
                                            <?php else: ?>
                                                🧪 Tidak ada data bahan
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

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
                                        <a class="page-link" href="/inventory/daftar-bahan?page=<?= $currentPage - 1 ?><?= $queryString ?>">← Sebelumnya</a>
                                    </li>
                                <?php endif; ?>
                                <li class="page-item active"><span class="page-link">Halaman <?= $currentPage ?> dari <?= $totalPages ?></span></li>
                                <?php if ($currentPage < $totalPages): ?>
                                    <li class="page-item">
                                        <a class="page-link" href="/inventory/daftar-bahan?page=<?= $currentPage + 1 ?><?= $queryString ?>">Selanjutnya →</a>
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

<?php if (session()->get('role') === 'admin'): ?>
<script>
    function hapusBahan(id, nama) {
        if (confirm(`⚠️ Yakin ingin menghapus bahan "${nama}"?\n\nData yang dihapus tidak dapat dikembalikan!`)) {
            fetch(`/inventory/hapus-bahan/${id}`, {
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
                    alert('✅ Bahan berhasil dihapus!');
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

<!-- AdminLTE Scripts -->
<script src="<?= base_url('adminlte/AdminLTE-3.2.0/plugins/jquery/jquery.min.js') ?>"></script>
<script src="<?= base_url('adminlte/AdminLTE-3.2.0/plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
<script src="<?= base_url('adminlte/AdminLTE-3.2.0/dist/js/adminlte.min.js') ?>"></script>

</body>
</html>
