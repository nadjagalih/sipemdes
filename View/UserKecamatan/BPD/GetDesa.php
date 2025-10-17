<?php
include '../../../Module/Config/Env.php';
$Kecamatan = isset($_POST['Kecamatan']) ? sql_injeksi($_POST['Kecamatan']) : '';

echo "<option value=''> --Pilih Desa-- </option>";
$QueryDesa = mysqli_query($db, "SELECT * FROM master_desa WHERE IdKecamatanFK = '$Kecamatan' ORDER BY NamaDesa ASC");
while ($RowDesa = mysqli_fetch_assoc($QueryDesa)) {
?>
    <option value="<?php echo isset($RowDesa['IdDesa']) ? htmlspecialchars($RowDesa['IdDesa']) : ''; ?>"> <?php echo isset($RowDesa['NamaDesa']) ? htmlspecialchars($RowDesa['NamaDesa']) : ''; ?></option>;
<?php
}
?>