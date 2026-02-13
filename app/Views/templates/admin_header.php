<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $titulo ?? 'MiniMarket Admin' ?> | MatDash</title>

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/png" href="<?= base_url('assets/images/logos/favicon.png') ?>" />

    <!-- MatDash CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/css/styles.css') ?>" />
    <link rel="stylesheet" href="<?= base_url('assets/libs/bootstrap-icons/font/bootstrap-icons.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/libs/apexcharts/dist/apexcharts.css') ?>">

    <!-- Custom CSS -->
    <style>
        .sidebar-link.active {
            background-color: #f3f4f6;
            color: #2a3547;
        }

        .product-img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 8px;
        }

        .status-badge {
            font-size: 0.75rem;
            padding: 0.35em 0.65em;
            border-radius: 50rem;
        }
    </style>
</head>

<body data-sidebartype="full">
    <!-- Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebar-position="fixed" data-header-position="fixed">

        <!-- Sidebar -->
        <aside class="left-sidebar">
            <div>
                <div class="brand-logo d-flex align-items-center justify-content-between">
                    <a href="<?= base_url('admin/dashboard') ?>" class="text-nowrap logo-img d-flex align-items-center gap-2 text-decoration-none">
                        <i class="ti ti-building-store fs-7" style="color: #0d6efd;"></i>
                        <span class="fw-bolder fs-6 text-dark" style="letter-spacing: -0.5px;">MiniMarket</span>
                    </a>
                    <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                        <i class="ti ti-x fs-8"></i>
                    </div>
                </div>

                <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
                    <ul id="sidebarnav">
                        <li class="nav-small-cap">
                            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                            <span class="hide-menu">Principal</span>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link <?= current_url() == base_url('admin/dashboard') ? 'active' : '' ?>"
                                href="<?= base_url('admin/dashboard') ?>" aria-expanded="false">
                                <span><i class="ti ti-layout-dashboard"></i></span>
                                <span class="hide-menu">Dashboard</span>
                            </a>
                        </li>

                        <li class="nav-small-cap">
                            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                            <span class="hide-menu">Gestión</span>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link <?= strpos(current_url(), 'productos') ? 'active' : '' ?>"
                                href="<?= base_url('admin/productos') ?>" aria-expanded="false">
                                <span><i class="ti ti-package"></i></span>
                                <span class="hide-menu">Productos</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link <?= strpos(current_url(), 'categorias') ? 'active' : '' ?>"
                                href="<?= base_url('admin/categorias') ?>" aria-expanded="false">
                                <span><i class="ti ti-category"></i></span>
                                <span class="hide-menu">Categorías</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link <?= strpos(current_url(), 'pedidos') ? 'active' : '' ?>"
                                href="<?= base_url('admin/pedidos') ?>" aria-expanded="false">
                                <span><i class="ti ti-shopping-cart"></i></span>
                                <span class="hide-menu">Pedidos</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link <?= strpos(current_url(), 'clientes') ? 'active' : '' ?>"
                                href="<?= base_url('admin/clientes') ?>" aria-expanded="false">
                                <span><i class="ti ti-users"></i></span>
                                <span class="hide-menu">Clientes</span>
                            </a>
                        </li>

                        <li class="nav-small-cap">
                            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                            <span class="hide-menu">Reportes</span>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link <?= strpos(current_url(), 'reportes') ? 'active' : '' ?>"
                                href="<?= base_url('admin/reportes') ?>" aria-expanded="false">
                                <span><i class="ti ti-report-analytics"></i></span>
                                <span class="hide-menu">Reportes</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>

        <!-- Main wrapper -->
        <div class="body-wrapper">
            <!-- Header -->
            <header class="app-header">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <ul class="navbar-nav">
                        <li class="nav-item d-block d-xl-none">
                            <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse" href="javascript:void(0)">
                                <i class="ti ti-menu-2"></i>
                            </a>
                        </li>
                    </ul>
                    <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
                        <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
                            <li class="nav-item dropdown">
                                <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    <img src="<?= base_url('assets/images/profile/user-1.jpg') ?>" alt="" width="35" height="35" class="rounded-circle">
                                </a>
                                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">
                                    <div class="message-body">
                                        <a href="<?= base_url('admin/perfil') ?>" class="d-flex align-items-center gap-2 dropdown-item">
                                            <i class="ti ti-user fs-6"></i>
                                            <p class="mb-0 fs-3">Mi Perfil</p>
                                        </a>
                                        <a href="<?= base_url('/') ?>" target="_blank" class="d-flex align-items-center gap-2 dropdown-item">
                                            <i class="ti ti-store fs-6"></i>
                                            <p class="mb-0 fs-3">Ver Tienda</p>
                                        </a>
                                        <a href="<?= base_url('logout') ?>" class="btn btn-outline-primary mx-3 mt-2 d-block">Cerrar Sesión</a>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>

            <!-- Content -->
            <div class="container-fluid">