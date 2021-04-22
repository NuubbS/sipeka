<input type="hidden" name="user_id" value="<?= $buku->buku_id ?>">
<!-- <div class="row">
    <div class="col-md-12 form-group"> -->
<table id="table_buku" class="table table-hover">
    <thead>
        <tr>
            <th scope="col">Ditambahkan</th>
            <th scope="col">Diubah</th>
            <th scope="col">Dibuat Oleh</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><?= $buku->date_created ?></td>
            <td><?= $buku->date_updated ?></td>
            <td><?= $buku->created_by ?></td>
        </tr>
    </tbody>
</table>
<!-- </div>
</div> -->

<script type="text/javascript">
function reload_datatables() {
    table.ajax.location.reload();
}
</script>