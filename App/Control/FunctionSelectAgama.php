<?php
if ($Agama == '') {
?>
    <select name="Agama" id="Agama" style="width: 100%;" class="select2_agama form-control" required>
        <option value="">Pilih Agama</option>
        <?php
        $QueryAgama = mysqli_query($db, "SELECT * FROM master_agama ORDER BY IdAgama ASC");
        while ($DataAgama = mysqli_fetch_assoc($QueryAgama)) {
            $IdAgama = $DataAgama['IdAgama'];
            $Agama = $DataAgama['Agama'];
        ?>
            <option value="<?php echo $IdAgama; ?>"><?php echo $Agama; ?></option>
        <?php }
        ?>
    </select>
<?php
} elseif ($Agama <> '') {
?>
    <select name="Agama" id="Agama" style="width: 100%;" class="select2_agama form-control" required>
        <option value="<?php echo $Agama; ?>"><?php echo $EditNamaAgama; ?></option>
        <?php
        $QueryAgama = mysqli_query($db, "SELECT * FROM master_agama WHERE IdAgama <> '$Agama' ORDER BY IdAgama ASC");
        while ($DataAgama = mysqli_fetch_assoc($QueryAgama)) {
            $IdAgama = $DataAgama['IdAgama'];
            $Agama = $DataAgama['Agama'];
        ?>
            <option value="<?php echo $IdAgama; ?>"><?php echo $Agama; ?></option>
        <?php }
        ?>
    </select>
<?php } ?>