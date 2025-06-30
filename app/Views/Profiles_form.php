<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Laboratorium</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('adminlte/AdminLTE-3.2.0/plugins/fontawesome-free/css/all.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('adminlte/AdminLTE-3.2.0/dist/css/adminlte.min.css') ?>">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&family=Poppins:wght@400;600&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', 'Inter', sans-serif;
            background: url('<?= base_url('adminlte/AdminLTE-3.2.0/dist/img/1.jpg') ?>') no-repeat center center fixed !important;
            background-size: cover !important;
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
        .section-title {
            font-size: 1.2rem;
            font-weight: 500;
            border-left: 4px solid white;
            padding-left: 10px;
            color: white;
        }
    </style>
</head>

<body class="hold-transition layout-navbar-fixed layout-top-nav">
<div class="wrapper">
    <?= view('partial/header') ?>

    <div class="content-wrapper">
        <div class="content-header">
            <div class="container py-2">
                <h1 class="dashboard-title mb-2">Profil Saya</h1>
                <p class="welcome-text mb-3">Selamat datang di menu perubahan profil</p>
            </div>
        </div>

        <div class="content">
            <div class="container">
                <h4 class="section-title mb-3">Informasi Akun</h4>

                <?php if(session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
                <?php endif; ?>
                <?php if(session()->getFlashdata('success')): ?>
                    <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
                <?php endif; ?>

                <div class="card mb-4">
                    <div class="card-body">
                        <div class="mb-3">
                            <p><strong>Nama:</strong> <?= esc($user['nama_lengkap']) ?></p>
                            <p><strong>Cohort:</strong> <?= esc($user['cohort']) ?></p>
                            <p><strong>Prodi:</strong> <?= esc($user['prodi']) ?></p>
                        </div>

                        <?php if($user['foto_profil']): ?>
                            <div class="mb-3">
                                <img src="<?= base_url('uploads/' . $user['foto_profil']) ?>" width="150" class="img-thumbnail">
                            </div>
                        <?php endif; ?>

                        <form action="<?= base_url('profiles/update') ?>" method="post" enctype="multipart/form-data">
                            <?= csrf_field() ?>

                            <div class="form-group mb-3">
                                <label>Password Lama:</label>
                                <input type="password" name="old_password" class="form-control" required>
                            </div>

                            <div class="form-group mb-3">
                                <label>Password Baru:</label>
                                <input type="password" name="password" class="form-control">
                            </div>

                            <div class="form-group mb-3">
                                <label>Ulangi Password:</label>
                                <input type="password" name="repassword" class="form-control">
                            </div>

                            <div class="form-group mb-4">
                                <label>Upload Foto Profil:</label>
                                <input type="file" name="foto_profil" class="form-control">
                            </div>

                            <button type="submit" class="btn btn-primary">Update</button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<script src="<?= base_url('adminlte/AdminLTE-3.2.0/plugins/jquery/jquery.min.js') ?>"></script>
<script src="<?= base_url('adminlte/AdminLTE-3.2.0/plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
<script src="<?= base_url('adminlte/AdminLTE-3.2.0/dist/js/adminlte.min.js') ?>"></script>
</body>
</html>
