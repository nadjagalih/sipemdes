<?php
include '../../../Module/Config/Env.php';

// Debug: Check if database connection exists
if (!isset($db)) {
    error_log("Database connection not found in GetDesa.php");
    echo "<option value=''>Database connection error</option>";
    exit;
}

$Kecamatan = isset($_POST['Kecamatan']) ? sql_injeksi($_POST['Kecamatan']) : '';

// Debug: Log the received value
error_log("GetDesa.php received Kecamatan: " . $Kecamatan);

if (empty($Kecamatan)) {
    echo "<option value=''> --Pilih Desa-- </option>";
    exit;
}

echo "<option value=''> --Pilih Desa-- </option>";
$QueryDesa = mysqli_query($db, "SELECT * FROM master_desa WHERE IdKecamatanFK = '$Kecamatan' ORDER BY NamaDesa ASC");

// Debug: Check if query was successful
if (!$QueryDesa) {
    error_log("GetDesa.php query error: " . mysqli_error($db));
    echo "<option value=''>Error executing query</option>";
    exit;
}

// Debug: Check if any results found
$resultCount = mysqli_num_rows($QueryDesa);
error_log("GetDesa.php found $resultCount desa records for Kecamatan: $Kecamatan");

if ($resultCount == 0) {
    echo "<option value=''>Tidak ada desa ditemukan</option>";
    exit;
}

while ($RowDesa = mysqli_fetch_assoc($QueryDesa)) {
?>
    <option value="<?php echo isset($RowDesa['IdDesa']) ? htmlspecialchars($RowDesa['IdDesa']) : ''; ?>"> <?php echo isset($RowDesa['NamaDesa']) ? htmlspecialchars($RowDesa['NamaDesa']) : ''; ?></option>
<?php
}
?>