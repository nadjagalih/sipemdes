<select name="IdDesa" id="IdDesa" style="width: 100%;" class="select2_desa form-control">
    <option value="">Pilih Desa/Kelurahan</option>
    <?php
    $QueryDesa = mysqli_query($db, "SELECT
    master_desa.IdDesa,
    master_desa.NamaDesa,
    master_kecamatan.Kecamatan,
    master_desa.IdKecamatanFK,
    master_kecamatan.IdKecamatan
    FROM master_desa
    INNER JOIN master_kecamatan ON master_desa.IdKecamatanFK = master_kecamatan.IdKecamatan
    ORDER BY
    master_kecamatan.Kecamatan ASC,
    master_desa.NamaDesa ASC");
    while ($DataDesa = mysqli_fetch_assoc($QueryDesa)) {
        $IdDesa = $DataDesa['IdDesa'];
        $NamaDesa = $DataDesa['NamaDesa'];
        $NamaKecamatan = $DataDesa['Kecamatan'];
    ?>
        <option value="<?php echo $IdDesa; ?>"><?php echo $NamaDesa; ?> - <?php echo $NamaKecamatan; ?></option>
    <?php }
    ?>
</select>