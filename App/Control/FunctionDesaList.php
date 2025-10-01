<?php
$Nomor = 1;
$QueryDesa = mysqli_query($db, "SELECT
master_desa.IdDesa,
master_desa.KodeDesa,
master_desa.NamaDesa,
master_desa.IdKecamatanFK,
master_desa.IdKabupatenFK,
master_desa.AlamatDesa,
master_kecamatan.IdKecamatan,
master_kecamatan.Kecamatan,
master_setting_profile_dinas.IdKabupatenProfile,
master_setting_profile_dinas.Kabupaten
FROM
master_setting_profile_dinas
INNER JOIN master_desa ON master_setting_profile_dinas.IdKabupatenProfile = master_desa.IdKabupatenFK
INNER JOIN master_kecamatan ON master_kecamatan.IdKecamatan = master_desa.IdKecamatanFK
ORDER BY
master_desa.IdKecamatanFK ASC,
master_desa.NamaDesa ASC");
while ($DataDesa = mysqli_fetch_assoc($QueryDesa)) {
    $IdDesa = $DataDesa['IdDesa'];
    $KodeDesa = $DataDesa['KodeDesa'];
    $Desa = $DataDesa['NamaDesa'];
    $Kecamatan = $DataDesa['Kecamatan'];
    $Kabupaten = $DataDesa['Kabupaten'];
    $AlamatDesa = $DataDesa['AlamatDesa'];
?>
    <tr class="gradeX">
        <td>
            <?php echo $Nomor; ?>
        </td>
        <!--<td>
            <?php echo $KodeDesa; ?>
        </td>-->
        <td>
            <?php echo $Desa; ?>
        </td>
        <td>
            <?php echo $Kecamatan; ?>
        </td>
        <td>
            <?php echo $Kabupaten; ?>
        </td>
        <td>
            <?php if ($AlamatDesa == 'Data Tidak Ditemukan' || empty($AlamatDesa)) {
                echo '<span style="color: red; font-weight: 500; font-size: 0.85em; font-style: italic;" title="Belum di set">Belum di set</span>';
            } else {
                echo $AlamatDesa;
            } ?>
        </td>
        <td>
            <a href="?pg=DesaEdit&Kode=<?php echo $IdDesa; ?>">
                <button class="btn btn-outline btn-success btn-xs" data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i></button>
            </a>
            <a href="../App/Model/ExcDesa?Act=Delete&Kode=<?php echo $IdDesa; ?>" onclick="return confirm('Anda yakin ingin menghapus : <?php echo $Desa; ?> ?');">
                <button class="btn btn-outline btn-danger  btn-xs " data-toggle="tooltip" title="Delete"><i class="fa fa-eraser"></i></button>
            </a>
        </td>
    </tr>
<?php $Nomor++;
}
?>