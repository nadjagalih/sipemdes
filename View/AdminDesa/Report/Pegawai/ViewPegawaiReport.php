<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Data Seluruh Pemerintah Desa </h2>
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
                <h5>Filter Pemerintah Desa</h5>
               
            </div>

            <div class="ibox-content">

                <div class="text-left">
                    <a href="AdminDesa/Report/Pdf/PegawaiDesaPdf" target="_BLANK">
                        <button type="button" class="btn btn-white" style="width:150px; text-align:center">
                            Cetak PDF
                        </button>
                    </a>
                </div>
            </div>
        </div>
    </div>


    <div class="col-lg-12">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>List Semua Data Pemerintah Desa</h5>
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
                            <tr align="center">
                                <th rowspan="2">No</th>
                                <th rowspan="2">Kecamatan<br>Desa<br>Kode Desa</th>
                                <th rowspan="2">Foto</th>
                                <th rowspan="2">Nama Perangkat<br>Alamat</th>
                                <th rowspan="2">Tgl Lahir<br>Jenis Kelamin</th>
                                <th rowspan="2">Pendidikan</th>
                                <th colspan="2">SK Pengangkatan</th>
                                <th rowspan="2">Jabatan</th>
                                <th rowspan="2">Keterangan</th>
                                <th rowspan="2">Siltap (Rp.)</th>
                                <th rowspan="2">Telp</th>
                            </tr>
                            <tr align="center">
                                <th>No SK</th>
                                <th>Tgl SK</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $IdDesa = $_SESSION['IdDesa'];
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
                            master_pegawai.IdDesaFK = '$IdDesa'
                            GROUP BY
                            master_pegawai.IdPegawaiFK
                            ORDER BY
                            master_kecamatan.IdKecamatan ASC,
                            master_desa.NamaDesa ASC,
                            master_jabatan.IdJabatan ASC");
                            while ($DataPegawai = mysqli_fetch_assoc($QueryPegawai)) {
                                $IdPegawaiFK = $DataPegawai['IdPegawaiFK'];
                                $Foto = $DataPegawai['Foto'];
                                $NIK = $DataPegawai['NIK'];
                                $Nama = $DataPegawai['Nama'];

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
                                    $HasilTahun = $Temp->y . ' Tahun ';
                                    $HasilBulan = $Temp->m . ' Bulan ';
                                    $HasilHari = $Temp->d + 1 . ' Hari ';
                                }
                                //SELESAI

                                $JenKel = $DataPegawai['JenKel'];
                                $KodeDesa = $DataPegawai['KodeDesa'];
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
                                $JenisMutasi = $DataPegawai['JenisMutasi'];

                                $TglSKMutasi = $DataPegawai['TanggalMutasi'];
                                $exp2 = explode('-', $TglSKMutasi);
                                $TanggalMutasi = $exp2[2] . "-" . $exp2[1] . "-" . $exp2[0];

                                $NomorSK = $DataPegawai['NomorSK'];
                                $SKMutasi = $DataPegawai['FileSKMutasi'];
                                $Jabatan = $DataPegawai['Jabatan'];
                                $KetJabatan = $DataPegawai['KeteranganJabatan'];
                                $Siltap =  number_format($DataPegawai['Siltap'], 0, ",", ".");
                                $Telp = $DataPegawai['NoTelp'];

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
                                    if (empty($Foto)) {
                                    ?>
                                        <td>
                                            <img style="width:80px; height:auto" alt="image" class="message-avatar" src="../Vendor/Media/Pegawai/no-image.jpg">
                                        </td>
                                    <?php } else { ?>
                                        <td>
                                            <img style="width:80px; height:auto" alt="image" class="message-avatar" src="../Vendor/Media/Pegawai/<?php echo $Foto; ?>">
                                        </td>
                                    <?php } ?>

                                    <td style="width:350px;">
                                        <strong><?php echo $Nama; ?></strong><br><br>
                                        <?php echo $Address; ?>
                                    </td>
                                    <td style="width:70px;">
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
                                        $Pendidikan = $DataPendidikan['JenisPendidikan'];
                                        echo $Pendidikan;
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
                                    <td><?php echo $Siltap; ?></td>
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