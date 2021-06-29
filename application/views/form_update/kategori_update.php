<input type="hidden" name="kategori_id" value="<?= $kategori->kategori_id ?>">
<div class="form-group">
    <label>Kategori</label>
    <input type="text" class="form-control" name="kategori" id="kategori" required="" value="<?= $kategori->kategori ?>">
</div>
<script type="text/javascript">
function reload_datatables() {
    table.ajax.location.reload();
}
</script>