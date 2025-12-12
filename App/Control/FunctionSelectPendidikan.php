<?php 
// Definisi dan validasi variabel di awal file
$IdPendidikan = isset($_GET['IdPendidikan']) ? mysqli_real_escape_string($db, $_GET['IdPendidikan']) : '';

// Inisialisasi variabel default
$JenjangPendidikan = '';
$selectedPendidikan = null;

// Mode 1: Jika ada parameter IdPendidikan (Edit Mode)
if (!empty($IdPendidikan)) {
    $selectedQuery = mysqli_query($db, "SELECT * FROM master_pendidikan WHERE IdPendidikan = '$IdPendidikan'");
    
    if ($selectedQuery && mysqli_num_rows($selectedQuery) > 0) {
        $selectedPendidikan = mysqli_fetch_assoc($selectedQuery);
        $JenjangPendidikan = $selectedPendidikan['JenisPendidikan'] ?? '';
    }
}
?>

<?php if (empty($IdPendidikan)) { ?>
    <select name="Pendidikan" id="Pendidikan" style="width: 100%;" class="select2_pendidikan form-control" required>
        <option value="">Pilih Pendidikan</option>
        <?php
        $QueryPendidikan = mysqli_query($db, "SELECT * FROM master_pendidikan ORDER BY IdPendidikan ASC");
        if ($QueryPendidikan && mysqli_num_rows($QueryPendidikan) > 0) {
            while ($DataPendidikan = mysqli_fetch_assoc($QueryPendidikan)) {
                $IdPendidikanOption = $DataPendidikan['IdPendidikan'];
                $PendidikanOption = $DataPendidikan['JenisPendidikan'];
        ?>
            <option value="<?php echo $IdPendidikanOption; ?>"><?php echo $PendidikanOption; ?></option>
        <?php 
            }
        }
        ?>
    </select>
<?php } else { ?>
    <select name="Pendidikan" id="Pendidikan" style="width: 100%;" class="select2_pendidikan form-control" required>
        <option value="<?php echo $IdPendidikan; ?>"><?php echo $JenjangPendidikan; ?></option>
        <?php
        $QueryPendidikan = mysqli_query($db, "SELECT * FROM master_pendidikan WHERE IdPendidikan <> '$IdPendidikan' ORDER BY IdPendidikan ASC");
        if ($QueryPendidikan && mysqli_num_rows($QueryPendidikan) > 0) {
            while ($DataPendidikan = mysqli_fetch_assoc($QueryPendidikan)) {
                $IdPendidikanOption = $DataPendidikan['IdPendidikan'];
                $PendidikanOption = $DataPendidikan['JenisPendidikan'];
        ?>
            <option value="<?php echo $IdPendidikanOption; ?>"><?php echo $PendidikanOption; ?></option>
        <?php 
            }
        }
        ?>
    </select>
<?php } ?>