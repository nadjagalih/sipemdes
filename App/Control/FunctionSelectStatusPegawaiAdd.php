<select name="StatusPegawai" id="StatusPegawai" style="width: 100%;" class="select2_status_pegawai form-control" required>
    <option value="">Pilih Status Kepegawaian</option>
    <?php
    $QueryStatusPegawai = mysqli_query($db, "SELECT * FROM master_status_kepegawaian ORDER BY IdStatusPegawai ASC");
    while ($DataStatusPegawai = mysqli_fetch_assoc($QueryStatusPegawai)) {
        $IdStatusPegawai = $DataStatusPegawai['IdStatusPegawai'];
        $StatusPegawai = $DataStatusPegawai['StatusPegawai'];
    ?>
        <option value="<?php echo $IdStatusPegawai; ?>"><?php echo $StatusPegawai; ?></option>
    <?php }
    ?>
</select>