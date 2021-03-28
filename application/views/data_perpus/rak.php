<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Rak</h1>
        </div>

        <div class="section-body">
            <p class="section-lead">
                <button onclick="tambah();" class="btn btn-icon icon-left btn-primary" data-toggle="modal"
                    data-target="#tambah_user">
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
                                            <th scope="col">Nama</th>
                                            <th scope="col">Keterangan</th>
                                            <th scope="col">Tgl dibuat</th>
                                            <th scope="col">Tgl Diubah</th>
                                            <th scope="col">Ditambahkan oleh</th>
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

table = $('#table_rak').DataTable({
    'ajax': {
        'url': '<?= base_url('data_perpus/rak_fetch') ?>',
        'dataSrc': 'data',
        'type': 'POST'
    },
    'processing': true,
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
    var form = $('#form_add');
    $.ajax({
        type: "POST",
        url: form.attr('action'),
        data: form.serialize(),
        dataType: "json",
        success: function(result) {
            message = result.messages;
            status = result.status;
            $('#modalUserAdd').modal('hide');
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
    $('#tambah_user').modal('show');
    $.LoadingOverlay("hide");
}

function edit(id) {
    $.LoadingOverlay("show", {
        image: "",
        fontawesome: "fa fa-spinner fa-pulse"
    });
    $.ajax({
        url: "<?= base_url("tutorial/crud_edit/") ?>" + id,
        dataType: "html",
        success: function(result) {
            $.LoadingOverlay("hide");
            $('#modalUserUpdate').modal('show');
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
            $('#modalUserUpdate').modal('hide');
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
            $.post('<?= base_url('tutorial/crud_hapus') ?>', {
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
    $('#tambah_user').modal('hide');
}

function closes_update() {
    $('#modalUserUpdate').modal('hide');
}
</script>
<!-- script crud-->

<!-- modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="tambah_user" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modal Title</h5> <button type="button" class="close" data-dismiss="modal"
                    aria-label="Close"> <span aria-hidden="true">×</span> </button>
            </div>
            <div class="modal-body"> Modal body text goes here.</div>
            <div class="modal-footer bg-whitesmoke br">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>
<!-- modal -->