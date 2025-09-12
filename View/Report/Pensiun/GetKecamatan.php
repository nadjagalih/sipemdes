<?php
include '../../../Module/Config/Env.php';

echo "<option value=''> --Pilih Kecamatan-- </option>";

$QueryKecamatan = mysqli_query($db, "SELECT * FROM master_kecamatan ORDER BY Kecamatan ASC");
while ($RowKecamatan = mysqli_fetch_assoc($QueryKecamatan)) {
?>
    <option value="<?php echo $RowKecamatan['IdKecamatan']; ?>"> <?php echo  $RowKecamatan['Kecamatan']; ?></option>;
<?php
}
?>