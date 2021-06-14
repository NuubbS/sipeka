<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Buku</h1>
        </div>

        <div class="section-body">


            <p class="section-lead">
                <button onclick="tambah();" class="btn btn-icon icon-left btn-primary" data-toggle="modal"
                    data-target="#tambah_buku">
                    <i class="fas fa-rss-square"></i>
                    Tambahkan
                    Buku
                </button>
            </p>

        </div>
        <!-- animasi table -->
        <div class="animate__animated animate__fadeInUp animate__fast">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card table-responsive">
                        <div class="card-body">
                            <table id="table_buku" class="table table-hover">
                                <thead>
                                    <tr>
                                        <!-- <th scope="col">#</th> -->
                                        <th scope="col">Judul</th>
                                        <th scope="col">Prodi</th>
                                        <!-- <th scope="col">Tahun</th>
                                        <th scope="col">Jumlah</th> -->
                                        <th scope="col">Rak</th>
                                        <!-- <th scope="col">Tools</th> -->
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
var table = $('table').DataTable({
    'ajax': {
        'url': '<?php echo base_url("administrator/buku_proposal_ta_fetch") ?>',
        'dataSrc': 'data',
        'type': 'POST'
    },
    'processing': true,
    'serverSide': true,
    'paging': true,
    'lengthChange': true,
    'searching': true,
    'ordering': false,
    'info': true,
    'autoWidth': false,
});

function reload_datatables() {
    table.ajax.reload();
}


<?php if ($this->session->flashdata('result')) : ?>
<?php if ($this->session->flashdata('result')['status']) : ?>
Swal.Fire('Sukses!', '<?= $this->session->flashdata('result')['msg'] ?>', 'success');
<?php else : ?>
Swal.Fire('Maaf!', '<?= $this->session->flashdata('result')['msg'] ?>', 'error');
<?php endif ?>
<?php endif ?>

// });

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
            $('#tambah_buku').modal('hide');
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
    $('#tambah_buku').modal('show');
    $.LoadingOverlay("hide");
}

function edit(id) {
    $.LoadingOverlay("show", {
        image: "",
        fontawesome: "fa fa-spinner fa-pulse"
    });
    $.ajax({
        url: "<?= base_url("administrator/buku_edit/") ?>" + id,
        dataType: "html",
        success: function(result) {
            $.LoadingOverlay("hide");
            $('#update_buku').modal('show');
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
            $('#update_buku').modal('hide');
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
            $.post('<?= base_url('administrator/buku_hapus') ?>', {
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
    $('#tambah_buku').modal('hide');
}

function detail(id) {
    $.LoadingOverlay("show");
    $.ajax({
        url: "<?= base_url("administrator/buku_detail/") ?>" + id,
        dataType: "html",
        success: function(result) {
            $.LoadingOverlay("hide");
            $('#infouser').modal('show');
            $('#content_detail').html(result);

        }
    });
}

function closes_update() {
    $('#update_buku').modal('hide');
}
</script>
<!-- script crud-->


<!-- modal info -->
<div class="modal" id="infouser" role="dialog" data-backdrop="false" style="background: rgba(0,0,0,0.3);">
    <div class="modal-dialog modal-lg">
        <div class="modal-content P-1">
            <div class="modal-header">
                <h5 class="modal-title">Detail Buku</h5> <button type="button" class="close" data-dismiss="modal"
                    aria-label="Close"> <span aria-hidden="true">×</span> </button>
            </div>
            <form id="form_detail" action="<?= base_url('administrator/buku_detail'); ?>" method="post">
                <div class="modal-body" id="content_detail">

                </div>
            </form>
        </div>
    </div>
</div>
<!-- modal info -->