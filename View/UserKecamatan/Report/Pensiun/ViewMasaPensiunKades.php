<?php
$IdKec = $_SESSION['IdKecamatan'];
$QueryKecamatan = mysqli_query($db, "SELECT * FROM master_kecamatan WHERE IdKecamatan = '$IdKec' ");
$DataQuery = mysqli_fetch_assoc($QueryKecamatan);
$Kecamatan = $DataQuery['Kecamatan'];
?>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Data Kepala Desa Mendekati Masa Pensiun Kecamatan <?php echo $Kecamatan; ?></h2>
    </div>
    <div class="col-lg-2">

    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">

    <div class="col-lg-12">
        <div class="ibox ">

            <form action="UserKecamatan/Report/Pensiun/PdfMasaPensiunKecamatanKades" method="GET"
                enctype="multipart/form-data" target="_BLANK">
                <button type="submit" name="Proses" value="Proses" class="btn btn-outline btn-primary">Cetak
                    PDF</button>
                <?php
                if (isset($_POST['Proses'])) {
                    $QueryKecamatan = mysqli_query($db, "SELECT * FROM master_kecamatan WHERE IdKecamatan ='$IdKec' ");
                    $DataKecamatan = mysqli_fetch_assoc($QueryKecamatan);
                    $NamaKecamatan = $DataKecamatan['Kecamatan'];

                    ?>
                <?php } ?>
            </form>
        </div>
    </div>

    <div class="col-lg-12">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>List Semua Data Kades Mendekati Masa Pensiun</h5>
                <div class="ibox-tools">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-wrench"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="#" class="dropdown-item">Config option 1</a>
                        </li>
                        <li><a href="#" class="dropdown-item">Config option 2</a>
                        </li>
                    </ul>
                    <a class="close-link">
                        <i class="fa fa-times"></i>
                    </a>
                </div>
            </div>

            <div class="ibox-content">
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
                            $QueryPegawai = mysqli_query($db, "SELECT
                                            master_pegawai.IdPegawaiFK,
                                            master_pegawai.Foto,
                                            master_pegawai.NIK,
                                            master_pegawai.Nama,
                                            master_pegawai.TanggalLahir,
                                            master_pegawai.JenKel,
                                            master_pegawai.IdDesaFK,
                                            master_pegawai.Alamat,
                                            master_pegawai.RT,
                                            master_pegawai.RW,
                                            master_pegawai.Lingkungan,
                                            master_pegawai.Kecamatan AS Kec,
                                            master_pegawai.Kabupaten,
                                            master_pegawai.Setting,
                                            master_pegawai.TanggalPensiun,
                                            master_desa.IdDesa,
                                            master_desa.NamaDesa,
                                            master_desa.IdKecamatanFK,
                                            master_kecamatan.IdKecamatan,
                                            master_kecamatan.Kecamatan,
                                            master_kecamatan.IdKabupatenFK,
                                            master_setting_profile_dinas.IdKabupatenProfile,
                                            master_setting_profile_dinas.Kabupaten,
                                            main_user.IdPegawai,
                                            main_user.IdLevelUserFK,
                                            history_mutasi.IdPegawaiFK,
                                            history_mutasi.Setting,
											history_mutasi.TanggalMutasi,
                                            master_jabatan.IdJabatan,
                                            history_mutasi.IdJabatanFK,
                                            master_jabatan.Jabatan,
                                            master_pegawai.StatusPensiunDesa,
                                            master_pegawai.StatusPensiunKecamatan,
                                            master_pegawai.IdFilePengajuanPensiunFK
                                        FROM
                                            master_pegawai
                                            LEFT JOIN
                                            master_desa
                                            ON
                                                master_pegawai.IdDesaFK = master_desa.IdDesa
                                            LEFT JOIN
                                            master_kecamatan
                                            ON
                                                master_desa.IdKecamatanFK = master_kecamatan.IdKecamatan
                                            LEFT JOIN
                                            master_setting_profile_dinas
                                            ON
                                                master_kecamatan.IdKabupatenFK = master_setting_profile_dinas.IdKabupatenProfile
                                            INNER JOIN
                                            main_user
                                            ON
                                                main_user.IdPegawai = master_pegawai.IdPegawaiFK
                                            INNER JOIN
                                            history_mutasi
                                            ON
                                                master_pegawai.IdPegawaiFK = history_mutasi.IdPegawaiFK
                                            INNER JOIN
                                            master_jabatan
                                            ON
                                                history_mutasi.IdJabatanFK = master_jabatan.IdJabatan
                                        WHERE
                                            master_pegawai.Setting = 1 AND
                                            main_user.IdLevelUserFK <> 1 AND
                                            main_user.IdLevelUserFK <> 2 AND
                                            history_mutasi.IdJabatanFK = 1 AND
                                            history_mutasi.Setting = 1 AND
                                            master_kecamatan.IdKecamatan = '$IdKec'
                                        ORDER BY
                                            master_pegawai.TanggalPensiun ASC");
                            while ($DataPegawai = mysqli_fetch_assoc($QueryPegawai)) {
                                $IdPegawaiFK = $DataPegawai['IdPegawaiFK'];
                                $Foto = $DataPegawai['Foto'];
                                $NIK = $DataPegawai['NIK'];
                                $Nama = $DataPegawai['Nama'];
                                $Jabatan = $DataPegawai['Jabatan'];

                                $TanggalLahir = $DataPegawai['TanggalLahir'];
                                $exp = explode('-', $TanggalLahir);
                                $ViewTglLahir = $exp[2] . "-" . $exp[1] . "-" . $exp[0];

                                $TanggalMutasi = $DataPegawai['TanggalMutasi'];
                                $exp1 = explode('-', $TanggalMutasi);
                                $ViewTglMutasi = $exp1[2] . "-" . $exp1[1] . "-" . $exp1[0];
                                // $AddTahun = $exp1[0] + 6;
                            
                                $TanggalPensiun = date('Y-m-d', strtotime('+6 year', strtotime($TanggalMutasi)));
                                $ViewTglPensiun = date('d-m-Y', strtotime($TanggalPensiun));

                                $TglPensiun = date_create($TanggalPensiun);
                                $TglSekarang = date_create();
                                $Temp = date_diff($TglSekarang, $TglPensiun);


                                $TglSekarang1 = date('Y-m-d');

                                if ($TglSekarang1 >= $TanggalPensiun) {
                                    $HasilTahun = 0 . ' Tahun ';
                                    $HasilBulan = 0 . ' Bulan ';
                                    $HasilHari = 0 . ' Hari ';
                                } elseif ($TglSekarang1 < $TanggalPensiun) {
                                    $HasilTahun = $Temp->y . ' Tahun ';
                                    $HasilBulan = $Temp->m . ' Bulan ';
                                    $HasilHari = $Temp->d + 1 . ' Hari ';
                                }
                                //SELESAI
                            
                                $JenKel = $DataPegawai['JenKel'];
                                $NamaDesa = $DataPegawai['NamaDesa'];
                                $Kecamatan = $DataPegawai['Kecamatan'];
                                $Kabupaten = $DataPegawai['Kabupaten'];
                                $Alamat = $DataPegawai['Alamat'];
                                $RT = $DataPegawai['RT'];
                                $RW = $DataPegawai['RW'];

                                $Lingkungan = $DataPegawai['Lingkungan'];
                                $AmbilDesa = mysqli_query($db, "SELECT * FROM master_desa WHERE IdDesa = '$Lingkungan' ");
                                $LingkunganBPD = mysqli_fetch_assoc($AmbilDesa);
                                $Komunitas = $LingkunganBPD['NamaDesa'];

                                $KecamatanBPD = $DataPegawai['Kec'];
                                $AmbilKecamatan = mysqli_query($db, "SELECT * FROM master_kecamatan WHERE IdKecamatan = '$KecamatanBPD' ");
                                $KecamatanBPD = mysqli_fetch_assoc($AmbilKecamatan);
                                $KomunitasKec = $KecamatanBPD['Kecamatan'];

                                $Address = $Alamat . " RT." . $RT . "/RW." . $RW . " " . $Komunitas . " Kecamatan " . $KomunitasKec;
                                $Setting = $DataPegawai['Setting'];
                                
                                $StatusPensiunDesa = $DataPegawai['StatusPensiunDesa'];
                                $StatusPensiunKecamatan = $DataPegawai['StatusPensiunKecamatan'];
                                $IdFilePengajuanPensiunFK = $DataPegawai['IdFilePengajuanPensiunFK'];
                                ?>

                                <tr class="gradeX">
                                    <td>
                                        <?php echo $Nomor; ?>
                                    </td>

                                    <?php
                                    if (empty($Foto)) {
                                        ?>
                                        <td>
                                            <img style="width:80px; height:auto" alt="image" class="message-avatar"
                                                src="../Vendor/Media/Pegawai/no-image.jpg">
                                        </td>
                                    <?php } else { ?>
                                        <td>
                                            <img style="width:80px; height:auto" alt="image" class="message-avatar"
                                                src="../Vendor/Media/Pegawai/<?php echo $Foto; ?>">
                                        </td>
                                    <?php } ?>

                                    <td style="width:130px;">
                                        <?php echo $NIK; ?></a>
                                    </td>
                                    <td>
                                        <strong><?php echo $Nama; ?></strong><br>
                                        <strong><?php echo $Jabatan ?></strong><br><br>
                                        <?php echo $Address; ?>
                                    </td>
                                    <td style="width:110px;">
                                        <?php echo $ViewTglLahir; ?><br>
                                        <?php
                                        $QueryJenKel = mysqli_query($db, "SELECT * FROM master_jenkel WHERE IdJenKel = '$JenKel' ");
                                        $DataJenKel = mysqli_fetch_assoc($QueryJenKel);
                                        $JenisKelamin = $DataJenKel['Keterangan'];
                                        echo $JenisKelamin;
                                        ?>
                                    </td>
                                    <td>
                                        <?php echo $ViewTglMutasi; ?><br>
                                    </td>
                                    <td style="width:160px;">
                                        <?php echo $ViewTglPensiun; ?><br>
                                        <?php echo $HasilTahun . " " . $HasilBulan . " " . $HasilHari; ?>
                                    </td>
                                    <td>
                                        <?php
                                        if ($TglSekarang1 >= $TanggalPensiun && $Setting == 1) {
                                            ?>
                                            <?php
                                            if (!is_null($IdFilePengajuanPensiunFK) && $StatusPensiunDesa === '1') {
                                                $qFile = mysqli_query($db, "SELECT * FROM file WHERE IdFile = '$IdFilePengajuanPensiunFK'");
                                                $dataFile = mysqli_fetch_assoc($qFile);
                                                ?>
                                                <a href="../Module/File/ViewFilePengajuan.php?id=<?= $IdFilePengajuanPensiunFK ?>"
                                                    target="_blank" class="btn btn-xs btn-info" style="margin-bottom:5px;">
                                                    Lihat File Pengajuan
                                                </a>
                                                <?php
                                            } else if (!is_null($IdFilePengajuanPensiunFK) && $StatusPensiunDesa === null) {
                                                ?>
                                                    <a href="#"><span class="label label-warning float-left">MENUNGGU PERSETUJUAN
                                                            DESA</span></a>
                                                <?php
                                            } else if ($StatusPensiunDesa === '0') {
                                                ?>
                                                        <a href="#"><span class="label label-danger float-left">PENGAJUAN DITOLAK
                                                                DESA</span></a>
                                                <?php
                                            } else {
                                                ?>
                                                        <a href="#"><span class="label label-danger float-left">PENSIUN BELUM
                                                                MENGAJUKAN</span></a>
                                                <?php
                                            }

                                            if (is_null($StatusPensiunKecamatan) && !is_null($IdFilePengajuanPensiunFK) && $StatusPensiunDesa === '1') {
                                                ?>
                                                <form method="POST"
                                                    action="UserKecamatan/Report/Pensiun/UpdateStatusPengajuanKec.php"
                                                    style="margin-top: 5px;">
                                                    <input type="hidden" name="IdPegawaiFK" value="<?= $IdPegawaiFK ?>">
                                                    <button type="submit" name="setujui"
                                                        class="btn btn-xs btn-success">Setujui</button>
                                                    <button type="submit" name="tolak" class="btn btn-xs btn-danger">Tolak</button>
                                                </form>
                                                <?php
                                            } else if ($StatusPensiunKecamatan === '1') {
                                                echo "<span class='label label-success'>Disetujui Kecamatan</span>";
                                            } elseif ($StatusPensiunKecamatan === '0') {
                                                echo "<span class='label label-danger'>Ditolak Kecamatan</span>";
                                            }

                                        } else {
                                            echo "BELUM PENSIUN";
                                        }
                                        ?>
                                    </td>

                                    <td>
                                        <?php echo $NamaDesa; ?><br>
                                        <?php echo $Kecamatan; ?><br>
                                        <?php echo $Kabupaten; ?>
                                    </td>
                                </tr>
                                <?php $Nomor++;
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>