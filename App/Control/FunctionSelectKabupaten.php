<?php
if ($EditIdKabupaten == '') {
?>
    <select name="IdKabupaten" id="IdKabupaten" style="width: 100%;" class="select2_kabupaten form-control" required>
        <option value="">Pilih Kabupaten</option>
        <?php
        $QueryKabupaten = mysqli_query($db, "SELECT * FROM master_setting_profile_dinas ORDER BY Kabupaten ASC");
        while ($DataKabupaten = mysqli_fetch_assoc($QueryKabupaten)) {
            $IdKabupaten = $DataKabupaten['IdKabupatenProfile'];
            $Kabupaten = $DataKabupaten['Kabupaten'];
        ?>
            <option value="<?php echo $IdKabupaten; ?>"><?php echo $Kabupaten; ?></option>
        <?php }
        ?>
    </select>
<?php } elseif ($EditIdKabupaten <> '') {
?>
    <select name="IdKabupaten" id="IdKabupaten" style="width: 100%;" class="select2_kabupaten form-control" required>
        <option value="<?php echo $EditIdKabupaten; ?>"><?php echo $EditKabupaten; ?></option>
        <?php
        $QueryKabupaten = mysqli_query($db, "SELECT * FROM master_setting_profile_dinas WHERE IdKabupatenProfile <> '$EditIdKabupaten' ORDER BY Kabupaten ASC");
        while ($DataKabupaten = mysqli_fetch_assoc($QueryKabupaten)) {
            $IdKabupaten = $DataKabupaten['IdKabupatenProfile'];
            $Kabupaten = $DataKabupaten['Kabupaten'];
        ?>
            <option value="<?php echo $IdKabupaten; ?>"><?php echo $Kabupaten; ?></option>
        <?php }
        ?>
    </select>
<?php } ?>