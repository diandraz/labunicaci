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

<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo">
        <a href="#"><b>Registrasi</b> Akun</a>
    </div>

    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">Silakan isi data untuk mendaftar</p>

            <?php if(session()->getFlashdata('success')): ?>
                <div class="alert alert-success">
                    <?= session()->getFlashdata('success') ?>
                </div>
            <?php endif; ?>

            <?php if(isset($validation)): ?>
                <div class="alert alert-danger">
                    <?= $validation->listErrors() ?>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('registrasi/simpan') ?>" method="post" onsubmit="return validateForm()">
                <div class="input-group mb-3">
                    <input type="text" name="nama_lengkap" class="form-control" placeholder="Nama Lengkap" required onkeypress="validateNameInput(event)">
                    <div class="input-group-append">
                        <div class="input-group-text"><span class="fas fa-user"></span></div>
                    </div>
                </div>

                <div class="input-group mb-3">
                    <input type="email" name="email" class="form-control" placeholder="Email" required>
                    <div class="input-group-append">
                        <div class="input-group-text"><span class="fas fa-envelope"></span></div>
                    </div>
                </div>
                <?php if(isset($emailError)): ?>
                    <p style="color:red"><?= $emailError ?></p>
                <?php endif; ?>

                <div class="input-group mb-3">
                    <input type="number" name="cohort" class="form-control" placeholder="Cohort" required>
                    <div class="input-group-append">
                        <div class="input-group-text"><span class="fas fa-calendar-alt"></span></div>
                    </div>
                </div>

                <div class="input-group mb-3">
                    <select name="prodi" class="form-control" required>
                        <option value="">-- Pilih Prodi --</option>
                        <option value="Kimia">Kimia</option>
                    </select>
                </div>

                <div class="input-group mb-3">
                    <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
                    <div class="input-group-append">
                        <div class="input-group-text"><span class="fas fa-lock"></span></div>
                    </div>
                </div>
                <div class="mb-2">
                    <input type="checkbox" onclick="togglePassword('password')"> Lihat Password<br>
                    <small>Password harus mengandung huruf besar, kecil, angka, dan simbol.</small>
                </div>

                <div class="input-group mb-3">
                    <input type="password" name="password_confirm" id="password_confirm" class="form-control" placeholder="Ulangi Password" required>
                    <div class="input-group-append">
                        <div class="input-group-text"><span class="fas fa-lock"></span></div>
                    </div>
                </div>
                <div class="mb-3">
                    <input type="checkbox" onclick="togglePassword('password_confirm')"> Lihat Ulangi Password
                </div>

                <div class="row">
                    <div class="col-8">
                        <a href="<?= base_url('/login') ?>">Sudah punya akun?</a>
                    </div>
                    <div class="col-4">
                        <button type="submit" class="btn btn-primary btn-block">Daftar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- JS -->
<script src="<?= base_url('adminlte/AdminLTE-3.2.0/plugins/jquery/jquery.min.js') ?>"></script>
<script src="<?= base_url('adminlte/AdminLTE-3.2.0/plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
<script src="<?= base_url('adminlte/AdminLTE-3.2.0/dist/js/adminlte.min.js') ?>"></script>

<script>
    // Validasi nama hanya huruf
    function validateNameInput(event) {
        const char = String.fromCharCode(event.which);
        if (!/^[a-zA-Z\s]+$/.test(char)) {
            event.preventDefault();
        }
    }

    // Toggle show/hide password
    function togglePassword(id) {
        const field = document.getElementById(id);
        field.type = field.type === "password" ? "text" : "password";
    }

    // Validasi password sebelum submit
    function validateForm() {
        const password = document.getElementById('password').value;
        const regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/;

        if (!regex.test(password)) {
            alert("Password harus memiliki huruf besar, huruf kecil, angka, dan karakter spesial.");
            return false;
        }

        return true;
    }
</script>
</body>
</html>
