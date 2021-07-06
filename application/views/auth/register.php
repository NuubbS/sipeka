<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Registrasi &mdash; Perpus Kampus</title>

    <!-- General CSS Files -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/fontawesome/css/all.min.css">

    <!-- CSS Libraries -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/bootstrap/css/bootstrap-social.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/toast/iziToast.css">

    <!-- Template CSS -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/style.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/components.css">
</head>

<body>
    <div id="app">
        <section class="section">
            <div class="d-flex flex-wrap align-items-stretch">
                <div class="col-lg-4 col-md-6 col-12 order-lg-1 min-vh-100 order-2 bg-white">
                    <div class="p-4 m-3">
                        <div class="loginPage d-block">
                            <h4 class="text-dark font-weight-normal">Selamat Datang di <span
                                    class="font-weight-bold">PERPUS
                                    KAMPUS</span>
                            </h4>
                            <p class="text-muted">Sebelum menggunakan aplikasi ini, anda harus masuk atau mendaftar jika
                                belum mempunyai akun.</p>
                            <form method="POST" action="<?=site_url('auth/register')?> ">
                                <div class="form-group">
                                    <label>Nama</label>
                                    <input type="text" class="form-control" name="nama" id="nama"
                                        value="<?= set_value('nama') ?>" placeholder="Nama Lengkap anda">
                                    <?= form_error('nama', '<small class="text-danger">','</small>') ?>
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" class="form-control" name="email" id="email"
                                        value="<?= set_value('email'); ?>"
                                        placeholder="Harap masukkan email yang masih aktif">
                                    <?= form_error('email', '<small class="text-danger">','</small>') ?>
                                </div>
                                <div class="form-group row">
                                    <div class="col-6"><label>Password</label>
                                        <input type="password" class="form-control" name="password" id="password">
                                        <?= form_error('password', '<small class="text-danger">','</small>') ?>
                                    </div>
                                    <div class="col-6"><label>Ulangi Password</label>
                                        <input type="password" class="form-control" name="passwordconfig"
                                            id="passwordconfig">
                                        <?= form_error('passwordconfig', '<small class="text-danger">','</small>') ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Alamat</label>
                                    <input type="text" class="form-control" name="alamat" id="alamat"
                                        value="<?= set_value('alamat'); ?>">
                                    <?= form_error('alamat', '<small class="text-danger">','</small>') ?>
                                </div>
                                <div class="form-group">
                                    <label>No. Handphone</label>
                                    <input type="number" class="form-control" name="no_handphone" id="no_handphone"
                                        value="<?= set_value('no_handphone'); ?>">
                                    <?= form_error('no_handphone', '<small class="text-danger">','</small>') ?>
                                </div>
                                <div class="form-group text-right">
                                    <a href="<?= base_url('auth'); ?>" class="float-left mt-3">
                                        Login
                                    </a>
                                    <button type="submit" name="register"
                                        class="btn btn-primary btn-lg btn-icon icon-right" tabindex="4">
                                        Daftar Sekarang
                                    </button>
                                </div>
                            </form>

                            <div class="text-center text-small">
                                Copyright &copy; NuubbS. Made with 💙 by Stisla
                            </div>
                        </div>
                        <!-- end login page -->
                    </div>
                </div>
                <div class="col-lg-8 col-12 order-lg-2 order-1 min-vh-100 background-walk-y position-relative overlay-gradient-bottom d-none d-sm-block"
                    data-background="<?= base_url() ?>assets/img/unsplash/login-bg.jpg">
                    <div class="absolute-bottom-left index-2">
                        <div class="text-light p-5 pb-2">
                            <div class="mb-5 pb-3">
                                <h1 class="mb-2 display-4 font-weight-bold">Good Morning</h1>
                                <h5 class="font-weight-normal text-muted-transparent">Bali, Indonesia</h5>
                            </div>
                            Photo by <a class="text-light bb" target="_blank"
                                href="https://unsplash.com/photos/a8lTjWJJgLA">Justin
                                Kauffman</a> on <a class="text-light bb" target="_blank"
                                href="https://unsplash.com">Unsplash</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- General JS Scripts -->
    <script src="<?= base_url() ?>assets/plugins/jquery/jquery-3.6.0.min.js"></script>
    <script src="<?= base_url() ?>assets/plugins/loading-overlay/loadingoverlay.js"></script>
    <script src="<?= base_url() ?>assets/plugins/popper.js"></script>
    <script src="<?= base_url() ?>assets/plugins/tooltip.js"></script>
    <script src="<?= base_url() ?>assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?= base_url() ?>assets/plugins/jquery/jquery.nicescroll.min.js"></script>
    <script src="<?= base_url() ?>assets/plugins/jquery/moment.js"></script>
    <script src="<?= base_url() ?>assets/js/stisla.js"></script>
    <script src="<?= base_url() ?>assets/plugins/toast/iziToast.min.js"></script>
    <script src="<?= base_url() ?>assets/plugins/sweetalert2/sweetalert2.all.min.js"></script>

    <!-- JS Libraies -->

    <!-- Template JS File -->
    <script src="<?= base_url(); ?>assets/js/scripts.js"></script>
    <script src="<?= base_url(); ?>assets/js/custom.js"></script>

    <!-- Page Specific JS File --> -->
    <script>
    $.LoadingOverlay("show")
    $(document).ready(function() {
        $.LoadingOverlay("hide")
    })
    </script>
</body>

</html>