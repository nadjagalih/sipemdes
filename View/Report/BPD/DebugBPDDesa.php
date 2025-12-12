<?php
echo "<h3>Debug BPD Desa Data</h3>";

include '../../../Module/Config/Env.php';

// Check kecamatan data
echo "<h4>Available Kecamatan:</h4>";
$QueryKec = mysqli_query($db, "SELECT * FROM master_kecamatan ORDER BY Kecamatan ASC");
while ($RowKec = mysqli_fetch_assoc($QueryKec)) {
    echo "<p>ID: " . $RowKec['IdKecamatan'] . " - " . $RowKec['Kecamatan'] . "</p>";
}

// Find Kampak kecamatan ID
$kampakQuery = mysqli_query($db, "SELECT * FROM master_kecamatan WHERE Kecamatan LIKE '%Kampak%'");
$kampakData = mysqli_fetch_assoc($kampakQuery);
if ($kampakData) {
    $kampakId = $kampakData['IdKecamatan'];
    echo "<hr><h4>Kampak Kecamatan ID: $kampakId</h4>";
    
    // Check desa data for Kampak
    $desaQuery = mysqli_query($db, "SELECT * FROM master_desa WHERE IdKecamatanFK = '$kampakId' ORDER BY NamaDesa ASC");
    $count = mysqli_num_rows($desaQuery);
    echo "<p>Found $count desa records for Kampak</p>";
    
    if ($count > 0) {
        echo "<h5>Desa list:</h5>";
        while ($desaData = mysqli_fetch_assoc($desaQuery)) {
            echo "<p>ID: " . $desaData['IdDesa'] . " - " . $desaData['NamaDesa'] . "</p>";
        }
    }
} else {
    echo "<p>Kampak kecamatan not found</p>";
}

// Test POST data simulation
echo "<hr><h4>Test POST Simulation:</h4>";
if ($kampakData) {
    $_POST['selected_kecamatan'] = $kampakData['IdKecamatan'];
    echo "<p>Simulating POST with Kampak ID: " . $_POST['selected_kecamatan'] . "</p>";
    
    // Simulate the dropdown generation
    $selectedKecamatan = $_POST['selected_kecamatan'];
    $desaOptions = '<option value="">Filter Desa</option>';
    
    $QueryDesaDirect = mysqli_query($db, "SELECT * FROM master_desa WHERE IdKecamatanFK = '$selectedKecamatan' ORDER BY NamaDesa ASC");
    if ($QueryDesaDirect) {
        while ($DataDesaDirect = mysqli_fetch_assoc($QueryDesaDirect)) {
            $IdDesa = htmlspecialchars($DataDesaDirect['IdDesa']);
            $NamaDesa = htmlspecialchars($DataDesaDirect['NamaDesa']);
            $desaOptions .= "<option value=\"$IdDesa\">$NamaDesa</option>";
        }
    }
    
    echo "<h5>Generated Desa Options:</h5>";
    echo "<select>$desaOptions</select>";
}
?>