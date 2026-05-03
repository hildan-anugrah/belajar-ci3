<!DOCTYPE html>
<html>
<head>
    <title>Sistem User</title>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/style.css'); ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<body>

    <header class="p-3 mb-3 border-bottom">
    <div class="container">
        <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
            
            <!-- Logo / Ikon Kiri -->
            <a href="<?= site_url() ?>" class="d-flex align-items-center mb-2 mb-lg-0 link-body-emphasis text-decoration-none">
                <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap">
                    <use xlink:href="#bootstrap"></use>
                </svg>
            </a>
            
            <!-- Menu Navigasi Utama -->
            <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                <li><a href="<?php echo site_url('user'); ?>" class="nav-link px-2 link-secondary">Data Users</a></li>
                <li><a href="<?php echo site_url('user/export_excel'); ?>" class="nav-link px-2 link-body-emphasis">Export Excel</a></li>
                <li><a href="<?php echo site_url('user/export_pdf'); ?>" class="nav-link px-2 link-body-emphasis">Export PDF</a></li>
                <li><a href="<?php echo site_url('user/generate_qrcode'); ?>" class="nav-link px-2 link-body-emphasis">Generate QR</a></li>
            </ul>
            
            <!-- Form Pencarian -->
            <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3" role="search">
                <input type="search" class="form-control" placeholder="Search..." aria-label="Search">
            </form>
            
            <!-- Dropdown Profil User -->
            <div class="dropdown text-end">
                <a href="#" class="d-block link-body-emphasis text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="https://github.com/mdo.png" alt="mdo" width="32" height="32" class="rounded-circle">
                </a>
                <ul class="dropdown-menu text-small" style="">
                    <li><a class="dropdown-item" href="#">New project...</a></li>
                    <li><a class="dropdown-item" href="#">Settings</a></li>
                    <li><a class="dropdown-item" href="#">Profile</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <!-- Link Logout sudah disesuaikan dengan CI3 -->
                    <li><a class="dropdown-item" href="<?php echo site_url('auth/logout'); ?>">Sign out</a></li>
                </ul>
            </div>
            
        </div>
    </div>
</header>

    