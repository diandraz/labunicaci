<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Instrumen</title>

    <!-- CSS lokal -->
    <link rel="stylesheet" href="<?= base_url('css/style_reguler.css') ?>">

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

        <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= base_url('css/kelolauser.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/global.css') ?>">

    <!-- jQuery & DataTables JS -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
</head>
<body>

<!-- NAVIGASI -->
<div>
    <a href="/dashboard">🏠 Dashboard</a>
    <a href="/manajemen">🛠️ Manajemen</a>
    <a href="/pemakaian">📦 Pemakaian</a>
    <a href="/logbook">📚 Logbook</a>
    <a href="/manajemen-user">👥 Manajemen User</a>
    <a href="/inventory/daftar-alat">🔧 Daftar Alat</a>
    <a href="/inventory/daftar-bahan">🧪 Daftar Bahan</a>
    <a href="/inventory/daftar-instrumen">📏 Daftar Instrumen</a>
    <a href="/pemberitahuan">🔔 Pemberitahuan</a>
    <a href="/profiles">👤 Profiles</a>
    <a href="/logout">🔒 Logout</a>
</div>

<!-- ISI KONTEN -->
<h2>Manage User</h2>

<?php if(session()->getFlashdata('success')): ?>
    <div style="color:green"><?= session()->getFlashdata('success') ?></div>
<?php endif; ?>

<table id="userTable" class="display">
    <thead>
        <tr>
            <th>Username</th>
            <th>Photo</th>
            <th>Status</th>
            <th>Prodi</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach($users as $user): ?>
        <tr>
            <td><?= esc($user['nama_lengkap']) ?></td>
            <td>
                <?php if($user['foto_profil']): ?>
                    <img src="<?= base_url('uploads/'.$user['foto_profil']) ?>" width="50" height="50">
                <?php else: ?>
                    <span>No Photo</span>
                <?php endif; ?>
            </td>
            <td>
                <form method="post" action="<?= site_url('user/updateStatus/'.$user['id_regis']) ?>">
                    <select name="status" onchange="this.form.submit()">
                        <option value="user" <?= $user['status']=='user'?'selected':'' ?>>User</option>
                        <option value="admin" <?= $user['status']=='admin'?'selected':'' ?>>Admin</option>
                    </select>
                    <?= csrf_field() ?>
                </form>
            </td>
            <td><?= esc($user['prodi']) ?></td>
            <td>
                <!-- Tambahkan aksi lain jika perlu -->
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<!-- DataTables init -->
<script>
$(document).ready(function() {
    $('#userTable').DataTable();
});
</script>

</body>
</html>
