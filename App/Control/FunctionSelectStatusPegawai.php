<?php 
// Definisi dan validasi variabel
$StatusPegawai = isset($_GET['StatusPegawai']) ? mysqli_real_escape_string($db, $_GET['StatusPegawai']) : '';
$EditNamaSTPegawai = '';

// Mode edit: ambil data status pegawai yang dipilih
if (!empty($StatusPegawai)) {
    $queryEdit = mysqli_query($db, "SELECT * FROM master_status_kepegawaian WHERE IdStatusPegawai = '$StatusPegawai'");
    if ($queryEdit && mysqli_num_rows($queryEdit) > 0) {
        $dataEdit = mysqli_fetch_assoc($queryEdit);
        $EditNamaSTPegawai = $dataEdit['StatusPegawai'] ?? '';
    }
}

if (empty($StatusPegawai)) {
?>
    <select name="StatusPegawai" id="StatusPegawai" style="width: 100%;" class="select2_status_pegawai form-control" required>
        <option value="">Pilih Status Kepegawaian</option>
        <?php
        $QueryStatusPegawai = mysqli_query($db, "SELECT * FROM master_status_kepegawaian ORDER BY IdStatusPegawai ASC");
        if ($QueryStatusPegawai && mysqli_num_rows($QueryStatusPegawai) > 0) {
            while ($DataStatusPegawai = mysqli_fetch_assoc($QueryStatusPegawai)) {
                $IdStatusPegawaiOption = $DataStatusPegawai['IdStatusPegawai'];
                $StatusPegawaiOption = $DataStatusPegawai['StatusPegawai'];
        ?>
            <option value="<?php echo $IdStatusPegawaiOption; ?>"><?php echo $StatusPegawaiOption; ?></option>
        <?php 
            }
        }
        ?>
    </select>
<?php } else {
?>
    <select name="StatusPegawai" id="StatusPegawai" style="width: 100%;" class="select2_status_pegawai form-control" required>
        <option value="<?php echo $StatusPegawai; ?>"><?php echo $EditNamaSTPegawai; ?></option>
        <?php
        $QueryStatusPegawai = mysqli_query($db, "SELECT * FROM master_status_kepegawaian WHERE IdStatusPegawai <> '$StatusPegawai' ORDER BY IdStatusPegawai ASC");
        if ($QueryStatusPegawai && mysqli_num_rows($QueryStatusPegawai) > 0) {
            while ($DataStatusPegawai = mysqli_fetch_assoc($QueryStatusPegawai)) {
                $IdStatusPegawaiOption = $DataStatusPegawai['IdStatusPegawai'];
                $StatusPegawaiOption = $DataStatusPegawai['StatusPegawai'];
        ?>
            <option value="<?php echo $IdStatusPegawaiOption; ?>"><?php echo $StatusPegawaiOption; ?></option>
        <?php 
            }
        }
        ?>
    </select>
<?php } ?>