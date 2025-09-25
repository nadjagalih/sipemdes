<?php
session_start();
$_SESSION['visited_pensiun_kecamatan'] = true;
$IdKec = $_SESSION['IdKecamatan'];
$QueryKecamatan = mysqli_query($db, "SELECT * FROM master_kecamatan WHERE IdKecamatan = '$IdKec' ");
$DataQuery = mysqli_fetch_assoc($QueryKecamatan);
$Kecamatan = $DataQuery['Kecamatan'];
?>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Data Perangkat Desa Mendekati Masa Pensiun Kecamatan <?php echo $Kecamatan; ?></h2>
    </div>
    <div class="col-lg-2">

    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">

    <div class="col-lg-12">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>Filter Data Perangkat Desa Mendekati Masa Pensiun</h5>
            </div>

            <div class="ibox-content">

                <div class="text-left">
                    <!-- <a href="?pg=FilterKecamatan">
                        <button type="button" class="btn btn-white" style="width:150px; text-align:center">
                            Filter Kecamatan
                        </button>
                    </a> -->
                    <a href="?pg=FilterDesaKec">
                        <button type="button" class="btn btn-white" style="width:150px; text-align:center">
                            Filter Desa
                        </button>
                    </a>
                    <!-- <a href="?pg=PDFFilterKecamatan">
                        <button type="button" class="btn btn-white" style="width:150px; text-align:center">
                            PDF Kecamatan
                        </button>
                    </a> -->
                    <a href="?pg=PDFFilterDesaKec">
                        <button type="button" class="btn btn-white" style="width:150px; text-align:center">
                            PDF Desa
                        </button>
                    </a>
                    <!-- <a href="Report/Pdf/PdfMasaPensiunFilterKabupaten" target="_BLANK">
                        <button type="button" class="btn btn-white" style="width:150px; text-align:center">
                            PDF Kabupaten
                        </button>
                    </a> -->
                </div>
            </div>
            <br><br><span style="font-style: italic; color:red">*) Laporan Dengan Warna </span><span
                style="background-color: #fecaca;">Background</span> <span style="font-style: italic; color:red">Adalah
                Perangkat Desa Dengan Masa Pensiun Kurang dari 3
                Bulan</span>

        </div>
    </div>


    <div class="col-lg-12">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>List Semua Data Mendekati Masa Pensiun</h5>
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
                                <th>Tanggal Pensiun</th>
                                <th>Sisa Pensiun</th>
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
                                            history_mutasi.IdJabatanFK <> 1 AND
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

                                $TanggalPensiun = $DataPegawai['TanggalPensiun'];
                                $exp1 = explode('-', $TanggalPensiun);
                                $ViewTglPensiun = $exp1[2] . "-" . $exp1[1] . "-" . $exp1[0];

                                //HITUNG DETAIL TANGGAL PENSIUN
                                $TglPensiun = date_create($TanggalPensiun);
                                $TglSekarang = date_create();
                                $Temp = date_diff($TglSekarang, $TglPensiun);

                                //CEK TANGGAL ASLI SAAT INI
                                $TglSekarang1 = Date('Y-m-d');

                                if ($TglSekarang1 >= $TanggalPensiun) {
                                    $HasilTahun = 0 . ' Tahun ';
                                    $HasilBulan = 0 . ' Bulan ';
                                    $HasilHari = 0 . ' Hari ';
                                } elseif ($TglSekarang1 < $TanggalPensiun) {
                                    $TahunInt = $Temp->y;
                                    $BulanInt = $Temp->m;
                                    $HariInt = $Temp->d + 1;

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

                                $highlight = '';
                                if ($TahunInt == 0 && $BulanInt < 3) {
                                    $highlight = 'style="background-color: #fecaca;"';
                                }
                                ?>

                                <tr class="gradeX" <?php echo $highlight; ?>>
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
                                        <?php
                                        echo $ViewTglPensiun;
                                        ?><br>

                                    </td>
                                    <td style="width:160px;">
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