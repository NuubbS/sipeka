<input type="hidden" name="prodi_id" value="<?= $prodi->prodi_id ?>">
<div class="form-group">
    <label>Prodi</label>
    <input type="text" class="form-control" name="prodi" id="prodi" required="" value="<?= $prodi->prodi ?>">
</div>
<script type="text/javascript">
function reload_datatables() {
    table.ajax.location.reload();
}
</script>