        <div class="table-responsive">
            <table id="table_anggota" class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Alamat</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
        <script type="text/javascript">
table = $('#table_anggota').DataTable({
    'ajax': {
        'url': '<?= base_url('transaksi/anggota_fetch') ?>',
        'dataSrc': 'data',
        'type': 'POST'
    },
    'processing': true,
    // scrollY: '250px',
    'serverSide': true,
    'paging': true,
    'lengthChange': true,
    'searching': true,
    'ordering': true,
    'info': true,
    'autoWidth': false,
});
        </script>