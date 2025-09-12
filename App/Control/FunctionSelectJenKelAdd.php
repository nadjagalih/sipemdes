<select name="JenKel" id="JenKel" style="width: 100%;" class="select2_jenkel form-control" required>
    <option value="">Pilih Jenis Kelamin</option>
    <?php
    $QueryJenKel = mysqli_query($db, "SELECT * FROM master_jenkel ORDER BY IdJenKel ASC");
    while ($DataJenKel = mysqli_fetch_assoc($QueryJenKel)) {
        $IdJenKel = $DataJenKel['IdJenKel'];
        $JenKel = $DataJenKel['Keterangan'];
    ?>
        <option value="<?php echo $IdJenKel; ?>"><?php echo $JenKel; ?></option>
    <?php }
    ?>
</select>