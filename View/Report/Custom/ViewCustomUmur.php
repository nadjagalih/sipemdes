<?php
// Include CSP Handler untuk nonce support
require_once __DIR__ . '/../../../Module/Security/CSPHandler.php';
?>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Data Kepala Desa & Perangkat Desa Berdasarkan Kriteria Umur </h2>
    </div>
    <div class="col-lg-2">

    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <form action="?pg=ViewCustomUmur" method="post" enctype="multipart/form-data">
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
                            <a class="alert-link" href="#">Pesan</a>. Input Umur Awal Harus Lebih Kecil Umur Akhir.
                        </div>
                        <script>
                            function hanyaAngka(evt) {
                                var charCode = (evt.which) ? evt.which : event.keyCode
                                if (charCode > 31 && (charCode < 48 || charCode > 57))
                                    return false;
                                return true;
                            }
                        </script>
                        <div class="form-group row"><label class="col-lg-1 col-form-label">Umur</label>
                            <div class="col-lg-1"><input type="text" name="UmurAwal" id="UmurAwal" class="form-control" placeholder="Awal" autocomplete="off" required onkeypress="return hanyaAngka(event)"></div>
                            Sampai <div class="col-lg-1"><input type="text" name="UmurAkhir" id="UmurAkhir" class="form-control" placeholder="Akhir" autocomplete="off" required onkeypress="return hanyaAngka(event)"></div>
                        </div>
                        <button class="btn btn-outline btn-primary" type="submit" name="Cari" id="Cari">Cari</button>
                    </div>
                </div>
            </div>
        </div>

        <?php
        if (isset($_POST['Cari'])) {
            $AmbilJabatan = sql_injeksi($_POST['Jabatan']);
            $UmurAwal = sql_injeksi($_POST['UmurAwal']);
            $UmurAkhir = sql_injeksi($_POST['UmurAkhir']);

            if ($UmurAwal > $UmurAkhir) {
                echo '<div class="alert alert-danger alert-dismissable">
                        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                        <a class="alert-link" href="#"> Pesan Error.</a> Input Umur Awal Harus Lebih Kecil Umur Akhir.
                    </div>';
            } else {

                if ($AmbilJabatan == 1) {
                    $Jabatan = "Kepala Desa";
        ?>
                    <div class="col-lg-12">
                        <div class="ibox ">
                            <div class="ibox-title">
                                <h5>Jabatan <?php echo $Jabatan; ?> Dari Umur <?php echo $UmurAwal; ?> Sampai <?php echo $UmurAkhir; ?> Tahun</h5>
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

                            <!-- Hidden elements for custom filters -->
                            <div style="display: none;">
                                <select id="kecamatanFilter_1">
                                    <option value="">Filter Kecamatan</option>
                                    <?php
                                    $QueryKec = mysqli_query($db, "SELECT * FROM master_kecamatan ORDER BY Kecamatan ASC");
                                    while ($DataKec = mysqli_fetch_assoc($QueryKec)) {
                                        echo '<option value="' . $DataKec['IdKecamatan'] . '">' . $DataKec['Kecamatan'] . '</option>';
                                    }
                                    ?>
                                </select>
                                <input type="search" id="customSearch_1" placeholder="Search:">
                            </div>

                            <form action="?pg=ViewCustomUmur" method="post" enctype="multipart/form-data">
                                <div class="ibox-content">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover" id="tabelUmur_1">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Foto</th>
                                                    <th>NIK</th>
                                                    <th>Nama<br>Jabatan<br>Alamat</th>
                                                    <th>Tanggal Lahir<br>Jenis Kelamin</th>
                                                    <th>Umur</th>
                                                    <th>Tanggal Pensiun</th>
                                                    <th>Pendidikan Akhir</th>
                                                    <th>Tanggal/SK Mutasi</th>
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
                                                TIMESTAMPDIFF(YEAR, master_pegawai.TanggalLahir, CURDATE()) BETWEEN '$UmurAwal' AND '$UmurAkhir'
                                            ORDER BY
                                                master_pegawai.TanggalPensiun ASC");
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
                                                    $Komunitas = isset($LingkunganBPD['NamaDesa']) ? $LingkunganBPD['NamaDesa'] : '';

                                                    $KecamatanBPD = $DataPegawai['Kec'];
                                                    $AmbilKecamatan = mysqli_query($db, "SELECT * FROM master_kecamatan WHERE IdKecamatan = '$KecamatanBPD' ");
                                                    $KecamatanBPD = mysqli_fetch_assoc($AmbilKecamatan);
                                                    $KomunitasKec = isset($KecamatanBPD['Kecamatan']) ? $KecamatanBPD['Kecamatan'] : '';

                                                    $Address = $Alamat . " RT." . $RT . "/RW." . $RW . " " . $Komunitas . " Kecamatan " . $KomunitasKec;
                                                    $Setting = $DataPegawai['Setting'];
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
                                                            $JenisKelamin = isset($DataJenKel['Keterangan']) ? $DataJenKel['Keterangan'] : '-';
                                                            echo $JenisKelamin;
                                                            ?>
                                                        </td>
                                                        <td><?php echo $UmurSekarang; ?></td>
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
                                                            $Pendidikan = isset($DataPendidikan['JenisPendidikan']) ? $DataPendidikan['JenisPendidikan'] : '-';
                                                            echo $Pendidikan;
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <span style="color:blue"><?php echo $TanggalSK; ?></span><br>
                                                            <strong><?php echo $NomerSK; ?></strong>
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
                <?php } elseif ($AmbilJabatan == 2) {
                    $Jabatan = "Perangkat Desa";
                ?>
                    <div class="col-lg-12">
                        <div class="ibox ">
                            <div class="ibox-title">
                                <h5>Jabatan <?php echo $Jabatan; ?> Dari Umur <?php echo $UmurAwal; ?> Sampai <?php echo $UmurAkhir; ?> Tahun</h5>
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

                            <!-- Hidden elements for custom filters -->
                            <div style="display: none;">
                                <select id="kecamatanFilter_2">
                                    <option value="">Filter Kecamatan</option>
                                    <?php
                                    $QueryKec2 = mysqli_query($db, "SELECT * FROM master_kecamatan ORDER BY Kecamatan ASC");
                                    while ($DataKec2 = mysqli_fetch_assoc($QueryKec2)) {
                                        echo '<option value="' . $DataKec2['IdKecamatan'] . '">' . $DataKec2['Kecamatan'] . '</option>';
                                    }
                                    ?>
                                </select>
                                <input type="search" id="customSearch_2" placeholder="Search:">
                            </div>

                            <form action="?pg=ViewCustomUmur" method="post" enctype="multipart/form-data">
                                <div class="ibox-content">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover" id="tabelUmur_2">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Foto</th>
                                                    <th>NIK</th>
                                                    <th>Nama<br>Jabatan<br>Alamat</th>
                                                    <th>Tanggal Lahir<br>Jenis Kelamin</th>
                                                    <th>Umur</th>
                                                    <th>Tanggal Pensiun</th>
                                                    <th>Pendidikan Akhir</th>
                                                    <th>Tanggal/SK Mutasi</th>
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
                                                TIMESTAMPDIFF(YEAR, master_pegawai.TanggalLahir, CURDATE()) BETWEEN '$UmurAwal' AND '$UmurAkhir'
                                            ORDER BY
                                                master_pegawai.TanggalPensiun ASC");
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
                                                    $Komunitas = isset($LingkunganBPD['NamaDesa']) ? $LingkunganBPD['NamaDesa'] : '';

                                                    $KecamatanBPD = $DataPegawai['Kec'];
                                                    $AmbilKecamatan = mysqli_query($db, "SELECT * FROM master_kecamatan WHERE IdKecamatan = '$KecamatanBPD' ");
                                                    $KecamatanBPD = mysqli_fetch_assoc($AmbilKecamatan);
                                                    $KomunitasKec = isset($KecamatanBPD['Kecamatan']) ? $KecamatanBPD['Kecamatan'] : '';

                                                    $Address = $Alamat . " RT." . $RT . "/RW." . $RW . " " . $Komunitas . " Kecamatan " . $KomunitasKec;
                                                    $Setting = $DataPegawai['Setting'];
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
                                                            $JenisKelamin = isset($DataJenKel['Keterangan']) ? $DataJenKel['Keterangan'] : '-';
                                                            echo $JenisKelamin;
                                                            ?>
                                                        </td>
                                                        <td><?php echo $UmurSekarang; ?></td>
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
                                                            $Pendidikan = isset($DataPendidikan['JenisPendidikan']) ? $DataPendidikan['JenisPendidikan'] : '-';
                                                            echo $Pendidikan;
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <span style="color:blue"><?php echo $TanggalSK; ?></span><br>
                                                            <strong><?php echo $NomerSK; ?></strong>
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

        <?php
                }
            }
        }
        ?>
    </form>
</div>

<script <?php echo CSPHandler::scriptNonce(); ?>>
$(document).ready(function() {
    console.log('Initializing DataTables with custom filters...');
    
    var kecamatanMap_1 = {};
    var kecamatanMap_2 = {};
    
    // Load Kecamatan data for table 1
    $("#kecamatanFilter_1 option").each(function() {
        if ($(this).val() !== '') {
            kecamatanMap_1[$(this).val()] = $(this).text();
        }
    });
    
    // Load Kecamatan data for table 2
    $("#kecamatanFilter_2 option").each(function() {
        if ($(this).val() !== '') {
            kecamatanMap_2[$(this).val()] = $(this).text();
        }
    });
    
    // Initialize DataTable for Kepala Desa (table 1) - only if table exists
    if ($('#tabelUmur_1').length > 0) {
        console.log('Table 1 found, initializing...');
        
        if ($.fn.DataTable.isDataTable('#tabelUmur_1')) {
            $('#tabelUmur_1').DataTable().destroy();
        }
        
        var table1 = $('#tabelUmur_1').DataTable({
        "dom": '<"row"<"col-sm-6"B><"col-sm-6"<"custom-filters-1">>>rt<"bottom"ip><"clear">',
        "pageLength": 50,
        "searching": true,
        "paging": true,
        "info": true,
        "lengthChange": true,
        "destroy": true,
        "columnDefs": [
            {
                "targets": 0,
                "searchable": false,
                "orderable": false,
                "render": function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            }
        ],
        "buttons": [
            {
                extend: 'copy',
                text: '<i class="fa fa-copy"></i> Copy',
                className: 'btn btn-outline btn-primary'
            },
            {
                extend: 'csv',
                text: '<i class="fa fa-file-text-o"></i> CSV',
                className: 'btn btn-outline btn-success'
            },
            {
                extend: 'excel',
                text: '<i class="fa fa-file-excel-o"></i> Excel',
                className: 'btn btn-outline btn-success'
            },
            {
                text: '<i class="fa fa-file-pdf-o"></i> PDF',
                className: 'btn btn-outline btn-danger',
                action: function (e, dt, node, config) {
                    var kecamatanId = $('#kecamatanFilter_1').val();
                    var umurAwal = '<?php echo isset($UmurAwal) ? $UmurAwal : ""; ?>';
                    var umurAkhir = '<?php echo isset($UmurAkhir) ? $UmurAkhir : ""; ?>';
                    
                    if (!kecamatanId || kecamatanId === '') {
                        alert('Silakan pilih Filter Kecamatan terlebih dahulu');
                        return;
                    }
                    
                    var pdfUrl = 'Report/Custom/PdfCustomUmurKecamatan?Kecamatan=' + 
                        encodeURIComponent(kecamatanId) + '&Jabatan=1&UmurAwal=' + 
                        encodeURIComponent(umurAwal) + '&UmurAkhir=' + encodeURIComponent(umurAkhir) + '&ExportPDF=';
                    window.open(pdfUrl, '_blank');
                }
            },
            {
                extend: 'print',
                text: '<i class="fa fa-print"></i> Print',
                className: 'btn btn-outline btn-primary'
            }
        ],
        "language": {
            "search": "",
            "searchPlaceholder": "Search...",
            "lengthMenu": "Show _MENU_ entries",
            "info": "Showing _START_ to _END_ of _TOTAL_ entries",
            "infoEmpty": "Showing 0 to 0 of 0 entries",
            "infoFiltered": "(filtered from _MAX_ total entries)",
            "paginate": {
                "first": "First",
                "last": "Last",
                "next": "Next",
                "previous": "Previous"
            }
        }
    });

    setTimeout(function() {
        var filterHtml1 = '<div style="text-align: right; padding-top: 5px;">' +
            '<select class="form-control input-sm" style="display: inline-block; width: 150px; margin-right: 10px;" id="kecamatanFilterMoved_1">' +
            $('#kecamatanFilter_1').html() +
            '</select>' +
            '<input type="search" class="form-control input-sm" placeholder="Search:" style="display: inline-block; width: 200px;" id="customSearchMoved_1">' +
            '</div>';
        
        $('.custom-filters-1').html(filterHtml1);
        
        // Filter by Kecamatan for table 1
        $('#kecamatanFilterMoved_1').on('change', function() {
            var kecamatanId = $(this).val();
            $('#kecamatanFilter_1').val(kecamatanId);
            
            if (kecamatanId === '') {
                table1.column(9).search('').draw();
            } else {
                var kecamatanName = kecamatanMap_1[kecamatanId] || '';
                table1.column(9).search(kecamatanName).draw();
            }
        });
        
        // Custom search for table 1
        $('#customSearchMoved_1').on('keyup', function() {
            table1.search(this.value).draw();
        });
    }, 500);
    
    } // End if table 1 exists
    
    // Initialize DataTable for Perangkat Desa (table 2) - only if table exists
    if ($('#tabelUmur_2').length > 0) {
        console.log('Table 2 found, initializing...');
        
        if ($.fn.DataTable.isDataTable('#tabelUmur_2')) {
            $('#tabelUmur_2').DataTable().destroy();
        }
        
        var table2 = $('#tabelUmur_2').DataTable({
        "dom": '<"row"<"col-sm-6"B><"col-sm-6"<"custom-filters-2">>>rt<"bottom"ip><"clear">',
        "pageLength": 50,
        "searching": true,
        "paging": true,
        "info": true,
        "lengthChange": true,
        "destroy": true,
        "columnDefs": [
            {
                "targets": 0,
                "searchable": false,
                "orderable": false,
                "render": function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            }
        ],
        "buttons": [
            {
                extend: 'copy',
                text: '<i class="fa fa-copy"></i> Copy',
                className: 'btn btn-outline btn-primary'
            },
            {
                extend: 'csv',
                text: '<i class="fa fa-file-text-o"></i> CSV',
                className: 'btn btn-outline btn-success'
            },
            {
                extend: 'excel',
                text: '<i class="fa fa-file-excel-o"></i> Excel',
                className: 'btn btn-outline btn-success'
            },
            {
                text: '<i class="fa fa-file-pdf-o"></i> PDF',
                className: 'btn btn-outline btn-danger',
                action: function (e, dt, node, config) {
                    var kecamatanId = $('#kecamatanFilter_2').val();
                    var umurAwal = '<?php echo isset($UmurAwal) ? $UmurAwal : ""; ?>';
                    var umurAkhir = '<?php echo isset($UmurAkhir) ? $UmurAkhir : ""; ?>';
                    
                    if (!kecamatanId || kecamatanId === '') {
                        alert('Silakan pilih Filter Kecamatan terlebih dahulu');
                        return;
                    }
                    
                    var pdfUrl = 'Report/Custom/PdfCustomUmurKecamatan?Kecamatan=' + 
                        encodeURIComponent(kecamatanId) + '&Jabatan=2&UmurAwal=' + 
                        encodeURIComponent(umurAwal) + '&UmurAkhir=' + encodeURIComponent(umurAkhir) + '&ExportPDF=';
                    window.open(pdfUrl, '_blank');
                }
            },
            {
                extend: 'print',
                text: '<i class="fa fa-print"></i> Print',
                className: 'btn btn-outline btn-primary'
            }
        ],
        "language": {
            "search": "",
            "searchPlaceholder": "Search...",
            "lengthMenu": "Show _MENU_ entries",
            "info": "Showing _START_ to _END_ of _TOTAL_ entries",
            "infoEmpty": "Showing 0 to 0 of 0 entries",
            "infoFiltered": "(filtered from _MAX_ total entries)",
            "paginate": {
                "first": "First",
                "last": "Last",
                "next": "Next",
                "previous": "Previous"
            }
        }
    });

    setTimeout(function() {
        var filterHtml2 = '<div style="text-align: right; padding-top: 5px;">' +
            '<select class="form-control input-sm" style="display: inline-block; width: 150px; margin-right: 10px;" id="kecamatanFilterMoved_2">' +
            $('#kecamatanFilter_2').html() +
            '</select>' +
            '<input type="search" class="form-control input-sm" placeholder="Search:" style="display: inline-block; width: 200px;" id="customSearchMoved_2">' +
            '</div>';
        
        $('.custom-filters-2').html(filterHtml2);
        
        // Filter by Kecamatan for table 2
        $('#kecamatanFilterMoved_2').on('change', function() {
            var kecamatanId = $(this).val();
            $('#kecamatanFilter_2').val(kecamatanId);
            
            if (kecamatanId === '') {
                table2.column(9).search('').draw();
            } else {
                var kecamatanName = kecamatanMap_2[kecamatanId] || '';
                table2.column(9).search(kecamatanName).draw();
            }
        });
        
        // Custom search for table 2
        $('#customSearchMoved_2').on('keyup', function() {
            table2.search(this.value).draw();
        });
    }, 500);
    
    } // End if table 2 exists
});
</script>