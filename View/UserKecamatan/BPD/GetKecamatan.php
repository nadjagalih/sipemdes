<?php
include '../../../Module/Config/Env.php';

echo "<option value=''> --Pilih Kecamatan-- </option>";

$QueryKecamatan = mysqli_query($db, "SELECT * FROM master_kecamatan ORDER BY Kecamatan ASC");
while ($RowKecamatan = mysqli_fetch_assoc($QueryKecamatan)) {
?>
    <option value="<?php echo isset($RowKecamatan['IdKecamatan']) ? htmlspecialchars($RowKecamatan['IdKecamatan']) : ''; ?>"> <?php echo isset($RowKecamatan['Kecamatan']) ? htmlspecialchars($RowKecamatan['Kecamatan']) : ''; ?></option>;
<?php
}
?>