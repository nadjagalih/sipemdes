<?php
// Include safe helpers for production-ready error handling
require_once __DIR__ . '/../../../helpers/safe_helpers.php';

$IdKec = safeSession('IdKecamatan');
$QueryKecamatan = mysqli_query($db, "SELECT * FROM master_kecamatan WHERE IdKecamatan = '$IdKec' ");
$DataQuery = mysqli_fetch_assoc($QueryKecamatan);
$Kecamatan = safeGet($DataQuery, 'Kecamatan', 'Unknown');
?>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Data Kepala Desa & Perangkat Desa Kecamatan <?php echo $Kecamatan; ?></h2>
    </div>
    <div class="col-lg-2">

    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <style>
        /* Custom styling untuk header tabel agar sesuai dengan warna sidebar */
        .dataTables-kecamatan thead th {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%) !important;
            color: white !important;
            font-weight: bold !important;
            text-align: center !important;
            border: 1px solid #1e3c72 !important;
            padding: 12px 8px !important;
        }
        
        .dataTables-kecamatan thead tr {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%) !important;
        }
        
        /* Override untuk DataTables sorting */
        .dataTables-kecamatan thead th.sorting,
        .dataTables-kecamatan thead th.sorting_asc,
        .dataTables-kecamatan thead th.sorting_desc {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%) !important;
            color: white !important;
        }
        
        /* Styling untuk baris tabel */
        .dataTables-kecamatan tbody tr:hover {
            background-color: #f0f8ff !important;
        }
        
        /* Styling untuk sel tabel */
        .dataTables-kecamatan td {
            border: 1px solid #dee2e6 !important;
            vertical-align: middle !important;
            padding: 8px !important;
        }
        
        /* Override Bootstrap default */
        .table-striped > thead > tr > th {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%) !important;
            color: white !important;
        }
    </style>

    <div class="col-lg-12">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>Filter</h5>
            </div>

            <div class="ibox-content">
                <div class="text-left">

                    <a href="?pg=PegawaiFilterDesaKec">
                        <button type="button" class="btn btn-white" style="width:150px; text-align:center">
                            Filter Desa
                        </button>
                    </a>

                    <a href="?pg=PegawaiPDFFilterDesaKec">
                        <button type="button" class="btn btn-white" style="width:150px; text-align:center">
                            PDF Desa
                        </button>
                    </a>
                </div>
            </div>
        </div>
    </div>


    <div class="col-lg-12">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>List Semua Data</h5>
            </div>

            <div class="ibox-content">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dataTables-kecamatan">
                        <thead style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%) !important;">
                            <tr align="center" style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%) !important;">
                                <th rowspan="2" style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%) !important; color: white !important; font-weight: bold !important; text-align: center !important;">No</th>
                                <th rowspan="2" style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%) !important; color: white !important; font-weight: bold !important; text-align: center !important;">Kecamatan<br>Desa<br>Kode Desa</th>
                                <th rowspan="2" style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%) !important; color: white !important; font-weight: bold !important; text-align: center !important;">Foto</th>
                                <th rowspan="2" style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%) !important; color: white !important; font-weight: bold !important; text-align: center !important;">Nama Perangkat<br>Alamat</th>
                                <th rowspan="2" style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%) !important; color: white !important; font-weight: bold !important; text-align: center !important;">Tgl Lahir<br>Jenis Kelamin</th>
                                <th rowspan="2" style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%) !important; color: white !important; font-weight: bold !important; text-align: center !important;">Pendidikan</th>
                                <th colspan="2" style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%) !important; color: white !important; font-weight: bold !important; text-align: center !important;">SK Pengangkatan</th>
                                <th rowspan="2" style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%) !important; color: white !important; font-weight: bold !important; text-align: center !important;">Jabatan</th>
                                <th rowspan="2" style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%) !important; color: white !important; font-weight: bold !important; text-align: center !important;">Keterangan</th>
                                <!-- <th rowspan="2">Siltap (Rp.)</th> -->
                                <th rowspan="2" style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%) !important; color: white !important; font-weight: bold !important; text-align: center !important;">Telp</th>
                            </tr>
                            <tr align="center" style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%) !important;">
                                <th style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%) !important; color: white !important; font-weight: bold !important; text-align: center !important;">No SK</th>
                                <th style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%) !important; color: white !important; font-weight: bold !important; text-align: center !important;">Tgl SK</th>
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
                            master_pegawai.TanggalPensiun,
                            master_pegawai.JenKel,
                            master_pegawai.IdDesaFK,
                            master_pegawai.Alamat,
                            master_pegawai.RT,
                            master_pegawai.RW,
                            master_pegawai.Lingkungan,
                            master_pegawai.Kecamatan AS Kec,
                            master_pegawai.Kabupaten,
                            master_pegawai.Setting,
                            master_pegawai.Siltap,
                            master_pegawai.NoTelp,
                            master_desa.IdDesa,
                            master_desa.KodeDesa,
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
                            history_mutasi.NomorSK,
                            history_mutasi.TanggalMutasi,
                            history_mutasi.IdJabatanFK,
                            history_mutasi.KeteranganJabatan,
                            history_mutasi.JenisMutasi,
                            history_mutasi.FileSKMutasi,
                            history_mutasi.Setting,
                            master_jabatan.IdJabatan,
                            master_jabatan.Jabatan
                            FROM
                            master_pegawai
                            LEFT JOIN master_desa ON master_pegawai.IdDesaFK = master_desa.IdDesa
                            LEFT JOIN master_kecamatan ON master_desa.IdKecamatanFK = master_kecamatan.IdKecamatan
                            LEFT JOIN master_setting_profile_dinas ON master_kecamatan.IdKabupatenFK = master_setting_profile_dinas.IdKabupatenProfile
                            INNER JOIN main_user ON master_pegawai.IdPegawaiFK = main_user.IdPegawai
                            INNER JOIN history_mutasi ON master_pegawai.IdPegawaiFK = history_mutasi.IdPegawaiFK
                            INNER JOIN master_jabatan ON history_mutasi.IdJabatanFK = master_jabatan.IdJabatan
                            WHERE
                            master_pegawai.Setting = 1 AND
                            main_user.IdLevelUserFK <> 1 AND
                            main_user.IdLevelUserFK <> 2 AND
                            history_mutasi.Setting = 1 AND
                            master_kecamatan.IdKecamatan = '$IdKec'
                            GROUP BY
                            master_pegawai.IdPegawaiFK
                            ORDER BY
                            master_kecamatan.IdKecamatan ASC,
                            master_desa.NamaDesa ASC,
                            history_mutasi.IdJabatanFK ASC");
                            while ($DataPegawai = mysqli_fetch_assoc($QueryPegawai)) {
                                // Use safe data access with schema for employee data
                                $safeEmployeeSchema = [
                                    'IdPegawaiFK' => '',
                                    'Foto' => '',
                                    'NIK' => '',
                                    'Nama' => '',
                                    'TanggalLahir' => '',
                                    'TanggalPensiun' => '',
                                    'JenKel' => '',
                                    'NamaDesa' => '',
                                    'Kecamatan' => '',
                                    'Kabupaten' => '',
                                    'Alamat' => '',
                                    'RT' => '',
                                    'RW' => '',
                                    'Lingkungan' => '',
                                    'Kec' => '',
                                    'Setting' => '',
                                    'JenisMutasi' => '',
                                    'TanggalMutasi' => '',
                                    'NomorSK' => '',
                                    'FileSKMutasi' => '',
                                    'Jabatan' => '',
                                    'KeteranganJabatan' => '',
                                    'Siltap' => '0',
                                    'NoTelp' => ''
                                ];
                                $safeData = safeDataRow($DataPegawai, $safeEmployeeSchema);
                                
                                $IdPegawaiFK = $safeData['IdPegawaiFK'];
                                $Foto = $safeData['Foto'];
                                $NIK = $safeData['NIK'];
                                $Nama = $safeData['Nama'];

                                // Safe date formatting
                                $TanggalLahir = $safeData['TanggalLahir'];
                                $ViewTglLahir = safeDateFormat($TanggalLahir);

                                $TanggalPensiun = $safeData['TanggalPensiun'];
                                $ViewTglPensiun = safeDateFormat($TanggalPensiun);

                                //HITUNG DETAIL TANGGAL PENSIUN - SAFE VERSION
                                if (!safeEmpty($TanggalPensiun) && $TanggalPensiun !== '0000-00-00') {
                                    $TglPensiun = date_create($TanggalPensiun);
                                    $TglSekarang = date_create();
                                    $Temp = date_diff($TglSekarang, $TglPensiun);

                                    //CEK TANGGAL ASLI SAAT INI
                                    $TglSekarang1 = Date('Y-m-d');

                                    if ($TglSekarang1 >= $TanggalPensiun) {
                                        $HasilTahun = '0 Tahun ';
                                        $HasilBulan = '0 Bulan ';
                                        $HasilHari = '0 Hari ';
                                    } else {
                                        $HasilTahun = $Temp->y . ' Tahun ';
                                        $HasilBulan = $Temp->m . ' Bulan ';
                                        $HasilHari = ($Temp->d + 1) . ' Hari ';
                                    }
                                } else {
                                    $HasilTahun = 'N/A';
                                    $HasilBulan = '';
                                    $HasilHari = '';
                                }
                                //SELESAI

                                $JenKel = $safeData['JenKel'];
                                $KodeDesa = safeGet($DataPegawai, 'KodeDesa', '');
                                $NamaDesa = $safeData['NamaDesa'];
                                $Kecamatan = $safeData['Kecamatan'];
                                $Kabupaten = $safeData['Kabupaten'];
                                $Alamat = $safeData['Alamat'];
                                $RT = $safeData['RT'];
                                $RW = $safeData['RW'];

                                $Lingkungan = $safeData['Lingkungan'];
                                $AmbilDesa = mysqli_query($db, "SELECT * FROM master_desa WHERE IdDesa = '$Lingkungan' ");
                                $LingkunganBPD = mysqli_fetch_assoc($AmbilDesa);
                                $Komunitas = safeGet($LingkunganBPD, 'NamaDesa', '');

                                $KecamatanBPD = $safeData['Kec'];
                                $AmbilKecamatan = mysqli_query($db, "SELECT * FROM master_kecamatan WHERE IdKecamatan = '$KecamatanBPD' ");
                                $KecamatanBPDData = mysqli_fetch_assoc($AmbilKecamatan);
                                $KomunitasKec = safeGet($KecamatanBPDData, 'Kecamatan', '');

                                $Address = $Alamat . " RT." . $RT . "/RW." . $RW . " " . $Komunitas . " Kecamatan " . $KomunitasKec;
                                $Setting = $safeData['Setting'];
                                $JenisMutasi = $safeData['JenisMutasi'];

                                $TglSKMutasi = $safeData['TanggalMutasi'];
                                $TanggalMutasi = safeDateFormat($TglSKMutasi);

                                $NomorSK = $safeData['NomorSK'];
                                $SKMutasi = $safeData['FileSKMutasi'];
                                $Jabatan = $safeData['Jabatan'];
                                $KetJabatan = $safeData['KeteranganJabatan'];
                                $Siltap = number_format(safeFloat($safeData['Siltap'], 0), 0, ",", ".");
                                $Telp = $safeData['NoTelp'];

                            ?>

                                <tr class="gradeX">
                                    <td>
                                        <?php echo $Nomor; ?>
                                    </td>
                                    <td>
                                        <?php echo $Kecamatan; ?><br>
                                        <span style="color:blue"><strong><?php echo $NamaDesa; ?></strong></span><br>
                                        <?php echo $KodeDesa; ?>
                                    </td>

                                    <?php
                                    if (safeEmpty($Foto)) {
                                    ?>
                                        <td>
                                            <img style="width:80px; height:auto" alt="image" class="message-avatar" src="../Vendor/Media/Pegawai/no-image.jpg">
                                        </td>
                                    <?php } else { ?>
                                        <td>
                                            <img style="width:80px; height:auto" alt="image" class="message-avatar" src="../Vendor/Media/Pegawai/<?php echo safeHtml($Foto); ?>">
                                        </td>
                                    <?php } ?>

                                    <td style="width:350px;">
                                        <strong><?php echo safeHtml($Nama); ?></strong><br><br>
                                        <?php echo safeHtml($Address); ?>
                                    </td>
                                    <td style="width:70px;">
                                        <?php echo $ViewTglLahir; ?><br>
                                        <?php
                                        $QueryJenKel = mysqli_query($db, "SELECT * FROM master_jenkel WHERE IdJenKel = '$JenKel' ");
                                        $DataJenKel = mysqli_fetch_assoc($QueryJenKel);
                                        $JenisKelamin = safeGet($DataJenKel, 'Keterangan', 'N/A');
                                        echo safeHtml($JenisKelamin);
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        $QPendidikan = mysqli_query($db, "SELECT
                                                history_pendidikan.IdPegawaiFK,
                                                history_pendidikan.IdPendidikanFK,
                                                master_pendidikan.IdPendidikan,
                                                master_pendidikan.JenisPendidikan,
                                                history_pendidikan.Setting
                                                FROM
                                                history_pendidikan
                                                INNER JOIN master_pendidikan ON history_pendidikan.IdPendidikanFK = master_pendidikan.IdPendidikan
                                        WHERE history_pendidikan.IdPegawaiFK = '$IdPegawaiFK' AND  history_pendidikan.Setting=1 ");
                                        $DataPendidikan = mysqli_fetch_assoc($QPendidikan);
                                        $Pendidikan = safeGet($DataPendidikan, 'JenisPendidikan', 'N/A');
                                        echo safeHtml($Pendidikan);
                                        ?>
                                    </td>
                                    <td style="width:60px;">
                                        <?php echo $NomorSK  ?>
                                    </td>
                                    <td style="width:70px;">
                                        <?php echo $TanggalMutasi; ?><br>
                                    </td>
                                    <td><?php echo $Jabatan; ?></td>
                                    <td><?php echo $KetJabatan; ?></td>
                                    <!-- <td><?php echo $Siltap; ?></td> -->
                                    <td><?php echo $Telp; ?></td>
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