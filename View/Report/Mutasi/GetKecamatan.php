<?php
// Set error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Prevent direct access (optional - commented for now)
// if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
//     die('Direct access not permitted');
// }

// Use absolute path
$rootPath = dirname(dirname(dirname(__DIR__)));
require_once $rootPath . '/Module/Config/Env.php';

// Check database connection
if (!$db) {
    die("<option value=''>Database connection error</option>");
}

echo "<option value=''> --Pilih Kecamatan-- </option>";

$QueryKecamatan = mysqli_query($db, "SELECT * FROM master_kecamatan ORDER BY Kecamatan ASC");

// Check query execution
if (!$QueryKecamatan) {
    die("<option value=''>Query error: " . mysqli_error($db) . "</option>");
}

// Check if there are results
if (mysqli_num_rows($QueryKecamatan) == 0) {
    die("<option value=''>No data available</option>");
}

while ($RowKecamatan = mysqli_fetch_assoc($QueryKecamatan)) {
    $IdKecamatan = htmlspecialchars($RowKecamatan['IdKecamatan'], ENT_QUOTES, 'UTF-8');
    $NamaKecamatan = htmlspecialchars($RowKecamatan['Kecamatan'], ENT_QUOTES, 'UTF-8');
?>
    <option value="<?php echo $IdKecamatan; ?>"><?php echo $NamaKecamatan; ?></option>
<?php
}
?>