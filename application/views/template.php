<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Dashboard &mdash; SIPEKA AKB</title>
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
    <link rel="stylesheet" href="<?= base_url() ?>assets/vendor/select2/css/select2.min.css">
    <link rel="stylesheet" type="text/css"
        href="<?= base_url('assets/vendor/select2-bootstrap4-theme/select2-bootstrap4.min.css') ?>">
    </link>
    <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/bootstrap/css/bootstrap-social.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/toast/iziToast.css">
    <link href="<?= base_url() ?>assets/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

    <!-- Template CSS -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/style.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/custom.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/components.css">

    <!-- General JS Scripts -->
    <script src="<?= base_url() ?>assets/plugins/jquery/jquery-3.6.0.min.js"></script>
    <script src="<?= base_url() ?>assets/vendor/select2/js/select2.full.js"></script>
    <script>
    // In your Javascript (external .js resource or <script> tag)
    $(document).ready(function() {
        $(".select3").select2({
            placeholder: 'anjay'
        });
        $(".selectPeminjaman").select2({
            placeholder: 'anjay'
        });
        $('#mySelect2').select2({
            ajax: {
                url: 'https://api.github.com/orgs/select2/repos',
                data: function(params) {
                    var query = {
                        search: params.term,
                        type: 'public'
                    }

                    // Query parameters will be ?search=[term]&type=public
                    return query;
                }
            }
        });
    });
    </script>
    <script src="<?= base_url() ?>assets/js/datatables.min.js"></script>
    <script src="<?= base_url() ?>assets/plugins/loading-overlay/loadingoverlay.js"></script>
    <script src="<?= base_url() ?>assets/plugins/popper.js"></script>
    <script src="<?= base_url() ?>assets/plugins/tooltip.js"></script>
    <!-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> -->

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
                        <a href="#">PERPUSTAKAAN</a>
                    </div>
                    <div class="sidebar-brand sidebar-brand-sm">
                        <a href="#"><img src="<?= base_url('assets/img/logo/favicon.png'); ?>" width="50"></a>
                    </div>
                    <ul class="sidebar-menu">
                        <!-- admin menu -->
                        <?php if($this->session->userdata('level_id') == 1 ) { ?>
                        <li class="menu-header">Dashboard</li>
                        <li
                            class="<?= $this->uri->segment(2) == 'dashboard' || $this->uri->segment(1) == null ? 'active' : '' ?>">
                            <a class="nav-link" href="<?= base_url('administrator/dashboard') ?>">
                                <i class="fas fa-fire"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        <li class="menu-header">DATA PERPUSTAKAAN</li>
                        <!-- dropdown -->
                        <li
                            class="nav-item dropdown <?= $this->uri->segment(2) == "rak" || $this->uri->segment(1) == "buku" ? 'active' : '' ?>">
                            <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-lock"></i>
                                <span>Master Data</span></a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="nav-link" href="<?php echo base_url ('administrator/prodi'); ?>">Program
                                        Studi</a>
                                </li>
                                <li>
                                    <a class="nav-link"
                                        href="<?php echo base_url ('administrator/kategori'); ?>">Kategori
                                        Buku</a>
                                </li>
                                <li
                                    class="<?= $this->uri->segment(2) == 'rak' || $this->uri->segment(1) == null ? 'active' : '' ?>">
                                    <a class="nav-link" href="<?php echo base_url ('administrator/rak'); ?>">Rak</a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-book"></i>
                                <span>Buku</span></a>
                            <ul class="dropdown-menu">
                                <!-- <li class="<?= $this->uri->segment(2) == 'referensi' ? 'active' : '' ?>"> -->
                                <li>
                                    <a class="nav-link" href="<?= base_url ('administrator/referensi')?>">Referensi</a>
                                </li>
                                <li>
                                    <a class="nav-link" href="<?= base_url ('administrator/laporan_ta')?>">Laporan Tugas
                                        Akhir</a>
                                </li>
                                <li>
                                    <a class="nav-link" href="<?= base_url ('administrator/laporan_ojt')?>">Laporan
                                        OJT</a>
                                </li>
                                <li>
                                    <a class="nav-link" href="<?= base_url ('administrator/mata_kuliah')?>">Mata
                                        Kuliah</a>
                                </li>
                            </ul>
                        </li>
                        <!-- <li
                            class="<?= $this->uri->segment(2) == 'buku' || $this->uri->segment(1) == null ? 'active' : '' ?>">
                            <a class="nav-link" href="<?= base_url('administrator/buku') ?>">
                                <i class="fas fa-book"></i>
                                <span>Buku</span>
                            </a>
                        </li> -->
                        <li class="dropdown">
                            <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i
                                    class="fab fa-wpforms"></i> <span>Peraturan</span></a>
                            <ul class="dropdown-menu">
                                <li class=""><a class="nav-link"
                                        href="<?php echo base_url ('administrator/lama_peminjaman'); ?>">Lama
                                        Peminjaman</a>
                                </li>
                                <li>
                                    <a class="nav-link" href="#">Denda</a>
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i
                                    class="fas fa-users"></i> <span>Data Pengguna</span></a>
                            <ul class="dropdown-menu">
                                <li class="">
                                    <a class="nav-link" href="<?= base_url() ?>administrator/anggota">
                                        <!-- <i class="fas fa-users fa-fw"></i> -->
                                        <span>Anggota</span>
                                    </a>
                                </li>
                                <li class="">
                                    <a class="nav-link" href="<?= base_url() ?>administrator/petugas">
                                        <!-- <i class="fas fa-user-shield fa-fw"></i> -->
                                        <span>Petugas</span>
                                    </a>
                                </li>
                                <li class="">
                                    <a class="nav-link" href="<?= base_url() ?>administrator/petugas">
                                        <!-- <i class="fas fa-user-shield fa-fw"></i> -->
                                        <span>Banned</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="menu-header">Transaki</li>
                        <li class="">
                            <a class="nav-link" href="<?= base_url() ?>transaksi/peminjaman">
                                <i class="fas fa-upload fa-fw"></i>
                                <span>Transaksi Peminjaman</span>
                            </a>
                        </li>

                        <!-- <li class="">
                            <a class="nav-link" href="<?= base_url() ?>administrator/peminjaman2">
                                <i class="fas fa-upload fa-fw"></i>
                                <span>Transaksi Peminjaman v2</span>
                            </a>
                        </li> -->
                        <li class="">
                            <a class="nav-link" href="<?= base_url() ?>transaksi/peminjamanBuku">
                                <i class="fas fa-clipboard-list fa-fw"></i>
                                <span>Peminjaman</span>
                            </a>
                        </li>
                        <li class="">
                            <a class="nav-link" href="<?= base_url() ?>transaksi/pengembalianBuku">
                                <i class="fas fa-clipboard-check fa-fw"></i>
                                <span>Pengembalian</span>
                            </a>
                        </li>
                        <li class="menu-header">Extra</li>
                        <li class="dropdown">
                            <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-file"></i>
                                <span>Laporan</span></a>
                            <ul class="dropdown-menu">
                                <li class=""><a class="nav-link"
                                        href="<?php echo base_url ('administrator/laporan_ojt'); ?>">OJT</a></li>
                                <li><a class="nav-link" href="<?php echo base_url ('administrator/anggota'); ?>">Tugas
                                        Akhir</a>
                                </li>
                            </ul>
                        </li>

                        <li class="menu-header">Pengaturan</li>
                        <!-- <li class="dropdown">

                            <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i
                                    class="fas fa-laptop-code"></i> <span>Aplikasi</span></a>
                            <ul class="dropdown-menu">
                                <li class=""><a class="nav-link"
                                        href="<?php echo base_url ('administrator/maintenance'); ?>">Maintenance Aplikasi</a>
                                </li>
                                <li><a class="nav-link" href="<?php echo base_url ('administrator/kontak'); ?>">Kontak
                                        Developer</a></li>
                            </ul>
                        </li>
                        <li class="">
                            <a class="nav-link" href="<?= base_url() ?>webconfig">
                                <i class="fas fa-money-bill-wave"></i>
                                <span>Denda</span>
                            </a>
                        </li> -->
                        <li class="">
                            <a class="nav-link" href="<?= base_url() ?>user/user_account">
                                <i class="fas fa-users-cog"></i>
                                <span>Profil Saya</span>
                            </a>
                        </li>
                        <?php } ?>
                        <!-- admin menu -->
                        <!-- member menu -->
                        <!-- <?php if($this->session->userdata('level_id') == 2 ) { ?>
                        <li class="menu-header">Dashboard</li>
                        <li
                            class="<?= $this->uri->segment(2) == 'buku' || $this->uri->segment(1) == null ? 'active' : '' ?>">
                            <a class="nav-link" href="<?= base_url('administrator/buku') ?>">
                                <i class="fas fa-book-open"></i>
                                <span>Data Buku</span>
                            </a>
                        </li>
                        <?php } ?> -->
                        <!-- member menu -->
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
    <script src="<?= base_url() ?>assets/js/custom.js" defer></script>
    <script src="<?= base_url() ?>assets/datatables/jquery.dataTables.min.js"></script>
    <script src="<?= base_url() ?>assets/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <!-- <script src="<?= base_url() ?>assets/datatables/datatables-demo.js"></script> -->

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
        $('#tableclient').DataTable();
    });
    </script>
    <!-- ========== SCRIPT SELECT2 ========== -->
    <script>
    $(document).ready(function() {
        selectBuku()
        selectPeminjam()
    });

    function selectBuku() {
        // ===== Buku ===== //

        $('.select_buku').select2({
            ajax: {
                url: "<?= base_url('administrator/getDataBuku_Select'); ?>",
                dataType: "json",
                type: "post",
                delay: 250,
                data: function(params) {
                    console.log(params.term)
                    return {
                        search: params.term,
                    }
                },
                processResults: function(data) {
                    return {
                        results: data
                    };
                },
                cache: true
            },
            placeholder: 'Ketik Judul Buku',
            minimumInputLength: 3,
        });

        // ===== End Buku ===== //   
    }

    function selectPeminjam() {

        // ===== Peminjam ===== //

        $('.select_peminjam').select2({
            ajax: {
                url: "<?= base_url('administrator/getDataPeminjam_Select'); ?>",
                dataType: "json",
                type: "post",
                delay: 250,
                data: function(params) {
                    console.log(params.term)
                    return {
                        search: params.term,
                    }
                },
                processResults: function(data) {
                    return {
                        results: data
                    };
                },
                cache: true
            },
            placeholder: 'Ketikkan Nama Peminjam',
            minimumInputLength: 3,
        });
        // ===== End Peminjam ===== //
    }
    </script>
    <!-- ========== END SCRIPT SELECT2 ========== -->
</body>

</html>