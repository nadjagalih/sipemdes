<?php
// Definisi dan validasi variabel
$Lingkungan = isset($_GET['Lingkungan']) ? mysqli_real_escape_string($db, $_GET['Lingkungan']) : '';
$EditNamaDesa = '';

// Mode edit: ambil data desa yang dipilih
if (!empty($Lingkungan)) {
    $queryEdit = mysqli_query($db, "SELECT master_desa.*, master_kecamatan.Kecamatan 
                                   FROM master_desa 
                                   INNER JOIN master_kecamatan ON master_desa.IdKecamatanFK = master_kecamatan.IdKecamatan 
                                   WHERE master_desa.IdDesa = '$Lingkungan'");
    if ($queryEdit && mysqli_num_rows($queryEdit) > 0) {
        $dataEdit = mysqli_fetch_assoc($queryEdit);
        $EditNamaDesa = $dataEdit['NamaDesa'] . ' - ' . $dataEdit['Kecamatan'];
    }
}

if (empty($Lingkungan)) {
?>
    <select name="IdDesa" id="IdDesa" style="width: 100%;" class="select2_desa form-control" required>
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
        if ($QueryDesa && mysqli_num_rows($QueryDesa) > 0) {
            while ($DataDesa = mysqli_fetch_assoc($QueryDesa)) {
                $IdDesaOption = $DataDesa['IdDesa'];
                $NamaDesaOption = $DataDesa['NamaDesa'];
                $NamaKecamatanOption = $DataDesa['Kecamatan'];
        ?>
            <option value="<?php echo $IdDesaOption; ?>"><?php echo $NamaDesaOption; ?> - <?php echo $NamaKecamatanOption; ?></option>
        <?php 
            }
        }
        ?>
    </select>
<?php } else { ?>
    <select name="IdDesa" id="IdDesa" style="width: 100%;" class="select2_desa form-control" required>
        <option value="<?php echo $Lingkungan; ?>"><?php echo $EditNamaDesa; ?></option>
        <?php
        $QueryDesa = mysqli_query($db, "SELECT
    master_desa.IdDesa,
    master_desa.NamaDesa,
    master_kecamatan.Kecamatan,
    master_desa.IdKecamatanFK,
    master_kecamatan.IdKecamatan
    FROM master_desa
    INNER JOIN master_kecamatan ON master_desa.IdKecamatanFK = master_kecamatan.IdKecamatan
    WHERE master_desa.IdDesa <> '$Lingkungan'
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