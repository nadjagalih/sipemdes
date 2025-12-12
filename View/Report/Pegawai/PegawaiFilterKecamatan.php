<form action="?pg=PegawaiFilterKecamatan" method="post" enctype="multipart/form-data">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Filter Data PerKecamatan </h5>
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
                    <div class=row>
                        <div class="col-lg-6">
                            <div class="form-group row"><label class="col-lg-2 col-form-label">Kecamatan</label>
                                <div class="col-lg-6">
                                    <select name="Kecamatan" id="Kecamatan" style="width: 100%;" class="select2_kecamatan form-control" required>
                                        <option value="">Filter Kecamatan</option>
                                        <?php
                                        $QueryKecamatanList = mysqli_query($db, "SELECT * FROM master_kecamatan ORDER BY Kecamatan ASC");
                                        while ($RowKecamatanList = mysqli_fetch_assoc($QueryKecamatanList)) {
                                            $IdKecamatanList = isset($RowKecamatanList['IdKecamatan']) ? $RowKecamatanList['IdKecamatan'] : '';
                                            $NamaKecamatanList = isset($RowKecamatanList['Kecamatan']) ? $RowKecamatanList['Kecamatan'] : '';
                                        ?>
                                            <option value="<?php echo htmlspecialchars($IdKecamatanList); ?>"><?php echo htmlspecialchars($NamaKecamatanList); ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <button type="submit" name="Proses" value="Proses" class="btn btn-outline btn-primary">Tampilkan</button>
                            <a href="?pg=ViewPegawaiReport"><button type="button" class="btn btn-outline btn-primary">Batal</button></a>
                            <?php if (isset($_SESSION['filter_kecamatan'])): ?>
                                <a href="?pg=PegawaiFilterKecamatan&clear_filter=1"><button type="button" class="btn btn-outline btn-warning">Clear Filter</button></a>
                            <?php endif; ?>
                        </div>

                        <div class="col-lg-6"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- FILTERING -->
    <?php
    // Handle clear filter
    if (isset($_GET['clear_filter'])) {
        unset($_SESSION['filter_kecamatan']);
        // Redirect to clean page
        echo "<script>window.location.href = '?pg=PegawaiFilterKecamatan';</script>";
        exit;
    }
    
    // Cek apakah ada filter yang aktif dari POST atau dari session/GET parameter
    $showResults = false;
    $Kecamatan = '';
    $NamaKecamatan = '';
    
    if (isset($_POST['Proses']) && isset($_POST['Kecamatan'])) {
        // Filter baru dari form
        $Kecamatan = sql_injeksi($_POST['Kecamatan']);
        $_SESSION['filter_kecamatan'] = $Kecamatan; // Simpan di session
        $showResults = true;
    } elseif (isset($_SESSION['filter_kecamatan']) && isset($_GET['page'])) {
        // Navigasi pagination - ambil filter dari session
        $Kecamatan = $_SESSION['filter_kecamatan'];
        $showResults = true;
    }
    
    if ($showResults && !empty($Kecamatan)) {
        $QueryKecamatan = mysqli_query($db, "SELECT * FROM master_kecamatan WHERE IdKecamatan ='$Kecamatan' ");
        $DataKecamatan = mysqli_fetch_assoc($QueryKecamatan);
        $NamaKecamatan = ($DataKecamatan && isset($DataKecamatan['Kecamatan'])) ? $DataKecamatan['Kecamatan'] : '';

    ?>
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5>Hasil Data Filter Kecamatan <?php echo $NamaKecamatan; ?></h5>
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
                                        <th rowspan="2">NIK</th>
                                        <th rowspan="2">Nama Pegawai<br>Alamat</th>
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
                                    // Pagination setup
                                    $limit = 20; // Jumlah data per halaman
                                    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                                    $offset = ($page - 1) * $limit;
                                    
                                    // Count total records untuk pagination
                                    $CountQuery = mysqli_query($db, "SELECT COUNT(DISTINCT master_pegawai.IdPegawaiFK) as total
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
                            master_kecamatan.IdKecamatan = '$Kecamatan'");
                                    
                                    $CountResult = mysqli_fetch_assoc($CountQuery);
                                    $totalRecords = $CountResult['total'];
                                    $totalPages = ceil($totalRecords / $limit);
                                    
                                    $Nomor = $offset + 1;
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
                            master_kecamatan.IdKecamatan = '$Kecamatan'
                            GROUP BY
                            master_pegawai.IdPegawaiFK
                            ORDER BY
                            master_kecamatan.IdKecamatan ASC,
                            master_desa.NamaDesa ASC,
                            history_mutasi.IdJabatanFK ASC
                            LIMIT $limit OFFSET $offset");
                                    while ($DataPegawai = mysqli_fetch_assoc($QueryPegawai)) {
                                        $IdPegawaiFK = isset($DataPegawai['IdPegawaiFK']) ? $DataPegawai['IdPegawaiFK'] : '';
                                        $Foto = isset($DataPegawai['Foto']) ? $DataPegawai['Foto'] : '';
                                        $NIK = isset($DataPegawai['NIK']) ? $DataPegawai['NIK'] : '';
                                        $Nama = isset($DataPegawai['Nama']) ? $DataPegawai['Nama'] : '';

                                        $TanggalLahir = isset($DataPegawai['TanggalLahir']) ? $DataPegawai['TanggalLahir'] : '';
                                        if (!empty($TanggalLahir)) {
                                            $exp = explode('-', $TanggalLahir);
                                            $ViewTglLahir = (isset($exp[2]) ? $exp[2] : '') . "-" . (isset($exp[1]) ? $exp[1] : '') . "-" . (isset($exp[0]) ? $exp[0] : '');
                                        } else {
                                            $ViewTglLahir = '';
                                        }

                                        $TanggalPensiun = isset($DataPegawai['TanggalPensiun']) ? $DataPegawai['TanggalPensiun'] : '';
                                        if (!empty($TanggalPensiun)) {
                                            $exp1 = explode('-', $TanggalPensiun);
                                            $ViewTglPensiun = (isset($exp1[2]) ? $exp1[2] : '') . "-" . (isset($exp1[1]) ? $exp1[1] : '') . "-" . (isset($exp1[0]) ? $exp1[0] : '');
                                        } else {
                                            $ViewTglPensiun = '';
                                        }

                                        //HITUNG DETAIL TANGGAL PENSIUN
                                        if (!empty($TanggalPensiun)) {
                                            $TglPensiun = date_create($TanggalPensiun);
                                            $TglSekarang = date_create();
                                            $Temp = date_diff($TglSekarang, $TglPensiun);
                                        } else {
                                            $Temp = null;
                                        }

                                        //CEK TANGGAL ASLI SAAT INI
                                        $TglSekarang1 = Date('Y-m-d');

                                        if (empty($TanggalPensiun) || $Temp === null) {
                                            $HasilTahun = '-';
                                            $HasilBulan = '';
                                            $HasilHari = '';
                                        } elseif ($TglSekarang1 >= $TanggalPensiun) {
                                            $HasilTahun = 0 . ' Tahun ';
                                            $HasilBulan = 0 . ' Bulan ';
                                            $HasilHari = 0 . ' Hari ';
                                        } elseif ($TglSekarang1 < $TanggalPensiun) {
                                            $HasilTahun = $Temp->y . ' Tahun ';
                                            $HasilBulan = $Temp->m . ' Bulan ';
                                            $HasilHari = $Temp->d + 1 . ' Hari ';
                                        }
                                        //SELESAI

                                        $JenKel = isset($DataPegawai['JenKel']) ? $DataPegawai['JenKel'] : '';
                                        $KodeDesa = isset($DataPegawai['KodeDesa']) ? $DataPegawai['KodeDesa'] : '';
                                        $NamaDesa = isset($DataPegawai['NamaDesa']) ? $DataPegawai['NamaDesa'] : '';
                                        $Kecamatan = isset($DataPegawai['Kecamatan']) ? $DataPegawai['Kecamatan'] : '';
                                        $Kabupaten = isset($DataPegawai['Kabupaten']) ? $DataPegawai['Kabupaten'] : '';
                                        $Alamat = isset($DataPegawai['Alamat']) ? $DataPegawai['Alamat'] : '';
                                        $RT = isset($DataPegawai['RT']) ? $DataPegawai['RT'] : '';
                                        $RW = isset($DataPegawai['RW']) ? $DataPegawai['RW'] : '';

                                        $Lingkungan = isset($DataPegawai['Lingkungan']) ? $DataPegawai['Lingkungan'] : '';
                                        $AmbilDesa = mysqli_query($db, "SELECT * FROM master_desa WHERE IdDesa = '$Lingkungan' ");
                                        $LingkunganBPD = mysqli_fetch_assoc($AmbilDesa);
                                        $Komunitas = ($LingkunganBPD && isset($LingkunganBPD['NamaDesa'])) ? $LingkunganBPD['NamaDesa'] : '';

                                        $KecamatanBPD = isset($DataPegawai['Kec']) ? $DataPegawai['Kec'] : '';
                                        $AmbilKecamatan = mysqli_query($db, "SELECT * FROM master_kecamatan WHERE IdKecamatan = '$KecamatanBPD' ");
                                        $KecamatanBPD = mysqli_fetch_assoc($AmbilKecamatan);
                                        $KomunitasKec = ($KecamatanBPD && isset($KecamatanBPD['Kecamatan'])) ? $KecamatanBPD['Kecamatan'] : '';

                                        $Address = $Alamat . " RT." . $RT . "/RW." . $RW . " " . $Komunitas . " Kecamatan " . $KomunitasKec;
                                        $Setting = isset($DataPegawai['Setting']) ? $DataPegawai['Setting'] : '';
                                        $JenisMutasi = isset($DataPegawai['JenisMutasi']) ? $DataPegawai['JenisMutasi'] : '';

                                        $TglSKMutasi = isset($DataPegawai['TanggalMutasi']) ? $DataPegawai['TanggalMutasi'] : '';
                                        if (!empty($TglSKMutasi)) {
                                            $exp2 = explode('-', $TglSKMutasi);
                                            $TanggalMutasi = (isset($exp2[2]) ? $exp2[2] : '') . "-" . (isset($exp2[1]) ? $exp2[1] : '') . "-" . (isset($exp2[0]) ? $exp2[0] : '');
                                        } else {
                                            $TanggalMutasi = '';
                                        }

                                        $NomorSK = isset($DataPegawai['NomorSK']) ? $DataPegawai['NomorSK'] : '';
                                        $SKMutasi = isset($DataPegawai['FileSKMutasi']) ? $DataPegawai['FileSKMutasi'] : '';
                                        $Jabatan = isset($DataPegawai['Jabatan']) ? $DataPegawai['Jabatan'] : '';
                                        $KetJabatan = isset($DataPegawai['KeteranganJabatan']) ? $DataPegawai['KeteranganJabatan'] : '';
                                        $Siltap = isset($DataPegawai['Siltap']) ? number_format($DataPegawai['Siltap'], 0, ",", ".") : '0';
                                        $Telp = isset($DataPegawai['NoTelp']) ? $DataPegawai['NoTelp'] : '';

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
                                            
                                            
                                            <td style="width:250px;">
                                                <strong><?php echo $NIK; ?></strong>
                                            </td>

                                            <td style="width:250px;">
                                                <strong><?php echo $Nama; ?></strong><br><br>
                                                <?php echo $Address; ?>
                                            </td>
                                            <td style="width:70px;">
                                                <?php echo $ViewTglLahir; ?><br>
                                                <?php
                                                $QueryJenKel = mysqli_query($db, "SELECT * FROM master_jenkel WHERE IdJenKel = '$JenKel' ");
                                                $DataJenKel = mysqli_fetch_assoc($QueryJenKel);
                                                $JenisKelamin = ($DataJenKel && isset($DataJenKel['Keterangan'])) ? $DataJenKel['Keterangan'] : '-';
                                                echo htmlspecialchars($JenisKelamin);
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
                                                $Pendidikan = ($DataPendidikan && isset($DataPendidikan['JenisPendidikan'])) ? $DataPendidikan['JenisPendidikan'] : '-';
                                                echo htmlspecialchars($Pendidikan);
                                                ?>
                                            </td>
                                            <td style="width:160px;">
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
                        
                        <!-- Pagination Info dan Controls -->
                        <div class="row">
                            <div class="col-sm-5">
                                <div class="dataTables_info">
                                    Menampilkan <?php echo $offset + 1; ?> sampai <?php echo min($offset + $limit, $totalRecords); ?> dari <?php echo $totalRecords; ?> data
                                </div>
                            </div>
                            <div class="col-sm-7">
                                <div class="dataTables_paginate paging_simple_numbers">
                                    <ul class="pagination">
                                        <!-- Previous Button -->
                                        <?php if ($page > 1): ?>
                                            <li class="paginate_button previous">
                                                <a href="?pg=PegawaiFilterKecamatan&page=<?php echo $page - 1; ?>" 
                                                   onclick="submitFormWithPage(<?php echo $page - 1; ?>); return false;">Previous</a>
                                            </li>
                                        <?php else: ?>
                                            <li class="paginate_button previous disabled">
                                                <span>Previous</span>
                                            </li>
                                        <?php endif; ?>
                                        
                                        <!-- Page Numbers -->
                                        <?php
                                        $startPage = max(1, $page - 2);
                                        $endPage = min($totalPages, $page + 2);
                                        
                                        if ($startPage > 1): ?>
                                            <li class="paginate_button">
                                                <a href="?pg=PegawaiFilterKecamatan&page=1" 
                                                   onclick="submitFormWithPage(1); return false;">1</a>
                                            </li>
                                            <?php if ($startPage > 2): ?>
                                                <li class="paginate_button disabled"><span>...</span></li>
                                            <?php endif;
                                        endif;
                                        
                                        for ($i = $startPage; $i <= $endPage; $i++): ?>
                                            <li class="paginate_button <?php echo ($i == $page) ? 'active' : ''; ?>">
                                                <?php if ($i == $page): ?>
                                                    <span><?php echo $i; ?></span>
                                                <?php else: ?>
                                                    <a href="?pg=PegawaiFilterKecamatan&page=<?php echo $i; ?>" 
                                                       onclick="submitFormWithPage(<?php echo $i; ?>); return false;"><?php echo $i; ?></a>
                                                <?php endif; ?>
                                            </li>
                                        <?php endfor;
                                        
                                        if ($endPage < $totalPages): 
                                            if ($endPage < $totalPages - 1): ?>
                                                <li class="paginate_button disabled"><span>...</span></li>
                                            <?php endif; ?>
                                            <li class="paginate_button">
                                                <a href="?pg=PegawaiFilterKecamatan&page=<?php echo $totalPages; ?>" 
                                                   onclick="submitFormWithPage(<?php echo $totalPages; ?>); return false;"><?php echo $totalPages; ?></a>
                                            </li>
                                        <?php endif; ?>
                                        
                                        <!-- Next Button -->
                                        <?php if ($page < $totalPages): ?>
                                            <li class="paginate_button next">
                                                <a href="?pg=PegawaiFilterKecamatan&page=<?php echo $page + 1; ?>" 
                                                   onclick="submitFormWithPage(<?php echo $page + 1; ?>); return false;">Next</a>
                                            </li>
                                        <?php else: ?>
                                            <li class="paginate_button next disabled">
                                                <span>Next</span>
                                            </li>
                                        <?php endif; ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <script>
        function submitFormWithPage(pageNum) {
            // Redirect langsung dengan parameter page - filter disimpan di session
            window.location.href = '?pg=PegawaiFilterKecamatan&page=' + pageNum;
        }
        </script>
    <?php } ?>
</form>