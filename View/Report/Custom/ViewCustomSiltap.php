<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Data Kepala Desa & Perangkat Desa Berdasarkan Kriteria Siltap</h2>
    </div>
    <div class="col-lg-2">

    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <form action="?pg=ViewCustomSiltap" method="post" enctype="multipart/form-data">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Filter Kabupaten</h5>
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
                    <div class="text-left">
                        <div class="form-group row"><label class="col-lg-1 col-form-label">Jabatan</label>
                            <div class="col-lg-3">
                                <select name="Jabatan" id="Jabatan" style="width: 100%;" class="select2_pendidikan form-control" required>
                                    <option value="">Pilih Jabatan</option>
                                    <option value="1">Kepala Desa</option>
                                    <option value="2">Perangkat Desa</option>
                                </select>
                            </div>
                        </div>
                        <div class="alert alert-info">
                            <a class="alert-link" href="#">Pesan</a>. Input Siltap Awal Harus Lebih Kecil Siltap Akhir
                        </div>
                        <script>
                            function hanyaAngka(evt) {
                                var charCode = (evt.which) ? evt.which : event.keyCode
                                if (charCode > 31 && (charCode < 48 || charCode > 57))
                                    return false;
                                return true;
                            }
                        </script>
                        <div class="form-group row"><label class="col-lg-1 col-form-label">Siltap</label>
                            <div class="col-lg-2"><input type="text" name="SiltapAwal" id="SiltapAwal" class="form-control" placeholder="Awal" autocomplete="off" required onkeypress="return hanyaAngka(event)"></div>
                            Sampai <div class="col-lg-2"><input type="text" name="SiltapAkhir" id="SiltapAkhir" class="form-control" placeholder="Akhir" autocomplete="off" required onkeypress="return hanyaAngka(event)"></div>
                        </div>
                        <button class="btn btn-outline btn-primary" type="submit" name="Cari" id="Cari">Cari</button>
                        <a href="?pg=CustomSiltapPDFFilterKecamatan">
                            <button type="button" class="btn btn-outline btn-success" style="width:150px; text-align:center">
                                PDF Kabupaten
                            </button>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <?php
        if (isset($_POST['Cari'])) {
            $AmbilJabatan = sql_injeksi($_POST['Jabatan']);
            $SiltapAwal = sql_injeksi($_POST['SiltapAwal']);
            $SiltapAkhir = sql_injeksi($_POST['SiltapAkhir']);
            $FormatSiltapAwal = number_format(($SiltapAwal), 0, ",", ".");
            $FormatSiltapAkhir = number_format(($SiltapAkhir), 0, ",", ".");

            if ($SiltapAwal > $SiltapAkhir) {
                echo '<div class="alert alert-danger alert-dismissable">
                        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                        <a class="alert-link" href="#">Pesan Error. </a> Input Siltap Awal Harus Lebih Kecil Siltap Akhir.
                    </div>';
            } else {
                if ($AmbilJabatan == 1) {
                    $Jabatan = "Kepala Desa";
        ?>
                    <div class="col-lg-12">
                        <div class="ibox ">
                            <div class="ibox-title">
                                <h5>Siltap <?php echo $Jabatan; ?> Dari Rp. <?php echo $FormatSiltapAwal; ?> Sampai Rp. <?php echo $FormatSiltapAkhir; ?></h5>
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

                            <form action="?pg=ViewCustomSiltap" method="post" enctype="multipart/form-data">
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
                                                    <th>Pendidikan Akhir</th>
                                                    <th>Tanggal/SK Mutasi</th>
                                                    <th>Siltap (Rp.)</th>
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
                                                TIMESTAMPDIFF(YEAR, master_pegawai.TanggalLahir, CURDATE()) AS UmurPeg,
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
                                                history_mutasi.NomorSK,
                                                history_mutasi.TanggalMutasi,
                                                master_pegawai.Siltap
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
                                                history_mutasi.Setting = 1 AND
                                                history_mutasi.IdJabatanFK = 1 AND
                                                master_pegawai.Siltap BETWEEN '$SiltapAwal' AND '$SiltapAkhir'
                                            ORDER BY
                                                master_pegawai.Siltap ASC");
                                                while ($DataPegawai = mysqli_fetch_assoc($QueryPegawai)) {
                                                    $IdPegawaiFK = $DataPegawai['IdPegawaiFK'];
                                                    $Foto = $DataPegawai['Foto'];
                                                    $NIK = $DataPegawai['NIK'];
                                                    $Nama = $DataPegawai['Nama'];
                                                    $Jabatan = $DataPegawai['Jabatan'];
                                                    $AmbilTanggalSK = $DataPegawai['TanggalMutasi'];
                                                    $expSK = explode('-', $AmbilTanggalSK);
                                                    $TanggalSK = $expSK[2] . "-" . $expSK[1] . "-" . $expSK[0];
                                                    $NomerSK = $DataPegawai['NomorSK'];

                                                    $TanggalLahir = $DataPegawai['TanggalLahir'];
                                                    $exp = explode('-', $TanggalLahir);
                                                    $ViewTglLahir = $exp[2] . "-" . $exp[1] . "-" . $exp[0];

                                                    $UmurSekarang = $DataPegawai['UmurPeg'];

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
                                                    $Siltap =  number_format($DataPegawai['Siltap'], 0, ",", ".");
                                                ?>
                                                    <tr class="gradeX">
                                                        <td>
                                                            <?php echo $Nomor; ?>
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
                                                            <?php echo $ViewTglPensiun; ?><br><br>
                                                            <?php echo $HasilTahun; ?><br>
                                                            <?php echo $HasilBulan; ?><br>
                                                            <?php echo $HasilHari; ?>
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
                                                        <td>
                                                            <span style="color:blue"><?php echo $TanggalSK; ?></span><br>
                                                            <strong><?php echo $NomerSK; ?></strong>
                                                        </td>
                                                        <td><?php echo $Siltap; ?></td>
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
                <?php } elseif ($AmbilJabatan == 2) {
                    $Jabatan = "Perangkat Desa";
                ?>
                    <div class="col-lg-12">
                        <div class="ibox ">
                            <div class="ibox-title">
                                <h5>Siltap <?php echo $Jabatan; ?> Dari Rp. <?php echo $FormatSiltapAwal; ?> Sampai Rp. <?php echo $FormatSiltapAkhir; ?></h5>
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

                            <form action="?pg=ViewCustomSiltap" method="post" enctype="multipart/form-data">
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
                                                    <th>Pendidikan Akhir</th>
                                                    <th>Tanggal/SK Mutasi</th>
                                                    <th>Siltap (Rp.)</th>
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
                                                TIMESTAMPDIFF(YEAR, master_pegawai.TanggalLahir, CURDATE()) AS UmurPeg,
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
                                                history_mutasi.NomorSK,
                                                history_mutasi.TanggalMutasi,
                                                master_pegawai.Siltap
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
                                                history_mutasi.Setting = 1 AND
                                                history_mutasi.IdJabatanFK <> 1 AND
                                                master_pegawai.Siltap BETWEEN '$SiltapAwal' AND '$SiltapAkhir'
                                            ORDER BY
                                                master_pegawai.Siltap ASC");
                                                while ($DataPegawai = mysqli_fetch_assoc($QueryPegawai)) {
                                                    $IdPegawaiFK = $DataPegawai['IdPegawaiFK'];
                                                    $Foto = $DataPegawai['Foto'];
                                                    $NIK = $DataPegawai['NIK'];
                                                    $Nama = $DataPegawai['Nama'];
                                                    $Jabatan = $DataPegawai['Jabatan'];
                                                    $AmbilTanggalSK = $DataPegawai['TanggalMutasi'];
                                                    $expSK = explode('-', $AmbilTanggalSK);
                                                    $TanggalSK = $expSK[2] . "-" . $expSK[1] . "-" . $expSK[0];
                                                    $NomerSK = $DataPegawai['NomorSK'];

                                                    $TanggalLahir = $DataPegawai['TanggalLahir'];
                                                    $exp = explode('-', $TanggalLahir);
                                                    $ViewTglLahir = $exp[2] . "-" . $exp[1] . "-" . $exp[0];

                                                    $UmurSekarang = $DataPegawai['UmurPeg'];

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
                                                    $Siltap =  number_format($DataPegawai['Siltap'], 0, ",", ".");
                                                ?>
                                                    <tr class="gradeX">
                                                        <td>
                                                            <?php echo $Nomor; ?>
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
                                                            <?php echo $ViewTglPensiun; ?><br><br>
                                                            <?php echo $HasilTahun; ?><br>
                                                            <?php echo $HasilBulan; ?><br>
                                                            <?php echo $HasilHari; ?>
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
                                                        <td>
                                                            <span style="color:blue"><?php echo $TanggalSK; ?></span><br>
                                                            <strong><?php echo $NomerSK; ?></strong>
                                                        </td>
                                                        <td><?php echo $Siltap; ?></td>
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

        <?php
                }
            }
        }
        ?>
    </form>
</div>