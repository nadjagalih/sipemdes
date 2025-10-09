<?php
// Definisi dan validasi variabel
$Pernikahan = isset($_GET['Pernikahan']) ? mysqli_real_escape_string($db, $_GET['Pernikahan']) : '';
$EditPernikahan = '';

// Mode edit: ambil data status pernikahan yang dipilih
if (!empty($Pernikahan)) {
    $queryEdit = mysqli_query($db, "SELECT * FROM master_status_pernikahan WHERE IdPernikahan = '$Pernikahan'");
    if ($queryEdit && mysqli_num_rows($queryEdit) > 0) {
        $dataEdit = mysqli_fetch_assoc($queryEdit);
        $EditPernikahan = $dataEdit['StatusPernikahan'] ?? '';
    }
}

if (empty($Pernikahan)) {
?>
    <select name="Pernikahan" id="Pernikahan" style="width: 100%;" class="select2_pernikahan form-control" required>
        <option value="">Pilih Status Pernikahan</option>
        <?php
        $QueryPernikahan = mysqli_query($db, "SELECT * FROM master_status_pernikahan ORDER BY IdPernikahan ASC");
        if ($QueryPernikahan && mysqli_num_rows($QueryPernikahan) > 0) {
            while ($DataPernikahan = mysqli_fetch_assoc($QueryPernikahan)) {
                $IdPernikahanOption = $DataPernikahan['IdPernikahan'];
                $PernikahanOption = $DataPernikahan['StatusPernikahan'];
        ?>
            <option value="<?php echo $IdPernikahanOption; ?>"><?php echo $PernikahanOption; ?></option>
        <?php 
            }
        }
        ?>
    </select>
<?php } else {
?>
    <select name="Pernikahan" id="Pernikahan" style="width: 100%;" class="select2_pernikahan form-control" required>
        <option value="<?php echo $Pernikahan; ?>"><?php echo $EditPernikahan; ?></option>
        <?php
        $QueryPernikahan = mysqli_query($db, "SELECT * FROM master_status_pernikahan WHERE IdPernikahan <> '$Pernikahan' ORDER BY IdPernikahan ASC");
        if ($QueryPernikahan && mysqli_num_rows($QueryPernikahan) > 0) {
            while ($DataPernikahan = mysqli_fetch_assoc($QueryPernikahan)) {
                $IdPernikahanOption = $DataPernikahan['IdPernikahan'];
                $PernikahanOption = $DataPernikahan['StatusPernikahan'];
        ?>
            <option value="<?php echo $IdPernikahanOption; ?>"><?php echo $PernikahanOption; ?></option>
        <?php 
            }
        }
        ?>
    </select>
<?php } ?>