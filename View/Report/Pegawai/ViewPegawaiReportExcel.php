<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Data Kepala Desa & Perangkat Desa </h2>
    </div>
    <div class="col-lg-2">

    </div>
</div>

<style>
/* Enhanced Pagination Styles */
.pagination {
    margin: 20px 0;
    display: flex;
    justify-content: center;
}
.pagination .page-item .page-link {
    color: #337ab7;
    background-color: #fff;
    border: 1px solid #ddd;
    padding: 8px 12px;
    margin: 0 2px;
    border-radius: 4px;
    text-decoration: none;
    font-weight: 500;
    font-size: 14px;
}
.pagination .page-item.active .page-link {
    background-color: #337ab7 !important;
    border-color: #337ab7 !important;
    color: #fff !important;
    font-weight: bold;
    box-shadow: 0 2px 4px rgba(51, 122, 183, 0.3);
}
.pagination .page-item:hover .page-link {
    background-color: #286090;
    border-color: #286090;
    color: #fff;
}
.pagination .page-item.disabled .page-link {
    color: #6c757d;
    background-color: #fff;
    border-color: #ddd;
    cursor: not-allowed;
}
.dataTables_info {
    padding-top: 8px;
    color: #666;
    font-size: 14px;
}
.dataTables_paginate {
    text-align: right;
}
.mb-3 {
    margin-bottom: 1rem;
}
.search-box {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 8px;
    margin-bottom: 20px;
    border: 1px solid #e9ecef;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}
.search-input {
    width: 100%;
    padding: 10px 15px;
    border: 1px solid #ced4da;
    border-radius: 5px;
    font-size: 14px;
    transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
}
.search-input:focus {
    border-color: #337ab7;
    box-shadow: 0 0 0 0.2rem rgba(51, 122, 183, 0.25);
    outline: 0;
}
.search-btn {
    padding: 10px 20px;
    background-color: #337ab7;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 14px;
    font-weight: 500;
    transition: background-color 0.15s ease-in-out;
    display: inline-block;
    text-decoration: none;
}
.search-btn:hover {
    background-color: #286090;
    color: white;
    text-decoration: none;
}
.form-group {
    margin-bottom: 15px;
}
.form-group label {
    color: #495057;
    font-size: 14px;
}
/* Table Responsive */
.table-responsive {
    border: 1px solid #ddd;
    border-radius: 5px;
    margin-bottom: 20px;
}
.table {
    margin-bottom: 0;
}
.table th {
    background-color: #f8f9fa;
    font-weight: 600;
    border-top: none;
    vertical-align: middle;
}
.table td {
    vertical-align: middle;
}
/* Alert Styling */
.alert {
    border: none;
    border-radius: 5px;
}
.mt-2 {
    margin-top: 0.5rem;
}
.mb-3 {
    margin-bottom: 1rem;
}
.align-items-center {
    align-items: center;
}
</style>

<div class="wrapper wrapper-content animated fadeInRight">

    <div class="col-lg-12">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>List Semua Data</h5>
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
                <!-- Search Box -->
                <div class="search-box">
                    <form method="GET" action="">
                        <input type="hidden" name="pg" value="ViewPegawaiReportExcel">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="search" style="margin-bottom: 5px; font-weight: bold;">Pencarian Data:</label>
                                    <input type="text" name="search" id="search" class="search-input" 
                                           placeholder="Cari berdasarkan nama, NIK, kecamatan, desa, atau jabatan..." 
                                           value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group" style="padding-top: 25px;">
                                    <button type="submit" class="search-btn">
                                        <i class="fa fa-search"></i> Cari
                                    </button>
                                    <?php if(isset($_GET['search']) && !empty($_GET['search'])): ?>
                                        <a href="?pg=ViewPegawaiReportExcel" class="search-btn" style="background-color: #dc3545; margin-left: 5px; text-decoration: none;">
                                            <i class="fa fa-times"></i> Reset
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <?php if(isset($_GET['search']) && !empty($_GET['search'])): ?>
                        <div class="row mt-2">
                            <div class="col-md-12">
                                <div class="alert alert-info" style="margin-bottom: 0; padding: 10px;">
                                    <i class="fa fa-search"></i> Hasil pencarian untuk: "<strong><?php echo htmlspecialchars($_GET['search']); ?></strong>"
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                    </form>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dataTables-kecamatan">
                        <thead>
                            <tr align="center">
                                <th>No</th>
                                <th>Kecamatan</th>
                                <th>Desa</th>
                                <th>Kode Desa</th>
                                <th>Foto</th>
                                <th>NIK</th>
                                <th>Nama Perangkat</th>
                                <th>Alamat</th>
                                <th>Tgl Lahir</th>
                                <th>Jenis Kelamin</th>
                                <th>Pendidikan</th>
                                <th>SK</th>
                                <th>Tgl Pengangkatan</th>
                                <th>Jabatan</th>
                                <th>Keterangan</th>
                                <th>Siltap (Rp.)</th>
                                <th>Telp</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Search functionality
                            $search = isset($_GET['search']) ? mysqli_real_escape_string($db, $_GET['search']) : '';
                            $searchCondition = '';
                            $searchParams = '';
                            if (!empty($search)) {
                                $searchCondition = " AND (
                                    master_pegawai.Nama LIKE '%$search%' OR 
                                    master_pegawai.NIK LIKE '%$search%' OR 
                                    master_kecamatan.Kecamatan LIKE '%$search%' OR 
                                    master_desa.NamaDesa LIKE '%$search%' OR
                                    master_jabatan.Jabatan LIKE '%$search%'
                                )";
                                $searchParams = '&search=' . urlencode($_GET['search']);
                            }

                            // Pagination setup
                            $limit = 50; // Record per halaman
                            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                            $offset = ($page - 1) * $limit;

                            // Query untuk menghitung total data
                            $queryCount = mysqli_query($db, "SELECT COUNT(DISTINCT master_pegawai.IdPegawaiFK) as total
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
                            history_mutasi.Setting = 1
                            $searchCondition");
                            
                            $countResult = mysqli_fetch_assoc($queryCount);
                            $totalRecords = ($countResult !== null) ? $countResult['total'] : 0;
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
                            history_mutasi.Setting = 1
                            $searchCondition
                            GROUP BY
                            master_pegawai.IdPegawaiFK
                            ORDER BY
                            master_kecamatan.IdKecamatan ASC,
                            master_desa.NamaDesa ASC,
                            history_mutasi.IdJabatanFK ASC
                            LIMIT $limit OFFSET $offset");
                            while ($DataPegawai = mysqli_fetch_assoc($QueryPegawai)) {
                                $IdPegawaiFK = $DataPegawai['IdPegawaiFK'];
                                $Foto = $DataPegawai['Foto'];
                                $NIK = $DataPegawai['NIK'];
                                $Nama = $DataPegawai['Nama'];

                                $TanggalLahir = $DataPegawai['TanggalLahir'];
                                $exp = explode('-', $TanggalLahir);
                                $ViewTglLahir = (count($exp) >= 3) ? $exp[2] . "-" . $exp[1] . "-" . $exp[0] : $TanggalLahir;

                                $TanggalPensiun = $DataPegawai['TanggalPensiun'] ?? '';
                                if (!empty($TanggalPensiun)) {
                                    $exp1 = explode('-', $TanggalPensiun);
                                    $ViewTglPensiun = (count($exp1) >= 3) ? $exp1[2] . "-" . $exp1[1] . "-" . $exp1[0] : $TanggalPensiun;
                                } else {
                                    $ViewTglPensiun = '-';
                                }

                                //HITUNG DETAIL TANGGAL PENSIUN
                                if (!empty($TanggalPensiun)) {
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
                                } else {
                                    $HasilTahun = '-';
                                    $HasilBulan = '-';
                                    $HasilHari = '-';
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
                                $Komunitas = $LingkunganBPD['NamaDesa'] ?? 'Tidak Diketahui';

                                $KecamatanBPD = $DataPegawai['Kec'];
                                $AmbilKecamatan = mysqli_query($db, "SELECT * FROM master_kecamatan WHERE IdKecamatan = '$KecamatanBPD' ");
                                $KecamatanBPD = mysqli_fetch_assoc($AmbilKecamatan);
                                $KomunitasKec = $KecamatanBPD['Kecamatan'] ?? 'Tidak Diketahui';

                                $Address = $Alamat . " RT." . $RT . "/RW." . $RW . " " . $Komunitas . " Kecamatan " . $KomunitasKec;
                                $Setting = $DataPegawai['Setting'];
                                $JenisMutasi = $DataPegawai['JenisMutasi'] ?? '';

                                $TglSKMutasi = $DataPegawai['TanggalMutasi'];
                                if (!empty($TglSKMutasi)) {
                                    $exp2 = explode('-', $TglSKMutasi);
                                    $TanggalMutasi = (count($exp2) >= 3) ? $exp2[2] . "-" . $exp2[1] . "-" . $exp2[0] : $TglSKMutasi;
                                } else {
                                    $TanggalMutasi = '-';
                                }

                                $NomorSK = $DataPegawai['NomorSK'];
                                $SKMutasi = $DataPegawai['FileSKMutasi'] ?? '';
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
                                        <?php echo $Kecamatan; ?>
                                    </td>

                                    <td>
                                        <span style="color:blue"><strong><?php echo $NamaDesa; ?></strong></span>
                                    </td>

                                    <td>
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
                                        <span style="font-size:1">'</span><span style="font-size:14"><strong><?php echo $NIK; ?></strong></span>
                                    </td>

                                    <td style="width:350px;">
                                        <strong><?php echo $Nama; ?></strong>
                                    </td>

                                     <td style="width:350px;">
                                        <?php echo $Address; ?>
                                    </td>

                                    <td style="width:70px;">
                                        <?php echo $ViewTglLahir; ?>
                                    </td>

                                    <td style="width:70px;">
                                        <?php
                                        $QueryJenKel = mysqli_query($db, "SELECT * FROM master_jenkel WHERE IdJenKel = '$JenKel' ");
                                        $DataJenKel = mysqli_fetch_assoc($QueryJenKel);
                                        $JenisKelamin = ($DataJenKel !== null) ? $DataJenKel['Keterangan'] : '-';
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
                                        $Pendidikan = ($DataPendidikan !== null) ? $DataPendidikan['JenisPendidikan'] : '-';
                                        echo $Pendidikan;
                                        ?>
                                    </td>
                                    <td style="width:60px;">
                                        <?php echo $NomorSK;?>
                                    </td>
                                    <td style="width:70px;">
                                        <?php echo $TanggalMutasi; ?>
                                    </td>
                                    <td><?php echo $Jabatan; ?></td>
                                    <td><?php echo $KetJabatan; ?></td>
                                    <td><?php echo $Siltap; ?></td>
                                    <td><span style="font-size:1">'</span><?php echo $Telp; ?></td>

                                </tr>
                            <?php $Nomor++;
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="dataTables_info">
                            Menampilkan <?php echo $offset + 1; ?> sampai <?php echo min($offset + $limit, $totalRecords); ?> dari <?php echo $totalRecords; ?> data
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="dataTables_paginate">
                            <ul class="pagination justify-content-end">
                                <?php if ($page > 1): ?>
                                    <li class="page-item">
                                        <a class="page-link" href="?pg=ViewPegawaiReportExcel&page=<?php echo $page - 1; ?><?php echo $searchParams; ?>">Previous</a>
                                    </li>
                                <?php endif; ?>

                                <?php
                                // Tampilkan halaman pertama jika tidak terlihat
                                if ($page > 3): ?>
                                    <li class="page-item">
                                        <a class="page-link" href="?pg=ViewPegawaiReportExcel&page=1<?php echo $searchParams; ?>">1</a>
                                    </li>
                                    <?php if ($page > 4): ?>
                                        <li class="page-item disabled">
                                            <span class="page-link">...</span>
                                        </li>
                                    <?php endif; ?>
                                <?php endif; ?>

                                <?php
                                // Tampilkan maksimal 5 nomor halaman
                                $start = max(1, $page - 2);
                                $end = min($totalPages, $page + 2);
                                
                                for ($i = $start; $i <= $end; $i++): ?>
                                    <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                                        <a class="page-link" href="?pg=ViewPegawaiReportExcel&page=<?php echo $i; ?><?php echo $searchParams; ?>"><?php echo $i; ?></a>
                                    </li>
                                <?php endfor; ?>

                                <?php
                                // Tampilkan halaman terakhir jika tidak terlihat
                                if ($page < $totalPages - 2): ?>
                                    <?php if ($page < $totalPages - 3): ?>
                                        <li class="page-item disabled">
                                            <span class="page-link">...</span>
                                        </li>
                                    <?php endif; ?>
                                    <li class="page-item">
                                        <a class="page-link" href="?pg=ViewPegawaiReportExcel&page=<?php echo $totalPages; ?><?php echo $searchParams; ?>"><?php echo $totalPages; ?></a>
                                    </li>
                                <?php endif; ?>

                                <?php if ($page < $totalPages): ?>
                                    <li class="page-item">
                                        <a class="page-link" href="?pg=ViewPegawaiReportExcel&page=<?php echo $page + 1; ?><?php echo $searchParams; ?>">Next</a>
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