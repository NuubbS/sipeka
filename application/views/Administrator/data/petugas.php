<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>petugas Perpustakaan</h1>
        </div>

        <div class="section-body">
            <p class="section-lead">
                <button onclick="tambah();" class="btn btn-icon icon-left btn-primary" data-toggle="modal"
                    data-target="#tambah_petugas">
                    <i class="fas fa-rss-square"></i>
                    Tambahkan
                    petugas
                </button>
            </p>

            <!-- animasi table -->
            <div class="animate__animated animate__fadeInUp animate__fast">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card table-responsive">
                            <div class="card-body">
                                <table id="table_petugas" class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">Nama</th>
                                            <th scope="col">Email</th>
                                            <th scope="col">Alamat</th>
                                            <th scope="col">No. Handphone</th>
                                            <th scope="col">Tgl Dibuat</th>
                                            <th scope="col">Tgl Diubah</th>
                                            <th scope="col">Tools</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- main content -->

<!-- script crud-->
<script type="text/javascript">
var table;

// $(document).ready(function() {

table = $('#table_petugas').DataTable({
    'ajax': {
        'url': '<?= base_url('administrator/admin_fetch') ?>',
        'dataSrc': 'data',
        'type': 'POST'
    },
    'processing': true,
    // scrollY: '250px',
    'serverSide': true,
    'paging': true,
    'lengthChange': true,
    'searching': true,
    'ordering': true,
    'info': true,
    'autoWidth': false,
});

<?php if ($this->session->flashdata('result')) : ?>
<?php if ($this->session->flashdata('result')['status']) : ?>
Swal.Fire('Sukses!', '<?= $this->session->flashdata('result')['msg'] ?>', 'success');
<?php else : ?>
Swal.Fire('Maaf!', '<?= $this->session->flashdata('result')['msg'] ?>', 'error');
<?php endif ?>
<?php endif ?>

// });


function reload() {
    location.reload();
}

function notifikasi(status, message) {
    $.LoadingOverlay("hide");
    if (status == 1) {
        table.ajax.reload();
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

function saveData() {
    $.LoadingOverlay("show", {
        image: "",
        fontawesome: "fa fa-spinner fa-pulse"
    });
    var form = $('#form_tambah');
    $.ajax({
        type: "POST",
        url: form.attr('action'),
        data: form.serialize(),
        dataType: "json",
        success: function(result) {
            message = result.messages;
            status = result.status;
            $('#tambah_petugas').modal('hide');
            $('input').val('');
            notifikasi(status, message);
            clear_form_elements('modal-body');
        }
    });

}

function clear_form_elements(class_name) {
    $("." + class_name).find(':input').each(function() {
        switch (this.type) {
            case 'password':
            case 'text':
            case 'textarea':
            case 'file':
            case 'select-one':
            case 'select-multiple':
            case 'date':
            case 'number':
            case 'tel':
            case 'email':
                jQuery(this).val('');
                break;
            case 'checkbox':
            case 'radio':
                this.checked = false;
                break;
        }
    });
}

function tambah() {
    $.LoadingOverlay("show", {
        image: "",
        fontawesome: "fa fa-spinner fa-pulse"
    });
    $('#tambah_petugas').modal('show');
    $.LoadingOverlay("hide");
}

function edit(id) {
    $.LoadingOverlay("show", {
        image: "",
        fontawesome: "fa fa-spinner fa-pulse"
    });
    $.ajax({
        url: "<?= base_url("administrator/admin_edit/") ?>" + id,
        dataType: "html",
        success: function(result) {
            $.LoadingOverlay("hide");
            $('#update_petugas').modal('show');
            $('#content_update').html(result);

        }
    });
}

function detail(id) {
    $.LoadingOverlay("show", {
        image: "",
        fontawesome: "fa fa-spinner fa-pulse"
    });
    $.ajax({
        url: "<?= base_url("tutorial/user_account_detail/") ?>" + id,
        dataType: "html",
        success: function(result) {
            $.LoadingOverlay("hide");
            $('#infouser').modal('show');
            $('#content_detail').html(result);

        }
    });
}

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
            $('#update_petugas').modal('hide');
            notifikasi(status, message);
        }
    });
}

function hapus(id) {
    Swal.fire({
        title: 'Apakah anda Yakin ?',
        text: "Data yang dihapus tidak dapat dikembalikan !",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, hapus sekarang!',
        cancelButtonText: 'Batal hapus'
    }).then((result) => {
        if (result.value) {
            $.LoadingOverlay("show", {
                image: "",
                fontawesome: "fa fa-spinner fa-pulse"
            });
            $.post('<?= base_url('administrator/admin_hapus') ?>', {
                'id': id
            }, function(data, textStatus, xhr) {
                $.LoadingOverlay("hide");
                if (data.status = 1) {
                    iziToast.success({
                        title: 'Success!',
                        message: 'Data berhasil dihapus !',
                        position: 'topRight',
                        balloon: true,
                        transitionIn: 'fadeInLeft',
                        transitionOut: 'fadeOutRight'
                    });
                    table.ajax.reload();
                } else {
                    iziToast.error({
                        title: 'Error!',
                        message: 'Data gagal dihapus',
                        position: 'topRight',
                        balloon: true,
                        transitionIn: 'fadeInLeft',
                        transitionOut: 'fadeOutRight'
                    });
                    table.ajax.reload();
                }
            }, 'json');
        }
    })
}


function closes() {
    $('#tambah_petugas').modal('hide');
}

function closes_update() {
    $('#update_petugas').modal('hide');
}
</script>
<!-- script crud-->

<!-- modal tambah -->
<div class="modal fade" tabindex="-1" role="dialog" id="tambah_petugas" aria-hidden="true" style="display: none;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Masukkan Data petugas</h5> <button type="button" class="close"
                    data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
            </div>
            <form id="form_tambah" action="<?= base_url('administrator/admin_simpan'); ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" class="form-control" name="nama" id="nama" required>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" class="form-control" name="email" id="email" required>
                    </div>
                    <div class="form-group row">
                        <div class="col-6"><label>Password</label>
                            <input type="password" class="form-control" name="password" id="password" required>
                        </div>
                        <div class="col-6"><label>Ulangi Password</label>
                            <input type="password" class="form-control" name="password_config" id="password_config"
                                required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Alamat</label>
                        <input type="text" class="form-control" name="alamat" id="alamat" required>
                    </div>
                    <div class="form-group">
                        <label>No. Handphone</label>
                        <input type="text" class="form-control" name="no_handphone" id="no_handphone" required>
                    </div>
                    <div class="float-right mb-2">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                        <button type="button" onclick="saveData()" class="btn btn-primary">Simpan Data</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- modal tambah-->
<!-- modal update -->
<div class="modal fade" tabindex="-1" role="dialog" id="update_petugas" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Perbarui Data petugas</h5> <button type="button" class="close"
                    data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
            </div>
            <form id="form_update" action="<?= base_url('administrator/admin_update'); ?>" method="post">
                <div class="modal-body" id="content_update">
                    <!-- isi form di folder lain -->
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-danger" onclick="closes_update()">Close</button>
                    <button type="button" class="btn btn-primary" onclick="updateData()">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- modal update -->