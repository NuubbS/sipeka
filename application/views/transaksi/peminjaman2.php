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
            <div class='col-lg-12'>
                <div class="card">
                    <div class="card-body">
                        <?php form_open(); ?>
                        <div class='row'>
                            <div class='col-6'>
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <div class='bg-primary text-white'>
                                            <p class='m-1 ml-2'>Data Transaksi</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">No. Peminjaman</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" value="<?= $newKode ?>" readonly>
                                    </div>
                                </div>
                                <!-- <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Tgl. Peminjaman</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" value="<?= date('Y-m-d');?>" readonly>
                                    </div>
                                </div> -->
                                <!-- <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">ID Anggota</label>
                                    <div class="col-sm-9">
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Cari ID Anggota"
                                                required autocomplete="off" name="user_id" id="cari_peminjam"
                                                onclick="dataPeminjam()">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary" type="button"
                                                    onclick="dataPeminjam()"><i class='fas fa-search'></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div> -->
                                <div class="form-group row mb-0">
                                    <label class="col-sm-3 col-form-label">Peminjam</label>
                                    <div class="col-sm-9">
                                        <div class="form-group">
                                            <select class="select_peminjam form-control" name="user_id"
                                                required></select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class='col-6'>
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <div class='bg-primary text-white'>
                                            <p class='m-1 ml-2'>Data Buku Dipinjam</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Cari Buku</label>
                                    <div class="col-sm-9">
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Cari Kode Buku"
                                                required autocomplete="off" name="kode_buku" id="cari_buku"
                                                onclick="dataBuku()">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary" type="button" onclick="dataBuku()"><i
                                                        class='fas fa-search'></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Tanggal Pengembalian</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" value="<?= $tgl_kembali; ?>" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <button type="button" id class='btn btn-success float-right'><i
                                        class='fas fa-save mr-2'></i>Simpan Data Pinjam</button>
                            </div>
                        </div>
                        <?php form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- data buku -->

        <div class="row">
            <div class="col">
                <div class="form-group row">
                    <div class='col-sm-12'>
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th scope="col">Judul</th>
                                    <th scope="col" width="20">Tahun</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row">1</th>
                                    <td>2020</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- main content -->
<script>
$("#pilihAnggota").click(function(e) {
    document.getElementsByName('user_id')[0].value = $(this).attr("data_id");
    $('#dataPeminjam').modal('hide');
    $.ajax({
        type: "POST",
        url: "<?php echo base_url('transaksi/result');?>",
        data: 'kode_anggota=' + $(this).attr("data_id"),
        beforeSend: function() {
            $("#result").html("");
            $("#result_tunggu").html('<p style="color:green"><blink>tunggu sebentar</blink></p>');
        },
        success: function(html) {
            $("#result").html(html);
            $("#result_tunggu").html('');
        }
    });
});

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
                        <table class="table table-bordered text-dark" width="100%" cellspacing="0">
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