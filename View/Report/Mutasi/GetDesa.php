<?php
include '../../../Module/Config/Env.php';
$Kecamatan = $_POST['Kecamatan'];

echo "<option value=''> --Pilih Desa-- </option>";
$QueryDesa = mysqli_query($db, "SELECT * FROM master_desa WHERE IdKecamatanFK = '$Kecamatan' ORDER BY NamaDesa ASC");
while ($RowDesa = mysqli_fetch_assoc($QueryDesa)) {
?>
    <option value="<?php echo $RowDesa['IdDesa']; ?>"> <?php echo  $RowDesa['NamaDesa']; ?></option>;
<?php
}
?>