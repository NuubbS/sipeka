<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Profil Saya</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active">
                    <a href="#">Dashboard</a>
                </div>
                <div class="breadcrumb-item">
                    Profile
                </div>
            </div>
        </div>
        <div class="section-body">
            <h2 class="section-title">Hi, <?= $this->sesi->user_login()->nama; ?></h2>
            <p class="section-lead">
                Ubah informasi seputar dirimu di form yang sudah tersedia !
            </p>

            <div class="row mt-sm-4">
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card profile-widget">
                        <div class="profile-widget-header">
                            <img alt="image" src="http://localhost:8080/stisla-master/assets/img/avatar/avatar-1.png"
                                class="rounded-circle profile-widget-picture">
                            <div class="profile-widget-items">
                                <div class="profile-widget-item text-right mr-4">
                                    <div class="profile-widget-item-label">
                                        Terdaftar Sejak
                                    </div>
                                    <div class="profile-widget-item-value">
                                        <?= $member->date_created; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="profile-widget-description">
                            <form>
                                <div class="row">
                                    <div class="form-group col-md-12 col-12">
                                        <label>Nama Lengkap</label>
                                        <input type="text" class="form-control" value="<?= $member->nama; ?>" required
                                            readonly>
                                        <div class="invalid-feedback">
                                            Please fill in the first name
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-7 col-12">
                                        <label>Email</label>
                                        <input type="email" class="form-control" value="<?= $member->email; ?>" required
                                            readonly>
                                        <div class="invalid-feedback">
                                            Please fill in the email
                                        </div>
                                    </div>
                                    <div class="form-group col-md-5 col-12">
                                        <label>Phone</label>
                                        <input type="number" class="form-control" value="<?= $member->no_handphone; ?>">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-12">
                                        <label for="alamat">Alamat</label>
                                        <input type="text" class="form-control" value="<?= $member->alamat; ?>">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-12">
                                        <button class="btn btn-primary float-right">Simpan Perubahan</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- main content -->