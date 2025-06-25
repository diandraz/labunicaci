<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Alat</title>

    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="<?= base_url('adminlte/AdminLTE-3.2.0/plugins/fontawesome-free/css/all.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('adminlte/AdminLTE-3.2.0/dist/css/adminlte.min.css') ?>">
    
    <!-- PERBAIKAN: Gunakan CSS yang sama -->
    <link rel="stylesheet" href="<?= base_url('css/global.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/inventory.css') ?>">
</head>
<body class="hold-transition layout-navbar-fixed layout-top-nav">
<div class="wrapper">

    <!-- Navbar -->
    <?= view('partial/header') ?>

    <!-- Content Wrapper -->
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container">
                <h1 class="m-0 text-dark">🔧 Daftar Alat</h1>
            </div>
        </div>

        <div class="content">
            <div class="container">

                <!-- FORM PENCARIAN -->
                <div class="card">
                    <div class="card-body">
                        <form method="GET" action="/inventory/daftar-alat">
                            <div class="form-row">
                                <div class="col-md-5 mb-2">
                                    <input type="text" name="search" class="form-control" placeholder="🔍 Cari nama alat..." value="<?= esc($search ?? '') ?>">
                                </div>
                                <div class="col-md-4 mb-2">
                                    <select name="location" class="form-control">
                                        <option value="">📍 Semua Lokasi</option>
                                        <?php if (!empty($locations)): ?>
                                            <?php foreach ($locations as $loc): ?>
                                                <option value="<?= esc($loc['lokasi']) ?>" <?= ($location ?? '') == $loc['lokasi'] ? 'selected' : '' ?>>
                                                    <?= esc($loc['lokasi']) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                                <div class="col-md-3 mb-2">
                                    <button type="submit" class="btn btn-primary">🔍 Cari</button>
                                    <a href="/inventory/daftar-alat" class="btn btn-secondary">🗑️ Reset</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- INFO HASIL PENCARIAN -->
                <?php if (!empty($search) || !empty($location)): ?>
                    <div class="alert alert-info">
                        <strong>📊 Hasil Pencarian:</strong>
                        <?php if (!empty($search)): ?>Nama: "<em><?= esc($search) ?></em>"<?php endif; ?>
                        <?php if (!empty($location)): ?> Lokasi: "<em><?= esc($location) ?></em>"<?php endif; ?>
                        - Ditemukan <strong><?= $total ?? 0 ?></strong> alat
                    </div>
                <?php endif; ?>

                <!-- TABEL ALAT -->
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Alat</th>
                                        <th>Jumlah</th>
                                        <th>Lokasi</th>
                                        <?php if (session()->get('role') === 'admin'): ?>
                                            <th>🔧 Aksi</th>
                                        <?php endif; ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($items)): ?>
                                        <?php $no = (($currentPage ?? 1) - 1) * ($perPage ?? 20) + 1; ?>
                                        <?php foreach ($items as $item): ?>
                                            <tr>
                                                <td><?= $no++ ?></td>
                                                <td><?= esc($item['nama_alat']) ?></td>
                                                <td>
                                                    <?= $item['jumlah_alat'] ?>
                                                    <?php if ($item['jumlah_alat'] <= 5): ?>
                                                        <span class="text-danger ml-1">⚠️</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td><?= esc($item['lokasi']) ?></td>
                                                <?php if (session()->get('role') === 'admin'): ?>
                                                    <td>
                                                        <button class="btn btn-danger btn-sm" onclick="hapusAlat(<?= $item['id_alat'] ?>, '<?= esc($item['nama_alat']) ?>')">
                                                            🗑️ Hapus
                                                        </button>
                                                    </td>
                                                <?php endif; ?>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="<?= session()->get('role') === 'admin' ? '5' : '4' ?>" class="text-center text-muted">
                                                <?php if (!empty($search) || !empty($location)): ?>
                                                    🔍 Tidak ada alat yang sesuai dengan pencarian
                                                <?php else: ?>
                                                    📦 Tidak ada data alat
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
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

<!-- JAVASCRIPT -->
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

<!-- AdminLTE Scripts -->
<script src="<?= base_url('adminlte/AdminLTE-3.2.0/plugins/jquery/jquery.min.js') ?>"></script>
<script src="<?= base_url('adminlte/AdminLTE-3.2.0/plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
<script src="<?= base_url('adminlte/AdminLTE-3.2.0/dist/js/adminlte.min.js') ?>"></script>

</body>
</html>