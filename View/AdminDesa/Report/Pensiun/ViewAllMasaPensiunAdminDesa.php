<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$_SESSION['visited_pensiun_perangkat'] = true;
$IdDesa = $_SESSION['IdDesa'];
?>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Data Kepala Desa dan Perangkat Desa Mendekati Masa Pensiun</h2>
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
        
        /* Styling untuk background highlight pensiun */
        .dataTables-kecamatan tbody tr[style*="background-color: #fecaca"] {
            background-color: #fecaca !important;
        }
        
        .dataTables-kecamatan tbody tr[style*="background-color: #fecaca"]:hover {
            background-color: #fdb8b8 !important;
        }
    </style>

    <div class="col-lg-12">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>Filter Data Kepala Desa dan Perangkat Desa Mendekati Masa Pensiun</h5>
            </div>

            <div class="ibox-content">

                <div class="text-left">
                    <a href="AdminDesa/Report/Pdf/MasaPensiunDesaPdf" target="_BLANK">
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
                                            history_mutasi.Setting AS IDSetting,
                                            master_jabatan.IdJabatan,
                                            history_mutasi.IdJabatanFK,
                                            master_jabatan.Jabatan,
                                            history_mutasi.TanggalMutasi,
                                            master_pegawai.StatusPensiunDesa,
                                            master_pegawai.StatusPensiunKecamatan,
                                            master_pegawai.StatusPensiunKabupaten,
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
                                            history_mutasi.Setting = 1 AND
                                            master_pegawai.IdDesaFK = '$IdDesa'
                                            ORDER BY 
                                            CASE WHEN history_mutasi.IdJabatanFK = 1 THEN 0 ELSE 1 END,
                                            master_pegawai.TanggalPensiun ASC");
                            while ($DataPegawai = mysqli_fetch_assoc($QueryPegawai)) {
                                $IdPegawaiFK = $DataPegawai['IdPegawaiFK'];
                                $Foto = $DataPegawai['Foto'];
                                $NIK = $DataPegawai['NIK'];
                                $Nama = $DataPegawai['Nama'];
                                $Jabatan = $DataPegawai['Jabatan'];

                                $TanggalLahir = $DataPegawai['TanggalLahir'];
                                $ViewTglLahir = date("d-m-Y", strtotime($TanggalLahir));
                                
                                $IdJabatanFK = $DataPegawai['IdJabatanFK'];
                                
                                // Logika perhitungan tanggal pensiun berbeda untuk Kepala Desa dan Perangkat Desa
                                if ($IdJabatanFK == 1) { 
                                    // Logika untuk Kepala Desa (6 tahun dari tanggal mutasi)
                                    $TanggalMutasi = $DataPegawai['TanggalMutasi'];
                                    $TanggalPensiun = date('Y-m-d', strtotime('+6 year', strtotime($TanggalMutasi)));
                                } else { 
                                    // Logika untuk Perangkat Desa (dari field TanggalPensiun)
                                    $TanggalPensiun = $DataPegawai['TanggalPensiun'];
                                }
                                
                                $ViewTglPensiun = date('d-m-Y', strtotime($TanggalPensiun));

                                //HITUNG DETAIL TANGGAL PENSIUN
                                $TglPensiun = date_create($TanggalPensiun);
                                $TglSekarang = date_create();
                                $Temp = date_diff($TglSekarang, $TglPensiun);

                                //CEK TANGGAL ASLI SAAT INI
                                $TglSekarang1 = Date('Y-m-d');

                                // Inisialisasi variabel untuk menghindari error
                                $TahunInt = 0; 
                                $BulanInt = 0; 
                                $HariInt = 0;

                                if ($TglSekarang1 >= $TanggalPensiun) {
                                    $HasilTahun = '0 Tahun ';
                                    $HasilBulan = '0 Bulan ';
                                    $HasilHari = '0 Hari ';
                                } elseif ($TglSekarang1 < $TanggalPensiun) {
                                    $HasilTahun = $Temp->y . ' Tahun ';
                                    $HasilBulan = $Temp->m . ' Bulan ';
                                    $HasilHari = ($Temp->d + 1) . ' Hari ';

                                    $TahunInt = $Temp->y;
                                    $BulanInt = $Temp->m;
                                    $HariInt = $Temp->d + 1;
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
                                $StatusPensiunKabupaten = $DataPegawai['StatusPensiunKabupaten'];
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
                                        <strong style="color: <?php echo ($Jabatan == 'Kepala Desa') ? '#006400' : 'inherit'; ?> !important;"><?php echo $Jabatan; ?></strong><br><br>
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
                                        // Hitung tanggal 3 bulan sebelum pensiun
                                        $tanggal3BulanSebelumPensiun = date('Y-m-d', strtotime('-3 months', strtotime($TanggalPensiun)));
                                        
                                        // Tampilkan approval jika kurang dari 3 bulan sebelum pensiun
                                        if ($TglSekarang1 >= $tanggal3BulanSebelumPensiun && $Setting == 1) {
                                            // Tampilkan tombol Lihat File jika ada file dan tidak ditolak
                                            if (!is_null($IdFilePengajuanPensiunFK) && $IdFilePengajuanPensiunFK != '' && 
                                                $StatusPensiunDesa !== '0' && 
                                                $StatusPensiunKecamatan !== '0' && 
                                                $StatusPensiunKabupaten !== '0') {
                                                ?>
                                                <a href="../Module/File/ViewFilePengajuan.php?id=<?= $IdFilePengajuanPensiunFK ?>"
                                                    target="_blank" class="btn btn-xs btn-info" style="margin-bottom:5px;">
                                                    Lihat File Pengajuan
                                                </a><br>
                                                <?php
                                            }
                                            
                                            // Prioritas tampilan: Kabupaten > Kecamatan > Desa
                                            // Tampilkan status tertinggi/terakhir saja
                                            if ($StatusPensiunKabupaten === '1') {
                                                echo "<span class='label label-success'>Disetujui Kabupaten</span>";
                                            } elseif ($StatusPensiunKabupaten === '0') {
                                                echo "<span class='label label-danger'>Ditolak Kabupaten</span>";
                                            } 
                                            // Jika belum ada status Kabupaten, cek Kecamatan
                                            elseif ($StatusPensiunKecamatan === '1') {
                                                echo "<span class='label label-success'>Disetujui Kecamatan</span>";
                                            } elseif ($StatusPensiunKecamatan === '0') {
                                                echo "<span class='label label-danger'>Ditolak Kecamatan</span>";
                                            } 
                                            // Jika belum ada status Kecamatan, tampilkan status Desa
                                            elseif ($StatusPensiunDesa === '1') {
                                                echo "<span class='label label-success'>Disetujui Desa</span>";
                                            } elseif ($StatusPensiunDesa === '0') {
                                                echo "<span class='label label-danger'>Ditolak Desa</span>";
                                            } elseif (is_null($StatusPensiunDesa) && !is_null($IdFilePengajuanPensiunFK)) {
                                                ?>
                                                <form method="POST" action="AdminDesa/Report/Pensiun/UpdateStatusPengajuanDesa.php"
                                                    style="margin-top: 5px;">
                                                    <input type="hidden" name="IdPegawaiFK" value="<?= $IdPegawaiFK ?>">
                                                    <button type="submit" name="setujui"
                                                        class="btn btn-xs btn-success">Setujui</button>
                                                    <button type="submit" name="tolak" class="btn btn-xs btn-danger">Tolak</button>
                                                </form>
                                                <?php
                                            } else {
                                                echo "<span class='label label-danger'>Belum Mengajukan Pensiun</span>";
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

<!-- Script untuk mengatasi masalah pace loading yang tidak selesai -->
<script>
    // Force pace loading to complete after page is fully loaded
    window.addEventListener('load', function() {
        // Wait a bit for all scripts to finish
        setTimeout(function() {
            // Force pace to complete if it's still running
            if (typeof Pace !== 'undefined' && Pace.running) {
                Pace.stop();
            }
            // Add pace-done class to body if not already present
            if (!document.body.classList.contains('pace-done')) {
                document.body.classList.add('pace-done');
            }
            // Hide any remaining pace elements
            var paceElements = document.querySelectorAll('.pace');
            paceElements.forEach(function(el) {
                el.style.display = 'none';
            });
        }, 1000); // Wait 1 second after page load
    });

    // Fallback - force pace to complete after DOM is ready
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(function() {
            if (typeof Pace !== 'undefined' && Pace.running) {
                Pace.stop();
            }
            document.body.classList.add('pace-done');
        }, 2000); // Wait 2 seconds after DOM ready
    });
    
    // Function untuk close notification bar
    function closeNotificationBar() {
        const notifBar = document.querySelector('.notification-bar');
        if (notifBar) {
            notifBar.style.animation = 'slideUp 0.3s ease-out forwards';
            setTimeout(() => {
                notifBar.style.display = 'none';
                // Store in localStorage untuk session ini
                localStorage.setItem('notifBarClosed', 'true');
            }, 300);
        }
    }
    
    // Check apakah notification bar sudah di-close sebelumnya
    document.addEventListener('DOMContentLoaded', function() {
        if (localStorage.getItem('notifBarClosed') === 'true') {
            const notifBar = document.querySelector('.notification-bar');
            if (notifBar) {
                notifBar.style.display = 'none';
            }
        }
    });
</script>