<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login - LABUNICA</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?= base_url('adminlte/AdminLTE-3.2.0/plugins/fontawesome-free/css/all.min.css') ?>">
  <!-- iCheck Bootstrap -->
  <link rel="stylesheet" href="<?= base_url('adminlte/AdminLTE-3.2.0/plugins/icheck-bootstrap/icheck-bootstrap.min.css') ?>">
  <!-- AdminLTE -->
  <link rel="stylesheet" href="<?= base_url('adminlte/AdminLTE-3.2.0/dist/css/adminlte.min.css') ?>">
  <!-- Custom Login CSS -->
  <link rel="stylesheet" href="<?= base_url('css/login.css') ?>">
  <link rel="stylesheet" href="<?= base_url('css/global.css') ?>">

</head>
<body class="hold-transition login-page">

<div class="login-box">
  <div class="login-logo">
    <a href="#"><b>LABUNICA</b> </a>
  </div>

  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">🌟 Selamat datang kembali!</p>

      <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger">
          <i class="fas fa-exclamation-triangle"></i>
          <?= session()->getFlashdata('error') ?>
        </div>
      <?php endif; ?>

      <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success">
          <i class="fas fa-check-circle"></i>
          <?= session()->getFlashdata('success') ?>
        </div>
      <?php endif; ?>

      <form action="<?= base_url('/login/auth') ?>" method="post" id="loginForm">
        <div class="input-group mb-3">
          <input type="email" name="email" class="form-control" placeholder="📧 Masukkan email Anda" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>

        <div class="input-group mb-3">
          <input type="password" name="password" class="form-control" placeholder="🔒 Masukkan password Anda" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-8 d-flex align-items-center">
            <a href="<?= base_url('/registrasi') ?>">
              <i class="fas fa-user-plus"></i> Belum punya akun? Daftar
            </a>
          </div>
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block" id="loginBtn">
              <i class="fas fa-sign-in-alt"></i> Masuk
            </button>
          </div>
        </div>
      </form>

      <!-- Additional Info -->
      <div class="text-center mt-4">
        <hr style="border-color: rgba(0,0,0,0.1);">
        <small class="text-muted">
          <i class="fas fa-shield-alt"></i> 
          Sistem aman dan terpercaya
        </small>
      </div>
    </div>
  </div>
</div>

<!-- JS Dependencies -->
<script src="<?= base_url('adminlte/AdminLTE-3.2.0/plugins/jquery/jquery.min.js') ?>"></script>
<script src="<?= base_url('adminlte/AdminLTE-3.2.0/plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
<script src="<?= base_url('adminlte/AdminLTE-3.2.0/dist/js/adminlte.min.js') ?>"></script>

<script>
// Simple form enhancement
document.getElementById('loginForm').addEventListener('submit', function(e) {
    const loginBtn = document.getElementById('loginBtn');
    loginBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Masuk...';
    loginBtn.disabled = true;
});

// Auto-hide alerts after 5 seconds
setTimeout(function() {
    document.querySelectorAll('.alert').forEach(function(alert) {
        alert.style.opacity = '0';
        setTimeout(() => alert.remove(), 500);
    });
}, 5000);
</script>

</body>
</html>
