<?php
include "koneksi.php";

if (!isset($_SESSION['user'])) {
    header('location:login.php');
    exit;
}

$page = isset($_GET['page']) ? $_GET['page'] : 'home';
$namaUser = $_SESSION['user']['nama'] ?? 'Pengguna';

/* Menentukan menu aktif */
if (strpos($page, 'pelanggan_') === 0) {
    $menuAktif = 'pelanggan';
} elseif (strpos($page, 'produk_') === 0) {
    $menuAktif = 'produk';
} elseif (
    strpos($page, 'pembelian_') === 0 ||
    strpos($page, 'penjualan_') === 0
) {
    $menuAktif = 'pembelian';
} else {
    $menuAktif = $page;
}

/* Daftar halaman yang diizinkan */
$halamanDiizinkan = [
    'home',
    'pelanggan',
    'pelanggan_tambah',
    'pelanggan_ubah',
    'pelanggan_hapus',
    'produk',
    'produk_tambah',
    'produk_ubah',
    'produk_hapus',
    'pembelian',
    'pembelian_tambah',
    'pembelian_detail',
    'penjualan_detail',
    'user'
];
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Aplikasi Kasir Restoran</title>

    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet">

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        :root {
            --sidebar-bg: #172033;
            --sidebar-hover: #263550;
            --primary: #3b82f6;
            --text-muted: #94a3b8;
        }

        body {
            background: #f5f7fb;
            font-family: "Segoe UI", Arial, sans-serif;
        }

        /* =========================
           NAVBAR ATAS BIRU GELAP
        ========================= */

        .sb-topnav {
            height: 65px;
            background: linear-gradient(
                135deg,
                #172033,
                #243653
            ) !important;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 4px 14px rgba(15, 23, 42, 0.15);
        }

        .sb-topnav .navbar-brand {
            width: 225px;
            margin: 0;
            color: #ffffff !important;
            font-size: 18px;
            font-weight: 750;
            display: flex;
            align-items: center;
        }

        .brand-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            margin-right: 10px;
            border-radius: 10px;
            background: linear-gradient(135deg, #2563eb, #60a5fa);
            color: #ffffff;
            box-shadow: 0 4px 10px rgba(37, 99, 235, 0.25);
        }

        #sidebarToggle {
            color: #ffffff !important;
            font-size: 17px;
            text-decoration: none;
        }

        #sidebarToggle:hover {
            color: #93c5fd !important;
        }

        /* Profil navbar */
        .topbar-user {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #ffffff !important;
            padding: 7px 12px;
            border-radius: 10px;
            text-decoration: none;
        }

        .topbar-user:hover,
        .topbar-user:focus {
            background: rgba(255, 255, 255, 0.1);
            color: #ffffff !important;
        }

        .topbar-avatar {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: #334b70;
            color: #bfdbfe;
        }

        .topbar-name {
            display: block;
            color: #ffffff;
            font-size: 13px;
            font-weight: 650;
        }

        .topbar-role {
            display: block;
            color: #a8b7cc;
            font-size: 11px;
        }

        /* Dropdown akun tetap terang */
        .dropdown-menu {
            background: #ffffff;
            border: 1px solid #e8edf4;
            border-radius: 12px;
            padding: 8px;
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.12);
        }

        .dropdown-item {
            color: #334155;
            padding: 10px 12px;
            border-radius: 7px;
            font-size: 13px;
        }

        .dropdown-item:hover {
            background: #eff6ff;
            color: #2563eb;
        }

        /* =========================
           SIDEBAR
        ========================= */

        #layoutSidenav_nav {
            width: 225px;
        }

        .sb-sidenav {
            background: var(--sidebar-bg) !important;
        }

        .sb-sidenav-menu {
            padding-top: 12px;
        }

        .sb-sidenav .sb-sidenav-menu-heading {
            padding: 22px 22px 12px;
            color: var(--text-muted) !important;
            font-size: 10px;
            font-weight: 750;
            letter-spacing: 1.5px;
            text-transform: uppercase;
        }

        .sb-sidenav .nav-link {
            display: flex;
            align-items: center;
            margin: 4px 12px;
            padding: 12px 14px;
            color: #cbd5e1 !important;
            font-size: 13px;
            font-weight: 500;
            border-radius: 9px;
            transition: all 0.2s ease;
        }

        .sb-sidenav .nav-link:hover {
            background: var(--sidebar-hover);
            color: #ffffff !important;
            transform: translateX(2px);
        }

        .sb-sidenav .nav-link.active {
            background: linear-gradient(135deg, #2563eb, #3b82f6);
            color: #ffffff !important;
            font-weight: 650;
            box-shadow: 0 5px 14px rgba(37, 99, 235, 0.22);
        }

        .sb-nav-link-icon {
            width: 25px;
            min-width: 25px;
            margin-right: 8px;
            color: #94a3b8;
            text-align: center;
            font-size: 15px;
        }

        .sb-sidenav .nav-link.active .sb-nav-link-icon {
            color: #ffffff;
        }

        .sb-sidenav .nav-link:hover .sb-nav-link-icon {
            color: #93c5fd;
        }

        /* =========================
           PROFIL SIDEBAR
        ========================= */

        .sb-sidenav-footer {
            background: rgba(0, 0, 0, 0.16) !important;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
            padding: 16px;
        }

        .profile-box {
            display: flex;
            align-items: center;
            gap: 11px;
        }

        .profile-avatar {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 38px;
            height: 38px;
            flex-shrink: 0;
            border-radius: 11px;
            background: #334155;
            color: #bfdbfe;
        }

        .profile-label {
            color: #94a3b8;
            font-size: 10px;
            margin-bottom: 3px;
        }

        .profile-name {
            color: #ffffff;
            font-size: 13px;
            font-weight: 650;
            overflow-wrap: anywhere;
        }

        /* =========================
           KONTEN UTAMA DAN FOOTER
        ========================= */

        #layoutSidenav_content {
            background: #ffffff;
            min-width: 0;
        }

        #layoutSidenav_content > main {
            min-height: calc(100vh - 145px);
        }

        footer {
            border-top: 1px solid #edf0f5;
        }

        footer a {
            color: #2563eb;
            text-decoration: none;
        }

        footer a:hover {
            text-decoration: underline;
        }

        /* =========================
           RESPONSIVE
        ========================= */

        @media (max-width: 991px) {
            .sb-topnav .navbar-brand {
                width: auto;
                font-size: 15px;
                padding-right: 10px;
            }

            .brand-icon {
                width: 32px;
                height: 32px;
                margin-right: 8px;
            }

            .topbar-name,
            .topbar-role {
                display: none;
            }
        }

        @media (max-width: 480px) {
            .sb-topnav {
                height: 58px;
            }

            .sb-topnav .navbar-brand {
                font-size: 13px;
                padding-left: 10px !important;
            }

            .brand-icon {
                width: 29px;
                height: 29px;
            }

            footer .d-flex {
                flex-direction: column;
                align-items: flex-start !important;
                gap: 8px;
            }
        }
    </style>
</head>

<body class="sb-nav-fixed">

    <!-- NAVBAR ATAS -->
    <nav class="sb-topnav navbar navbar-expand navbar-dark">

        <a class="navbar-brand ps-3" href="index.php">
            <span class="brand-icon">
                <i class="fa-solid fa-utensils"></i>
            </span>
            Kasir Restoran
        </a>

        <button
            class="btn btn-link btn-sm order-1 order-lg-0 me-3"
            id="sidebarToggle"
            type="button"
            aria-label="Buka atau tutup navigasi">

            <i class="fa-solid fa-bars"></i>
        </button>

        <div class="ms-auto"></div>

        <ul class="navbar-nav me-3 me-lg-4">
            <li class="nav-item dropdown">

                <a
                    class="nav-link dropdown-toggle topbar-user"
                    id="navbarDropdown"
                    href="#"
                    role="button"
                    data-bs-toggle="dropdown"
                    aria-expanded="false">

                    <span class="topbar-avatar">
                        <i class="fa-solid fa-user"></i>
                    </span>

                    <span>
                        <span class="topbar-name">
                            <?php echo htmlspecialchars($namaUser); ?>
                        </span>

                        <span class="topbar-role">
                            Akun Pengguna
                        </span>
                    </span>
                </a>

                <ul
                    class="dropdown-menu dropdown-menu-end"
                    aria-labelledby="navbarDropdown">

                    <li>
                        <span class="dropdown-item-text">
                            <small class="text-muted">Login sebagai</small><br>
                            <strong>
                                <?php echo htmlspecialchars($namaUser); ?>
                            </strong>
                        </span>
                    </li>

                    <li><hr class="dropdown-divider"></li>

                    <li>
                        <a class="dropdown-item text-danger" href="logout.php">
                            <i class="fa-solid fa-right-from-bracket me-2"></i>
                            Logout
                        </a>
                    </li>
                </ul>

            </li>
        </ul>
    </nav>

    <!-- LAYOUT SIDEBAR -->
    <div id="layoutSidenav">

        <div id="layoutSidenav_nav">

            <nav
                class="sb-sidenav accordion sb-sidenav-dark"
                id="sidenavAccordion">

                <div class="sb-sidenav-menu">
                    <div class="nav">

                        <div class="sb-sidenav-menu-heading">
                            Menu Utama
                        </div>

                        <a
                            class="nav-link <?php echo $menuAktif === 'home' ? 'active' : ''; ?>"
                            href="index.php">

                            <div class="sb-nav-link-icon">
                                <i class="fa-solid fa-house"></i>
                            </div>
                            Dashboard
                        </a>

                        <a
                            class="nav-link <?php echo $menuAktif === 'pelanggan' ? 'active' : ''; ?>"
                            href="?page=pelanggan">

                            <div class="sb-nav-link-icon">
                                <i class="fa-solid fa-users"></i>
                            </div>
                            Pelanggan
                        </a>

                        <a
                            class="nav-link <?php echo $menuAktif === 'produk' ? 'active' : ''; ?>"
                            href="?page=produk">

                            <div class="sb-nav-link-icon">
                                <i class="fa-solid fa-box-open"></i>
                            </div>
                            Produk / Barang
                        </a>

                        <a
                            class="nav-link <?php echo $menuAktif === 'pembelian' ? 'active' : ''; ?>"
                            href="?page=pembelian">

                            <div class="sb-nav-link-icon">
                                <i class="fa-solid fa-basket-shopping"></i>
                            </div>
                            Pembelian
                        </a>

                        <a
                            class="nav-link <?php echo $menuAktif === 'user' ? 'active' : ''; ?>"
                            href="?page=user">

                            <div class="sb-nav-link-icon">
                                <i class="fa-solid fa-user-gear"></i>
                            </div>
                            User
                        </a>

                    </div>
                </div>

                <!-- PROFIL PENGGUNA -->
                <div class="sb-sidenav-footer">

                    <div class="profile-box">

                        <div class="profile-avatar">
                            <i class="fa-solid fa-user-shield"></i>
                        </div>

                        <div>
                            <div class="profile-label">
                                LOGIN SEBAGAI
                            </div>

                            <div class="profile-name">
                                <?php echo htmlspecialchars($namaUser); ?>
                            </div>
                        </div>

                    </div>

                </div>

            </nav>
        </div>

        <!-- KONTEN HALAMAN -->
        <div id="layoutSidenav_content">

            <main>
                <?php
                if (
                    in_array($page, $halamanDiizinkan, true) &&
                    is_file($page . '.php')
                ) {
                    include $page . '.php';
                } else {
                    echo '
                    <div class="container-fluid px-4 py-4">
                        <div class="alert alert-warning">
                            Halaman tidak ditemukan.
                        </div>
                    </div>';
                }
                ?>
            </main>

            <!-- FOOTER -->
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">

                    <div class="d-flex align-items-center justify-content-between small">

                        <div class="text-muted">
                            &copy; <?php echo date('Y'); ?>
                            Aplikasi Kasir Restoran
                        </div>

                        <div>
                            <a href="#">Privacy Policy</a>
                            &middot;
                            <a href="#">Terms &amp; Conditions</a>
                        </div>

                    </div>
                </div>
            </footer>

        </div>
    </div>

    <!-- JAVASCRIPT -->
    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous">
    </script>

    <script src="js/scripts.js"></script>

    <script
        src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
        crossorigin="anonymous">
    </script>

    <script src="js/datatables-simple-demo.js"></script>

</body>
</html>