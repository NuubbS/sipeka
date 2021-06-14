<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Petugas Perpustakaan</h1>
        </div>

        <div class="section-body">
            <p class="section-lead">
                <button onclick="tambah();" class="btn btn-icon icon-left btn-primary" data-toggle="modal"
                    data-target="#tambah_rak">
                    <i class="fas fa-rss-square"></i>
                    Tambahkan
                    Petugas
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
                                            <th scope="col">Alamat</th>
                                            <th scope="col">No. Handphone</th>
                                            <th scope="col">Tgl Dibuat</th>
                                            <th scope="col">Tgl Diubah</th>
                                            <!-- <th scope="col">Ditambahkan oleh</th> -->
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
var table = $('table').DataTable({
    'ajax': {
        'url': '<?php echo base_url("administrator/admin_fetch") ?>',
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

function import_data() {
    $.LoadingOverlay("show");
    setTimeout(function() {
        $.LoadingOverlay("hide");
        toastr.success("Sukses Ambil Data");
        reload_datatables();
    }, 2000);
}

function import_data(t) {
    $.LoadingOverlay("show");
    t.form.submit();
}

$(document).ready(function() {
    <?php if ($this->session->flashdata("alert")): ?>
    <?php if ($this->session->flashdata("alert")["status"]): ?>
    swal("Sukses!", "<?php echo $this->session->flashdata("alert")["msg"] ?>", "success");
    <?php else: ?>
    swal("Maaf!", "<?php echo $this->session->flashdata("alert")["msg"] ?>", "error");
    <?php endif ?>
    <?php endif ?>
});
</script>
<!-- script crud-->

<!-- modal tambah -->
<div class="modal fade" tabindex="-1" role="dialog" id="tambah_rak" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Masukkan Data Rak</h5> <button type="button" class="close" data-dismiss="modal"
                    aria-label="Close"> <span aria-hidden="true">×</span> </button>
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
                    aria-label="Close"> <span aria-hidden="true">×</span> </button>
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