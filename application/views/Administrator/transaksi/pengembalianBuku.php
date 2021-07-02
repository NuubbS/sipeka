<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Daftar Pengembalian</h1>
        </div>
        <!-- data tabel -->
        <div class="row">
            <div class="col">
                <!-- animasi table -->
                <div class="animate__animated animate__fadeInUp animate__fast">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card table-responsive">
                                <div class="card-body">
                                    <table id="bukuDipinjam" class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th scope="col">Kode Transaki</th>
                                                <th scope="col">Nama Peminjam</th>
                                                <th scope="col">Tanggal Pinjam</th>
                                                <th scope="col">Petugas</th>
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
        </div>
        <!-- data tabel -->
    </section>
</div>
<!-- main content -->
<script>
// datatables
var table = $('#bukuDipinjam').DataTable({
    'ajax': {
        'url': '<?php echo base_url("transaksi/daftarPengembalianBuku_fetch") ?>',
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
// enddatatables

// tampil modal transaksi
function tampilTransaksi() {
    $.LoadingOverlay("show", {
        image: "",
        fontawesome: "fa fa-spinner fa-pulse"
    });
    $('#formTransaksi').modal('show');
    $.LoadingOverlay("hide");
}
// end tampil modal transaksi

// select peminjam
$('.selectPeminjam').select2({
    ajax: {
        url: "<?= base_url('administrator/getDataPeminjam_Select'); ?>",
        dataType: "json",
        type: "post",
        delay: 250,
        data: function(params) {
            console.log(params.term)
            return {
                search: params.term,
            }
        },
        processResults: function(data) {
            return {
                results: data
            };
        },
        cache: true
    },
    placeholder: 'Ketikkan Nama Peminjam',
    minimumInputLength: 2,
});
// end select peminjam

// kembalikan
function kembali(id) {
    Swal.fire({
        title: 'Konfirmasi Pengembalian',
        text: "Apakah anda yakin untuk mengkonfirmasi pengembalian buku ?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, konfirmasi sekarang!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.value) {
            $.post('<?= base_url('transaksi/kembalikanBuku') ?>', {
                'id': id
            }, function(data, textStatus, xhr) {
                $.LoadingOverlay("hide");
                if (data.status = 1) {
                    iziToast.success({
                        title: 'Success!',
                        message: 'Data berhasil dikonfirmasi !',
                        position: 'topRight',
                        balloon: true,
                        transitionIn: 'fadeInLeft',
                        transitionOut: 'fadeOutRight'
                    });
                    table.ajax.reload();
                } else {
                    iziToast.error({
                        title: 'Error!',
                        message: 'Data gagal dikonfirmasi',
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
// script kembalikan
</script>

<!-- modal transaksi -->
<div class="modal fade" tabindex="-1" role="dialog" id="formTransaksi" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Form Tambah Peminjaman</h5> <button type="button" class="close"
                    data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
            </div>
            <form id="form_update" action="<?= base_url('administrator/admin_update'); ?>" method="post">
                <div class="modal-body" id="content_update">
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                            <input type="email" class="form-control" id="inputEmail3" placeholder="Email">
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label class="col-sm-2 col-form-label">Peminjam</label>
                        <div class="col-sm-10">
                            <div class="form-group">
                                <select class="select_peminjam form-control" name="user_id"></select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <div class="col-sm-9">
                            <div class="form-group">
                                <select class="select_buku form-control " multiple="multiple" name="buku_id" required>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-danger" onclick="closes_update()">Close</button>
                    <button type="button" class="btn btn-primary" onclick="updateData()">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- end modal transaksi -->