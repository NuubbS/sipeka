<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Login &mdash; SIPEKA AKB</title>

    <!-- General CSS Files -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/fontawesome/css/all.min.css">

    <!-- CSS Libraries -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/bootstrap/css/bootstrap-social.css">

    <!-- Template CSS -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/style.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/components.css">
    <!-- Start GA -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-94034622-3"></script>
    <script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
        dataLayer.push(arguments);
    }
    gtag('js', new Date());

    gtag('config', 'UA-94034622-3');
    </script>
    <!-- /END GA -->
</head>

<body>
    <div id="app">
        <section class="section">
            <div class="container mt-5">
                <div class="row">
                    <div
                        class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
                        <div class="login-brand">
                            <h3>SIPAKB</h3>
                        </div>

                        <div class="card card-primary">
                            <div class="card-body">
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
                                                <a href="<?= base_url() ?>dist/auth_forgot_password" class="text-small">
                                                    Forgot Password?
                                                </a>
                                            </div>
                                        </div>
                                        <input id="password" type="password" class="form-control" name="password"
                                            tabindex="2">
                                        <?= form_error('password', '<small class="text-danger">','</small>') ?>
                                    </div>

                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" name="remember" class="custom-control-input"
                                                tabindex="3" id="remember-me">
                                            <label class="custom-control-label" for="remember-me">Remember Me</label>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" name="login" class="btn btn-primary btn-lg btn-block"
                                            tabindex="4">
                                            Login
                                        </button>
                                        <!-- <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
											Login
										</button> -->
                                    </div>
                                </form>
                            </div>
                            <div class="text-muted text-center">
                                Don't have an account? <a class="text-primary" onclick="registration();"
                                    data-toggle="modal" data-target="#registrasi">Create One</a>
                            </div>
                        </div>
                        <div class="simple-footer">
                            Copyright &copy; NuubbS <?= date('Y'); ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- General JS Scripts -->
    <script src="<?= base_url() ?>assets/plugins/jquery/jquery-3.5.1.min.js"></script>
    <script src="<?= base_url() ?>assets/plugins/jquery/popper.js"></script>
    <script src="<?= base_url() ?>assets/plugins/jquery/tooltip.js"></script>
    <script src="<?= base_url() ?>assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?= base_url() ?>assets/plugins/jquery/jquery.nicescroll.min.js"></script>
    <script src="<?= base_url() ?>assets/plugins/jquery/moment.js"></script>
    <script src="<?= base_url() ?>assets/js/stisla.js"></script>

    <!-- JS Libraies -->

    <!-- Page Specific JS File -->
    <script>
    function tambah() {
        $.LoadingOverlay("show", {
            image: "",
            fontawesome: "fa fa-spinner fa-pulse"
        });
        $('#registrasi').modal('show');
        $.LoadingOverlay("hide");
    }

    function closes() {
        $('#registrasi').modal('hide');
    }
    </script>

    <!-- Template JS File -->
    <script src="<?= base_url() ?>assets/js/scripts.js"></script>
    <script src="<?= base_url() ?>assets/js/custom.js"></script>
</body>
<!-- modal tambah -->
<div class="modal fade" tabindex="-1" role="dialog" id="registrasi" aria-hidden="true" style="display: none;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Daftar Akun SIPAKB</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×
                    </span>
                </button>
            </div>
            <form id="form_tambah" action="<?= base_url('administrator/rak_simpan'); ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" class="form-control" name="email" id="email" required="">
                    </div>
                    <div class='row'>
                        <div class='col'>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="text" class="form-control" name="password" id="password" required="">
                            </div>
                        </div>
                        <div class='col'>
                            <div class="form-group">
                                <label>Password-Confirmation</label>
                                <input type="text" class="form-control" name="passconf" id="passconf" required="">
                            </div>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col'>
                            <div class="form-group">
                                <label>Nama Lengkap</label>
                                <input type="text" class="form-control" name="nama" id="nama" required="">
                            </div>
                        </div>
                        <div class='col'>
                            <div class="form-group">
                                <label>No. Handphone</label>
                                <input type="text" class="form-control" name="no_handphone" id="no_handphone"
                                    required="">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Alamat</label>
                        <input type="text" class="form-control" name="alamat" id="alamat" required="">
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Batal Daftar</button>
                    <button type="button" onclick="saveData()" class="btn btn-primary">Daftar Sekarang</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- modal tambah-->

</html>