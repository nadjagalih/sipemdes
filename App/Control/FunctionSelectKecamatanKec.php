<?php
if ($EditIdKecamatanFK == '') {
?>
    <select name="IdKecamatan" id="IdKecamatan" style="width: 100%;" class="select2_akses form-control" required>
        <option value="">Pilih Kecamatan</option>
        <?php
        $QueryKecamatan = mysqli_query($db, "SELECT * FROM master_kecamatan ORDER BY Kecamatan ASC");
        while ($DataKecamatan = mysqli_fetch_assoc($QueryKecamatan)) {
            $IdKecamatan = $DataKecamatan['IdKecamatan'];
            $Kecamatan = $DataKecamatan['Kecamatan'];
        ?>
            <option value="<?php echo $IdKecamatan; ?>"><?php echo $Kecamatan; ?></option>
        <?php }
        ?>
    </select>
<?php } elseif ($EditIdKecamatanFK <> '') {
?>
    <select name="IdKecamatan" id="IdKecamatan" style="width: 100%;" class="select2_akses form-control" required>
        <option value="<?php echo $EditIdKecamatanFK; ?>"><?php echo $EditNamaKecamatan; ?></option>
        <?php
        $QueryKecamatan = mysqli_query($db, "SELECT * FROM master_kecamatan WHERE IdKecamatan <> '$EditIdKecamatanFK' ORDER BY Kecamatan ASC");
        while ($DataKecamatan = mysqli_fetch_assoc($QueryKecamatan)) {
            $IdKecamatan = $DataKecamatan['IdKecamatan'];
            $Kecamatan = $DataKecamatan['Kecamatan'];
        ?>
            <option value="<?php echo $IdKecamatan; ?>"><?php echo $Kecamatan; ?></option>
        <?php }
        ?>
    </select>
<?php } ?>