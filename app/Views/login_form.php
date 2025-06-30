<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

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
      background: url('<?= base_url('adminlte/AdminLTE-3.2.0/dist/img/3.jpg') ?>') no-repeat center center fixed;
      background-size: cover;
      position: relative;
    }

    body::before {
      content: '';
      position: fixed;
      top: 0;
      left: 0;
      width: 100vw;
      height: 100vh;
      background: rgba(0, 0, 0, 0.5);
      z-index: -1;
    }

    .login-logo a {
      color: #fff !important;
    }

    /* CAPTCHA STYLING */
    .captcha-box {
      background: linear-gradient(45deg, #f8f9fa, #e9ecef);
      border: 2px solid #dee2e6;
      padding: 12px 15px;
      text-align: center;
      font-family: 'Courier New', monospace;
      font-size: 20px;
      font-weight: bold;
      letter-spacing: 3px;
      color: #495057;
      border-radius: 5px;
      user-select: none;
      position: relative;
      overflow: hidden;
    }

    .captcha-box::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: repeating-linear-gradient(
        45deg,
        transparent,
        transparent 2px,
        rgba(0,0,0,0.1) 2px,
        rgba(0,0,0,0.1) 4px
      );
      pointer-events: none;
    }

    .captcha-refresh {
      color: #007bff;
      cursor: pointer;
      font-size: 14px;
      text-decoration: none;
      margin-top: 5px;
      display: inline-block;
    }

    .captcha-refresh:hover {
      color: #0056b3;
      text-decoration: underline;
    }

    .captcha-loading {
      opacity: 0.6;
      pointer-events: none;
    }
  </style>
  <link rel="icon" href="<?= base_url('assets/images/favicon.ico') ?>" type="image/x-icon">
</head>

<body class="hold-transition login-page">

  <div class="login-box">
    <div class="login-logo text-center">
      <img src="<?= base_url('adminlte/AdminLTE-3.2.0/dist/img/logo.png') ?>" alt="Logo Labunica" style="max-width:250px; margin-bottom:4px; display:block; margin-left:auto; margin-right:auto;">
    </div>

    <div class="card">
      <div class="card-body login-card-body">
        <p class="login-box-msg">Silakan login untuk melanjutkan</p>

        <?php if (session()->getFlashdata('error')): ?>
          <div class="alert alert-danger">
            <?= session()->getFlashdata('error') ?>
          </div>
        <?php endif; ?>

        <form action="<?= base_url('/login/auth') ?>" method="post">
          
          <!-- EMAIL INPUT -->
          <div class="input-group mb-3">
            <input type="email" name="email" class="form-control" placeholder="Email" 
                   value="<?= old('email') ?>" required>
            <div class="input-group-append">
              <div class="input-group-text"><span class="fas fa-envelope"></span></div>
            </div>
          </div>

          <!-- PASSWORD INPUT -->
          <div class="input-group mb-3">
            <input type="password" name="password" class="form-control" placeholder="Password" required>
            <div class="input-group-append">
              <div class="input-group-text"><span class="fas fa-lock"></span></div>
            </div>
          </div>

          <!-- CAPTCHA SECTION -->
          <div class="mb-3">
            <label class="form-label">🔒 Kode Keamanan</label>
            
            <!-- CAPTCHA DISPLAY -->
            <div class="captcha-box" id="captcha-display">
              <?= session()->getFlashdata('captcha') ?? $captcha ?? 'ERROR' ?>
            </div>
            
            <!-- REFRESH CAPTCHA LINK -->
            <div class="text-center mt-2">
              <a href="#" class="captcha-refresh" id="refresh-captcha">
                🔄 Ganti Kode Baru
              </a>
            </div>
            
            <!-- CAPTCHA INPUT -->
            <div class="input-group mt-2">
              <input type="text" name="captcha" id="captcha-input" class="form-control" 
                     placeholder="Masukkan kode di atas" maxlength="5" required 
                     autocomplete="off" style="text-align: center; font-family: 'Courier New', monospace; font-size: 16px; letter-spacing: 2px;">
              <div class="input-group-append">
                <div class="input-group-text"><span class="fas fa-shield-alt"></span></div>
              </div>
            </div>
            <small class="text-muted">💡 Masukkan 5 karakter sesuai kode di atas (huruf besar/kecil tidak berpengaruh)</small>
          </div>

          <!-- SUBMIT BUTTON -->
          <div class="row">
            <div class="col-8 d-flex align-items-center">
              <a href="<?= base_url('/registrasi') ?>">Daftar akun baru</a>
            </div>
            <div class="col-4">
              <button type="submit" class="btn btn-primary btn-block" id="login-btn">
                <span class="login-text">Login</span>
                <span class="login-loading d-none">
                  <i class="fas fa-spinner fa-spin"></i> 
                </span>
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- JS Dependencies -->
  <script src="<?= base_url('adminlte/AdminLTE-3.2.0/plugins/jquery/jquery.min.js') ?>"></script>
  <script src="<?= base_url('adminlte/AdminLTE-3.2.0/plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
  <script src="<?= base_url('adminlte/AdminLTE-3.2.0/dist/js/adminlte.min.js') ?>"></script>

  <script>
    $(document).ready(function() {
        
        // Refresh Captcha Function
        $('#refresh-captcha').click(function(e) {
            e.preventDefault();
            
            // Add loading state
            $(this).addClass('captcha-loading').text('🔄 Memuat...');
            $('#captcha-display').addClass('captcha-loading');
            
            // AJAX request untuk refresh captcha
            $.get('<?= base_url('/login/refresh-captcha') ?>')
                .done(function(response) {
                    if (response.success) {
                        $('#captcha-display').text(response.captcha);
                        $('#captcha-input').val('').focus();
                    } else {
                        alert('❌ Gagal memuat captcha baru');
                    }
                })
                .fail(function() {
                    alert('⚠️ Error: Tidak dapat terhubung ke server');
                })
                .always(function() {
                    // Remove loading state
                    $('#refresh-captcha').removeClass('captcha-loading').text('🔄 Ganti Kode Baru');
                    $('#captcha-display').removeClass('captcha-loading');
                });
        });

        // Form submission loading state
        $('form').submit(function() {
            $('#login-btn').prop('disabled', true);
            $('.login-text').addClass('d-none');
            $('.login-loading').removeClass('d-none');
        });

        // Auto focus to captcha after password
        $('input[name="password"]').blur(function() {
            $('#captcha-input').focus();
        });

    });
  </script>

</body>

</html>