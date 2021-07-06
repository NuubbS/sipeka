<?php 

// tanggal kembali
$kembali = mktime(0,0,0, date("n"), date("j") + 7, date("Y"));
$tgl_kembali = date('d-m-Y', $kembali);

?>
<!-- modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="dataBuku" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Daftar Buku</h5> <button type="button" class="close" data-dismiss="modal"
                    aria-label="Close"> <span aria-hidden="true">×</span> </button>
            </div>
            <form id="form_update" action="<?= base_url('transaksi/cari_buku'); ?>" method="post">
                <div class="modal-body" id="search_buku">
                </div>
            </form>
        </div>
    </div>
</div>
<!-- modal -->
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Peminjaman Buku 2</h1>
        </div>

        <!-- data buku -->
        <div class='row'>
            <div class='col-lg-6'>
                <div class="card card-primary">
                    <div class="card-body">
                        <div class="form-group mb-2">
                            <label>Tanggal</label>
                            <input type="text" class="form-control form-control-sm" value="<?= date('Y-m-d') ?>"
                                disabled>
                        </div>
                        <div class="form-group mb-2">
                            <label>Petugas</label>
                            <input type="text" class="form-control form-control-sm"
                                value="<?= $this->sesi->user_login()->nama;?>" disabled>
                        </div>
                        <div class="form-group mb-2">
                            <label>Cari Anggota</label>
                            <div class="input-group mb-3">
                                <input type="text" id="user_id" name="user_id" class="form-control form-control-sm"
                                    placeholder="Cari ID anggota" aria-label="" autofocus onclick="dataPeminjam()">
                                <div class="input-group-append">
                                    <button class="btn btn-primary btn-sm" type="button"
                                        onclick="dataPeminjam()">Cari</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card card-primary">
                    <div class="card-body">
                        <div class="form-group mb-2">
                            <label>Kode Transaksi</label>
                            <input type="text" class="form-control form-control-sm" value="<?= $kode; ?>" disabled>
                        </div>
                        <div class="form-group mb-2">
                            <label>Cari Buku</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control form-control-sm" placeholder="Pilih Buku"
                                    aria-label="" onclick="dataBuku()">
                                <div class="input-group-append">
                                    <button class="btn btn-primary btn-sm" type="button"
                                        onclick="dataBuku()">Cari</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- data buku -->

        <div class="row">
            <div class="col-lg-12 col-md-6 col-lg-6">
                <div class="card">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped table-md">
                                <tbody>
                                    <tr>
                                        <th>#</th>
                                        <th>Judul</th>
                                        <th>Jumlah</th>
                                        <th>Tanggal Kembali</th>
                                        <th>Action</th>
                                    </tr>
                                    <tr>
                                        <td>1</td>
                                        <td>Irwansyah Saputra</td>
                                        <td>2017-01-09</td>
                                        <td>
                                            <div class="badge badge-success">
                                                Active
                                            </div>
                                        </td>
                                        <td><a href="#" class="btn btn-secondary">Detail</a></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- main content -->
<script>
$(document).ready(function() {
    // $("#user_id").val("Dolly Duck");
})

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
// onclick="pilihPeminjam(3)"
function id_anggota(id) {
    // alert(id)
    // $.LoadingOverlay("show", {
    //     image: "",
    //     fontawesome: "fa fa-spinner fa-pulse"
    // });
    // $.LoadingOverlay("hide")
    // $('#user_id').val(id)
    table.ajax.reload();
    $("#user_id").val("Dolly Duck");
}

function beli(id) {
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

function dataPeminjam() {
    $.LoadingOverlay("show", {
        image: "",
        fontawesome: "fa fa-spinner fa-pulse"
    });
    $.ajax({
        url: "<?= base_url("transaksi/dataPeminjam/") ?>",
        dataType: "html",
        success: function(result) {
            $.LoadingOverlay("hide");
            $('#dataPeminjam').modal('show');
            $('#search_member').html(result);

        }
    });
}

function dataBuku() {
    $.LoadingOverlay("show", {
        image: "",
        fontawesome: "fa fa-spinner fa-pulse"
    });
    $.ajax({
        url: "<?= base_url("transaksi/dataBuku/") ?>",
        dataType: "html",
        success: function(result) {
            $.LoadingOverlay("hide");
            $('#dataBuku').modal('show');
            $('#search_buku').html(result);

        }
    });
}
</script>

<!-- modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="dataPeminjam" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Daftar Anggota</h5> <button type="button" class="close" data-dismiss="modal"
                    aria-label="Close"> <span aria-hidden="true">×</span> </button>
            </div>
            <form id="form_update">
                <div class=" modal-body" id="search_member">
                </div>
            </form>
        </div>
    </div>
</div>
<!-- modal -->