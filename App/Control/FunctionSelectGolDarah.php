<?php
// Definisi dan validasi variabel
$GolDarah = isset($_GET['GolDarah']) ? mysqli_real_escape_string($db, $_GET['GolDarah']) : '';
$EditGolDarah = '';

// Mode edit: ambil data golongan darah yang dipilih
if (!empty($GolDarah)) {
    $queryEdit = mysqli_query($db, "SELECT * FROM master_golongan_darah WHERE IdGolDarah = '$GolDarah'");
    if ($queryEdit && mysqli_num_rows($queryEdit) > 0) {
        $dataEdit = mysqli_fetch_assoc($queryEdit);
        // DB column is `Golongan` in master_golongan_darah
        $EditGolDarah = $dataEdit['Golongan'] ?? '';
    }
}

// Check if we have edit data from FunctionPegawaiEdit.php
if (isset($EditNamaGolDarah) && !empty($EditNamaGolDarah)) {
    $EditGolDarah = $EditNamaGolDarah;
}

if (empty($GolDarah)) {
?>
    <select name="GolDarah" id="GolDarah" style="width: 100%;" class="select2_goldarah form-control" required>
        <option value="">Pilih Golongan Darah</option>
        <?php
        $QueryGolDarah = mysqli_query($db, "SELECT * FROM master_golongan_darah ORDER BY IdGolDarah ASC");
        if ($QueryGolDarah && mysqli_num_rows($QueryGolDarah) > 0) {
            while ($DataGolDarah = mysqli_fetch_assoc($QueryGolDarah)) {
                $IdGolDarahOption = $DataGolDarah['IdGolDarah'];
                // column name is `Golongan`
                $GolDarahOption = $DataGolDarah['Golongan'];
        ?>
            <option value="<?php echo $IdGolDarahOption; ?>"><?php echo $GolDarahOption; ?></option>
        <?php 
            }
        }
        ?>
    </select>
<?php } else {
?>
    <select name="GolDarah" id="GolDarah" style="width: 100%;" class="select2_goldarah form-control" required>
        <option value="<?php echo $GolDarah; ?>"><?php echo $EditGolDarah; ?></option>
        <?php
        $QueryGolDarah = mysqli_query($db, "SELECT * FROM master_golongan_darah WHERE IdGolDarah <> '$GolDarah' ORDER BY IdGolDarah ASC");
        if ($QueryGolDarah && mysqli_num_rows($QueryGolDarah) > 0) {
            while ($DataGolDarah = mysqli_fetch_assoc($QueryGolDarah)) {
                $IdGolDarahOption = $DataGolDarah['IdGolDarah'];
                $GolDarahOption = $DataGolDarah['Golongan'];
        ?>
            <option value="<?php echo $IdGolDarahOption; ?>"><?php echo $GolDarahOption; ?></option>
        <?php 
            }
        }
        ?>
    </select>
<?php } ?>