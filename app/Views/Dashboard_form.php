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
                <h1 class="dashboard-title mb-2">Dashboard Laboratorium</h1>
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

                <!-- Statistik Section -->
                <h4 class="section-title mb-3">Statistik Overview</h4>
                <div class="row g-3 mb-4">
                    <div class="col-md-3">
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3><?= $stats_inventory['total_alat'] ?? 0 ?></h3>
                                <p>Total Alat</p>
                            </div>
                            <div class="icon"><i class="fas fa-wrench"></i></div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3><?= $stats_inventory['total_bahan'] ?? 0 ?></h3>
                                <p>Total Bahan</p>
                            </div>
                            <div class="icon"><i class="fas fa-flask"></i></div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3><?= $stats_inventory['total_instrumen'] ?? 0 ?></h3>
                                <p>Total Instrumen</p>
                            </div>
                            <div class="icon"><i class="fas fa-ruler"></i></div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3><?= ($stats_inventory['alat_stok_rendah'] ?? 0) + ($stats_inventory['bahan_stok_rendah'] ?? 0) + ($stats_inventory['instrumen_stok_rendah'] ?? 0) ?></h3>
                                <p>Stok Rendah</p>
                            </div>
                            <div class="icon"><i class="fas fa-exclamation-circle"></i></div>
                        </div>
                    </div>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-md-3">
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3><?= $stats_aktivitas['aktivitas_hari_ini'] ?? 0 ?></h3>
                                <p>Hari Ini</p>
                            </div>
                            <div class="icon"><i class="fas fa-calendar-day"></i></div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3><?= $stats_aktivitas['aktivitas_minggu_ini'] ?? 0 ?></h3>
                                <p>Minggu Ini</p>
                            </div>
                            <div class="icon"><i class="fas fa-calendar-week"></i></div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3><?= ($stats_aktivitas['peminjaman_pending'] ?? 0) + ($stats_aktivitas['pemakaian_pending'] ?? 0) ?></h3>
                                <p>Pending</p>
                            </div>
                            <div class="icon"><i class="fas fa-hourglass-half"></i></div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3><?= $stats_aktivitas['alat_belum_kembali'] ?? 0 ?></h3>
                                <p>Belum Kembali</p>
                            </div>
                            <div class="icon"><i class="fas fa-undo-alt"></i></div>
                        </div>
                    </div>
                </div>

                <?php if (session('role') === 'admin'): ?>
                    <div class="row g-3 mb-4">
                        <div class="col-md-3">
                            <div class="small-box bg-primary">
                                <div class="inner">
                                    <h3><?= $stats_user['total_user'] ?? 0 ?></h3>
                                    <p>Total User</p>
                                </div>
                                <div class="icon"><i class="fas fa-users"></i></div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3><?= $stats_user['user_aktif'] ?? 0 ?></h3>
                                    <p>User Aktif</p>
                                </div>
                                <div class="icon"><i class="fas fa-user-check"></i></div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="small-box bg-warning">
                                <div class="inner">
                                    <h3><?= $stats_user['user_pending'] ?? 0 ?></h3>
                                    <p>User Pending</p>
                                </div>
                                <div class="icon"><i class="fas fa-user-clock"></i></div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="small-box bg-danger">
                                <div class="inner">
                                    <h3><?= $stats_user['admin_count'] ?? 0 ?></h3>
                                    <p>Admin</p>
                                </div>
                                <div class="icon"><i class="fas fa-user-shield"></i></div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Chart Section -->
                <h4 class="section-title mb-3">Analisis Data</h4>
                <div class="row g-4 mb-5">
                    <div class="col-md-6">
                        <div class="card card-outline card-primary h-100">
                            <div class="card-header">
                                <h3 class="card-title">Distribusi Inventory</h3>
                            </div>
                            <div class="card-body">
                                <canvas id="inventoryChart"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card card-outline card-info h-100">
                            <div class="card-header">
                                <h3 class="card-title">Aktivitas 7 Hari Terakhir</h3>
                            </div>
                            <div class="card-body">
                                <canvas id="weeklyChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

            </div> <!-- .container -->
        </div> <!-- .content -->
    </div> <!-- .content-wrapper -->
</div> <!-- .wrapper -->

<!-- Scripts -->
<script src="<?= base_url('adminlte/AdminLTE-3.2.0/plugins/jquery/jquery.min.js') ?>"></script>
<script src="<?= base_url('adminlte/AdminLTE-3.2.0/plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
<script src="<?= base_url('adminlte/AdminLTE-3.2.0/dist/js/adminlte.min.js') ?>"></script>

<script>
<?php if (!empty($chart_data['inventory_chart'])): ?>
const inventoryCtx = document.getElementById('inventoryChart').getContext('2d');
new Chart(inventoryCtx, {
    type: 'doughnut',
    data: {
        labels: <?= json_encode($chart_data['inventory_chart']['labels']) ?>,
        datasets: [{
            data: <?= json_encode($chart_data['inventory_chart']['data']) ?>,
            backgroundColor: ['#007bff', '#28a745', '#ffc107'],
            borderWidth: 2
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { position: 'bottom' } }
    }
});
<?php endif; ?>

<?php if (!empty($chart_data['aktivitas_mingguan'])): ?>
const weeklyCtx = document.getElementById('weeklyChart').getContext('2d');
new Chart(weeklyCtx, {
    type: 'line',
    data: {
        labels: <?= json_encode($chart_data['aktivitas_mingguan']['labels']) ?>,
        datasets: [{
            label: 'Aktivitas',
            data: <?= json_encode($chart_data['aktivitas_mingguan']['data']) ?>,
            borderColor: '#007bff',
            backgroundColor: 'rgba(0,123,255,0.1)',
            fill: true,
            tension: 0.4
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true,
                ticks: { stepSize: 1 }
            }
        }
    }
});
<?php endif; ?>

setTimeout(() => location.reload(), 300000); // refresh tiap 5 menit
</script>

</body>
</html>

