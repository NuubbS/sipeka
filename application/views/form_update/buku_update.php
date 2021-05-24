<input type="hidden" name="buku_id" value="<?= $buku->buku_id ?>">
<div class="form-group">
    <label>Judul</label>
    <input type="text" class="form-control" name="judul" id="judul" required="" value="<?= $buku->judul; ?>">
</div>
<div class="form-group row">
    <div class='col-6'>
        <label for="kategori_id">Jabatan</label>
        <select name="kategori_id" class="form-control select2 mb-3">
            <?php foreach ($kategori as $key => $kat) { ?>
            <option <?= ($kat->kategori_id == $buku->kategori_id) ? 'selected' : ''; ?>
                value="<?= $kat->kategori_id; ?>"><?= $kat->kategori ?></option>
            <?php } ?>
        </select>
    </div>
    <div class='col-6'>
        <label for="prodi_id">Program Studi</label>
        <select id="prodi_id" name="prodi_id" class="form-control">
            <?php foreach ($prodi as $key => $prod) { ?>
            <option <?= ($prod->prodi_id == $buku->prodi_id) ? 'selected' : ''; ?> value="<?= $prod->prodi_id; ?>">
                <?= $prod->prodi ?></option>
            <?php } ?>
        </select>
    </div>
</div>
<div class="form-group row">
    <div class='col-4'><label for="rak_id">Rak Penyimpanan</label>
        <select id="rak_id" name="rak_id" class="form-control">
            <?php foreach ($rak as $key => $rakdata) { ?>
            <option <?= ($rakdata->rak_id == $buku->rak_id) ? 'selected' : ''; ?> value="<?= $rakdata->rak_id; ?>">
                <?= $rakdata->rak_nama ?></option>
            <?php } ?>
        </select>
    </div>
    <div class='col-4'><label>Tahun</label>
        <input type="text" class="form-control" name="tahun" id="tahun" required value="<?= $buku->tahun; ?>">
    </div>
    <div class='col-4'><label>Jumlah</label>
        <input type="text" class="form-control" name="jumlah" id="jumlah" required value="<?= $buku->jumlah; ?>">
    </div>
</div>
<script type="text/javascript">
function reload_datatables() {
    table.ajax.location.reload();
}
</script>