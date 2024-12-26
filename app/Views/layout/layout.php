<!DOCTYPE html>

<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= (isset($title)) ? $title : 'Document'; ?></title>
    <base href="/">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- BS Stepper -->
    <link rel="stylesheet" href="../../plugins/bs-stepper/css/bs-stepper.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css" />
    <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css" />
    <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css" />
    <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css" />
    <link rel="stylesheet" href="plugins/sweetalert2/sweetalert2.min.css" />
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="<?= base_url(); ?>logout" class="nav-link">Log Out</a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Navbar Search -->
                <li class="nav-item">
                    <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                        <i class="fas fa-search"></i>
                    </a>
                    <div class="navbar-search-block">
                        <form class="form-inline">
                            <div class="input-group input-group-sm">
                                <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
                                <div class="input-group-append">
                                    <button class="btn btn-navbar" type="submit">
                                        <i class="fas fa-search"></i>
                                    </button>
                                    <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" onclick="document.body.requestFullscreen()" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
                        <i class="fas fa-th-large"></i>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="<?= route_to('dashboard') ?>" class="brand-link">
                <img src="dist/img/STMIK_Logo.png" alt="STMIK Logo" class="brand-image">
                <span class="brand-text font-weight-light">Perpustakaan STMIK</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="dist/img/admin2.jpg" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="<?= route_to('dashboard') ?>" class="d-block"><?= esc(ucwords(session()->get('nama'))) ?></a>
                    </div>
                </div>


                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <?php $current_route = str_replace(site_url(), '', current_url()); ?>
                        <li class="nav-item">
                            <a href="<?= route_to('dashboard') ?>" class="nav-link <?= strpos($current_route, 'dashboard') !== false ? 'active' : '' ?>">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Dashboard
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= route_to(method: 'katalog') ?>" class="nav-link <?= strpos($current_route, 'katalog') !== false ? 'active' : '' ?>">
                                <i class="nav-icon fas fa-book"></i>
                                <p>
                                    Katalog
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= route_to(method: 'anggota') ?>" class="nav-link <?= strpos($current_route, 'anggota') !== false ? 'active' : '' ?>">
                                <i class="nav-icon fas fa-users"></i>
                                <p>
                                    Anggota
                                </p>
                            </a>
                        </li>
                        <li class="nav-item <?= strpos($current_route, 'transaksi') !== false ? 'menu-is-opening menu-open' : '' ?>">
                            <a href="<?= route_to(method: 'transaksi') ?>" class="nav-link <?= strpos($current_route, 'transaksi') !== false ? 'active' : '' ?>">
                                <i class="nav-icon fas fa-table"></i>
                                <p>
                                    Transaksi
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="/transaksi/peminjaman" class="nav-link <?= $current_route == 'transaksi/peminjaman'  ? 'active' : '' ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Peminjaman</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/transaksi/entry-peminjaman" class="nav-link <?= $current_route == 'transaksi/entry-peminjaman' ? 'active' : '' ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Entry Peminjaman</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/transaksi/pengembalian" class="nav-link <?= $current_route == 'transaksi/pengembalian' ? 'active' : '' ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Pengembalian</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/transaksi/entry-pengembalian" class="nav-link <?= $current_route == 'transaksi/entry-pengembalian' ? 'active' : '' ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Entry Pengembalian</p>
                                    </a>
                                </li>
                            </ul>
                        </li>


                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0"><?= $title ?></h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="<?= route_to('dashboard') ?>">Home</a></li>
                                <li class="breadcrumb-item active"><?= $title ?></li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <div class="content">
                <div class="container-fluid">
                    <?php
                    // var_dump(str_replace(base_url(), '', current_url(),));
                    $current_route = str_replace(base_url(), '', current_url(),);
                    if ($current_route !== 'transaksi/entry-peminjaman' || $current_route !== 'transaksi/entry-pengembalian') {
                        if (session()->has('anggota')) {
                            session()->remove('anggota');
                        }
                        if (session()->has('currentStepPeminjaman')) {
                            session()->remove('currentStepPeminjaman');
                        }
                        if (session()->has('currentStepPengembalian')) {
                            session()->remove('currentStepPengembalian');
                        }
                        if (session()->has('anggota404')) {
                            session()->remove('anggota404');
                        }
                    }
                    ?>
                    <?= $this->renderSection('content'); ?>
                    <!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
            <div class="p-3">
                <h5>Title</h5>
                <p>Sidebar content</p>
            </div>
        </aside>
        <!-- /.control-sidebar -->

        <!-- Main Footer -->
        <footer class="main-footer">
            <!-- Default to the left -->
            <strong>Copyright &copy; 2024 <a href="https://stmikplk.ac.id" target="_blank">STMIK Palangka raya</a>.</strong> All rights reserved.
        </footer>
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->

    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.min.js"></script>

    <script src="plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>

    <!-- DataTables  & Plugins -->
    <script src="plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="plugins/jszip/jszip.min.js"></script>
    <script src="plugins/pdfmake/pdfmake.min.js"></script>
    <script src="plugins/pdfmake/vfs_fonts.js"></script>
    <script src="plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

    <!-- BS-Stepper -->
    <script src="../../plugins/bs-stepper/js/bs-stepper.min.js"></script>

    <!-- SweetAlert -->
    <script src="plugins/sweetalert2/sweetalert2.min.js"></script>

    <script>
        $(function() {
            bsCustomFileInput.init();

            $("#katalog_table").DataTable({
                responsive: true,
                lengthChange: false,
                autoWidth: false,
                language: {
                    searchPlaceholder: "Cari Buku",
                    search: "",
                },
                columnDefs: [{
                        searchable: true,
                        targets: 0
                    },
                    {
                        searchable: true,
                        targets: 1
                    },
                    {
                        searchable: true,
                        targets: 2
                    },
                    {
                        searchable: true,
                        targets: 3
                    },
                    {
                        searchable: true,
                        targets: 4
                    },
                    {
                        searchable: false,
                        targets: 5
                    }
                ]
            });

            var createButtonKatalog = $('<a>')
                .addClass('btn btn-primary')
                .attr('href', '/katalog/create')
                .html(' <i class="fas fa-plus"></i> Tambah Buku');

            var buttonContainerKatalog = $("#katalog_table_wrapper .col-md-6:eq(0)");
            buttonContainerKatalog.append(createButtonKatalog);

            $("#anggota_table").DataTable({
                responsive: true,
                lengthChange: false,
                autoWidth: false,
                language: {
                    searchPlaceholder: "Cari Anggota",
                    search: "",
                },
            });

            var createButtonAnggota = $('<a>')
                .addClass('btn btn-primary')
                .attr('href', '/anggota/create')
                .html(' <i class="fas fa-user-plus"></i> Tambah Anggota');

            var buttonContainerAnggota = $("#anggota_table_wrapper .col-md-6:eq(0)");
            buttonContainerAnggota.append(createButtonAnggota);

        });
    </script>


</body>

</html>