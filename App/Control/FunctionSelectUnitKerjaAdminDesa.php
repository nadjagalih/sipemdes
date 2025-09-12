<?php
$IdTemp = $_SESSION['IdDesa'];

?>
<select name="UnitKerja" id="UnitKerja" style="width: 100%;" class="select2_desa form-control" required>
    <?php
    $QueryDesa = mysqli_query($db, "SELECT
    master_desa.IdDesa,
    master_desa.NamaDesa,
    master_kecamatan.Kecamatan,
    master_desa.IdKecamatanFK,
    master_kecamatan.IdKecamatan
    FROM master_desa
    INNER JOIN master_kecamatan ON master_desa.IdKecamatanFK = master_kecamatan.IdKecamatan
    WHERE master_desa.IdDesa = '$IdTemp'
    GROUP BY master_desa.IdDesa
    ORDER BY
    master_kecamatan.Kecamatan ASC,
    master_desa.NamaDesa ASC");
    $DataDesa = mysqli_fetch_assoc($QueryDesa);
    $IdDesa = $DataDesa['IdDesa'];
    $NamaDesa = $DataDesa['NamaDesa'];
    $NamaKecamatan = $DataDesa['Kecamatan'];
    ?>
    <option value="<?php echo $IdDesa; ?>"><?php echo $NamaDesa; ?> - Kecamatan <?php echo $NamaKecamatan; ?></option>
</select>