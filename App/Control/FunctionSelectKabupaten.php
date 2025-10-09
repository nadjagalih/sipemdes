<?php
// Definisi dan validasi variabel
$EditIdKabupaten = isset($_GET['EditIdKabupaten']) ? mysqli_real_escape_string($db, $_GET['EditIdKabupaten']) : '';
$EditKabupaten = '';

// Mode edit: ambil data kabupaten yang dipilih
if (!empty($EditIdKabupaten)) {
    $queryEdit = mysqli_query($db, "SELECT * FROM master_setting_profile_dinas WHERE IdKabupatenProfile = '$EditIdKabupaten'");
    if ($queryEdit && mysqli_num_rows($queryEdit) > 0) {
        $dataEdit = mysqli_fetch_assoc($queryEdit);
        $EditKabupaten = $dataEdit['Kabupaten'] ?? '';
    }
}

if (empty($EditIdKabupaten)) {
?>
    <select name="IdKabupaten" id="IdKabupaten" style="width: 100%;" class="select2_kabupaten form-control" required>
        <option value="">Pilih Kabupaten</option>
        <?php
        $QueryKabupaten = mysqli_query($db, "SELECT * FROM master_setting_profile_dinas ORDER BY Kabupaten ASC");
        if ($QueryKabupaten && mysqli_num_rows($QueryKabupaten) > 0) {
            while ($DataKabupaten = mysqli_fetch_assoc($QueryKabupaten)) {
                $IdKabupatenOption = $DataKabupaten['IdKabupatenProfile'];
                $KabupatenOption = $DataKabupaten['Kabupaten'];
        ?>
            <option value="<?php echo $IdKabupatenOption; ?>"><?php echo $KabupatenOption; ?></option>
        <?php 
            }
        }
        ?>
    </select>
<?php } else {
?>
    <select name="IdKabupaten" id="IdKabupaten" style="width: 100%;" class="select2_kabupaten form-control" required>
        <option value="<?php echo $EditIdKabupaten; ?>"><?php echo $EditKabupaten; ?></option>
        <?php
        $QueryKabupaten = mysqli_query($db, "SELECT * FROM master_setting_profile_dinas WHERE IdKabupatenProfile <> '$EditIdKabupaten' ORDER BY Kabupaten ASC");
        if ($QueryKabupaten && mysqli_num_rows($QueryKabupaten) > 0) {
            while ($DataKabupaten = mysqli_fetch_assoc($QueryKabupaten)) {
                $IdKabupatenOption = $DataKabupaten['IdKabupatenProfile'];
                $KabupatenOption = $DataKabupaten['Kabupaten'];
        ?>
            <option value="<?php echo $IdKabupatenOption; ?>"><?php echo $KabupatenOption; ?></option>
        <?php 
            }
        }
        ?>
    </select>
<?php } ?>