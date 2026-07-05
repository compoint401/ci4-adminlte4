<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title><?= (isset($pageTitle)) ? $pageTitle : 'Document'; ?></title>
  <base href="/">
  <meta name="<?= csrf_token() ?>" content="<?= csrf_hash() ?>" class="csrf">

  <!--begin::Theme Init (prevents flash of incorrect theme on load, #6043)-->
  <script>
    (() => {
      'use strict';
      const STORAGE_KEY = 'lte-theme';
      let stored = null;
      try {
        stored = localStorage.getItem(STORAGE_KEY);
      } catch {
        // localStorage may be unavailable (private mode, sandboxed iframe).
      }
      const prefersDark = globalThis.matchMedia('(prefers-color-scheme: dark)').matches;
      // Mirror the resolution in _scripts.astro: explicit "dark"/"light" win,
      // otherwise ("auto" or unset) fall back to the OS preference.
      let resolved = 'light';
      if (stored === 'dark' || stored === 'light') {
        resolved = stored;
      } else if (prefersDark) {
        resolved = 'dark';
      }
      document.documentElement.setAttribute('data-bs-theme', resolved);
      document.documentElement.style.colorScheme = resolved;
    })();
  </script>
  <!--end::Theme Init-->
  <!--begin::Accessibility Meta Tags-->
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes" />
  <meta name="color-scheme" content="light dark" />
  <meta name="theme-color" content="#007bff" media="(prefers-color-scheme: light)" />
  <meta name="theme-color" content="#1a1a1a" media="(prefers-color-scheme: dark)" />
  <!--end::Accessibility Meta Tags-->

  <!--begin::Primary Meta Tags-->
  <meta name="title" content="Dashboard" />
  <meta name="author" content="ColorlibHQ" />
  <!-- <meta
      name="description"
      content="AdminLTE is a free Bootstrap 5 admin dashboard template with almost 50 example pages, built with vanilla JS and designed with accessibility in mind."
    />
    <meta
      name="keywords"
      content="bootstrap 5, bootstrap, bootstrap 5 admin dashboard, bootstrap 5 dashboard, bootstrap 5 charts, bootstrap 5 calendar, bootstrap 5 datepicker, bootstrap 5 tables, bootstrap 5 datatable, vanilla js datatable, colorlibhq, colorlibhq dashboard, colorlibhq admin dashboard, accessible admin panel"
    /> -->
  <!--end::Primary Meta Tags-->

  <!--begin::Accessibility Features-->
  <!-- Skip links will be dynamically added by accessibility.js -->
  <meta name="supported-color-schemes" content="light dark" />
  <link rel="preload" href="dist/css/adminlte.css" as="style" />
  <!--end::Accessibility Features-->

  <!--begin::Fonts-->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css"
    integrity="sha256-tXJfXfp6Ewt1ilPzLDtQnJV4hclT9XuaZUKyUvmyr+Q=" crossorigin="anonymous" media="print"
    onload="this.media = 'all'" />
  <!--end::Fonts-->

  <!--begin::Third Party Plugin(OverlayScrollbars)-->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/styles/overlayscrollbars.min.css"
    crossorigin="anonymous" />
  <!--end::Third Party Plugin(OverlayScrollbars)-->

  <!--begin::Third Party Plugin(Bootstrap Icons)-->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css"
    crossorigin="anonymous" />
  <!--end::Third Party Plugin(Bootstrap Icons)-->

  <!--begin::Required Plugin(AdminLTE)-->
  <link rel="stylesheet" href="dist/css/adminlte.css" />
  <!--end::Required Plugin(AdminLTE)-->


  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Datatables -->
  <!-- <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css"> -->

  <link rel="stylesheet" href="plugins/datatables5/datatables.min.css">
  <!-- sweetalert2 -->
  <link rel="stylesheet" href="plugins/sweetalert2/sweetalert2.min.css">
  <link rel="stylesheet" href="/plugins/toastr/toastr.min.css">

  <style>
    .modal-lg {
      max-width: 80% !important;
    }

    /* Custom styles for DataTables processing indicator */
    .dataTables_wrapper .dataTables_processing {
      position: absolute;
      top: 50%;
      left: 50%;
      width: 250px;
      margin-left: -125px;
      margin-top: -15px;
      padding: 1em;
      background-color: #fff;
      border: 2px solid #dee2e6;
      border-radius: 0.25rem;
      box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
      text-align: center;
      font-size: 1.2em;
      color: #333;
      z-index: 1051;
      /* Higher than modal backdrop */
    }

    .dataTables_wrapper .dataTables_processing::before {
      content: "\f110";
      /* Font Awesome spinner icon */
      font-family: "Font Awesome 5 Free";
      font-weight: 900;
      -webkit-animation: fa-spin 2s infinite linear;
      animation: fa-spin 2s infinite linear;
      margin-right: 10px;
    }
     @media print {

    /* All your print styles go here */
    #header,
    #footer,
    footer,
    #nav,
    #search-card,
    .btn {
      display: none !important;
    }

    @page {
      size: A4 landscape;
      max-height: 100%;
      max-width: 100%
    }
  }
  </style>
  <?= $this->renderSection('css'); ?>
</head>
<!--end::Head-->
<!--begin::Body-->

<body class="layout-fixed sidebar-expand-lg sidebar-mini bg-body-tertiary">
  <!--begin::App Wrapper-->
  <div class="app-wrapper">
    <!--begin::Header-->
    <nav class="app-header navbar navbar-expand bg-body">
      <!--begin::Container-->
      <div class="container-fluid">
        <!--begin::Start Navbar Links-->
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button" aria-label="Toggle sidebar">
              <i class="bi bi-list"></i>
            </a>
          </li>

          <li class="nav-item d-none d-md-block">
            <a href="user/home" class="nav-link">Home</a>
          </li>
          <li class="nav-item d-none d-md-block">
            <a href="#" class="nav-link">Contact</a>
          </li>
        </ul>
        <!--end::Start Navbar Links-->

        <!--begin::End Navbar Links-->
        <ul class="navbar-nav ms-auto">

          <!--begin::Fullscreen Toggle-->
          <li class="nav-item">
            <a class="nav-link" href="#" data-lte-toggle="fullscreen" aria-label="Toggle fullscreen">
              <i data-lte-icon="maximize" class="bi bi-arrows-fullscreen"></i>
              <i data-lte-icon="minimize" class="bi bi-fullscreen-exit d-none"></i>
            </a>
          </li>
          <!--end::Fullscreen Toggle-->

          <!--begin::Color Mode Toggle (#6010)-->
          <li class="nav-item dropdown">
            <a class="nav-link" href="#" id="bd-theme" aria-label="Toggle color scheme" data-bs-toggle="dropdown"
              aria-expanded="false">
              <i class="bi bi-sun-fill" data-lte-theme-icon="light"></i>
              <i class="bi bi-moon-fill d-none" data-lte-theme-icon="dark"></i>
              <i class="bi bi-circle-half d-none" data-lte-theme-icon="auto"></i>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="bd-theme"
              style="--bs-dropdown-min-width: 8rem">
              <li>
                <button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="light"
                  aria-pressed="false">
                  <i class="bi bi-sun-fill me-2"></i>
                  Light
                  <i class="bi bi-check-lg ms-auto d-none"></i>
                </button>
              </li>
              <li>
                <button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="dark"
                  aria-pressed="false">
                  <i class="bi bi-moon-fill me-2"></i>
                  Dark
                  <i class="bi bi-check-lg ms-auto d-none"></i>
                </button>
              </li>
              <li>
                <button type="button" class="dropdown-item d-flex align-items-center active" data-bs-theme-value="auto"
                  aria-pressed="true">
                  <i class="bi bi-circle-half me-2"></i>
                  Auto
                  <i class="bi bi-check-lg ms-auto d-none"></i>
                </button>
              </li>
            </ul>
          </li>
          <!--end::Color Mode Toggle-->

          <!--begin::User Menu Dropdown-->
          <li class="nav-item dropdown user-menu">
            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
              <img src="dist/assets/img/user2-160x160.jpg" class="user-image rounded-circle shadow"
                alt="Demo" />
              <span class="d-none d-md-inline">Demo</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
              <!--begin::User Image-->
              <li class="user-header text-bg-primary">
                <img src="dist/assets/img/user2-160x160.jpg" class="rounded-circle shadow" alt="Demo" />
                <p>
                  Demo - Web Developer
                  <small>Member since Nov. 2023</small>
                </p>
              </li>
              <!--end::User Image-->
              <!--begin::Menu Body-->
              <li class="user-body">
                <!--begin::Row-->
                <div class="row">
                  <div class="col-4 text-center">
                    <a href="#">Followers</a>
                  </div>
                  <div class="col-4 text-center">
                    <a href="#">Sales</a>
                  </div>
                  <div class="col-4 text-center">
                    <a href="#">Friends</a>
                  </div>
                </div>
                <!--end::Row-->
              </li>
              <!--end::Menu Body-->
              <!--begin::Menu Footer-->
              <li class="user-footer">
                <a href="/user/profile" class="btn btn-outline-secondary">Profile</a>
                <a href="/logout" class="btn btn-outline-danger float-end">Sign out</a>
              </li>
              <!--end::Menu Footer-->
            </ul>
          </li>
          <!--end::User Menu Dropdown-->
        </ul>
        <!--end::End Navbar Links-->
      </div>
      <!--end::Container-->
    </nav>
    <!--end::Header-->
    <!--begin::Sidebar-->
    <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">

      <!--begin::Sidebar Brand-->
      <div class="sidebar-brand">
        <!--begin::Brand Link-->
        <a href="dist/index.html" class="brand-link">
          <!--begin::Brand Image-->
          <img src="dist/assets/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image opacity-75 shadow" />
          <!--end::Brand Image-->
          <!--begin::Brand Text-->
          <span class="brand-text fw-light">Demo</span>
          <!--end::Brand Text-->
        </a>
        <!--end::Brand Link-->
      </div>
      <!--end::Sidebar Brand-->
      <!--begin::Sidebar Wrapper-->
      <div class="sidebar-wrapper">
        <nav class="mt-2" aria-label="Main navigation">
          <!--begin::Sidebar Menu-->
          <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" data-accordion="false" id="navigation">
            <?php
            helper('menu');
            $menuData = include APPPATH . 'Config/Menu.php';
            echo generateMenu($menuData);
            ?>

          </ul>
          <!--end::Sidebar Menu-->

          <!-- Docs CTA (bottom of sidebar) -->
          <div class="p-3 mt-3 border-top border-secondary border-opacity-25">
            <a href="dist/docs/introduction.html"
              class="btn btn-sm btn-outline-light w-100 d-flex align-items-center justify-content-center gap-2">
              <i class="bi bi-book" aria-hidden="true"></i>
              View documentation
            </a>
          </div>
        </nav>
      </div>
      <!--end::Sidebar Wrapper-->
    </aside>
    <!--end::Sidebar-->
    <!--begin::App Main-->
    <main class="app-main">
      <!--begin::App Content Header-->
      <div class="app-content-header">
        <!--begin::Container-->
        <div class="container-fluid">
          <!--begin::Row-->
          <div class="row">
            <div class="col-sm-6">
              <h1 class="mb-0 fs-3"><?= $pageTitle ?? 'Collapsed Sidebar' ?></h1>
            </div>
            <div class="col-sm-6">
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb float-sm-end">
                  <li class="breadcrumb-item"><a href="dashboard">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page"><?= $pageTitle ?? 'Collapsed Sidebar' ?></li>
                </ol>
              </nav>
            </div>
          </div>
          <!--end::Row-->
        </div>
        <!--end::Container-->
      </div>
      <!--end::App Content Header-->
      <!--begin::App Content-->
      <div class="app-content">
        <!--begin::Container-->
        <div class="container-fluid">
          <?= $this->renderSection('content'); ?>
        </div>
        <!--end::Container-->
      </div>
      <!--end::App Content-->
    </main>
    <!--end::App Main-->
    <!--begin::Footer-->
    <footer class="app-footer">
      <!--begin::To the end-->
      <div class="float-end d-none d-sm-inline">Affordable Website that Works</div>
      <!--end::To the end-->
      <!--begin::Copyright-->
      <strong>Copyright &copy; 2024-2026&nbsp; <a href="https://www.webdevdelhi.com/">WebDevDelhi</a>.</strong> All
      rights
      reserved.
      <!--end::Copyright-->
    </footer>
    <!--end::Footer-->
  </div>
  <!--end::App Wrapper-->

  <!--begin::Script-->
  <!--begin::Third Party Plugin(OverlayScrollbars)-->
  <script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/browser/overlayscrollbars.browser.es6.min.js"
    crossorigin="anonymous"></script>
  <!--end::Third Party Plugin(OverlayScrollbars)-->
  <!--begin::Required Plugin(popperjs for Bootstrap 5)-->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" crossorigin="anonymous">
  </script>
  <!--end::Required Plugin(popperjs for Bootstrap 5)-->
  <!--begin::Required Plugin(Bootstrap 5)-->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.min.js" crossorigin="anonymous"></script>
  <!--end::Required Plugin(Bootstrap 5)-->
  <!--begin::Required Plugin(AdminLTE)-->
  <script src="dist/js/adminlte.js"></script>
  <!--end::Required Plugin(AdminLTE)-->
  <!--begin::OverlayScrollbars Configure-->
  <script>
    const SELECTOR_SIDEBAR_WRAPPER = '.sidebar-wrapper';
    const Default = {
      scrollbarTheme: 'os-theme-light',
      scrollbarAutoHide: 'leave',
      scrollbarClickScroll: true,
    };
    document.addEventListener('DOMContentLoaded', function() {
      const sidebarWrapper = document.querySelector(SELECTOR_SIDEBAR_WRAPPER);

      // Disable OverlayScrollbars on mobile devices to prevent touch interference
      const isMobile = window.innerWidth <= 992;

      if (
        sidebarWrapper &&
        OverlayScrollbarsGlobal?.OverlayScrollbars !== undefined &&
        !isMobile
      ) {
        OverlayScrollbarsGlobal.OverlayScrollbars(sidebarWrapper, {
          scrollbars: {
            theme: Default.scrollbarTheme,
            autoHide: Default.scrollbarAutoHide,
            clickScroll: Default.scrollbarClickScroll,
          },
        });
      }
    });
  </script>
  <!--end::OverlayScrollbars Configure-->

  <!-- REQUIRED SCRIPTS -->

  <!-- jQuery -->
  <script src="plugins/jquery/jquery.min.js"></script>
  
  <script src="plugins/datatables5/datatables.min.js"></script>
  <script src="plugins/jszip/jszip.min.js"></script>
  <script src="plugins/pdfmake/pdfmake.min.js"></script>
  <script src="plugins/pdfmake/vfs_fonts.js"></script>

  <script src="plugins/sweetalert2/sweetalert2.min.js"></script>
  <script src="plugins/toastr/toastr.min.js"></script>

  <?= $this->renderSection('scripts'); ?>

  <!--begin::Color Mode Toggle-->
  <!-- The light/dark/auto switcher ships in adminlte.js as the ColorMode
     module (since 4.1) — no page script needed. Only the no-flash snippet
     in <head> stays inline, because it must run before first paint. -->
  <!--end::Color Mode Toggle-->
  <!--end::Script-->
</body>
<!--end::Body-->

</html>