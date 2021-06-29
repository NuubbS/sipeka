<input type="hidden" name="user_id" value="<?= $user->user_id ?>">
<div class='form-grup'>
    <label for="level_id">Program Studi</label>
    <select id="level_id" name="level_id" class="form-control">
        <?php foreach ($level as $key => $lv) { ?>
        <option <?= ($lv->level_id == $user->level_id) ? 'selected' : ''; ?> value="<?= $lv->level_id; ?>">
            <?= $lv->level ?></option>
        <?php } ?>
    </select>
</div>

<script type="text/javascript">
function reload_datatables() {
    table.ajax.location.reload();
}
</script>