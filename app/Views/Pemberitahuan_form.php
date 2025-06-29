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

<div class="wrapper">
    <?= view('partial/header') ?>

    <div class="content-wrapper">
        <div class="content-header">
            <div class="container py-2">
                <h1 class="dashboard-title mb-2">Pemberitahuan</h1>
                <p class="welcome-text mb-3">
                    Halaman notifikasi peminjaman dan penggunaan
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

                <?php if (session()->get('role') === 'admin'): ?>

                    <!-- Statistik Section -->
                <h4 class="section-title mb-3">Daftar Peminjaman Alat</h4>
                    <div class="card mb-5">
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Nama Lengkap</th>
                                        <th>Nama Alat</th>
                                        <th>Jumlah Peminjaman</th>
                                        <th>Tujuan</th>
                                        <th>Pesan</th>
                                        <th>Tanggal Dipinjam</th>
                                        <th>Tanggal Kembali</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead> 
                                <tbody>
                                    <?php if (!empty($alat)): ?>
                                        <?php foreach ($alat as $item): ?>
                                            <tr>
                                                <td><?= esc($item->nama_lengkap) ?></td>
                                                <td><?= esc($item->nama_alat) ?></td>
                                                <td><?= esc($item->pengurangan) ?></td>
                                                <td><?= esc($item->tujuan_pemakaian) ?></td>
                                                <td><?= esc($item->pesan) ?></td>
                                                <td><?= esc($item->tanggal_dipinjam) ?></td>
                                                <td><?= esc($item->tanggal_kembali) ?></td>
                                                <td><?= esc($item->status) ?></td>
                                                <td>
                                                    <form action="/pemberitahuan/approveAlat" method="post" style="display:inline;">
                                                        <?= csrf_field() ?>
                                                        <input type="hidden" name="id_logalat" value="<?= $item->id_logalat ?>">
                                                        <button type="submit" class="btn btn-success btn-sm">✔</button>
                                                    </form>
                                                    <form action="/pemberitahuan/declineAlat" method="post" style="display:inline;">
                                                        <?= csrf_field() ?>
                                                        <input type="hidden" name="id_logalat" value="<?= $item->id_logalat ?>">
                                                        <button type="submit" class="btn btn-danger btn-sm">✖</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        <?php endforeach ?>
                                    <?php else: ?>
                                        <tr><td colspan="9">belum ada alat terpinjam</td></tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                <h4 class="section-title mb-3">Daftar Pengambilan Bahan</h4>
                    <!-- Daftar Pengambilan Bahan -->
                    <div class="card mb-5">
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Nama Lengkap</th>
                                        <th>Nama Bahan</th>
                                        <th>Jumlah Pengambilan</th>
                                        <th>Tujuan</th>
                                        <th>Pesan</th>
                                        <th>Tanggal</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($bahan)): ?>
                                        <?php foreach ($bahan as $item): ?>
                                            <tr>
                                                <td><?= esc($item->nama_lengkap) ?></td>
                                                <td><?= esc($item->nama_bahan) ?></td>
                                                <td><?= esc($item->pengurangan) ?></td>
                                                <td><?= esc($item->tujuan_pemakaian) ?></td>
                                                <td><?= esc($item->pesan) ?></td>
                                                <td><?= esc($item->tanggal) ?></td>
                                                <td><?= esc($item->status) ?></td>
                                                <td>
                                                    <form action="/pemberitahuan/approveBahan" method="post" style="display:inline;">
                                                        <?= csrf_field() ?>
                                                        <input type="hidden" name="id_logbahan" value="<?= $item->id_logbahan ?>">
                                                        <button type="submit" class="btn btn-success btn-sm">✔</button>
                                                    </form>
                                                    <form action="/pemberitahuan/declineBahan" method="post" style="display:inline;">
                                                        <?= csrf_field() ?>
                                                        <input type="hidden" name="id_logbahan" value="<?= $item->id_logbahan ?>">
                                                        <button type="submit" class="btn btn-danger btn-sm">✖</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        <?php endforeach ?>
                                    <?php else: ?>
                                        <tr><td colspan="8">Belum ada alat atau bahan terambil</td></tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                <?php endif; ?>

                <?php if (session()->get('role') === 'user'): ?>
                <h4 class="section-title mb-3">Daftar Pengambilan Bahan</h4>
                    <!-- Daftar Pengambilan Bahan -->
                    <div class="card mb-5">
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Nama Lengkap</th>
                                        <th>Nama Alat</th>
                                        <th>Jumlah</th>
                                        <th>Tujuan</th>
                                        <th>Pesan</th>
                                        <th>Tanggal Dipinjam</th>
                                        <th>Tanggal Kembali</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($alatDipinjam)): ?>
                                        <?php foreach ($alatDipinjam as $item): ?>
                                            <tr>
                                                <td><?= esc($item->nama_lengkap) ?></td>
                                                <td><?= esc($item->nama_alat) ?></td>
                                                <td><?= esc($item->pengurangan) ?></td>
                                                <td><?= esc($item->tujuan_pemakaian) ?></td>
                                                <td><?= esc($item->pesan) ?></td>
                                                <td><?= esc($item->tanggal_dipinjam) ?></td>
                                                <td><?= esc($item->tanggal_kembali) ?></td>
                                                <td><?= esc($item->status) ?></td>
                                                <td>
                                                    <form action="/pemberitahuan/returnAlat" method="post" style="display:inline;">
                                                        <?= csrf_field() ?>
                                                        <input type="hidden" name="id_logalat" value="<?= $item->id_logalat ?>">
                                                        <button type="submit" class="btn btn-primary btn-sm">✔ Kembalikan</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        <?php endforeach ?>
                                    <?php else: ?>
                                        <tr><td colspan="9">Belum ada peminjaman</td></tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php endif; ?>

            </div>
        </div>
    </div>

</div>

<!-- AdminLTE JS -->
<script src="<?= base_url('adminlte/AdminLTE-3.2.0/plugins/jquery/jquery.min.js') ?>"></script>
<script src="<?= base_url('adminlte/AdminLTE-3.2.0/plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
<script src="<?= base_url('adminlte/AdminLTE-3.2.0/dist/js/adminlte.min.js') ?>"></script>
</body>
</html>
