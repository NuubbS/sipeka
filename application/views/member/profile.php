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
                            <img alt="image" src="<?= base_url() ?>assets/img/avatar/default_user.png"
                                class="rounded-circle profile-widget-picture">
                            <div class="profile-widget-items">
                                <div class="profile-widget-item">
                                    <div class="profile-widget-item-label">
                                        Terdaftar Sejak
                                    </div>
                                    <div class="profile-widget-item-value">
                                        <?= $member->date_created; ?>
                                    </div>
                                </div>
                                <div class="profile-widget-item">
                                    <div class="profile-widget-item-label">
                                        Terakhir Diubah
                                    </div>
                                    <div class="profile-widget-item-value">
                                        <?= $member->date_updated; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="profile-widget-description">
                            <form id="form_update" action="<?= base_url('member/update_profil'); ?>" method="post">
                                <div class="row">
                                    <div class="form-group col-md-12 col-12">
                                        <label>Nama Lengkap</label>
                                        <input type="hidden" name="user_id" value="<?= $member->user_id; ?>">
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
                                        <input type="number" class="form-control" name="no_handphone"
                                            value="<?= $member->no_handphone; ?>">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-12">
                                        <label for="alamat">Alamat</label>
                                        <input type="text" class="form-control" name="alamat"
                                            value="<?= $member->alamat; ?>">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-12">
                                        <button type="submit" onclick="updateData()"
                                            class="btn btn-primary float-right">Simpan
                                            Perubahan</button>
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
<script>
function updateData() {
    $.LoadingOverlay("show", {
        image: "",
        fontawesome: "fa fa-spinner fa-pulse"
    });
    var form = $('#form_update');
    $.ajax({
        type: "POST",
        url: form.attr('action'),
        data: form.serialize(),
        dataType: "json",
        success: function(result) {
            message = result.messages;
            status = result.status;
            notifikasi(status, message);
        }
    });
}

function notifikasi(status, message) {
    $.LoadingOverlay("hide");
    location.reload();
    if (status == 1) {
        iziToast.success({
            title: 'Success',
            message: message,
            position: 'topRight',
            balloon: true,
            transitionIn: 'fadeInLeft',
            transitionOut: 'fadeOutRight'
        });
    } else {
        iziToast.error({
            title: 'Error',
            message: message,
            position: 'topRight',
            balloon: true,
            transitionIn: 'fadeInLeft',
            transitionOut: 'fadeOutRight'
        });
    }
}
</script>