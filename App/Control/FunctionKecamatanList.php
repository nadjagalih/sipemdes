<?php
$Nomor = 1;
$QueryKecamatan = mysqli_query($db, "SELECT
master_kecamatan.IdKecamatan,
master_kecamatan.KodeKecamatan,
master_kecamatan.Kecamatan,
master_kecamatan.IdKabupatenFK,
master_setting_profile_dinas.IdKabupatenProfile,
master_setting_profile_dinas.Kabupaten
FROM master_kecamatan
INNER JOIN master_setting_profile_dinas ON master_kecamatan.IdKabupatenFK = master_setting_profile_dinas.IdKabupatenProfile
GROUP BY master_kecamatan.IdKecamatan
ORDER BY master_kecamatan.Kecamatan ASC");
while ($DataKecamatan = mysqli_fetch_assoc($QueryKecamatan)) {
    $IdKecamatan = $DataKecamatan['IdKecamatan'];
    $KodeKecamatan = $DataKecamatan['KodeKecamatan'];
    $Kecamatan = $DataKecamatan['Kecamatan'];
    $Kabupaten = $DataKecamatan['Kabupaten'];
?>
    <tr class="gradeX">
        <td>
            <?php echo $Nomor; ?>
        </td>
        <td>
            <?php echo $KodeKecamatan; ?>
        </td>
        <td>
            <?php echo $Kecamatan; ?>
        </td>
        <td>
            <?php echo $Kabupaten; ?>
        </td>
        <td>
            <a href="?pg=KecamatanEdit&Kode=<?php echo $IdKecamatan; ?>">
                <button class="btn btn-outline btn-success btn-xs" data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i></button>
            </a>
            <a href="../App/Model/ExcKecamatan?Act=Delete&Kode=<?php echo $IdKecamatan; ?>" onclick="return confirm('Anda yakin ingin menghapus : <?php echo $Kecamatan; ?> ?');">
                <button class="btn btn-outline btn-danger  btn-xs " data-toggle="tooltip" title="Delete"><i class="fa fa-eraser"></i></button>
            </a>
        </td>
    </tr>
<?php $Nomor++;
}
?>