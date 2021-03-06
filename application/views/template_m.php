<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title><?= $title; ?></title>
    <link rel="icon" type="image/png" href="<?= base_url() ?>assets/img/logo/favicon.png" />
    <!-- <title>Dashboard &mdash; Lazisnu</title> -->

    <!-- General CSS Files -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/fontawesome/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/css/datatables.min.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/plugins/animate.min.css">

    <!-- CSS Libraries -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/jqvmap/dist/jqvmap.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/summernote/css/summernote-bs4.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/OwlCarousel/dist/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/OwlCarousel/dist/assets/owl.theme.default.min.css">
    <!-- <link rel="stylesheet" src="<?= base_url() ?>assets/plugins/toast/sweetalert2.min.css"> -->
    </link>
    <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/bootstrap/css/bootstrap-social.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/toast/iziToast.css">

    <!-- Template CSS -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/style.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/custom.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/components.css">

    <!-- General JS Scripts -->
    <script src="<?= base_url() ?>assets/plugins/jquery/jquery-3.5.1.min.js"></script>
    <script src="<?= base_url() ?>assets/js/datatables.min.js"></script>
    <script src="<?= base_url() ?>assets/plugins/loading-overlay/loadingoverlay.js"></script>
    <script src="<?= base_url() ?>assets/plugins/popper.js"></script>
    <script src="<?= base_url() ?>assets/plugins/tooltip.js"></script>

    <style type="text/css">
    .preloader {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 9999;
        background-color: #fff;
    }

    .preloader .loading {
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
        font: 14px arial;
    }
    </style>
</head>

<body>
    <!-- loader -->
    <div class="preloader">
        <div class="loading">
            <img src="<?= base_url() ?>assets/img/loader/loader.gif" width="80">
            <p>Harap Tunggu</p>
        </div>
    </div>
    <!-- loader -->
    <div id="app">
        <div class="main-wrapper">
            <div class="navbar-bg"></div>
            <nav class="navbar navbar-expand-lg main-navbar">
                <form class="form-inline mr-auto">
                    <ul class="navbar-nav mr-3">
                        <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i
                                    class="fas fa-bars"></i></a></li>
                    </ul>
                </form>
                <ul class="navbar-nav navbar-right">
                    <div class="animate__animated animate__zoomIn animate__fast">
                        <li class="dropdown"><a href="#" data-toggle="dropdown"
                                class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                                <img alt="image" src="<?= base_url() ?>assets/img/avatar/default_user.png"
                                    class="rounded-circle mr-1">
                                <div class="d-sm-none d-lg-inline-block">Hi, <?= $this->sesi->user_login()->nama; ?>
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <div class="dropdown-title">Terakhir login 5 jam yang lalu</div>
                                <a href="<?= base_url() ?>profile" class="dropdown-item has-icon">
                                    <i class="fas fa-user"></i> Profile
                                </a>
                                <a href="features-activities.html" class="dropdown-item has-icon">
                                    <i class="fas fa-bolt"></i> Activities
                                </a>
                                <a href="features-settings.html" class="dropdown-item has-icon">
                                    <i class="fas fa-cog"></i> Settings
                                </a>
                                <div class="dropdown-divider"></div>
                                <a href="<?=site_url('auth/logout')?>" class="dropdown-item has-icon text-danger">
                                    <i class="fas fa-sign-out-alt"></i> Logout
                                </a>
                            </div>
                        </li>
                    </div>
                </ul>
            </nav>
            <div class="main-sidebar">
                <aside id="sidebar-wrapper">
                    <div class="sidebar-brand">
                        <a href="#">PERPus kampus</a>
                    </div>
                    <div class="sidebar-brand sidebar-brand-sm">
                        <a href="#">pk</a>
                    </div>
                    <!-- <div class="sidebar-brand sidebar-brand-sm">
                        <a href="#"><img src="<?= base_url('assets/img/logo/favicon.png'); ?>" width="50"></a>
                    </div> -->
                    <ul class="sidebar-menu">
                        <li class="menu-header">Dashboard</li>
                        <li class="<?= $this->uri->segment(2) == 'profil' ? 'active' : '' ?>">
                            <a class="nav-link" href="<?= base_url('member/profil') ?>">
                                <i class="fas fa-user"></i>
                                <span>Profil Saya</span>
                            </a>
                        </li>
                        <li
                            class="nav-item dropdownn <?= $this->uri->segment(2) == "referensi" || $this->uri->segment(2) == "laporan_ta" || $this->uri->segment(2) =="laporan_ojt" || $this->uri->segment(2) == "mata_kuliah" ? 'active' : '' ?>">
                            <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-book"></i>
                                <span>Buku</span></a>
                            <ul class="dropdown-menu">
                                <li class="<?= $this->uri->segment(2) == 'referensi' ? 'active' : '' ?>">
                                    <a class="nav-link" href="<?= base_url ('member/referensi')?>">Referensi</a>
                                </li>
                                <li class="<?= $this->uri->segment(2) == 'laporan_ta' ? 'active' : '' ?>">
                                    <a class="nav-link" href="<?= base_url ('member/laporan_ta')?>">Laporan Tugas
                                        Akhir</a>
                                </li>
                                <li class="<?= $this->uri->segment(2) == 'laporan_ojt' ? 'active' : '' ?>">
                                    <a class="nav-link" href="<?= base_url ('member/laporan_ojt')?>">Laporan
                                        OJT</a>
                                </li>
                                <li class="<?= $this->uri->segment(2) == 'mata_kuliah' ? 'active' : '' ?>">
                                    <a class="nav-link" href="<?= base_url ('member/mata_kuliah')?>">Mata
                                        Kuliah</a>
                                </li>
                            </ul>
                        </li>
                        <li class="<?= $this->uri->segment(2) == 'histori'  ? 'active' : '' ?>">
                            <a class="nav-link" href="<?= base_url('member/histori') ?>">
                                <i class="fas fa-history"></i>
                                <span>Riwayat Peminjaman</span>
                            </a>
                        </li>
                    </ul>
                    <!-- sidebar menu -->
                    <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
                        <a href="https://github.com/NuubbS" target="_blank"
                            class="btn btn-dark btn-lg btn-block btn-icon-split">
                            <i class="fab fa-github"></i> Follow Me on GitHub
                        </a>
                    </div>
                </aside>
            </div>

            <!-- untuk isi contents -->
            <?= $contents; ?>
            <!-- untuk isi contents -->

            <footer class="main-footer">
                <div class="footer-left">
                    Copyright &copy; 2021
                    <div class="bullet"></div> Develop By <a href="#">Arief
                        Rahman
                        Putera</a> &mdash; <a href="https://github.com/NuubbS/">M. Hamdan Yusuf</a>
                </div>
                <div class="footer-right">
                    <i>NuubbS</i>
                </div>
            </footer>
        </div>
    </div>

    <!-- General JS Scripts -->
    <script src="<?= base_url() ?>assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?= base_url() ?>assets/plugins/jquery/jquery.nicescroll.min.js"></script>
    <script src="<?= base_url() ?>assets/plugins/jquery/moment.js"></script>
    <script src="<?= base_url() ?>assets/js/stisla.js"></script>

    <!-- JS Libraies -->
    <script src="<?= base_url() ?>assets/plugins/jquery/sparkline.min.js"></script>
    <script src="<?= base_url() ?>assets/plugins/chart/Chart.js"></script>
    <script src="<?= base_url() ?>assets/plugins/OwlCarousel/dist/owl.carousel.min.js"></script>
    <script src="<?= base_url() ?>assets/plugins/summernote/js/summernote-bs4.js"></script>
    <script src="<?= base_url() ?>assets/plugins/Chocolat/dist/js/chocolat.js"></script>
    <script src="<?= base_url() ?>assets/plugins/toast/iziToast.min.js"></script>
    <script src="<?= base_url() ?>assets/plugins/sweetalert2/sweetalert2.all.min.js"></script>


    <!-- Template JS File -->
    <script src="<?= base_url() ?>assets/js/scripts.js"></script>
    <script src="<?= base_url() ?>assets/js/custom.js"></script>

    <!-- Page Specific JS File -->
    <script src="<?= base_url() ?>assets/js/page/index.js"></script>
    <script src="<?= base_url() ?>assets/js/page/components-user.js"></script>

    <!-- ============ Search UI End ============= -->
    <!-- Modal -->
    <div class="modal fade" id="modal-logout" tabindex="-1" role="dialog" aria-labelledby="modal-logoutLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-logoutLabel">Logout Confirmation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Apakah anda yakin untuk logout ?
                </div>
                <form id="formLogout" action="<?= base_url() ?>auth/logout" method="post">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Yes, Logout Now.</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
    // tooltip
    $(document).ready(function() {
        $("body").tooltip({
            selector: '[data-toggle=tooltip]'
        });
        $(".preloader").fadeOut();
    });
    </script>
</body>

</html>