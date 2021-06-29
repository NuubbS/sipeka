<input type="hidden" name="rak_id" value="<?= $rak->rak_id ?>">
<input type="hidden" name="rak_kode" value="<?= $rak->rak_kode ?>">
<div class="form-group">
    <label>Nama</label>
    <input type="text" class="form-control" name="rak_nama" id="rak_nama" required="" value="<?= $rak->rak_nama ?>">
</div>
<div class="form-group">
    <label>Keterangan</label>
    <input type="text" class="form-control" name="rak_keterangan" id="rak_keterangan" required=""
        value="<?= $rak->rak_keterangan ?>">
</div>

<script type="text/javascript">
function reload_datatables() {
    table.ajax.location.reload();
}
</script>