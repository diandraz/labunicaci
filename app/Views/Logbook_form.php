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

    <style>
        body {
            font-family: 'Poppins', 'Inter', sans-serif;
            background: url('<?= base_url('adminlte/AdminLTE-3.2.0/dist/img/1.jpg') ?>') no-repeat center center fixed !important;
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

        .wrapper,
        .content-wrapper {
            background: transparent !important;
        }

        .section-title {
            font-size: 1.2rem;
            font-weight: 500;
            border-left: 4px solid rgb(255, 255, 255);
            padding-left: 10px;
            color: rgb(252, 252, 252);
        }

        .dashboard-title {
            font-weight: 600;
            font-size: 1.75rem;
            color: rgb(244, 244, 245);
        }

        .welcome-text {
            color: rgb(244, 244, 245);
        }

        .dashboard-date {
            color: #fff !important;
        }

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
                <h1 class="dashboard-title mb-2">Logbook</h1>
                <p class="welcome-text mb-3">
                    Selamat datang, <strong><?= esc($user_info['nama'] ?? 'User') ?></strong>!
                    <span class="dashboard-date">(<?= date('l, d F Y') ?>)</span>
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

                <!-- Statistik Overview -->
                <h4 class="section-title mb-3">📊 Statistik Overview</h4>
                <div class="mb-4">
                    <ul class="text-light">
                        <li>Total Peminjaman Alat: <strong><?= $statistik['total_alat'] ?? 0 ?></strong></li>
                        <li>Total Pemakaian Bahan: <strong><?= $statistik['total_bahan'] ?? 0 ?></strong></li>
                        <li>Total Semua Aktivitas: <strong><?= $statistik['total_semua'] ?? 0 ?></strong></li>
                        <li>Total Disetujui: <strong><?= $statistik['total_approve'] ?? 0 ?></strong></li>
                        <li>Total Pending: <strong><?= $statistik['total_pending'] ?? 0 ?></strong></li>
                        <li>Aktivitas Hari Ini: <strong><?= $statistik['aktivitas_hari_ini'] ?? 0 ?></strong></li>
                    </ul>
                </div>

                <div class="mb-3">
                    <a href="<?= site_url('logbook/export') ?>" class="btn btn-primary">📊 Export CSV</a>
                </div>

                <!-- LOGBOOK ALAT (MODEL SAMA DENGAN INVENTORY) -->
                <h5 class="section-title mb-3">🔧 Logbook Peminjaman Alat</h5>
                <div class="card mb-4">
                    <div class="card-body table-responsive p-0">
                        <table class="table table-bordered table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Pengguna</th>
                                    <th>Nama Alat</th>
                                    <th>Penambahan</th>
                                    <th>Pengurangan</th>
                                    <th>Tanggal Pinjam</th>
                                    <th>Tanggal Kembali</th>
                                    <th>Tujuan Pemakaian</th>
                                    <th>Status</th>
                                    <th>Pesan</th>
                                    <th>🔧 Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($dataAlat)): ?>
                                    <?php $no = 1; foreach ($dataAlat as $alat): ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= esc($alat['nama_lengkap'] ?? '-') ?></td>
                                            <td><?= esc($alat['nama_alat'] ?? '-') ?></td>
                                            <td class="text-center">
                                                <?= $alat['penambahan'] ?? '0' ?>
                                                <?php if (($alat['penambahan'] ?? 0) > 0): ?>
                                                    <span class="text-success">📈</span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-center">
                                                <?= $alat['pengurangan'] ?? '0' ?>
                                                <?php if (($alat['pengurangan'] ?? 0) > 0): ?>
                                                    <span class="text-danger">📉</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?= !empty($alat['tanggal_dipinjam']) ? date('d/m/Y', strtotime($alat['tanggal_dipinjam'])) : '-' ?>
                                            </td>
                                            <td>
                                                <?php if (!empty($alat['tanggal_kembali'])): ?>
                                                    <?= date('d/m/Y', strtotime($alat['tanggal_kembali'])) ?>
                                                <?php else: ?>
                                                    <span class="text-warning">⏳ Belum Kembali</span>
                                                <?php endif; ?>
                                            </td>
                                            <td><?= esc($alat['tujuan_pemakaian'] ?? '-') ?></td>
                                            <td>
                                                <?php 
                                                $status = strtolower($alat['status'] ?? '');
                                                if ($status === 'approve'): ?>
                                                    <span class="badge badge-success">✅ Approve</span>
                                                <?php elseif ($status === 'pending'): ?>
                                                    <span class="badge badge-warning">⏳ Pending</span>
                                                <?php elseif ($status === 'reject'): ?>
                                                    <span class="badge badge-danger">❌ Reject</span>
                                                <?php else: ?>
                                                    <span class="badge badge-secondary">❓ <?= ucfirst($status) ?></span>
                                                <?php endif; ?>
                                            </td>
                                            <td><?= esc($alat['pesan'] ?? '-') ?></td>
                                            <td>
                                                <button class="btn btn-info btn-sm" onclick="showDetail('alat', <?= $alat['id_logalat'] ?>)">
                                                    👁️ Detail
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="11" class="text-center">
                                            📭 Tidak ada data peminjaman alat
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- LOGBOOK BAHAN (MODEL SAMA DENGAN INVENTORY) -->
                <h5 class="section-title mb-3">🧪 Logbook Pemakaian Bahan</h5>
                <div class="card mb-4">
                    <div class="card-body table-responsive p-0">
                        <table class="table table-bordered table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Pengguna</th>
                                    <th>Nama Bahan</th>
                                    <th>Penambahan</th>
                                    <th>Pengurangan</th>
                                    <th>Tanggal</th>
                                    <th>Tujuan Pemakaian</th>
                                    <th>Status</th>
                                    <th>Pesan</th>
                                    <th>🔧 Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($dataBahan)): ?>
                                    <?php $no = 1; foreach ($dataBahan as $bahan): ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= esc($bahan['nama_lengkap'] ?? '-') ?></td>
                                            <td><?= esc($bahan['nama_bahan'] ?? '-') ?></td>
                                            <td class="text-center">
                                                <?= $bahan['penambahan'] ?? '0' ?>
                                                <?php if (($bahan['penambahan'] ?? 0) > 0): ?>
                                                    <span class="text-success">📈</span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-center">
                                                <?= $bahan['pengurangan'] ?? '0' ?>
                                                <?php if (($bahan['pengurangan'] ?? 0) > 0): ?>
                                                    <span class="text-danger">📉</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?= !empty($bahan['tanggal']) ? date('d/m/Y', strtotime($bahan['tanggal'])) : '-' ?>
                                            </td>
                                            <td><?= esc($bahan['tujuan_pemakaian'] ?? '-') ?></td>
                                            <td>
                                                <?php 
                                                $status = strtolower($bahan['status'] ?? '');
                                                if ($status === 'approve'): ?>
                                                    <span class="badge badge-success">✅ Approve</span>
                                                <?php elseif ($status === 'pending'): ?>
                                                    <span class="badge badge-warning">⏳ Pending</span>
                                                <?php elseif ($status === 'reject'): ?>
                                                    <span class="badge badge-danger">❌ Reject</span>
                                                <?php else: ?>
                                                    <span class="badge badge-secondary">❓ <?= ucfirst($status) ?></span>
                                                <?php endif; ?>
                                            </td>
                                            <td><?= esc($bahan['pesan'] ?? '-') ?></td>
                                            <td>
                                                <button class="btn btn-info btn-sm" onclick="showDetail('bahan', <?= $bahan['id_logbahan'] ?>)">
                                                    👁️ Detail
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="10" class="text-center">
                                            📭 Tidak ada data pemakaian bahan
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Link ke Pemakaian -->
                <div class="alert alert-light">
                    <strong>💡 Info:</strong> Ingin menambah data baru? 
                    <a href="/pemakaian" class="btn btn-sm btn-primary ml-2">📝 Buka Halaman Pemakaian</a>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- Detail Modal -->
<div class="modal fade" id="detailModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">📋 Detail Logbook</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" id="detailContent">
                <p>🔄 Loading data...</p>
            </div>
        </div>
    </div>
</div>

<!-- AdminLTE Scripts -->
<script src="<?= base_url('adminlte/AdminLTE-3.2.0/plugins/jquery/jquery.min.js') ?>"></script>
<script src="<?= base_url('adminlte/AdminLTE-3.2.0/plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
<script src="<?= base_url('adminlte/AdminLTE-3.2.0/dist/js/adminlte.min.js') ?>"></script>

<script>
function showDetail(jenis, id) {
    $('#detailContent').html('<p>🔄 Loading data...</p>');
    $('#detailModal').modal('show');

    $.get('<?= site_url("logbook/detail/") ?>' + jenis + '/' + id)
        .done(function(response) {
            if (response.success) {
                const detail = response.data;
                const jenisText = response.jenis === 'alat' ? 'Alat' : 'Bahan';

                let content = `<h5>👤 Informasi Pengguna</h5><ul>
            <li><strong>Nama:</strong> ${detail.nama_lengkap || '-'}</li>
            <li><strong>Email:</strong> ${detail.email || '-'}</li></ul>`;

                content += `<h5>${response.jenis === 'alat' ? '🔧' : '🧪'} Informasi ${jenisText}</h5><ul>
            <li><strong>Nama:</strong> ${detail.nama_alat || detail.nama_bahan || '-'}</li>
            <li><strong>Lokasi:</strong> ${detail.lokasi_alat || detail.lokasi_bahan || '-'}</li>`;
                if (detail.satuan_bahan) {
                    content += `<li><strong>Satuan:</strong> ${detail.satuan_bahan}</li>`;
                }
                content += `</ul>`;

                content += `<h5>📊 Detail Transaksi</h5><ul>
            <li><strong>Penambahan:</strong> ${detail.penambahan || '0'}</li>
            <li><strong>Pengurangan:</strong> ${detail.pengurangan || '0'}</li>`;
                if (response.jenis === 'alat') {
                    content += `<li><strong>Tanggal Dipinjam:</strong> ${detail.tanggal_dipinjam || '-'}</li>
                <li><strong>Tanggal Kembali:</strong> ${detail.tanggal_kembali || '-'}</li>`;
                } else {
                    content += `<li><strong>Tanggal:</strong> ${detail.tanggal || '-'}</li>`;
                }
                content += `<li><strong>Status:</strong> ${detail.status || '-'}</li>
            <li><strong>Tujuan Pemakaian:</strong> ${detail.tujuan_pemakaian || '-'}</li>
            <li><strong>Pesan:</strong> ${detail.pesan || '-'}</li>
        </ul>`;

                $('#detailContent').html(content);
            } else {
                $('#detailContent').html('<p>❌ Gagal memuat data.</p>');
            }
        })
        .fail(function(xhr, status, error) {
            $('#detailContent').html('<p>⚠️ Error: ' + error + '</p>');
        });
}
</script>

</body>
</html>