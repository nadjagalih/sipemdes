<?php
// Definisi dan validasi variabel
$JenKel = isset($_GET['JenKel']) ? mysqli_real_escape_string($db, $_GET['JenKel']) : '';
$EditJenKel = '';

// Mode edit: ambil data jenis kelamin yang dipilih
if (!empty($JenKel)) {
    $queryEdit = mysqli_query($db, "SELECT * FROM master_jenkel WHERE IdJenKel = '$JenKel'");
    if ($queryEdit && mysqli_num_rows($queryEdit) > 0) {
        $dataEdit = mysqli_fetch_assoc($queryEdit);
        $EditJenKel = $dataEdit['Keterangan'] ?? '';
    }
}

if (empty($JenKel)) {
?>
    <select name="JenKel" id="JenKel" style="width: 100%;" class="select2_jenkel form-control" required>
        <option value="">Pilih Jenis Kelamin</option>
        <?php
        $QueryJenKel = mysqli_query($db, "SELECT * FROM master_jenkel ORDER BY IdJenKel ASC");
        if ($QueryJenKel && mysqli_num_rows($QueryJenKel) > 0) {
            while ($DataJenKel = mysqli_fetch_assoc($QueryJenKel)) {
                $IdJenKelOption = $DataJenKel['IdJenKel'];
                $JenKelOption = $DataJenKel['Keterangan'];
        ?>
            <option value="<?php echo $IdJenKelOption; ?>"><?php echo $JenKelOption; ?></option>
        <?php 
            }
        }
        ?>
    </select>
<?php } else {
?>
    <select name="JenKel" id="JenKel" style="width: 100%;" class="select2_jenkel form-control" required>
        <option value="<?php echo $JenKel; ?>"><?php echo $EditJenKel; ?></option>
        <?php
        $QueryJenKel = mysqli_query($db, "SELECT * FROM master_jenkel WHERE IdJenKel <> '$JenKel' ORDER BY IdJenKel ASC");
        if ($QueryJenKel && mysqli_num_rows($QueryJenKel) > 0) {
            while ($DataJenKel = mysqli_fetch_assoc($QueryJenKel)) {
                $IdJenKelOption = $DataJenKel['IdJenKel'];
                $JenKelOption = $DataJenKel['Keterangan'];
        ?>
            <option value="<?php echo $IdJenKelOption; ?>"><?php echo $JenKelOption; ?></option>
        <?php 
            }
        }
        ?>
    </select>
<?php } ?>