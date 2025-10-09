<?php
// Definisi dan validasi variabel
$Agama = isset($_GET['Agama']) ? mysqli_real_escape_string($db, $_GET['Agama']) : '';
$EditAgama = '';

// Mode edit: ambil data agama yang dipilih
if (!empty($Agama)) {
    $queryEdit = mysqli_query($db, "SELECT * FROM master_agama WHERE IdAgama = '$Agama'");
    if ($queryEdit && mysqli_num_rows($queryEdit) > 0) {
        $dataEdit = mysqli_fetch_assoc($queryEdit);
        $EditAgama = $dataEdit['Agama'] ?? '';
    }
}

if (empty($Agama)) {
?>
    <select name="Agama" id="Agama" style="width: 100%;" class="select2_agama form-control" required>
        <option value="">Pilih Agama</option>
        <?php
        $QueryAgama = mysqli_query($db, "SELECT * FROM master_agama ORDER BY IdAgama ASC");
        if ($QueryAgama && mysqli_num_rows($QueryAgama) > 0) {
            while ($DataAgama = mysqli_fetch_assoc($QueryAgama)) {
                $IdAgamaOption = $DataAgama['IdAgama'];
                $AgamaOption = $DataAgama['Agama'];
        ?>
            <option value="<?php echo $IdAgamaOption; ?>"><?php echo $AgamaOption; ?></option>
        <?php 
            }
        }
        ?>
    </select>
<?php } else {
?>
    <select name="Agama" id="Agama" style="width: 100%;" class="select2_agama form-control" required>
        <option value="<?php echo $Agama; ?>"><?php echo $EditAgama; ?></option>
        <?php
        $QueryAgama = mysqli_query($db, "SELECT * FROM master_agama WHERE IdAgama <> '$Agama' ORDER BY IdAgama ASC");
        if ($QueryAgama && mysqli_num_rows($QueryAgama) > 0) {
            while ($DataAgama = mysqli_fetch_assoc($QueryAgama)) {
                $IdAgamaOption = $DataAgama['IdAgama'];
                $AgamaOption = $DataAgama['Agama'];
        ?>
            <option value="<?php echo $IdAgamaOption; ?>"><?php echo $AgamaOption; ?></option>
        <?php 
            }
        }
        ?>
    </select>
<?php } ?>