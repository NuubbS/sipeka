<?php 

// tanggal kembali
$kembali = mktime(0,0,0, date("n"), date("j") + 7, date("Y"));
$tgl_kembali = date('Y-m-d', $kembali);

?>
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Peminjaman Buku</h1>
        </div>

        <!-- data buku -->
        <div class='row'>
            <div class='col-lg-12'>
                <div class="card">
                    <div class="card-body">
                        <!-- <form method="post" action="transaksi/peminjaman"> -->
                        <?= form_open() ?>
                        <div class='row'>
                            <div class='col-12'>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label text-right">No. Peminjaman</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" value="<?= $newKode ?>"
                                            name="kode_transaksi" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label text-right">Peminjam</label>
                                    <div class="col-sm-10">
                                        <select class="select_peminjam form-control" name="user_id"></select>
                                        <?= form_error('user_id', '<p class="text-danger">','</p>'); ?>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label text-right">Buku</label>
                                    <div class="col-sm-10">
                                        <select class="select_buku form-control " multiple="multiple" name="buku_id[]">
                                        </select>
                                        <?= form_error('buku_id[]', '<p class="text-danger">','</p>'); ?>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label text-right ">Tanggal Peminjaman</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="tanggal_pinjam" class="form-control"
                                            value="<?= date('Y-m-d') ?>" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label text-right">Tanggal Pengembalian</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="tanggal_kembali" class="form-control"
                                            value="<?= $tgl_kembali; ?>" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class='simpan btn btn-success float-right' name="simpan"><i
                                        class='fas fa-save mr-2'></i>Simpan Data Pinjam</button>
                            </div>
                        </div>
                        <?= form_close(); ?>
                        <!-- </form> -->
                    </div>
                </div>
            </div>
        </div>
        <!-- data buku -->
    </section>
</div>
<!-- main content -->
<script>
function pinjam() {
    $.LoadingOverlay("show", {
        image: "",
        fontawesome: "fa fa-spinner fa-pulse"
    });
    $.ajax({
        url: "<?= base_url("administrator/pinjamBuku/") ?>",
        dataType: "html",
        success: function(result) {
            // $.LoadingOverlay("hide");
            // $('#cari_buku').modal('show');
            // $('#search_book').html(result);

        }
    });
}

function cari_buku() {
    $.LoadingOverlay("show", {
        image: "",
        fontawesome: "fa fa-spinner fa-pulse"
    });
    $.ajax({
        url: "<?= base_url("transaksi/cari_buku/") ?>",
        dataType: "html",
        success: function(result) {
            $.LoadingOverlay("hide");
            $('#cari_buku').modal('show');
            $('#search_book').html(result);

        }
    });
}

function pilih_anggota($id) {
    $.LoadingOverlay("show", {
        image: "",
        fontawesome: "fa fa-spinner fa-pulse"
    });
    $.ajax({
        url: "<?= base_url("transaksi/pilih_anggota/") ?>",
        dataType: "html",
        success: function(result) {
            $.LoadingOverlay("hide");
            $('#cari_anggota').modal('show');
            $('#search_member').html(result);

        }
    });
}

function beli($id) {
    $.LoadingOverlay("show", {
        image: "",
        fontawesome: "fa fa-spinner fa-pulse"
    });
    $.ajax({
        url: "<?= base_url("transaksi/pilih_buku/") ?>",
        dataType: "html",
        success: function(result) {
            $.LoadingOverlay("hide");
            $('#cari_buku').modal('hide');
            // $('#search_book').html(result);

        }
    });
}

function cari_anggota() {
    $.LoadingOverlay("show", {
        image: "",
        fontawesome: "fa fa-spinner fa-pulse"
    });
    $.ajax({
        url: "<?= base_url("transaksi/cari_anggota/") ?>",
        dataType: "html",
        success: function(result) {
            $.LoadingOverlay("hide");
            $('#cari_anggota').modal('show');
            $('#search_member').html(result);

        }
    });
}

// $(".simpan").click(function() {
//     alert("The paragraph is now hidden");
// });
</script>
<!-- modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="cari_buku" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Hanya Ada Buku Yang Tersediadata</h5> <button type="button" class="close"
                    data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
            </div>
            <form>
                <div class="modal-body" id="search_book">
                </div>
            </form>
        </div>
    </div>
</div>
<!-- modal -->

<!-- modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="cari_anggota" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Data Peminjam</h5> <button type="button" class="close" data-dismiss="modal"
                    aria-label="Close"> <span aria-hidden="true">×</span> </button>
            </div>
            <form id="form_update" action="<?= base_url('transaksi/cari_anggota'); ?>" method="post">
                <div class="modal-body" id="search_member">
                </div>
            </form>
        </div>
    </div>
</div>
<!-- modal -->

<!-- modal Anggota -->
<div class="modal fade" id="modal_anggota" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <form action="<?= site_url('penjualan') ?>" method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Pilih Peminjam</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <!-- <script src="<?= base_url() ?>assets/js/jquery-3.5.1.min.js"></script> -->
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-bordered text-dark" id="tableclient" width="100%" cellspacing="0">
                            <thead>
                                <tr class="text-center">
                                    <th>ID</th>
                                    <th>Nama</th>
                                    <th>Alamat</th>
                                    <th>Pilih</th>
                                    <!-- <th>Stock</th>
                                    <th>Action</th> -->
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($anggota as $i => $data) { ?>
                                <tr>
                                    <td><?= $no++ ?>.</td>
                                    <td><?= $data->nama ?></td>
                                    <td><?= $data->address ?></td>
                                    <td><a class='btn btn-success'><i class='fas fa-check'></i></a></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </form>
    </div>
</div>
<!-- modal Anggota -->