<?php
if (isset($_GET['Kode'])) {
    $IdTemp = sql_url($_GET['Kode']);
    $Nomor = 1;
    $QueryOrtu = mysqli_query($db, "SELECT
hiskel_ortu.IdPegawaiFK,
master_pegawai.IdPegawaiFK,
master_pegawai.Nama AS NamaPegawai,
hiskel_ortu.IdPendidikanFK,
master_pendidikan.IdPendidikan,
hiskel_ortu.IdOrtu,
hiskel_ortu.NIK,
hiskel_ortu.Nama,
hiskel_ortu.Tempat,
hiskel_ortu.TanggalLahir,
hiskel_ortu.StatusHubungan,
hiskel_ortu.JenKel,
master_pendidikan.JenisPendidikan,
hiskel_ortu.Pekerjaan
FROM
hiskel_ortu
INNER JOIN master_pegawai ON master_pegawai.IdPegawaiFK = hiskel_ortu.IdPegawaiFK
INNER JOIN master_pendidikan ON hiskel_ortu.IdPendidikanFK = master_pendidikan.IdPendidikan
WHERE hiskel_ortu.IdPegawaiFK = '$IdTemp'");
    while ($DataOrtu = mysqli_fetch_assoc($QueryOrtu)) {
        $IdOrtu = $DataOrtu['IdOrtu'];
        $NamaPegawai = $DataOrtu['NamaPegawai'];
        $NIK = $DataOrtu['NIK'];
        $Nama = $DataOrtu['Nama'];
        $Tempat = $DataOrtu['Tempat'];

        $TglLahir = $DataOrtu['TanggalLahir'];
        $exp = explode('-', $TglLahir);
        $TanggalLahir = $exp[2] . "-" . $exp[1] . "-" . $exp[0];

        $Hubungan = $DataOrtu['StatusHubungan'];
        $JenKel = $DataOrtu['JenKel'];

        $Pendidikan = $DataOrtu['JenisPendidikan'];
        $Pekerjaan = $DataOrtu['Pekerjaan'];

?>
        <tr class="gradeX">
            <td>
                <?php echo $Nomor; ?>
            </td>
            <td>
                <?php echo $NamaPegawai; ?>
            </td>
            <td>
                <?php echo $NIK; ?>
            </td>
            <td>
                <?php echo $Nama; ?>
            </td>
            <td>
                <?php echo $Tempat; ?><br>
                <?php echo $TanggalLahir; ?>
            </td>
            <td>
                <?php echo $Hubungan; ?><br>
            </td>
            <td>
                <?php
                $QJenKel = mysqli_query($db, "SELECT * FROM master_jenkel WHERE IdJenKel = '$JenKel' ");
                $DataJenKel = mysqli_fetch_assoc($QJenKel);
                echo $JenisKelamin = $DataJenKel['Keterangan'];
                ?>

            </td>
            <td>
                <?php echo $Pendidikan; ?>
            </td>
            <td>
                <?php echo $Pekerjaan; ?>
            </td>
            <td>
                <a href="?pg=PegawaiEditOrtu&Kode=<?php echo $IdOrtu; ?>">
                    <button class="btn btn-outline btn-success btn-xs" data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i></button>
                </a>
                <a href="../App/Model/ExcPegawaiOrtu?Act=Delete&Kode=<?php echo $IdOrtu; ?>" onclick="return confirm('Anda yakin ingin menghapus : <?php echo $Nama; ?> ?');">
                    <button class="btn btn-outline btn-danger  btn-xs " data-toggle="tooltip" title="Delete"><i class="fa fa-eraser"></i></button>
                </a>
            </td>
        </tr>
<?php $Nomor++;
    }
}
?>