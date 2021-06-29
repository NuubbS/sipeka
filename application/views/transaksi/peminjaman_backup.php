<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Peminjaman Buku</h1>
        </div>

        <!-- data buku -->
        <div class='row'>
            <div class='col-lg-6'>
                <div class="card">
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Tanggal</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" value="<?= date('d M Y') ?>" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Petugas</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" value="<?= $this->sesi->user_login()->nama; ?>"
                                    readonly>
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <label class="col-sm-3 col-form-label">Peminjam</label>
                            <div class="col-sm-9">
                                <div class="form-group">
                                    <select class="select2 form-control" name="user_id" autofocus>
                                        <?php foreach($anggota as $row) { ?>
                                        <option value="<?= $row->user_id; ?>"><?= $row->nama; ?> (<?= $row->alamat; ?>)
                                        </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class='col-lg-6'>
                <div class="card">
                    <!-- </div> -->
                    <div class="card-body">
                        <div class="form-group row mb-0">
                            <label class="col-sm-3 col-form-label">Kode Transaksi</label>
                            <div class="col-sm-9">
                                <div class="form-group">
                                    <input type="text" class='form-control' name="kode_transaksi"
                                        value="tsafdcafgdcasfgda" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <label class="col-sm-3 col-form-label">Buku Dipinjam</label>
                            <div class="col-sm-9">
                                <div class="form-group">
                                    <select class="select2 form-control " multiple="multiple" name="buku_id" autofocus>
                                        <?php foreach($buku as $row) { ?>
                                        <option value="<?= $row->buku_id; ?>"><?= $row->judul; ?> (<?= $row->tahun; ?>)
                                        </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <label class="col-sm-3 col-form-label">Test</label>
                            <div class="col-sm-9">
                                <div class="form-group">
                                    <select id="mySelect2"></select>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="form-group input-group">
                            ype="hidden" name="kitab_id" id="kitab_id">
                            <input type="text" class="form-control" onclick="cari_buku();" placeholder="Cari Data Buku">
                            <span class="input-group-append">
                                <button class="btn btn-primary" onclick="cari_buku();" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </span>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
        <!-- data buku -->

        <!-- data pinjam buku -->
        <div class='row'>
            <div class='col-lg-12'>
                <div class="card">
                    <!-- <div class="card-header">
                        <h4>List Buku Dipinjam</h4>
                    </div> -->
                    <div class="card-body">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr class="text-center">
                                    <th>#</th>
                                    <!-- <th>Invoice</th> -->
                                    <th>kitab</th>
                                    <th>harga</th>
                                    <th>Qty</th>
                                    <th>total</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="cari_table">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- data pinjam buku -->

        <!-- data tabel -->
        <!-- data tabel -->
    </section>
</div>
<!-- main content -->
<script>
function pilih_buku($id) {
    $.LoadingOverlay("show", {
        image: "",
        fontawesome: "fa fa-spinner fa-pulse"
    });
    $.ajax({
        url: "<?= base_url("transaksi/pilih_buku/") ?>",
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