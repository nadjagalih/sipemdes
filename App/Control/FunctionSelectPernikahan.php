<?php if ($Pernikahan == '') {
?>
    <select name="Pernikahan" id="Pernikahan" style="width: 100%;" class="select2_pernikahan form-control" required>
        <option value="">Pilih Status Pernikahan</option>
        <?php
        $QueryPernikahan = mysqli_query($db, "SELECT * FROM master_status_pernikahan ORDER BY IdPernikahan ASC");
        while ($DataPernikahan = mysqli_fetch_assoc($QueryPernikahan)) {
            $IdPernikahan = $DataPernikahan['IdPernikahan'];
            $StatusPernikahan = $DataPernikahan['Status'];
        ?>
            <option value="<?php echo $IdPernikahan; ?>"><?php echo $StatusPernikahan; ?></option>
        <?php }
        ?>
    </select>
<?php } elseif ($Pernikahan <> '') {
?>
    <select name="Pernikahan" id="Pernikahan" style="width: 100%;" class="select2_pernikahan form-control" required>
        <option value="<?php echo $Pernikahan; ?>"><?php echo $EditNamaSTNikah; ?></option>
        <?php
        $QueryPernikahan = mysqli_query($db, "SELECT * FROM master_status_pernikahan WHERE IdPernikahan <> '$Pernikahan' ORDER BY IdPernikahan ASC");
        while ($DataPernikahan = mysqli_fetch_assoc($QueryPernikahan)) {
            $IdPernikahan = $DataPernikahan['IdPernikahan'];
            $StatusPernikahan = $DataPernikahan['Status'];
        ?>
            <option value="<?php echo $IdPernikahan; ?>"><?php echo $StatusPernikahan; ?></option>
        <?php }
        ?>
    </select>
<?php } ?>