<?php
// Use data from FunctionDesaEdit.php if available (for edit mode)
// Otherwise fall back to GET parameter (for add mode)
$CurrentIdKecamatan = isset($EditIdKecamatan) && !empty($EditIdKecamatan) 
    ? $EditIdKecamatan 
    : (isset($_GET['EditIdKecamatan']) ? mysqli_real_escape_string($db, $_GET['EditIdKecamatan']) : '');

$CurrentNamaKecamatan = isset($EditNamaKecamatan) && !empty($EditNamaKecamatan) 
    ? $EditNamaKecamatan 
    : '';

// Jika belum ada nama kecamatan tapi ada ID, ambil dari database
if (empty($CurrentNamaKecamatan) && !empty($CurrentIdKecamatan)) {
    $queryKec = mysqli_query($db, "SELECT Kecamatan FROM master_kecamatan WHERE IdKecamatan = '$CurrentIdKecamatan'");
    if ($queryKec && mysqli_num_rows($queryKec) > 0) {
        $dataKec = mysqli_fetch_assoc($queryKec);
        $CurrentNamaKecamatan = $dataKec['Kecamatan'] ?? '';
    }
}
?>
<select name="IdKecamatan" id="IdKecamatan" style="width: 100%;" class="select2_kecamatan form-control" required>
    <?php if (empty($CurrentIdKecamatan)) { ?>
        <option value="">Pilih Kecamatan</option>
    <?php } else { ?>
        <option value="<?php echo htmlspecialchars($CurrentIdKecamatan); ?>" selected>
            <?php echo htmlspecialchars($CurrentNamaKecamatan); ?>
        </option>
    <?php } ?>
    
    <?php
    // Tampilkan semua kecamatan lainnya
    $whereClause = !empty($CurrentIdKecamatan) ? "WHERE IdKecamatan <> '$CurrentIdKecamatan'" : "";
    $QueryKecamatan = mysqli_query($db, "SELECT * FROM master_kecamatan $whereClause ORDER BY Kecamatan ASC");
    if ($QueryKecamatan && mysqli_num_rows($QueryKecamatan) > 0) {
        while ($DataKecamatan = mysqli_fetch_assoc($QueryKecamatan)) {
            $IdKecamatanOption = $DataKecamatan['IdKecamatan'];
            $KecamatanOption = $DataKecamatan['Kecamatan'];
    ?>
        <option value="<?php echo htmlspecialchars($IdKecamatanOption); ?>">
            <?php echo htmlspecialchars($KecamatanOption); ?>
        </option>
    <?php 
        }
    }
    ?>
</select>