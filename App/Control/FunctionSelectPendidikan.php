<?php if ($IdPendidikan == '') { ?>
    <select name="Pendidikan" id="Pendidikan" style="width: 100%;" class="select2_pendidikan form-control" required>
        <option value="">Pilih Pendidikan</option>
        <?php
        $QueryPendidikan = mysqli_query($db, "SELECT * FROM master_pendidikan ORDER BY IdPendidikan ASC");
        while ($DataPendidikan = mysqli_fetch_assoc($QueryPendidikan)) {
            $IdPendidikan = $DataPendidikan['IdPendidikan'];
            $Pendidikan = $DataPendidikan['JenisPendidikan'];
        ?>
            <option value="<?php echo $IdPendidikan; ?>"><?php echo $Pendidikan; ?></option>
        <?php }
        ?>
    </select>
<?php } elseif ($IdPendidikan <> '') { ?>
    <select name="Pendidikan" id="Pendidikan" style="width: 100%;" class="select2_pendidikan form-control" required>
        <option value="<?php echo $IdPendidikan; ?>"><?php echo $Pendidikan; ?></option>
        <?php
        $QueryPendidikan = mysqli_query($db, "SELECT * FROM master_pendidikan WHERE IdPendidikan <> '$IdPendidikan' ORDER BY IdPendidikan ASC");
        while ($DataPendidikan = mysqli_fetch_assoc($QueryPendidikan)) {
            $IdPendidikan = $DataPendidikan['IdPendidikan'];
            $Pendidikan = $DataPendidikan['JenisPendidikan'];
        ?>
            <option value="<?php echo $IdPendidikan; ?>"><?php echo $Pendidikan; ?></option>
        <?php }
        ?>
    </select>
<?php } ?>