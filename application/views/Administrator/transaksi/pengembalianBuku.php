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
                                <div class="container">
                                    <div class="row mt-3">
                                        <!-- <form action="" method="GET">
                                            <div class="form-group col">
                                                <div class="input-group">
                                                    <input type="date" class="form-control" name="tgl_awal"
                                                        id="tgl_awal">
                                                    <input type="date" class="form-control" name="tgl_akhir"
                                                        id="tgl_akhir">
                                                    <div class="input-group-append">
                                                        <button class="btn btn-primary" type="submit">Cari</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form> -->
                                        <div class="col">
                                            <a href="eksportPDF" class="btn btn-icon btn-sm btn-success mr-2 ml-2">
                                                <i class="fa fa-file-pdf"></i>
                                                Eksport PDF
                                            </a>
                                            <a href="eksportExcel" class="btn btn-icon btn-sm btn-info mr-2">
                                                <i class="fa fa-file-excel"></i>
                                                Eksport Excel
                                            </a>
                                            <a href="eksportGrafik" class="btn btn-icon btn-sm btn-warning">
                                                <i class="fas fa-chart-bar"></i>
                                                Eksport Grafik
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-body">
                                    <table id="bukuDipinjam" class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th scope="col">Kode Transaki</th>
                                                <th scope="col">Nama Peminjam</th>
                                                <th scope="col">Tanggal Pinjam</th>
                                                <th scope="col">Petugas</th>
                                                <th scope="col">Status</th>
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
        'type': 'POST',
        'dataSrc': 'data',
        // 'dataSrc': 'is_date_search:is_date_search, tgl_awal:tgl_awal, tgl_akhir:tgl_akhir',
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
            $.post('<?= base_url('transaksi/peminjaman_hapus') ?>', {
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

function detail(id) {
    $.LoadingOverlay("show", {
        image: "",
        fontawesome: "fa fa-spinner fa-pulse"
    });
    $.ajax({
        url: "<?= base_url("transaksi/detailkembali/") ?>" + id,
        dataType: "html",
        success: function(result) {
            $.LoadingOverlay("hide");
            $('#detail_kembali').modal('show');
            $('#content_kembali').html(result);

        }
    });
}
</script>

<!-- modal detail -->
<div class="modal fade" tabindex="-1" role="dialog" id="detail_kembali" aria-hidden="true" style="display: none;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Data Buku Dipinjam</h5> <button type="button" class="close" data-dismiss="modal"
                    aria-label="Close"> <span aria-hidden="true">×</span> </button>
            </div>
            <form>
                <div class="modal-body" id="content_kembali">
                    <!-- isi form di folder lain -->
                </div>
            </form>
        </div>
    </div>
</div>
<!-- modal detail -->