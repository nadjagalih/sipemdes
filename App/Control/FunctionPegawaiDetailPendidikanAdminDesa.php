<?php
if (isset($_GET['Kode'])) {
    $IdTemp = sql_url($_GET['Kode']);
    $Nomor = 1;
    $QueryPendidikan = mysqli_query($db, "SELECT
master_pegawai.IdPegawaiFK,
history_pendidikan.IdPegawaiFK,
history_pendidikan.IdPendidikanFK,
history_pendidikan.IdPendidikanPegawai,
history_pendidikan.NamaSekolah,
history_pendidikan.Jurusan,
history_pendidikan.Setting,
history_pendidikan.TahunMasuk,
history_pendidikan.TahunLulus,
master_pendidikan.IdPendidikan,
master_pegawai.NIK,
master_pegawai.Nama,
master_pendidikan.JenisPendidikan
FROM
master_pegawai
INNER JOIN history_pendidikan ON master_pegawai.IdPegawaiFK = history_pendidikan.IdPegawaiFK
INNER JOIN master_pendidikan ON history_pendidikan.IdPendidikanFK = master_pendidikan.IdPendidikan
WHERE history_pendidikan.IdPegawaiFK = '$IdTemp'
ORDER BY
master_pegawai.IdPegawaiFK ASC,
master_pendidikan.IdPendidikan DESC");
    while ($DataPendidikan = mysqli_fetch_assoc($QueryPendidikan)) {
        $IdPendidikanV = $DataPendidikan['IdPendidikanPegawai'];
        $NamaSekolah = $DataPendidikan['NamaSekolah'];
        $Jurusan = $DataPendidikan['Jurusan'];
        $JenjangPendidikan = $DataPendidikan['JenisPendidikan'];
        $Setting = $DataPendidikan['Setting'];
        $Masuk = $DataPendidikan['TahunMasuk'];
        $Lulus = $DataPendidikan['TahunLulus'];

?>
        <tr class="gradeX">
            <td>
                <?php echo $Nomor; ?>
            </td>
            <td>
                <?php echo $JenjangPendidikan; ?>

            </td>
            <td>
                <?php echo $NamaSekolah; ?>
            </td>
            <td>
                <?php echo $Jurusan; ?>
            </td>
            <td>
                <?php echo $Masuk; ?> - <?php echo $Lulus; ?>
            </td>
            <td>
                <?php if ($Setting == 0) { ?>
                    <a href="../App/Model/ExcPegawaiPendidikanAdminDesa?Act=SettingOn&Kode=<?php echo $IdPendidikanV; ?>">
                        <span class="label label-warning float-left">NON AKTIF</span>
                    </a><?php } elseif ($Setting == 1) { ?>
                    <span class="label label-success float-left">AKTIF</span>
                <?php } ?>
            </td>
            <td>
                <a href="?pg=PegawaiEditPendidikanAdminDesa&Kode=<?php echo $IdPendidikanV; ?>">
                    <button class="btn btn-outline btn-success btn-xs" data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i></button>
                </a>
                <a href="../App/Model/ExcPegawaiPendidikanAdminDesa?Act=Delete&Kode=<?php echo $IdPendidikanV; ?>" onclick="return confirm('Anda yakin ingin menghapus : <?php echo $NamaSekolah; ?> ?');">
                    <button class="btn btn-outline btn-danger  btn-xs " data-toggle="tooltip" title="Delete"><i class="fa fa-eraser"></i></button>
                </a>
            </td>
        </tr>
<?php $Nomor++;
    }
}
?>