<?php
// Definisi dan validasi variabel
$UnitKerja = '';
$EditNamaUnitKerja = '';

// Get UnitKerja from various sources
if (isset($_GET['UnitKerja'])) {
    $UnitKerja = mysqli_real_escape_string($db, $_GET['UnitKerja']);
} elseif (isset($DataPegawaiEdit['IdDesaFK'])) {
    $UnitKerja = $DataPegawaiEdit['IdDesaFK'];
} elseif (isset($IdDesaFK)) {
    $UnitKerja = $IdDesaFK;
}

// Mode edit: ambil data unit kerja yang dipilih
if (!empty($UnitKerja)) {
    $queryEdit = mysqli_query($db, "SELECT master_desa.*, master_kecamatan.Kecamatan 
                                   FROM master_desa 
                                   INNER JOIN master_kecamatan ON master_desa.IdKecamatanFK = master_kecamatan.IdKecamatan 
                                   WHERE master_desa.IdDesa = '$UnitKerja'");
    if ($queryEdit && mysqli_num_rows($queryEdit) > 0) {
        $dataEdit = mysqli_fetch_assoc($queryEdit);
        $EditNamaUnitKerja = $dataEdit['NamaDesa'] . ' - ' . $dataEdit['Kecamatan'];
    }
}

if (empty($UnitKerja)) {
?>
    <select name="UnitKerja" id="UnitKerja" style="width: 100%;" class="select2_desa form-control">
        <option value="">Pilih Unit Kerja</option>
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
        if ($QueryDesa && mysqli_num_rows($QueryDesa) > 0) {
            while ($DataDesa = mysqli_fetch_assoc($QueryDesa)) {
                $IdDesaOption = $DataDesa['IdDesa'];
                $NamaDesaOption = $DataDesa['NamaDesa'];
                $NamaKecamatanOption = $DataDesa['Kecamatan'];
        ?>
            <option value="<?php echo $IdDesaOption; ?>"><?php echo $NamaDesaOption; ?> - Kecamatan <?php echo $NamaKecamatanOption; ?></option>
        <?php 
            }
        }
        ?>
    </select>
<?php } else { ?>
    <select name="UnitKerja" id="UnitKerja" style="width: 100%;" class="select2_desa form-control">
        <option value="<?php echo $UnitKerja; ?>"><?php echo $EditNamaUnitKerja; ?></option>
        <?php
        $QueryDesa = mysqli_query($db, "SELECT
    master_desa.IdDesa,
    master_desa.NamaDesa,
    master_kecamatan.Kecamatan,
    master_desa.IdKecamatanFK,
    master_kecamatan.IdKecamatan
    FROM master_desa
    INNER JOIN master_kecamatan ON master_desa.IdKecamatanFK = master_kecamatan.IdKecamatan
    WHERE master_desa.IdDesa <> '$UnitKerja'
    ORDER BY
    master_kecamatan.Kecamatan ASC,
    master_desa.NamaDesa ASC");
        if ($QueryDesa && mysqli_num_rows($QueryDesa) > 0) {
            while ($DataDesa = mysqli_fetch_assoc($QueryDesa)) {
                $IdDesaOption = $DataDesa['IdDesa'];
                $NamaDesaOption = $DataDesa['NamaDesa'];
                $NamaKecamatanOption = $DataDesa['Kecamatan'];
        ?>
            <option value="<?php echo $IdDesaOption; ?>"><?php echo $NamaDesaOption; ?> - Kecamatan <?php echo $NamaKecamatanOption; ?></option>
        <?php 
            }
        }
        ?>
    </select>
<?php } ?>