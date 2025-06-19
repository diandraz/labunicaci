<link rel="stylesheet" href="<?= base_url('adminlte/AdminLTE-3.2.0/plugins/fontawesome-free/css/all.min.css') ?>">

<header class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a href="/dashboard" class="nav-link">
                <i class="fas fa-home icon-yellow"></i> Dashboard
            </a>
        </li>
        <li class="nav-item">
            <a href="/manajemen" class="nav-link">
                <i class="fas fa-tools icon-yellow"></i> Manajemen
            </a>
        </li>
        <li class="nav-item">
            <a href="/pemakaian" class="nav-link">
                <i class="fas fa-box icon-yellow"></i> Pemakaian
            </a>
        </li>
        <li class="nav-item">
            <a href="/logbook" class="nav-link">
                <i class="fas fa-book icon-yellow"></i> Logbook
            </a>
        </li>
        <li class="nav-item">
            <a href="/manajemen-user" class="nav-link">
                <i class="fas fa-users icon-yellow"></i> Manajemen User
            </a>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="inventoryDropdown" role="button" data-toggle="dropdown">
                <i class="fas fa-boxes icon-yellow"></i> Inventory
            </a>
            <div class="dropdown-menu" aria-labelledby="inventoryDropdown">
                <a class="dropdown-item" href="/inventory/daftar-alat">
                    <i class="fas fa-wrench icon-yellow"></i> Daftar Alat
                </a>
                <a class="dropdown-item" href="/inventory/daftar-bahan">
                    <i class="fas fa-vial icon-yellow"></i> Daftar Bahan
                </a>
                <a class="dropdown-item" href="/inventory/daftar-instrumen">
                    <i class="fas fa-ruler icon-yellow"></i> Daftar Instrumen
                </a>
            </div>
        </li>
        <li class="nav-item">
            <a href="/pemberitahuan" class="nav-link">
                <i class="fas fa-bell icon-yellow"></i> Pemberitahuan
            </a>
        </li>
        <li class="nav-item">
            <a href="/profiles" class="nav-link">
                <i class="fas fa-user icon-yellow"></i> Profiles
            </a>
        </li>
        <li class="nav-item">
            <a href="/logout" class="nav-link text-danger">
                <i class="fas fa-lock icon-yellow"></i> Logout
            </a>
        </li>
    </ul>

    <!-- Right logos -->
    <ul class="navbar-nav ml-auto d-flex align-items-center">
        <li class="nav-item">
          <img src="<?= base_url('../adminlte/AdminLTE-3.2.0/dist/img/logo_kimia.png') ?>" alt="Logo Kimia" style="height: 36px; margin-right: 10px;">
          <img src="<?= base_url('../adminlte/AdminLTE-3.2.0/dist/img/logo_unhanri.png') ?>" alt="Logo Unhan RI" style="height: 36px; margin-right: 10px;">
        </li>
    </ul>
</header>
