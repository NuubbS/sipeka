<h4 class="text-dark font-weight-normal">Selamat Datang di <span class="font-weight-bold">PERPUS
        KAMPUS</span>
</h4>
<p class="text-muted">Sebelum menggunakan aplikasi ini, anda harus masuk atau mendaftar jika
    belum mempunyai akun.</p>
<form method="POST" action="<?=site_url('auth')?> ">
    <div class="form-group">
        <label for="email">Email</label>
        <input id="email" type="text" class="form-control" name="email" value="<?= set_value('email'); ?>" tabindex="1"
            autofocus>
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
        <input id="password" type="password" class="form-control" name="password" tabindex="2">
        <?= form_error('password', '<small class="text-danger">','</small>') ?>
    </div>

    <div class="form-group">
        <div class="custom-control custom-checkbox">
            <input type="checkbox" name="remember" class="custom-control-input" tabindex="3" id="remember-me">
            <label class="custom-control-label" for="remember-me">Remember Me</label>
        </div>
    </div>

    <div class="form-group text-right">
        <a href="auth-forgot-password.html" class="float-left mt-3">
            Forgot Password?
        </a>
        <button type="submit" name="login" class="btn btn-primary btn-lg btn-icon icon-right" tabindex="4">
            Login
        </button>
    </div>

    <div class="mt-5 text-center">
        Don't have an account? <a href="auth-register.html">Create new one</a>
    </div>
</form>