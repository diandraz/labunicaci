<header class="main-header navbar navbar-expand navbar-white navbar-light shadow-sm" style="position:fixed; top:0; width:100%; z-index:1030;">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a href="/dashboard" class="nav-link">Dashboard</a>
        </li>

        <!-- MANAJEMEN - Hanya untuk ADMIN -->
        <?php if (session()->get('role') === 'admin'): ?>
        <li class="nav-item">
            <a href="/manajemen" class="nav-link">Manajemen</a>
        </li>
        <?php endif; ?>

        <!-- PEMAKAIAN - Hanya untuk USER -->
        <?php if (session()->get('role') === 'user'): ?>
        <li class="nav-item">
            <a href="/pemakaian" class="nav-link">Pemakaian</a>
        </li>
        <?php endif; ?>

        <li class="nav-item">
            <a href="/logbook" class="nav-link">Logbook</a>
        </li>

        <!-- MANAJEMEN USER - Hanya untuk ADMIN -->
        <?php if (session()->get('role') === 'admin'): ?>
        <li class="nav-item">
            <a href="/manajemen-user" class="nav-link">Manajemen User</a>
        </li>
        <?php endif; ?>

        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="inventoryDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Inventory
            </a>
            <div class="dropdown-menu" aria-labelledby="inventoryDropdown">
                <a class="dropdown-item" href="/inventory/daftar-alat">Daftar Alat</a>
                <a class="dropdown-item" href="/inventory/daftar-bahan">Daftar Bahan</a>
                <a class="dropdown-item" href="/inventory/daftar-instrumen">Daftar Instrumen</a>
            </div>
        </li>

        <li class="nav-item">
            <a href="/pemberitahuan" class="nav-link">Pemberitahuan</a>
        </li>
        <li class="nav-item">
            <a href="/profiles" class="nav-link">Profiles</a>
        </li>
        <li class="nav-item">
            <a href="/logout" class="nav-link text-danger">Logout</a>
        </li>
    </ul>

    <!-- Logo kanan -->
    <div class="ml-auto d-flex align-items-center" style="position:absolute; right:30px; top:0; height:100%;">
        <img src="<?= base_url('adminlte/AdminLTE-3.2.0/dist/img/logo_kimia.png') ?>" alt="Logo Kimia" style="height:38px; margin-right:12px;">
        <img src="<?= base_url('adminlte/AdminLTE-3.2.0/dist/img/logo_unhanri.png') ?>" alt="Logo Unhanri" style="height:38px;">
    </div>
</header>
