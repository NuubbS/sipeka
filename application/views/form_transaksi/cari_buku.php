        <div class="table-responsive">
            <table id="table_buku" class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">Judul</th>
                        <th scope="col">Tahun</th>
                        <th scope="col">Jumlah</th>
                        <th scope="col">Dipinjam</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
        <script type="text/javascript">
var table = $('#table_buku').DataTable({
    'ajax': {
        'url': '<?php echo base_url("transaksi/buku_fetch") ?>',
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
        </script>