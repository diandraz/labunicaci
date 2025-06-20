<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Registrasi - Labunica Sistem</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= base_url('adminlte/AdminLTE-3.2.0/plugins/fontawesome-free/css/all.min.css') ?>">
    <!-- iCheck Bootstrap -->
    <link rel="stylesheet" href="<?= base_url('adminlte/AdminLTE-3.2.0/plugins/icheck-bootstrap/icheck-bootstrap.min.css') ?>">
    <!-- AdminLTE -->
    <link rel="stylesheet" href="<?= base_url('adminlte/AdminLTE-3.2.0/dist/css/adminlte.min.css') ?>">
    <!-- Custom Registrasi CSS -->
    <link rel="stylesheet" href="<?= base_url('css/registrasi.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/global.css') ?>">
</head>
<body class="hold-transition login-page">

<div class="login-box">
    <div class="login-logo">
        <a href="#"><b>Labunica</b> Registrasi</a>
    </div>

    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">🌟 Bergabunglah dengan kami!</p>

            <?php if(session()->getFlashdata('success')): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i>
                    <?= session()->getFlashdata('success') ?>
                </div>
            <?php endif; ?>

            <?php if(isset($validation)): ?>
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle"></i>
                    <?= $validation->listErrors() ?>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('registrasi/simpan') ?>" method="post" onsubmit="return validateForm()" id="registrationForm">
                <div class="input-group mb-3">
                    <input type="text" name="nama_lengkap" class="form-control" placeholder="👤 Nama Lengkap" required onkeypress="validateNameInput(event)">
                    <div class="input-group-append">
                        <div class="input-group-text"><span class="fas fa-user"></span></div>
                    </div>
                </div>

                <div class="input-group mb-3">
                    <input type="email" name="email" class="form-control" placeholder="📧 Alamat Email" required>
                    <div class="input-group-append">
                        <div class="input-group-text"><span class="fas fa-envelope"></span></div>
                    </div>
                </div>
                <?php if(isset($emailError)): ?>
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle"></i>
                        <?= $emailError ?>
                    </div>
                <?php endif; ?>

                <div class="input-group mb-3">
                    <input type="number" name="cohort" class="form-control" placeholder="📅 Tahun Masuk (Cohort)" required min="2" max="6">
                    <div class="input-group-append">
                        <div class="input-group-text"><span class="fas fa-calendar-alt"></span></div>
                    </div>
                </div>

                <div class="input-group mb-3">
                    <select name="prodi" class="form-control" required>
                        <option value="">🎓 Pilih Program Studi</option>
                        <option value="Kimia">Kimia</option>
                        <option value="Biologi">Biologi</option>
                        <option value="Fisika">Fisika</option>
                        <option value="Matematika">Matematika</option>
                    </select>
                </div>

                <div class="input-group mb-3">
                    <input type="password" name="password" id="password" class="form-control" placeholder="🔒 Password" required>
                    <div class="input-group-append">
                        <div class="input-group-text"><span class="fas fa-lock"></span></div>
                    </div>
                </div>
                <div class="mb-2">
                    <div class="d-flex align-items-center mb-2">
                        <input type="checkbox" id="showPassword" onclick="togglePassword('password')" style="margin-right: 8px;">
                        <label for="showPassword" style="margin: 0; cursor: pointer;">Tampilkan Password</label>
                    </div>
                    <small>
                        <i class="fas fa-info-circle"></i>
                        Password harus mengandung huruf besar, kecil, angka, dan simbol.
                    </small>
                    <div class="password-strength">
                        <div class="password-strength-bar" id="passwordStrengthBar"></div>
                    </div>
                </div>

                <div class="input-group mb-3">
                    <input type="password" name="password_confirm" id="password_confirm" class="form-control" placeholder="🔄 Konfirmasi Password" required>
                    <div class="input-group-append">
                        <div class="input-group-text"><span class="fas fa-lock"></span></div>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="d-flex align-items-center">
                        <input type="checkbox" id="showPasswordConfirm" onclick="togglePassword('password_confirm')" style="margin-right: 8px;">
                        <label for="showPasswordConfirm" style="margin: 0; cursor: pointer;">Tampilkan Konfirmasi Password</label>
                    </div>
                </div>

                <div class="row">
                    <div class="col-8 d-flex align-items-center">
                        <a href="<?= base_url('/login') ?>">
                            <i class="fas fa-arrow-left"></i> Sudah punya akun? Masuk
                        </a>
                    </div>
                    <div class="col-4">
                        <button type="submit" class="btn btn-primary btn-block" id="registerBtn">
                            <i class="fas fa-user-plus"></i> Daftar
                        </button>
                    </div>
                </div>
            </form>

            <!-- Additional Info -->
            <div class="text-center mt-4">
                <hr style="border-color: rgba(0,0,0,0.1);">
                <small class="text-muted">
                    <i class="fas fa-shield-alt"></i> 
                    Data Anda aman dan terlindungi
                </small>
            </div>
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

    // Password strength checker
    function checkPasswordStrength(password) {
        const strengthBar = document.getElementById('passwordStrengthBar');
        let strength = 0;
        
        if (password.length >= 8) strength++;
        if (/[a-z]/.test(password)) strength++;
        if (/[A-Z]/.test(password)) strength++;
        if (/[0-9]/.test(password)) strength++;
        if (/[^A-Za-z0-9]/.test(password)) strength++;
        
        const classes = ['strength-weak', 'strength-fair', 'strength-good', 'strength-strong'];
        strengthBar.className = 'password-strength-bar';
        
        if (strength > 0) {
            strengthBar.classList.add(classes[Math.min(strength - 1, 3)]);
        }
    }

    // Add password strength checker
    document.getElementById('password').addEventListener('input', function() {
        checkPasswordStrength(this.value);
    });

    // Validasi password sebelum submit
    function validateForm() {
        const password = document.getElementById('password').value;
        const passwordConfirm = document.getElementById('password_confirm').value;
        const regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/;

        if (!regex.test(password)) {
            alert("❌ Password harus memiliki huruf besar, huruf kecil, angka, dan karakter spesial.");
            return false;
        }

        if (password !== passwordConfirm) {
            alert("❌ Konfirmasi password tidak sesuai.");
            return false;
        }

        if (password.length < 8) {
            alert("❌ Password minimal 8 karakter.");
            return false;
        }

        return true;
    }

    // Form enhancement
    document.getElementById('registrationForm').addEventListener('submit', function(e) {
        const registerBtn = document.getElementById('registerBtn');
        registerBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mendaftar...';
        registerBtn.disabled = true;
    });

    // Auto-hide alerts after 5 seconds
    setTimeout(function() {
        document.querySelectorAll('.alert').forEach(function(alert) {
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 500);
        });
    }, 5000);

    // Add floating label effect
    document.querySelectorAll('.form-control').forEach(function(input) {
        input.addEventListener('focus', function() {
            this.parentElement.classList.add('focused');
        });
        
        input.addEventListener('blur', function() {
            if (!this.value) {
                this.parentElement.classList.remove('focused');
            }
        });
    });
</script>

</body>
</html>
