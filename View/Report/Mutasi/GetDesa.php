<?php
// Set error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Use absolute path
$rootPath = dirname(dirname(dirname(__DIR__)));
require_once $rootPath . '/Module/Config/Env.php';

// Check database connection
if (!$db) {
    die("<option value=''>Database connection error</option>");
}

// Get and sanitize input
$Kecamatan = isset($_POST['Kecamatan']) ? sql_injeksi($_POST['Kecamatan']) : '';

// Validate input
if (empty($Kecamatan)) {
    echo "<option value=''> --Pilih Desa-- </option>";
    exit;
}

echo "<option value=''> --Pilih Desa-- </option>";

$QueryDesa = mysqli_query($db, "SELECT * FROM master_desa WHERE IdKecamatanFK = '$Kecamatan' ORDER BY NamaDesa ASC");

// Check query execution
if (!$QueryDesa) {
    die("<option value=''>Query error: " . mysqli_error($db) . "</option>");
}

// Check if there are results
if (mysqli_num_rows($QueryDesa) == 0) {
    echo "<option value=''>No data available</option>";
    exit;
}

while ($RowDesa = mysqli_fetch_assoc($QueryDesa)) {
    $IdDesa = htmlspecialchars($RowDesa['IdDesa'], ENT_QUOTES, 'UTF-8');
    $NamaDesa = htmlspecialchars($RowDesa['NamaDesa'], ENT_QUOTES, 'UTF-8');
?>
    <option value="<?php echo $IdDesa; ?>"><?php echo $NamaDesa; ?></option>
<?php
}
?>