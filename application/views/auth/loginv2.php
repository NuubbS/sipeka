<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Login &mdash; Perpus Kampus</title>

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
    <div id="flash-eror" data-eror="<?= $this->session->flashdata('eror'); ?>"></div>
    <div id="flash-sukses" data-sukses="<?= $this->session->flashdata('sukses'); ?>"></div>
    <div id="flash-warning" data-warning="<?= $this->session->flashdata('warning'); ?>"></div>
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
                            <form method="POST" action="<?=site_url('auth')?> ">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input id="email" type="text" class="form-control" name="email"
                                        value="<?= set_value('email'); ?>" tabindex="1" autofocus>
                                    <?= form_error('email', '<small class="text-danger">','</small>') ?>
                                </div>

                                <div class="form-group">
                                    <div class="d-block">
                                        <label for="password" class="control-label">Password</label>
                                        <div class="float-right">
                                            <!-- <a href="<?= base_url() ?>dist/auth_forgot_password" class="text-small">
                                                Forgot Password?
                                            </a> -->
                                        </div>
                                    </div>
                                    <input id="password" type="password" class="form-control" name="password"
                                        tabindex="2">
                                    <?= form_error('password', '<small class="text-danger">','</small>') ?>
                                </div>

                                <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" name="remember" class="custom-control-input" tabindex="3"
                                            id="remember-me">
                                        <label class="custom-control-label" for="remember-me">Remember Me</label>
                                    </div>
                                </div>

                                <div class="form-group text-right">
                                    <!-- <a href="auth-forgot-password.html" class="float-left mt-3">
                                        Forgot Password?
                                    </a> -->
                                    <button type="submit" name="login"
                                        class="btn btn-primary btn-lg btn-icon icon-right" tabindex="4">
                                        Login
                                    </button>
                                </div>

                                <div class="mt-5 text-center">
                                    Don't have an account? <a href="<?= base_url('auth/register'); ?>">Create new
                                        one</a>
                                </div>
                            </form>

                            <div class="text-center mt-5 text-small">
                                Copyright &copy; NuubbS. Made with ???? by Stisla
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

    <!-- Page Specific JS File -->
    <script>
    $.LoadingOverlay("show")
    $(document).ready(function() {
        $.LoadingOverlay("hide")
    })

    // alert
    var flash = $('#flash-eror').data('eror');
    if (flash) {
        Swal.fire({
            icon: 'error',
            title: 'Username / Password salah!\n Periksa Kembali Username dan Password Anda !!!',
            toast: true,
            position: 'top',
            showConfirmButton: false,
            timer: 5000,
        })
        // toastr.success(flash)
    }

    var flash = $('#flash-sukses').data('sukses');
    if (flash) {
        Swal.fire({
            icon: 'success',
            title: 'Berhasil Mendaftar !\n Silakan login untuk melanjutkan !!!',
            toast: true,
            position: 'top',
            showConfirmButton: false,
            timer: 5000,
        })
        // toastr.success(flash)
    }

    var flash = $('#flash-warning').data('warning');
    if (flash) {
        Swal.fire({
            icon: 'warning',
            title: 'Berhasil Logout !\n Silakan login untuk kembali !!!',
            toast: true,
            position: 'top',
            showConfirmButton: false,
            timer: 5000,
        })
        // toastr.success(flash)
    }
    </script>
</body>

</html>