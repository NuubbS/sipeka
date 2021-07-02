<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Buku Laporan On the Job Training</h1>
        </div>

        <div class="section-body">
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
                                        <th scope="col">Rak</th>
                                        <th scope="col">Tahun</th>
                                        <th scope="col">Status</th>
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
        'url': '<?php echo base_url("member/buku_laporanOJT_fetch") ?>',
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

function reload_datatables() {
    table.ajax.reload();
}


<?php if ($this->session->flashdata('result')) : ?> <?php if ($this->session->flashdata('result')['status']) : ?> Swal
    .Fire('Sukses!', '<?= $this->session->flashdata('result')['msg'] ?>', 'success');
<?php else : ?> Swal.Fire(
    'Maaf!', '<?= $this->session->flashdata('result')['msg'] ?>', 'error');
<?php endif ?> <?php endif ?>

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
            $('#tambah_buku_referensi').modal('hide');
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
    $('#tambah_buku_referensi').modal('show');
    $.LoadingOverlay("hide");
}

function edit(id) {
    $.LoadingOverlay("show", {
        image: "",
        fontawesome: "fa fa-spinner fa-pulse"
    });
    $.ajax({
        url: "<?= base_url("member/buku_edit/") ?>" + id,
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
            $.post('<?= base_url('member/buku_hapus') ?>', {
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
    $('#tambah_buku_referensi').modal('hide');
}

function detail(id) {
    $.LoadingOverlay("show");
    $.ajax({
        url: "<?= base_url("member/buku_detail/") ?>" + id,
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
            <form id="form_detail" action="<?= base_url('member/buku_refrensi_detail'); ?>" method="post">
                <div class="modal-body" id="content_detail">

                </div>
            </form>
        </div>
    </div>
</div>
<!-- modal info -->

<!-- modal update -->
<div class="modal fade" tabindex="-1" role="dialog" id="update_buku" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Perbarui Data buku</h5> <button type="button" class="close" data-dismiss="modal"
                    aria-label="Close"> <span aria-hidden="true">×</span> </button>
            </div>
            <form id="form_update" action="<?= base_url('member/buku_update'); ?>" method="post">
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

<!-- modal tambah -->
<div class="modal fade" tabindex="-1" role="dialog" id="tambah_buku_referensi" aria-hidden="true"
    style="display: none;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Masukkan Data Buku</h5> <button type="button" class="close" data-dismiss="modal"
                    aria-label="Close"> <span aria-hidden="true">×</span> </button>
            </div>
            <form id="form_tambah" action="<?= base_url('member/buku_referensi_simpan'); ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Judul</label>
                        <input type="text" class="form-control" name="judul" id="judul" required="">
                    </div>
                    <div class="form-group row">
                        <div class='col-6'>
                            <label for="prodi_id">Program Studi</label>
                            <select id="prodi_id" name="prodi_id" class="form-control">
                                <?php foreach ($prodi as $key => $data) { ?>
                                <option value="<?= $data->prodi_id; ?>"><?= $data->prodi ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class='col-6'><label for="rak_id">Rak Penyimpanan</label>
                            <select id="rak_id" name="rak_id" class="form-control">
                                <?php foreach ($rak as $key => $data) { ?>
                                <option value="<?= $data->rak_id; ?>"><?= $data->rak_nama ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class='col-4'><label>Tahun</label>
                            <input type="text" class="form-control" name="tahun" id="tahun" required="">
                        </div>
                        <div class='col-4'><label>Jumlah</label>
                            <input type="text" class="form-control" name="jumlah" id="jumlah" required="">
                        </div>
                    </div>
                    <div class="modal-footer bg-whitesmoke br">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                        <button type="button" onclick="saveData()" class="btn btn-primary">Simpan Data Buku</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- modal tambah-->