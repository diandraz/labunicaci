<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Manajemen User</title>

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
            background: url('<?= base_url('adminlte/AdminLTE-3.2.0/dist/img/6.jpg') ?>') no-repeat center center fixed !important;
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
    <?= view('partial/header') ?>

    <div class="content-wrapper">
   <div class="content-header">
            <div class="container py-2">
                <h1 class="dashboard-title mb-2">Manajemen User</h1>
                <p class="welcome-text mb-3">
                    Kelola pengguna sistem laboratorium
                </p>
            </div>
        </div>

        <div class="content">
            <div class="container">

                <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <i class="fas fa-check-circle"></i> <?= session()->getFlashdata('success') ?>
                    </div>
                <?php elseif (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <i class="fas fa-exclamation-circle"></i> <?= session()->getFlashdata('error') ?>
                    </div>
                <?php endif; ?>

                <!-- Statistik User -->
                <div class="row mb-4">
                    <div class="col-md-12">
                        <h3 class="section-title mb-3">Statistik User</h3>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-primary text-white">
                            <div class="card-body text-center">
                                <h2 class="card-title"><?= $stats['total_user'] ?></h2>
                                <p class="card-text">Total User</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-warning text-white">
                            <div class="card-body text-center">
                                <h2 class="card-title"><?= $stats['total_admin'] ?></h2>
                                <p class="card-text">Admin</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-success text-white">
                            <div class="card-body text-center">
                                <h2 class="card-title"><?= $stats['total_regular_user'] ?></h2>
                                <p class="card-text">Regular User</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="row mb-3">
                    <div class="col-md-12">
                        <a href="<?= site_url('manajemen-user/export') ?>" class="btn btn-success">
                            <i class="fas fa-file-csv"></i> Export CSV
                        </a>
                    </div>
                </div>

                <!-- Filter Section -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5></i> Filter & Pencarian</h5>
                    </div>
                    <div class="card-body">
                        <form method="GET" action="<?= site_url('manajemen-user') ?>" id="filterForm">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label></i> Cari User</label>
                                        <input type="text" name="search" id="searchInput" value="<?= esc($search) ?>" 
                                               placeholder="Nama, email, cohort, prodi..." class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label></i> Filter Role</label>
                                        <select name="role" id="roleFilter" class="form-control">
                                            <option value="">Semua Role</option>
                                            <option value="admin" <?= $role === 'admin' ? 'selected' : '' ?>>Admin</option>
                                            <option value="user" <?= $role === 'user' ? 'selected' : '' ?>>User</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>&nbsp;</label><br>
                                        <button type="submit" class="btn btn-primary btn-block">
                                            <i class="fas fa-search"></i> Filter
                                        </button>
                                        <a href="<?= site_url('manajemen-user') ?>" class="btn btn-warning btn-block mt-1">
                                            <i class="fas fa-redo"></i> Reset
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Daftar User -->
                <div class="card">
                    <div class="card-header">
                        <h5></i> Daftar User</h5>
                        <p class="mb-0">Menampilkan <?= count($users) ?> dari <?= $totalUsers ?> user</p>
                    </div>
                    <div class="card-body p-0">
                        <?php if (!empty($users)): ?>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover mb-0 table-user">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Foto</th>
                                            <th>Nama Lengkap</th>
                                            <th>Email</th>
                                            <th>Cohort</th>
                                            <th>Program Studi</th>
                                            <th>Role</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = ($currentPage - 1) * $perPage + 1; ?>
                                        <?php foreach ($users as $user): ?>
                                            <tr>
                                                <td><?= $no++ ?></td>
                                                <td>
                                                    <?php if (!empty($user['foto_profil'])): ?>
                                                        <img src="<?= base_url('uploads/profiles/' . $user['foto_profil']) ?>" 
                                                             class="img-circle" alt="Foto <?= esc($user['nama_lengkap']) ?>">
                                                    <?php else: ?>
                                                        <div class="img-circle bg-secondary d-flex align-items-center justify-content-center" 
                                                             style="width: 40px; height: 40px; font-size: 18px;">
                                                            <i class="fas fa-user"></i>
                                                        </div>
                                                    <?php endif; ?>
                                                </td>
                                                <td><strong><?= esc($user['nama_lengkap']) ?></strong></td>
                                                <td><?= esc($user['email']) ?></td>
                                                <td><?= esc($user['cohort']) ?></td>
                                                <td><?= esc($user['prodi']) ?></td>
                                                <td>
                                                    <?php if ($user['role'] === 'admin'): ?>
                                                        <span class="badge badge-warning badge-lg">
                                                            <i class="fas fa-crown"></i> Admin
                                                        </span>
                                                    <?php else: ?>
                                                        <span class="badge badge-primary badge-lg">
                                                            <i class="fas fa-user"></i> User
                                                        </span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <div class="btn-group-vertical btn-group-sm">
                                                        <button onclick="showDetail(<?= $user['id_regis'] ?>)" 
                                                                class="btn btn-info btn-sm mb-1">
                                                            <i class="fas fa-eye"></i> Detail
                                                        </button>
                                                        
                                                        <?php if ($user['role'] === 'user'): ?>
                                                            <button onclick="updateRole(<?= $user['id_regis'] ?>, 'admin')" 
                                                                    class="btn btn-warning btn-sm mb-1">
                                                                <i class="fas fa-crown"></i> Jadikan Admin
                                                            </button>
                                                        <?php else: ?>
                                                            <button onclick="updateRole(<?= $user['id_regis'] ?>, 'user')" 
                                                                    class="btn btn-secondary btn-sm mb-1">
                                                                <i class="fas fa-user"></i> Jadikan User
                                                            </button>
                                                        <?php endif; ?>
                                                        
                                                        <button onclick="resetPassword(<?= $user['id_regis'] ?>)" 
                                                                class="btn btn-success btn-sm mb-1">
                                                            <i class="fas fa-key"></i> Reset Password
                                                        </button>
                                                        
                                                        <?php if ($user['id_regis'] != session()->get('id_regis')): ?>
                                                            <button onclick="deleteUser(<?= $user['id_regis'] ?>, '<?= esc($user['nama_lengkap']) ?>')" 
                                                                    class="btn btn-danger btn-sm">
                                                                <i class="fas fa-trash"></i> Hapus
                                                            </button>
                                                        <?php endif; ?>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
                            <?php if ($totalPages > 1): ?>
                                <div class="card-footer">
                                    <nav aria-label="Page navigation">
                                        <ul class="pagination justify-content-center mb-0">
                                            <?php if ($currentPage > 1): ?>
                                                <li class="page-item">
                                                    <a class="page-link" href="<?= site_url('manajemen-user?page=' . ($currentPage - 1) . '&search=' . urlencode($search) . '&role=' . urlencode($role)) ?>">
                                                        <i class="fas fa-chevron-left"></i> Previous
                                                    </a>
                                                </li>
                                            <?php endif; ?>

                                            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                                <li class="page-item <?= $i == $currentPage ? 'active' : '' ?>">
                                                    <a class="page-link" href="<?= site_url('manajemen-user?page=' . $i . '&search=' . urlencode($search) . '&role=' . urlencode($role)) ?>">
                                                        <?= $i ?>
                                                    </a>
                                                </li>
                                            <?php endfor; ?>

                                            <?php if ($currentPage < $totalPages): ?>
                                                <li class="page-item">
                                                    <a class="page-link" href="<?= site_url('manajemen-user?page=' . ($currentPage + 1) . '&search=' . urlencode($search) . '&role=' . urlencode($role)) ?>">
                                                        Next <i class="fas fa-chevron-right"></i>
                                                    </a>
                                                </li>
                                            <?php endif; ?>
                                        </ul>
                                    </nav>
                                </div>
                            <?php endif; ?>

                        <?php else: ?>
                            <div class="text-center py-5">
                                <i class="fas fa-users fa-3x text-muted mb-3"></i>
                                <h4 class="text-muted">Tidak ada user ditemukan</h4>
                                <p class="text-muted">Tidak ada user yang sesuai dengan filter yang dipilih</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Detail Modal -->
                <div class="modal fade" id="detailModal" tabindex="-1" role="dialog">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header bg-info">
                                <h5 class="modal-title text-white">
                                    <i class="fas fa-user"></i> Detail User
                                </h5>
                                <button type="button" class="close text-white" data-dismiss="modal">
                                    <span>&times;</span>
                                </button>
                            </div>
                            <div class="modal-body" id="detailContent">
                                <div class="text-center">
                                    <i class="fas fa-spinner fa-spin fa-2x"></i>
                                    <p class="mt-2">Loading...</p>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                    <i class="fas fa-times"></i> Tutup
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Reset Password Modal -->
                <div class="modal fade" id="resetPasswordModal" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header bg-success">
                                <h5 class="modal-title text-white">
                                    <i class="fas fa-key"></i> Reset Password
                                </h5>
                                <button type="button" class="close text-white" data-dismiss="modal">
                                    <span>&times;</span>
                                </button>
                            </div>
                            <form id="resetPasswordForm">
                                <div class="modal-body">
                                    <input type="hidden" id="resetUserId" name="user_id">
                                    <div class="form-group">
                                        <label for="newPassword">
                                            <i class="fas fa-lock"></i> Password Baru:
                                        </label>
                                        <input type="password" id="newPassword" class="form-control" 
                                               required minlength="6" placeholder="Minimal 6 karakter">
                                        <small class="form-text text-muted">
                                            <i class="fas fa-info-circle"></i> Password minimal 6 karakter
                                        </small>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                        <i class="fas fa-times"></i> Batal
                                    </button>
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-key"></i> Reset Password
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>

<!-- JQUERY HARUS PALING ATAS -->
<script src="<?= base_url('adminlte/AdminLTE-3.2.0/plugins/jquery/jquery.min.js') ?>"></script>
<!-- Bootstrap JS -->
<script src="<?= base_url('adminlte/AdminLTE-3.2.0/plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
<!-- AdminLTE JS -->
<script src="<?= base_url('adminlte/AdminLTE-3.2.0/dist/js/adminlte.min.js') ?>"></script>

<script>
// Show Detail Modal
function showDetail(userId) {
    document.getElementById('detailContent').innerHTML = `
        <div class="text-center">
            <i class="fas fa-spinner fa-spin fa-2x text-primary"></i>
            <p class="mt-2">⏳ Loading data...</p>
        </div>`;
    
    $('#detailModal').modal('show');
    
    $.get('<?= site_url("manajemen-user/detail/") ?>' + userId)
        .done(function(response) {
            if (response.success) {
                const user = response.data;
                let content = `
                    <div class="row">
                        <div class="col-md-4 text-center">`;
                
                if (user.foto_profil) {
                    content += `<img src="<?= base_url("uploads/profiles/") ?>${user.foto_profil}" 
                                     class="img-fluid rounded-circle mb-3" style="width: 150px; height: 150px; object-fit: cover;">`;
                } else {
                    content += `<div class="bg-light rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" 
                                     style="width: 150px; height: 150px; font-size: 48px;">
                                    <i class="fas fa-user text-muted"></i>
                                </div>`;
                }
                
                content += `</div>
                        <div class="col-md-8">
                            <h4><i class="fas fa-info-circle"></i> Informasi User</h4>
                            <table class="table table-bordered">
                                <tr><th><i class="fas fa-hashtag"></i> ID</th><td>${user.id_regis}</td></tr>
                                <tr><th><i class="fas fa-user"></i> Nama</th><td><strong>${user.nama_lengkap}</strong></td></tr>
                                <tr><th><i class="fas fa-envelope"></i> Email</th><td>${user.email}</td></tr>
                                <tr><th><i class="fas fa-calendar"></i> Cohort</th><td>${user.cohort}</td></tr>
                                <tr><th><i class="fas fa-graduation-cap"></i> Program Studi</th><td>${user.prodi}</td></tr>
                                <tr><th><i class="fas fa-user-tag"></i> Role</th><td>
                                    ${user.role === 'admin' 
                                        ? '<span class="badge badge-warning badge-lg"><i class="fas fa-crown"></i> Admin</span>' 
                                        : '<span class="badge badge-primary badge-lg"><i class="fas fa-user"></i> User</span>'}
                                </td></tr>
                            </table>
                        </div>
                    </div>`;
                
                document.getElementById('detailContent').innerHTML = content;
            } else {
                document.getElementById('detailContent').innerHTML = `
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-triangle"></i> ${response.message}
                    </div>`;
            }
        })
        .fail(function() {
            document.getElementById('detailContent').innerHTML = `
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle"></i> Gagal memuat data
                </div>`;
        });
}

// Update Role
function updateRole(userId, newRole) {
    const roleName = newRole === 'admin' ? 'Admin' : 'User';
    if (!confirm(`Yakin ingin mengubah role menjadi ${roleName}?`)) return;
    
    $.post('<?= site_url("manajemen-user/update-role") ?>', {
        user_id: userId,
        role: newRole
    })
    .done(function(response) {
        if (response.success) {
            alert('✅ ' + response.message);
            location.reload();
        } else {
            alert('❌ ' + response.message);
        }
    })
    .fail(function() {
        alert('❌ Gagal mengubah role');
    });
}

// Delete User
function deleteUser(userId, userName) {
    if (!confirm(`Yakin ingin menghapus user "${userName}"?\n\nTindakan ini tidak dapat dibatalkan!`)) return;
    
    $.post('<?= site_url("manajemen-user/delete-user") ?>', {
        user_id: userId
    })
    .done(function(response) {
        if (response.success) {
            alert('✅ ' + response.message);
            location.reload();
        } else {
            alert('❌ ' + response.message);
        }
    })
    .fail(function() {
        alert('❌ Gagal menghapus user');
    });
}

// Reset Password
function resetPassword(userId) {
    document.getElementById('resetUserId').value = userId;
    document.getElementById('newPassword').value = '';
    $('#resetPasswordModal').modal('show');
}

// Submit Reset Password
document.getElementById('resetPasswordForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const userId = document.getElementById('resetUserId').value;
    const newPassword = document.getElementById('newPassword').value;
    
    if (newPassword.length < 6) {
        alert('Password minimal 6 karakter');
        return;
    }
    
    $.post('<?= site_url("manajemen-user/reset-password") ?>', {
        user_id: userId,
        new_password: newPassword
    })
    .done(function(response) {
        if (response.success) {
            alert('✅ ' + response.message);
            $('#resetPasswordModal').modal('hide');
        } else {
            alert('❌ ' + response.message);
        }
    })
    .fail(function() {
        alert('❌ Gagal reset password');
    });
});

// Auto submit on search input (dengan debounce)
let searchTimeout;
document.getElementById('searchInput').addEventListener('input', function() {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(function() {
        document.getElementById('filterForm').submit();
    }, 500);
});

// Auto submit on role change
document.getElementById('roleFilter').addEventListener('change', function() {
    document.getElementById('filterForm').submit();
});
</script>

</body>
</html>