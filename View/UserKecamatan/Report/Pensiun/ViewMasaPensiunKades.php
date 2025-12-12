<?php
// Include CSP Handler untuk nonce support
require_once __DIR__ . '/../../../../Module/Security/CSPHandler.php';

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
        .kades-pensiun-table tbody tr[style*="background-color: #fecaca"] {
            background-color: #fecaca !important;
        }
        
        .kades-pensiun-table tbody tr[style*="background-color: #fecaca"]:hover {
            background-color: #fdb8b8 !important;
        }
        
        /* Custom styling for DataTables buttons */
        .dt-buttons .btn {
            border: 2px solid !important;
            margin-right: 5px !important;
            padding: 6px 12px !important;
            border-radius: 4px !important;
        }
        
        .dt-buttons .btn-outline-default {
            border-color: #6c757d !important;
            color: #6c757d !important;
        }
        
        .dt-buttons .btn-outline-success {
            border-color: #28a745 !important;
            color: #28a745 !important;
        }
        
        .dt-buttons .btn-outline-danger {
            border-color: #dc3545 !important;
            color: #dc3545 !important;
        }
        
        .dt-buttons .btn-outline-primary {
            border-color: #007bff !important;
            color: #007bff !important;
        }
        
        .dt-buttons .btn-outline-default:hover {
            background-color: #6c757d !important;
            color: white !important;
        }
        
        .dt-buttons .btn-outline-success:hover {
            background-color: #28a745 !important;
            color: white !important;
        }
        
        .dt-buttons .btn-outline-danger:hover {
            background-color: #dc3545 !important;
            color: white !important;
        }
        
        .dt-buttons .btn-outline-primary:hover {
            background-color: #007bff !important;
            color: white !important;
        }
    </style>

    <div class="col-lg-12">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>List Semua Data Kades Mendekati Masa Pensiun</h5>
            </div>

            <div class="ibox-content">
                <!-- Hidden elements for custom filters -->
                <div style="display: none;">
                    <select id="desaFilter">
                        <option value="">Filter Desa</option>
                        <?php
                        $QueryDesaFilter = mysqli_query($db, "SELECT DISTINCT master_desa.IdDesa, master_desa.NamaDesa 
                            FROM master_desa 
                            INNER JOIN master_pegawai ON master_desa.IdDesa = master_pegawai.IdDesaFK 
                            WHERE master_desa.IdKecamatanFK = '$IdKec' 
                            ORDER BY master_desa.NamaDesa ASC");
                        while ($RowDesaFilter = mysqli_fetch_assoc($QueryDesaFilter)) {
                            echo "<option value='" . htmlspecialchars($RowDesaFilter['NamaDesa']) . "'>" . htmlspecialchars($RowDesaFilter['NamaDesa']) . "</option>";
                        }
                        ?>
                    </select>
                    <input type="search" id="customSearch" placeholder="Search:">
                </div>
                
                <div style="margin-bottom: 15px;">
                    <span style="font-style: italic; color:red">*) Laporan Dengan Warna </span>
                    <span style="background-color: #fecaca; padding: 2px 5px;">Background</span> 
                    <span style="font-style: italic; color:red"> Adalah Kepala Desa Dengan Masa Pensiun Kurang dari 3 Bulan</span>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover kades-pensiun-table" id="kadesPensiunTable">
                        <thead style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%) !important;">
                            <tr style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%) !important;">
                                <th style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%) !important; color: white !important; font-weight: bold !important; text-align: center !important;">No</th>
                                <th style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%) !important; color: white !important; font-weight: bold !important; text-align: center !important;">Foto</th>
                                <th style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%) !important; color: white !important; font-weight: bold !important; text-align: center !important;">NIK</th>
                                <th style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%) !important; color: white !important; font-weight: bold !important; text-align: center !important;">Nama<br>Jabatan<br>Alamat</th>
                                <th style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%) !important; color: white !important; font-weight: bold !important; text-align: center !important;">Tanggal Lahir<br>Jenis Kelamin</th>
                                <th style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%) !important; color: white !important; font-weight: bold !important; text-align: center !important;">Tanggal Mutasi</th>
                                <th style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%) !important; color: white !important; font-weight: bold !important; text-align: center !important;">Tanggal Pensiun<br>Sisa Pensiun</th>
                                <th style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%) !important; color: white !important; font-weight: bold !important; text-align: center !important;">Keterangan</th>
                                <th style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%) !important; color: white !important; font-weight: bold !important; text-align: center !important;">Unit Kerja<br>Kecamatan<br>Kabupaten</th>
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
                                $StatusPensiunKabupaten = $DataPegawai['StatusPensiunKabupaten'];
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
                                            if ($StatusPensiunKabupaten === '1') {
                                                echo "<span class='label label-success'>Disetujui Kabupaten</span>";
                                            } elseif ($StatusPensiunKabupaten === '0') {
                                                echo "<span class='label label-danger'>Ditolak Kabupaten</span>";
                                            }
                                            // Jika belum ada status Kabupaten, cek Kecamatan
                                            elseif (is_null($StatusPensiunKecamatan) && !is_null($IdFilePengajuanPensiunFK) && $StatusPensiunDesa === '1') {
                                                ?>
                                                <form method="POST" action="UserKecamatan/Report/Pensiun/UpdateStatusPengajuanKec.php" style="margin-top: 5px;">
                                                    <input type="hidden" name="IdPegawaiFK" value="<?= $IdPegawaiFK ?>">
                                                    <button type="submit" name="setujui" class="btn btn-xs btn-success">Setujui</button>
                                                    <button type="submit" name="tolak" class="btn btn-xs btn-danger">Tolak</button>
                                                </form>
                                                <?php
                                            } elseif ($StatusPensiunKecamatan === '1') {
                                                echo "<span class='label label-success'>Disetujui Kecamatan</span>";
                                            } elseif ($StatusPensiunKecamatan === '0') {
                                                echo "<span class='label label-danger'>Ditolak Kecamatan</span>";
                                            }
                                            // Jika belum ada status Kecamatan, tampilkan status Desa
                                            elseif ($StatusPensiunDesa === '1') {
                                                echo "<span class='label label-success'>Disetujui Desa</span>";
                                            } elseif ($StatusPensiunDesa === '0') {
                                                echo "<span class='label label-danger'>Ditolak Desa</span>";
                                            }
                                            // Jika ada file tapi belum disetujui Desa
                                            elseif (!is_null($IdFilePengajuanPensiunFK) && is_null($StatusPensiunDesa)) {
                                                echo "<span class='label label-warning'>Menunggu Persetujuan Desa</span>";
                                            }
                                            // Jika tidak ada file pengajuan sama sekali
                                            else {
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

<!-- JavaScript untuk filter dropdown -->
<script <?php echo CSPHandler::scriptNonce(); ?>>
$(document).ready(function() {
    console.log('Initializing Kades Pensiun DataTable with custom filters...');
    
    // Check if DataTable already exists and destroy it
    if ($.fn.DataTable.isDataTable('#kadesPensiunTable')) {
        console.log('DataTable already exists, destroying...');
        $('#kadesPensiunTable').DataTable().destroy();
    }
    
    // Initialize DataTable dengan konfigurasi yang tepat
    var table = $('#kadesPensiunTable').DataTable({
        "dom": '<"row"<"col-sm-6"B><"col-sm-6"<"custom-filters">>>rt<"bottom"ip><"clear">',
        "pageLength": 10,
        "searching": true,
        "paging": true,
        "info": true,
        "lengthChange": true,
        "destroy": true, // Allow reinitialisation
        "buttons": [
            {
                extend: 'copy',
                text: '<i class="fa fa-copy"></i> Copy',
                className: 'btn btn-outline btn-default'
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
                    // Get current filter value from moved element
                    var currentFilter = $('#desaFilterMoved').val() || $('#desaFilter').val();
                    var pdfUrl = 'UserKecamatan/Report/Pensiun/PdfKadesPensiunReportAll.php';
                    
                    // Add filter parameter if exists
                    if (currentFilter && currentFilter !== '') {
                        pdfUrl += '?desa=' + encodeURIComponent(currentFilter);
                    }
                    
                    // Open PDF in new window
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

    console.log('Kades Pensiun DataTable initialized successfully');

    // Move custom filters to the right container
    setTimeout(function() {
        // Create the filter HTML
        var filterHtml = '<div style="text-align: right; padding-top: 5px;">' +
            '<select class="form-control input-sm" style="display: inline-block; width: 150px; margin-right: 10px;" id="desaFilterMoved">' +
            $('#desaFilter').html() +
            '</select>' +
            '<input type="search" class="form-control input-sm" placeholder="Search:" style="display: inline-block; width: 200px;" id="customSearchMoved">' +
            '</div>';
        
        // Insert into custom-filters container
        $('.custom-filters').html(filterHtml);
        
        // Copy current values
        $('#desaFilterMoved').val($('#desaFilter').val());
        $('#customSearchMoved').val($('#customSearch').val());
        
        console.log('Kades Pensiun filters moved to custom container');
    }, 100);

    // Custom search input (use event delegation for moved elements)
    $(document).on('keyup', '#customSearchMoved', function() {
        console.log('Kades Pensiun search input:', this.value);
        table.search(this.value).draw();
    });

    // Desa filter functionality (use event delegation for moved elements)
    $(document).on('change', '#desaFilterMoved', function() {
        var selectedDesa = $(this).val();
        console.log('Kades Pensiun desa filter changed to:', selectedDesa);
        
        if (selectedDesa === '') {
            table.column(8).search('').draw(); // Column 8 is Unit Kerja column (contains desa name)
        } else {
            table.column(8).search(selectedDesa).draw();
        }
    });

    // Debug: Check if elements exist
    setTimeout(function() {
        console.log('Kades Pensiun moved dropdown exists:', $('#desaFilterMoved').length > 0);
        console.log('Kades Pensiun moved search input exists:', $('#customSearchMoved').length > 0);
        console.log('Kades Pensiun custom filters container exists:', $('.custom-filters').length > 0);
    }, 200);
});
</script>