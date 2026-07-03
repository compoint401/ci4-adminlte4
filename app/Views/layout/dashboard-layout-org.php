<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="<?= csrf_token() ?>" content="<?= csrf_hash() ?>" class="csrf">
  <title><?= (isset($pageTitle)) ? $pageTitle : 'Document'; ?></title>
  <base href="/">

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Datatables -->
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

  <!-- sweetalert2 -->
  <link rel="stylesheet" href="plugins/sweetalert2/sweetalert2.min.css">

  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <style>
    .modal-lg {
      max-width: 80% !important;
    }
  </style>
  <?= $this->renderSection('css'); ?>

</head>

<body class="hold-transition sidebar-mini layout-fixed text-sm">
  <div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="user/home" class="nav-link">Home</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="#" class="nav-link">Contact</a>
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
          <a class="nav-link" data-widget="fullscreen" href="#" role="button">
            <i class="fas fa-expand-arrows-alt"></i>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
            <i class="fas fa-th-large"></i>
          </a>
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link" data-toggle="dropdown" href="#">
            <strong><?= auth()->user()->first_name . " " . auth()->user()->last_name ?> </strong>
            <img src="dist/img/user6-128x128.jpg" class="img-circle" width="30" alt="User Image">
          </a>
          <div class="dropdown-menu dropdown-menu-right">
            <a href="user/profile" class="dropdown-item"><i class="fas fa-user"></i> My Profile</a>
            <a href="<?= route_to('user.passwordreset') ?>" class="dropdown-item"><i class="fas fa-tools"></i>Reset
              Password</a>
            <a href="#" class="dropdown-item"><i class="fas fa-tools"></i> Settings</a>
            <div class="dropdown-divider"></div>
            <a href="logout" class="dropdown-item"><i class='fas fa-sign-out-alt'></i> Log Out</a>

        </li>

      </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="index3.html" class="brand-link">
        <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
          style="opacity: .8">
        <span class="brand-text font-weight-light">RS Natural</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <!-- <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
          </div>
          <div class="info">
            <a href="#" class="d-block">My Name</a>
          </div>
        </div> -->

        <!-- SidebarSearch Form -->
        <div class="form-inline">
          <div class="input-group" data-widget="sidebar-search">
            <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
              <button class="btn btn-sidebar">
                <i class="fas fa-search fa-fw"></i>
              </button>
            </div>
          </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul
            class="nav nav-pills nav-sidebar flex-column nav-legacyx nav-child-indent nav-collapse-hide-child nav-flat"
            data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

            <li class="nav-item">
              <a href="<?= route_to('user.home') ?>"
                class="nav-link <?= (current_url() == base_url('user/home')) ? 'active' : ''; ?>">
                <i class="nav-icon fas fa-home"></i>
                <p>
                  Home
                </p>
              </a>
            </li>
            <!-- <li class="nav-item">
              <a href="</?= route_to('user.profile') ?>"
                class="nav-link </?= (current_url() == base_url('user/profile')) ? 'active' : ''; ?>">
                <i class="nav-icon fas fa-user"></i>
                <p>
                  Profile
                </p>
              </a>
            </li> -->

            <?php if (auth()->user()->can('admin.settings')) { ?>

              <li class="nav-item">
                <a href="<?= route_to('backup') ?>"
                  class="nav-link <?= (current_url() == base_url('backup')) ? 'active' : ''; ?>">
                  <i class="nav-icon fas fa-file-archive"></i>
                  <p>
                    Database Backup
                  </p>
                </a>
              </li>

              <li class="nav-item">
                <a href="<?= route_to('settings') ?>"
                  class="nav-link <?= (current_url() == base_url('settings')) ? 'active' : ''; ?>">
                  <i class="nav-icon fas fa-tools"></i>
                  <p>
                    Settings
                  </p>
                </a>
              </li>
            <?php } ?>
            <?php if (auth()->user()->can('users.create')) { ?>
              <li class="nav-item">
                <a href="<?= route_to('list.users') ?>"
                  class="nav-link <?= (current_url() == base_url('admin/listUsers')) ? 'active' : ''; ?>">
                  <i class="nav-icon fas fa-address-book"></i>
                  <p>
                    Users
                  </p>
                </a>
              </li>
            <?php } ?>
            <li class="nav-item">
              <a href="<?= route_to('parties') ?>"
                class="nav-link <?= (current_url() == base_url('party/parties')) ? 'active' : ''; ?>">
                <i class="nav-icon far fa-address-card"></i>
                <p>
                  Party Master
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= route_to('list.items') ?>"
                class="nav-link <?= (current_url() == base_url('item/listItems')) ? 'active' : ''; ?>">
                <i class="nav-icon fas fa-boxes"></i>
                <p>
                  Materials(Items)
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= route_to('list.site') ?>"
                class="nav-link <?= (current_url() == base_url('site/listSite')) ? 'active' : ''; ?>">
                <i class="nav-icon fas fa-building"></i>
                <p>
                  Project/Site
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= route_to('list.orders') ?>"
                class="nav-link <?= (current_url() == base_url('orders')) ? 'active' : ''; ?>">
                <i class="nav-icon far fa-edit"></i>
                <p>
                  P. Orders
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= route_to('list.delivery') ?>"
                class="nav-link <?= (current_url() == base_url('deliveries')) ? 'active' : ''; ?>">
                <i class="nav-icon fas fa-truck-pickup"></i>
                <p>
                  Delivery
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= route_to('sales') ?>"
                class="nav-link <?= (current_url() == base_url('sales')) ? 'active' : ''; ?>">
                <i class="nav-icon fas fa-clipboard-check"></i>
                <p>
                  Sale - Invoice
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= route_to('purchases') ?>"
                class="nav-link <?= (current_url() == base_url('purchases')) ? 'active' : ''; ?>">
                <i class="nav-icon fas fa-warehouse"></i>
                <p>
                  Purchase - Invoice
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= route_to('money.receipt') ?>"
                class="nav-link <?= (current_url() == base_url('money')) ? 'active' : ''; ?>">
                <i class="nav-icon fas fa-rupee-sign"></i>
                <p>
                  Receipts
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= route_to('money.payment') ?>"
                class="nav-link <?= (current_url() == base_url('money/payment')) ? 'active' : ''; ?>">
                <i class="nav-icon fas fa-money-check"></i>
                <p>
                  Payments
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= route_to('vouchers') ?>"
                class="nav-link <?= (current_url() == base_url('vouchers')) ? 'active' : ''; ?>">
                <i class="nav-icon fas fa-money-check"></i>
                <p>
                  Vouchers - Journal
                </p>
              </a>
            </li>

            <?php if (auth()->user()->can('users.create')) { ?>
              <li class="nav-item <?= (strpos(current_url(), base_url('reports')) !== false) ? 'menu-open' : ''; ?>">
                <a href="#"
                  class="nav-link <?= (strpos(current_url(), base_url('reports')) !== false) ? 'active' : ''; ?>">
                  <i class="nav-icon fas fa-book"></i>
                  <p>
                    Reports
                    <i class="fas fa-angle-left right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="<?= route_to('reports') ?>"
                      class="nav-link <?= (current_url() == base_url('reports')) ? 'active' : ''; ?>">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Ledgers</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?= route_to('sum.ledger') ?>"
                      class="nav-link <?= (current_url() == base_url('reports/sumLedger')) ? 'active' : ''; ?>">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Ledger Summary</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?= route_to('reports.salesoverdues') ?>"
                      class="nav-link <?= (current_url() == base_url('reports/salesOverdues')) ? 'active' : ''; ?>">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Sales Overdues</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?= route_to('reports.crushers') ?>"
                      class="nav-link <?= (current_url() == base_url('reports/reportsCrushers')) ? 'active' : ''; ?>">

                      <i class="far fa-circle nav-icon"></i>
                      <p>Crushers Report</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?= route_to('reports.transporters') ?>"
                      class="nav-link <?= (current_url() == base_url('reports/reportsTransporters')) ? 'active' : ''; ?>">

                      <i class="far fa-circle nav-icon"></i>
                      <p>Transporters Report</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?= route_to('reports.customers') ?>"
                      class="nav-link <?= (current_url() == base_url('reports/reportsCustomers')) ? 'active' : ''; ?>">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Customers Report</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?= route_to('reports.delivery') ?>"
                      class="nav-link <?= (current_url() == base_url('reports/reportsDelivery')) ? 'active' : ''; ?>">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Delivery Report</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?= route_to('reports.invoiceannexure') ?>"
                      class="nav-link <?= (current_url() == base_url('reports/InvoiceAnnexure')) ? 'active' : ''; ?>">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Invoice Annexure</p>
                    </a>
                  </li>
                </ul>
              </li>
            <?php } ?>

            <?php if (auth()->user()->can('users.create')) { ?>
              <li class="nav-item <?= (strpos(current_url(), base_url('mis')) !== false) ? 'menu-open' : ''; ?>">
                <a href="#" class="nav-link <?= (strpos(current_url(), base_url('mis')) !== false) ? 'active' : ''; ?>">
                  <i class="nav-icon fas fa-book"></i>
                  <p>
                    MIS Reports
                    <i class="fas fa-angle-left right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="<?= route_to('mis.sum.delivery') ?>"
                      class="nav-link <?= (current_url() == base_url('mis/sumDelivery')) ? 'active' : ''; ?>">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Delivery Summary</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?= route_to('mis.sales') ?>"
                      class="nav-link <?= (current_url() == base_url('mis/sales')) ? 'active' : ''; ?>">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Sales Overdues</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?= route_to('mis.unbilled') ?>"
                      class="nav-link <?= (current_url() == base_url('mis/unBilled')) ? 'active' : ''; ?>">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Unbilled Qty Details</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?= route_to('mis.sum.customers') ?>"
                      class="nav-link <?= (current_url() == base_url('mis/sumCustomers')) ? 'active' : ''; ?>">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Summary Report - Customers</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?= route_to('mis.sum.crushers') ?>"
                      class="nav-link <?= (current_url() == base_url('mis/sumCrushers')) ? 'active' : ''; ?>">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Summary Report - Crushers</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?= route_to('mis.sum.transporters') ?>"
                      class="nav-link <?= (current_url() == base_url('mis/sumTransporters')) ? 'active' : ''; ?>">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Summary - Transporters</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?= route_to('mis.sum.transporters2') ?>"
                      class="nav-link <?= (current_url() == base_url('mis/sumTransporters2')) ? 'active' : ''; ?>">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Summary-Transporters-FOR</p>
                    </a>
                  </li>
                </ul>
              </li>
            <?php } ?>
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
              <h1 class="m-0"><?= (isset($pageTitle)) ? $pageTitle : 'Document'; ?></h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="<?= route_to('user.home'); ?>">Home</a></li>
                <li class="breadcrumb-item active"><?= (isset($pageTitle)) ? $pageTitle : 'Document'; ?></li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <!-- Main content -->
      <div class="content">
        <div class="container-fluid">
          <?= $this->renderSection('content'); ?>
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
      <!-- To the right -->
      <div class="float-right d-none d-sm-inline">
        Affordable Website that Works
      </div>
      <!-- Default to the left -->
      <strong>Copyright &copy; 2024-2025 <a href="https://www.webdevdelhi.com/">WebDevDelhi</a>.</strong> All rights
      reserved.
    </footer>
  </div>
  <!-- ./wrapper -->



  <!-- REQUIRED SCRIPTS -->

  <!-- jQuery -->
  <script src="plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- Datatable -->
  <script src="plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
  <script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
  <script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
  <script src="plugins/jszip/jszip.min.js"></script>
  <script src="plugins/pdfmake/pdfmake.min.js"></script>
  <script src="plugins/pdfmake/vfs_fonts.js"></script>
  <script src="plugins/datatables-buttons/js/buttons.html5.min.js"></script>
  <script src="plugins/datatables-buttons/js/buttons.print.min.js"></script>
  <script src="plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

  <script src="plugins/sweetalert2/sweetalert2.min.js"></script>
  <!-- AdminLTE App -->
  <script src="dist/js/adminlte.min.js"></script>

  <?= $this->renderSection('scripts'); ?>
</body>

</html>