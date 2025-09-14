<?php
$IdDesa = $_SESSION['IdDesa'];
$Nomor = 1;
$QueryPegawai = mysqli_query($db, "SELECT
master_pegawai_bpd.IdPegawaiFK,
master_pegawai_bpd.Foto,
master_pegawai_bpd.NIK,
master_pegawai_bpd.Nama,
master_pegawai_bpd.TanggalLahir,
master_pegawai_bpd.JenKel,
master_pegawai_bpd.IdDesaFK,
master_pegawai_bpd.Alamat,
master_pegawai_bpd.RT,
master_pegawai_bpd.RW,
master_pegawai_bpd.Lingkungan,
master_pegawai_bpd.Kecamatan AS Kec,
master_pegawai_bpd.Kabupaten,
master_pegawai_bpd.NoTelp,
master_desa.IdDesa,
master_desa.NamaDesa,
master_desa.IdKecamatanFK,
master_kecamatan.IdKecamatan,
master_kecamatan.Kecamatan,
master_kecamatan.IdKabupatenFK,
master_setting_profile_dinas.IdKabupatenProfile,
master_setting_profile_dinas.Kabupaten
FROM master_pegawai_bpd
LEFT JOIN master_desa ON master_pegawai_bpd.IdDesaFK = master_desa.IdDesa
LEFT JOIN master_kecamatan ON master_desa.IdKecamatanFK = master_kecamatan.IdKecamatan
LEFT JOIN master_setting_profile_dinas ON master_kecamatan.IdKabupatenFK = master_setting_profile_dinas.IdKabupatenProfile
WHERE master_desa.IdDesa = '$IdDesa'
ORDER BY
master_kecamatan.IdKecamatan ASC,
master_desa.NamaDesa ASC");
while ($DataPegawai = mysqli_fetch_assoc($QueryPegawai)) {
    $IdPegawaiFK = $DataPegawai['IdPegawaiFK'];
    $Foto = $DataPegawai['Foto'];
    $NIK = $DataPegawai['NIK'];
    $Nama = $DataPegawai['Nama'];
    $TanggalLahir = $DataPegawai['TanggalLahir'];
    $exp = explode('-', $TanggalLahir);
    $ViewTglLahir = $exp[2] . "-" . $exp[1] . "-" . $exp[0];
    $JenKel = $DataPegawai['JenKel'];
    $NamaDesa = $DataPegawai['NamaDesa'];
    $Kecamatan = $DataPegawai['Kecamatan'];
    $Kabupaten = $DataPegawai['Kabupaten'];
    $Alamat = $DataPegawai['Alamat'];
    $RT = $DataPegawai['RT'];
    $RW = $DataPegawai['RW'];
    $NoTelp = $DataPegawai['NoTelp'];

    $Lingkungan = $DataPegawai['Lingkungan'];
    $AmbilDesa = mysqli_query($db, "SELECT * FROM master_desa WHERE IdDesa = '$Lingkungan' ");
    $LingkunganBPD = mysqli_fetch_assoc($AmbilDesa);
    $Komunitas = $LingkunganBPD['NamaDesa'];

    $KecamatanBPD = $DataPegawai['Kec'];
    $AmbilKecamatan = mysqli_query($db, "SELECT * FROM master_kecamatan WHERE IdKecamatan = '$KecamatanBPD' ");
    $KecamatanBPD = mysqli_fetch_assoc($AmbilKecamatan);
    $KomunitasKec = $KecamatanBPD['Kecamatan'];

    $Address = $Alamat . " RT." . $RT . "/RW." . $RW . " " . $Komunitas . " Kecamatan " . $KomunitasKec;

    // Set default values untuk BPD (Badan Permusyawaratan Desa)
    $Pendidikan = '-'; // Akan diupdate nanti jika ada sistem pendidikan khusus BPD
    $Jabatan = 'Anggota BPD'; // Default jabatan untuk BPD
?>

    <tr class="gradeX">
        <td>
            <?php echo $Nomor; ?>
        </td>

        <?php
        if (empty($Foto)) {
        ?>
            <td>
                <a href="?pg=BPDViewFotoAdminDesa&Kode=<?php echo $IdPegawaiFK; ?>" title="Edit Foto"><img style="width:80px; height:auto" alt="image" class="message-avatar" src="../Vendor/Media/Pegawai/no-image.jpg"></a>
            </td>
        <?php } else { ?>
            <td>
                <a href="?pg=BPDViewFotoAdminDesa&Kode=<?php echo $IdPegawaiFK; ?>" title="Edit Foto"><img style="width:80px; height:auto" alt="image" class="message-avatar" src="../Vendor/Media/Pegawai/<?php echo $Foto; ?>"></a>
            </td>
        <?php } ?>

        <td>
            <?php echo $NIK; ?>
        </td>
        <td>
            <strong><?php echo $Nama; ?></strong><br><br>
            <?php echo $Address; ?>
        </td>

        <td>
            <?php echo $Pendidikan; ?>
        </td>
        <td>
            <?php echo $ViewTglLahir; ?><br>
            <?php
            $QueryJenKel = mysqli_query($db, "SELECT * FROM master_jenkel WHERE IdJenKel = '$JenKel' ");
            $DataJenKel = mysqli_fetch_assoc($QueryJenKel);
            $JenisKelamin = $DataJenKel['Keterangan'];
            echo $JenisKelamin;
            ?>
        </td>
        <td>
            <?php echo !empty($NoTelp) ? $NoTelp : '-'; ?>
        </td>
        <td>
            <?php echo $NamaDesa; ?><br>
            <?php echo $Kecamatan; ?><br>
            <?php echo $Kabupaten; ?>
        </td>

        <td>
            <?php echo $Jabatan; ?>
        </td>

        <td>
            <?php if ($IdPegawaiFK == $_SESSION['IdUser']) { ?>
                <div class="btn-group">
                    <button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-cog"></i> Aksi
                    </button>
                    <ul class="dropdown-menu dropdown-menu-right">
                        <li>
                            <a href="?pg=PegawaiViewPendidikanAdminDesa&Kode=<?php echo $IdPegawaiFK; ?>" class="dropdown-item">
                                <i class="fa fa-graduation-cap"></i> Pendidikan
                            </a>
                        </li>
                        <li>
                            <a href="?pg=ViewMutasiAdminDesa&Kode=<?php echo $IdPegawaiFK; ?>" class="dropdown-item">
                                <i class="fa fa-exchange"></i> Mutasi
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="?pg=PegawaiDetailAdminDesa&Kode=<?php echo $IdPegawaiFK; ?>" class="dropdown-item">
                                <i class="fa fa-eye"></i> Detail
                            </a>
                        </li>
                    </ul>
                </div>
            <?php } else { ?>
                <!-- Action buttons dan dropdown untuk user lain -->
                <div class="btn-group" role="group">
                    <a href="?pg=PegawaiBPDEditAdminDesa&Kode=<?php echo $IdPegawaiFK; ?>">
                        <button class="btn btn-outline btn-success btn-xs" data-toggle="tooltip" title="Edit Data"><i class="fa fa-edit"></i></button>
                    </a>
                    <a href="../App/Model/ExcPegawaiBPDAdminDesa?Act=Delete&Kode=<?php echo $IdPegawaiFK; ?>" onclick="return confirm('Anda yakin ingin menghapus : <?php echo $Nama; ?> ?');">
                        <button class="btn btn-outline btn-danger btn-xs" data-toggle="tooltip" title="Hapus Data"><i class="fa fa-eraser"></i></button>
                    </a>
                </div>
            <?php } ?>
        </td>
    </tr>
<?php $Nomor++;
}
?>