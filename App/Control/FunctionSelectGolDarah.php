<?php
if ($GolDarah == '') {
?>
    <select name="GolDarah" id="GolDarah" style="width: 100%;" class="select2_goldarah form-control" required>
        <option value="">Pilih Golongan Darah</option>
        <?php
        $QueryGolDarah = mysqli_query($db, "SELECT * FROM master_golongan_darah ORDER BY IdGolDarah ASC");
        while ($DataGolDarah = mysqli_fetch_assoc($QueryGolDarah)) {
            $IdGolDarah = $DataGolDarah['IdGolDarah'];
            $Golongan = $DataGolDarah['Golongan'];
        ?>
            <option value="<?php echo $IdGolDarah; ?>"><?php echo $Golongan; ?></option>
        <?php }
        ?>
    </select>
<?php } elseif ($GolDarah <> '') {
?>
    <select name="GolDarah" id="GolDarah" style="width: 100%;" class="select2_goldarah form-control" required>
        <option value="<?php echo $GolDarah; ?>"><?php echo $EditNamaGolDarah; ?></option>
        <?php
        $QueryGolDarah = mysqli_query($db, "SELECT * FROM master_golongan_darah WHERE IDGolDarah <> '$GolDarah' ORDER BY IdGolDarah ASC");
        while ($DataGolDarah = mysqli_fetch_assoc($QueryGolDarah)) {
            $IdGolDarah = $DataGolDarah['IdGolDarah'];
            $Golongan = $DataGolDarah['Golongan'];
        ?>
            <option value="<?php echo $IdGolDarah; ?>"><?php echo $Golongan; ?></option>
        <?php }
        ?>
    </select>
<?php } ?>