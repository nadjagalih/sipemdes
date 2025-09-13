<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$IdDesa = $_SESSION['IdDesa'];
?>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Data Kepala Desa dan Perangkat Desa Mendekati Masa Pensiun</h2>
    </div>
    <div class="col-lg-2"></div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>Data Pensiun Kepala Desa dan Perangkat Desa</h5>
                </div>
                <div class="ibox-content">
                    <div class="text-left mb-3">
                        <a href="AdminDesa/Report/Pdf/MasaPensiunDesaPdfKades" target="_BLANK">
                            <button type="button" class="btn btn-white" style="width:150px; text-align:center">
                                <i class="fa fa-print"></i> Cetak PDF
                            </button>
                        </a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-kecamatan">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Foto</th>
                                    <th>NIK</th>
                                    <th>Nama<br>Jabatan<br>Alamat</th>
                                    <th>Tanggal Lahir<br>Jenis Kelamin</th>
                                    <th>Tanggal Mutasi</th>
                                    <th>Tanggal Pensiun<br>Sisa Pensiun</th>
                                    <th>Keterangan</th>
                                    <th>Unit Kerja<br>Kecamatan<br>Kabupaten</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $Nomor = 1;
                                $QueryGabungan = mysqli_query($db, "SELECT
                                                master_pegawai.*,
                                                master_desa.NamaDesa,
                                                master_kecamatan.Kecamatan,
                                                master_setting_profile_dinas.Kabupaten AS NamaKabupaten,
                                                history_mutasi.TanggalMutasi,
                                                history_mutasi.IdJabatanFK,
                                                master_jabatan.Jabatan
                                            FROM master_pegawai
                                            LEFT JOIN master_desa ON master_pegawai.IdDesaFK = master_desa.IdDesa
                                            LEFT JOIN master_kecamatan ON master_desa.IdKecamatanFK = master_kecamatan.IdKecamatan
                                            LEFT JOIN master_setting_profile_dinas ON master_kecamatan.IdKabupatenFK = master_setting_profile_dinas.IdKabupatenProfile
                                            INNER JOIN main_user ON main_user.IdPegawai = master_pegawai.IdPegawaiFK
                                            INNER JOIN history_mutasi ON master_pegawai.IdPegawaiFK = history_mutasi.IdPegawaiFK
                                            INNER JOIN master_jabatan ON history_mutasi.IdJabatanFK = master_jabatan.IdJabatan
                                            WHERE
                                                master_pegawai.Setting = 1 AND
                                                main_user.IdLevelUserFK NOT IN (1, 2) AND
                                                history_mutasi.Setting = 1 AND
                                                master_pegawai.IdDesaFK = '$IdDesa'
                                            ORDER BY
                                                CASE WHEN history_mutasi.IdJabatanFK = 1 THEN 0 ELSE 1 END,
                                                master_pegawai.TanggalPensiun ASC");

                                while ($Data = mysqli_fetch_assoc($QueryGabungan)) {
                                    $IdPegawaiFK = $Data['IdPegawaiFK'];
                                    $Foto = $Data['Foto'];
                                    $NIK = $Data['NIK'];
                                    $Nama = $Data['Nama'];
                                    $Jabatan = $Data['Jabatan'];
                                    $IdJabatanFK = $Data['IdJabatanFK'];
                                    
                                    $TanggalLahir = $Data['TanggalLahir'];
                                    $ViewTglLahir = date("d-m-Y", strtotime($TanggalLahir));
                                    
                                    $ViewTglMutasi = '-';
                                    if ($IdJabatanFK == 1) { // Logika untuk Kepala Desa
                                        $TanggalMutasi = $Data['TanggalMutasi'];
                                        $ViewTglMutasi = date("d-m-Y", strtotime($TanggalMutasi));
                                        $TanggalPensiun = date('Y-m-d', strtotime('+6 year', strtotime($TanggalMutasi)));
                                    } else { // Logika untuk Perangkat Desa
                                        $TanggalPensiun = $Data['TanggalPensiun'];
                                    }
                                    
                                    $ViewTglPensiun = date('d-m-Y', strtotime($TanggalPensiun));
                                    $TglSekarang1 = date('Y-m-d');
                                    
                                    // HITUNG SISA WAKTU
                                    $TglPensiun_dt = date_create($TanggalPensiun);
                                    $TglSekarang_dt = date_create();
                                    $Temp = date_diff($TglSekarang_dt, $TglPensiun_dt);

                                    $TahunInt = 0; $BulanInt = 0;
                                    if ($TglSekarang1 >= $TanggalPensiun) {
                                        $HasilTahun = '0 Tahun'; $HasilBulan = '0 Bulan'; $HasilHari = '0 Hari';
                                    } else {
                                        $HasilTahun = $Temp->y . ' Tahun';
                                        $HasilBulan = $Temp->m . ' Bulan';
                                        $HasilHari = ($Temp->d + 1) . ' Hari';
                                        $TahunInt = $Temp->y;
                                        $BulanInt = $Temp->m;
                                    }
                                    $SisaPensiun = $HasilTahun . " " . $HasilBulan . " " . $HasilHari;

                                    // LOGIKA HIGHLIGHT DARI KODE ASLI
                                    $highlight = '';
                                    if ($TahunInt == 0 && $BulanInt < 3) {
                                        $highlight = 'style="background-color: #fecaca;"';
                                    }

                                    $JenKel = $Data['JenKel'];
                                    $StatusPensiunDesa = $Data['StatusPensiunDesa'];
                                    $IdFilePengajuanPensiunFK = $Data['IdFilePengajuanPensiunFK'];
                                    $Setting = $Data['Setting'];
                                    
                                    // ALAMAT
                                    $Lingkungan = $Data['Lingkungan'];
                                    $AmbilDesa = mysqli_query($db, "SELECT * FROM master_desa WHERE IdDesa = '$Lingkungan' ");
                                    $LingkunganBPD = mysqli_fetch_assoc($AmbilDesa);
                                    $Komunitas = $LingkunganBPD['NamaDesa'];
                                    
                                    $KecamatanBPD = $Data['Kecamatan']; 
                                    $AmbilKecamatan = mysqli_query($db, "SELECT * FROM master_kecamatan WHERE IdKecamatan = '$KecamatanBPD' ");
                                    $KecamatanBPD = mysqli_fetch_assoc($AmbilKecamatan);
                                    $KomunitasKec = $KecamatanBPD['Kecamatan'];

                                    $Address = $Data['Alamat'] . " RT." . $Data['RT'] . "/RW." . $Data['RW'] . " " . $Komunitas . " Kecamatan " . $KomunitasKec;
                                    ?>
                                    <tr class="gradeX" <?php echo $highlight; ?>>
                                        <td><?php echo $Nomor; ?></td>
                                        <td class="text-center">
                                            <img style="width:80px; height:auto" alt="image" class="message-avatar" src="../Vendor/Media/Pegawai/<?php echo empty($Foto) ? 'no-image.jpg' : $Foto; ?>">
                                        </td>
                                        <td style="width:130px;"><?php echo $NIK; ?></td>
                                        <td>
                                            <strong><?php echo $Nama; ?></strong><br>
                                            <?php
                                            if ($Jabatan == 'Kepala Desa') {
                                                 echo '<strong style="color: #006400;">' . $Jabatan . '</strong>';
                                                 } else {
                                                    echo '<strong>' . $Jabatan . '</strong>';
                                                 }
                                                 ?><br><br>
                                                 <?php echo $Address; ?>
                                        </td>
                                        <td style="width:110px;">
                                            <?php echo $ViewTglLahir; ?><br>
                                            <?php
                                            $QueryJenKel = mysqli_query($db, "SELECT Keterangan FROM master_jenkel WHERE IdJenKel = '$JenKel'");
                                            $DataJenKel = mysqli_fetch_assoc($QueryJenKel);
                                            echo $DataJenKel['Keterangan'];
                                            ?>
                                        </td>
                                        <td><?php echo $ViewTglMutasi; ?></td>
                                        <td style="width:160px;">
                                            <?php echo $ViewTglPensiun; ?><br>
                                            <?php echo $SisaPensiun; ?>
                                        </td>
                                        <td> 
                                            <?php
                                            // LOGIKA KETERANGAN PERSIS SEPERTI FILE ASLI ANDA
                                            if ($TglSekarang1 >= $TanggalPensiun && $Setting == 1) {
                                                if (!is_null($IdFilePengajuanPensiunFK)) {
                                            ?>
                                                    <a href="../Module/File/ViewFilePengajuan.php?id=<?= $IdFilePengajuanPensiunFK ?>" target="_blank" class="btn btn-xs btn-info" style="margin-bottom:5px;">
                                                        Lihat File Pengajuan
                                                    </a>
                                            <?php
                                                } else {
                                            ?>
                                                    <a href="#"><span class="label label-danger float-left">PENSIUN BELUM MENGAJUKAN</span></a>
                                            <?php
                                                }

                                                if ($StatusPensiunDesa === '1') {
                                                    echo "<span class='label label-success'>Disetujui Desa</span>";
                                                } elseif ($StatusPensiunDesa === '0') {
                                                    echo "<span class='label label-danger'>Ditolak Desa</span>";
                                                } elseif (is_null($StatusPensiunDesa) && !is_null($IdFilePengajuanPensiunFK)) {
                                            ?>
                                                    <form method="POST" action="AdminDesa/Report/Pensiun/UpdateStatusPengajuanDesa.php" style="margin-top: 5px;">
                                                        <input type="hidden" name="IdPegawaiFK" value="<?= $IdPegawaiFK ?>">
                                                        <button type="submit" name="setujui" class="btn btn-xs btn-success">Setujui</button>
                                                        <button type="submit" name="tolak" class="btn btn-xs btn-danger">Tolak</button>
                                                    </form>
                                            <?php
                                                } else {
                                                    echo "<span class='label label-warning'>Menunggu Pengajuan</span>";
                                                }
                                            } else {
                                                echo "BELUM PENSIUN";
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php echo $Data['NamaDesa']; ?><br>
                                            <?php echo $Data['Kecamatan']; ?><br>
                                            <?php echo $Data['NamaKabupaten']; ?>
                                        </td>
                                    </tr>
                                    <?php $Nomor++;
                                } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
