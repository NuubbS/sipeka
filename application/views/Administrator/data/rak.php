<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Rak</h1>
        </div>

        <div class="section-body">
            <p class="section-lead">
                <button onclick="tambah();" class="btn btn-icon icon-left btn-primary" data-toggle="modal"
                    data-target="#tambah_rak">
                    <i class="fas fa-rss-square"></i>
                    Tambahkan
                    Rak
                </button>
            </p>

            <!-- animasi table -->
            <div class="animate__animated animate__fadeInUp animate__fast">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card table-responsive">
                            <div class="card-body">
                                <table id="table_rak" class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Kode</th>
                                            <th scope="col">Nama</th>
                                            <th scope="col">Keterangan</th>
                                            <th scope="col">Tgl dibuat</th>
                                            <!-- <th scope="col">Tgl Diubah</th>
                                            <th scope="col">Ditambahkan oleh</th>
                                            <th scope="col">Tools</th> -->
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

table = $('#table_rak').DataTable({
    'ajax': {
        'url': '<?= base_url('administrator/rak_fetch') ?>',
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
            $('#tambah_rak').modal('hide');
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
    $('#tambah_rak').modal('show');
    $.LoadingOverlay("hide");
}

function edit(id) {
    $.LoadingOverlay("show", {
        image: "",
        fontawesome: "fa fa-spinner fa-pulse"
    });
    $.ajax({
        url: "<?= base_url("administrator/rak_edit/") ?>" + id,
        dataType: "html",
        success: function(result) {
            $.LoadingOverlay("hide");
            $('#update_rak').modal('show');
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
            $('#update_rak').modal('hide');
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
            $.post('<?= base_url('administrator/rak_hapus') ?>', {
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
    $('#tambah_rak').modal('hide');
}

function closes_update() {
    $('#update_rak').modal('hide');
}
</script>
<!-- script crud-->

<!-- modal tambah -->
<div class="modal fade" tabindex="-1" role="dialog" id="tambah_rak" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Masukkan Data Rak</h5> <button type="button" class="close" data-dismiss="modal"
                    aria-label="Close"> <span aria-hidden="true">??</span> </button>
            </div>
            <form id="form_tambah" action="<?= base_url('administrator/rak_simpan'); ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" class="form-control" name="rak_nama" id="rak_nama" required="">
                    </div>
                    <div class="form-group">
                        <label>Keterangan</label>
                        <input type="text" class="form-control" name="rak_keterangan" id="rak_keterangan" required="">
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                    <button type="button" onclick="saveData()" class="btn btn-primary">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- modal tambah-->
<!-- modal update -->
<div class="modal fade" tabindex="-1" role="dialog" id="update_rak" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Perbarui Data Rak</h5> <button type="button" class="close" data-dismiss="modal"
                    aria-label="Close"> <span aria-hidden="true">??</span> </button>
            </div>
            <form id="form_update" action="<?= base_url('administrator/rak_update'); ?>" method="post">
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