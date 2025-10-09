<?php
// Definisi dan validasi variabel
$EditIdKecamatan = isset($_GET['EditIdKecamatan']) ? mysqli_real_escape_string($db, $_GET['EditIdKecamatan']) : '';
$EditNamaKecamatan = '';

// Mode edit: ambil data kecamatan yang dipilih
if (!empty($EditIdKecamatan)) {
    $queryEdit = mysqli_query($db, "SELECT * FROM master_kecamatan WHERE IdKecamatan = '$EditIdKecamatan'");
    if ($queryEdit && mysqli_num_rows($queryEdit) > 0) {
        $dataEdit = mysqli_fetch_assoc($queryEdit);
        $EditNamaKecamatan = $dataEdit['Kecamatan'] ?? '';
    }
}

if (empty($EditIdKecamatan)) {
?>
    <select name="IdKecamatan" id="IdKecamatan" style="width: 100%;" class="select2_kecamatan form-control" required>
        <option value="">Pilih Kecamatan</option>
        <?php
        $QueryKecamatan = mysqli_query($db, "SELECT * FROM master_kecamatan ORDER BY Kecamatan ASC");
        if ($QueryKecamatan && mysqli_num_rows($QueryKecamatan) > 0) {
            while ($DataKecamatan = mysqli_fetch_assoc($QueryKecamatan)) {
                $IdKecamatanOption = $DataKecamatan['IdKecamatan'];
                $KecamatanOption = $DataKecamatan['Kecamatan'];
        ?>
            <option value="<?php echo $IdKecamatanOption; ?>"><?php echo $KecamatanOption; ?></option>
        <?php 
            }
        }
        ?>
    </select>
<?php } else {
?>
    <select name="IdKecamatan" id="IdKecamatan" style="width: 100%;" class="select2_kecamatan form-control" required>
        <option value="<?php echo $EditIdKecamatan; ?>"><?php echo $EditNamaKecamatan; ?></option>
        <?php
        $QueryKecamatan = mysqli_query($db, "SELECT * FROM master_kecamatan WHERE IdKecamatan <> '$EditIdKecamatan' ORDER BY Kecamatan ASC");
        if ($QueryKecamatan && mysqli_num_rows($QueryKecamatan) > 0) {
            while ($DataKecamatan = mysqli_fetch_assoc($QueryKecamatan)) {
                $IdKecamatanOption = $DataKecamatan['IdKecamatan'];
                $KecamatanOption = $DataKecamatan['Kecamatan'];
        ?>
            <option value="<?php echo $IdKecamatanOption; ?>"><?php echo $KecamatanOption; ?></option>
        <?php 
            }
        }
        ?>
    </select>
<?php } ?>