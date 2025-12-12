<?php
// Use data from FunctionDesaEdit.php if available (for edit mode)
// Otherwise fall back to GET parameter (for add mode)
$CurrentIdKabupaten = isset($EditIdKabupaten) && !empty($EditIdKabupaten) 
    ? $EditIdKabupaten 
    : (isset($_GET['EditIdKabupaten']) ? mysqli_real_escape_string($db, $_GET['EditIdKabupaten']) : '');

$CurrentNamaKabupaten = isset($EditKabupaten) && !empty($EditKabupaten) 
    ? $EditKabupaten 
    : '';

// Jika belum ada nama kabupaten tapi ada ID, ambil dari database
if (empty($CurrentNamaKabupaten) && !empty($CurrentIdKabupaten)) {
    $queryKab = mysqli_query($db, "SELECT Kabupaten FROM master_setting_profile_dinas WHERE IdKabupatenProfile = '$CurrentIdKabupaten'");
    if ($queryKab && mysqli_num_rows($queryKab) > 0) {
        $dataKab = mysqli_fetch_assoc($queryKab);
        $CurrentNamaKabupaten = $dataKab['Kabupaten'] ?? '';
    }
}
?>
<select name="IdKabupaten" id="IdKabupaten" style="width: 100%;" class="select2_kabupaten form-control" required>
    <?php if (empty($CurrentIdKabupaten)) { ?>
        <option value="">Pilih Kabupaten</option>
    <?php } else { ?>
        <option value="<?php echo htmlspecialchars($CurrentIdKabupaten); ?>" selected>
            <?php echo htmlspecialchars($CurrentNamaKabupaten); ?>
        </option>
    <?php } ?>
    
    <?php
    // Tampilkan semua kabupaten lainnya
    $whereClause = !empty($CurrentIdKabupaten) ? "WHERE IdKabupatenProfile <> '$CurrentIdKabupaten'" : "";
    $QueryKabupaten = mysqli_query($db, "SELECT * FROM master_setting_profile_dinas $whereClause ORDER BY Kabupaten ASC");
    if ($QueryKabupaten && mysqli_num_rows($QueryKabupaten) > 0) {
        while ($DataKabupaten = mysqli_fetch_assoc($QueryKabupaten)) {
            $IdKabupatenOption = $DataKabupaten['IdKabupatenProfile'];
            $KabupatenOption = $DataKabupaten['Kabupaten'];
    ?>
        <option value="<?php echo htmlspecialchars($IdKabupatenOption); ?>">
            <?php echo htmlspecialchars($KabupatenOption); ?>
        </option>
    <?php 
        }
    }
    ?>
</select>