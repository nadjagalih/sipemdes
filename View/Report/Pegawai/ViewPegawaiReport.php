<?php
// Include CSP Handler untuk nonce support
require_once __DIR__ . '/../../../Module/Security/CSPHandler.php';
?>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Data Kepala Desa & Perangkat Desa </h2>
    </div>
    <div class="col-lg-2">

    </div>
</div>

<style>
/* Perkecil kolom Pendidikan */
.tabel-pegawai th:nth-child(7), 
.tabel-pegawai td:nth-child(7) {
    width: 80px !important;
    max-width: 80px !important;
    font-size: 12px;
    text-align: center;
    word-wrap: break-word;
    vertical-align: middle;
}

/* Responsive font untuk tabel */
.tabel-pegawai {
    font-size: 12px;
    min-width: 1200px; /* Minimum width untuk memaksa horizontal scroll */
}

.tabel-pegawai th, 
.tabel-pegawai td {
    padding: 6px 4px !important;
    vertical-align: middle !important;
    white-space: nowrap; /* Prevent text wrapping untuk scroll horizontal */
}

/* Enhanced table responsive */
.table-responsive {
    overflow-x: auto !important;
    overflow-y: visible !important;
    -webkit-overflow-scrolling: touch;
    border: 1px solid #dee2e6;
    border-radius: 4px;
}

/* Custom scrollbar styling */
.table-responsive::-webkit-scrollbar {
    height: 12px;
}

.table-responsive::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 6px;
}

.table-responsive::-webkit-scrollbar-thumb {
    background: #888;
    border-radius: 6px;
}

.table-responsive::-webkit-scrollbar-thumb:hover {
    background: #555;
}

/* Sticky first column for better navigation */
.tabel-pegawai th:nth-child(1),
.tabel-pegawai td:nth-child(1) {
    position: sticky;
    left: 0;
    background: #fff;
    z-index: 10;
    border-right: 2px solid #dee2e6;
}

.tabel-pegawai thead th:nth-child(1) {
    background: #f8f9fa;
    z-index: 11;
}
</style>

<div class="wrapper wrapper-content animated fadeInRight">
    <!-- Hidden elements for custom filters -->
    <div style="display: none;">
        <select id="kecamatanFilter">
            <option value="">Filter Kecamatan</option>
        </select>
        <select id="desaFilter">
            <option value="">Filter Desa</option>
        </select>
        <input type="search" id="customSearch" placeholder="Search:">
    </div>

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
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover tabel-pegawai" id="pegawaiTable">
                        <thead>
                            <tr align="center">
                                <th rowspan="2">No</th>
                                <th rowspan="2">Kecamatan<br>Desa<br>Kode Desa</th>
                                <th rowspan="2">Foto</th>
                                <th rowspan="2">NIK</th>
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
                            // DataTables will handle pagination, so we load all data
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
                            history_mutasi.Setting = 1
                            GROUP BY
                            master_pegawai.IdPegawaiFK
                            ORDER BY
                            master_kecamatan.IdKecamatan ASC,
                            master_desa.NamaDesa ASC,
                            history_mutasi.IdJabatanFK ASC");
                            while ($DataPegawai = mysqli_fetch_assoc($QueryPegawai)) {
                                $IdPegawaiFK = $DataPegawai['IdPegawaiFK'];
                                $Foto = $DataPegawai['Foto'];
                                $NIK = $DataPegawai['NIK'];
                                $Nama = $DataPegawai['Nama'];

                                $TanggalLahir = $DataPegawai['TanggalLahir'];
                                // Cek dan format tanggal lahir
                                if (!empty($TanggalLahir) && $TanggalLahir != '0000-00-00') {
                                    $exp = explode('-', $TanggalLahir);
                                    if (count($exp) >= 3) {
                                        $ViewTglLahir = $exp[2] . "-" . $exp[1] . "-" . $exp[0];
                                    } else {
                                        $ViewTglLahir = $TanggalLahir;
                                    }
                                } else {
                                    $ViewTglLahir = "Tidak Diset";
                                }

                                $TanggalPensiun = $DataPegawai['TanggalPensiun'] ?? null;
                                // Cek dan format tanggal pensiun
                                if (!empty($TanggalPensiun) && $TanggalPensiun != '0000-00-00') {
                                    $exp1 = explode('-', $TanggalPensiun);
                                    if (count($exp1) >= 3) {
                                        $ViewTglPensiun = $exp1[2] . "-" . $exp1[1] . "-" . $exp1[0];
                                    } else {
                                        $ViewTglPensiun = $TanggalPensiun;
                                    }
                                } else {
                                    $ViewTglPensiun = "Tidak Diset";
                                }

                                //HITUNG DETAIL TANGGAL PENSIUN
                                if (!empty($TanggalPensiun) && $TanggalPensiun != '0000-00-00') {
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
                                    // Jika tanggal pensiun tidak valid
                                    $HasilTahun = 'Tidak Diset';
                                    $HasilBulan = '';
                                    $HasilHari = '';
                                }
                                //SELESAI

                                $JenKel = $DataPegawai['JenKel'];
                                $KodeDesa = $DataPegawai['KodeDesa'];
                                $NamaDesa = $DataPegawai['NamaDesa'];
                                $Kecamatan = $DataPegawai['Kecamatan'];
                                $Kabupaten = $DataPegawai['Kabupaten'];
                                $Alamat = $DataPegawai['Alamat'] ?? '';
                                $RT = $DataPegawai['RT'] ?? '';
                                $RW = $DataPegawai['RW'] ?? '';

                                $Lingkungan = $DataPegawai['Lingkungan'] ?? '';
                                $AmbilDesa = mysqli_query($db, "SELECT * FROM master_desa WHERE IdDesa = '$Lingkungan' ");
                                $LingkunganBPD = mysqli_fetch_assoc($AmbilDesa);
                                $Komunitas = ($LingkunganBPD && isset($LingkunganBPD['NamaDesa'])) ? $LingkunganBPD['NamaDesa'] : 'Data Tidak Ditemukan';

                                $KecamatanBPD = $DataPegawai['Kec'] ?? '';
                                $AmbilKecamatan = mysqli_query($db, "SELECT * FROM master_kecamatan WHERE IdKecamatan = '$KecamatanBPD' ");
                                $KecamatanBPDData = mysqli_fetch_assoc($AmbilKecamatan);
                                $KomunitasKec = ($KecamatanBPDData && isset($KecamatanBPDData['Kecamatan'])) ? $KecamatanBPDData['Kecamatan'] : 'Data Tidak Ditemukan';

                                $Address = $Alamat . " RT." . $RT . "/RW." . $RW . " " . $Komunitas . " Kecamatan " . $KomunitasKec;
                                $Setting = $DataPegawai['Setting'] ?? 1;
                                $JenisMutasi = $DataPegawai['JenisMutasi'] ?? '';

                                $TglSKMutasi = $DataPegawai['TanggalMutasi'] ?? null;
                                // Cek dan format tanggal mutasi
                                if (!empty($TglSKMutasi) && $TglSKMutasi != '0000-00-00') {
                                    $exp2 = explode('-', $TglSKMutasi);
                                    if (count($exp2) >= 3) {
                                        $TanggalMutasi = $exp2[2] . "-" . $exp2[1] . "-" . $exp2[0];
                                    } else {
                                        $TanggalMutasi = $TglSKMutasi;
                                    }
                                } else {
                                    $TanggalMutasi = "Tidak Diset";
                                }

                                $NomorSK = $DataPegawai['NomorSK'] ?? '';
                                $SKMutasi = $DataPegawai['FileSKMutasi'] ?? '';
                                $Jabatan = $DataPegawai['Jabatan'] ?? '';
                                $KetJabatan = $DataPegawai['KeteranganJabatan'] ?? '';
                                $Siltap = isset($DataPegawai['Siltap']) ? number_format($DataPegawai['Siltap'], 0, ",", ".") : '0';
                                $Telp = $DataPegawai['NoTelp'] ?? '';

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
                                        <strong><?php echo $NIK; ?></strong>
                                    </td>

                                    <td style="width:350px;">
                                        <strong><?php echo $Nama; ?></strong><br><br>
                                        <?php echo $Address; ?>
                                    </td>
                                    <td style="width:70px;">
                                        <?php echo $ViewTglLahir; ?><br>
                                        <?php
                                        $QueryJenKel = mysqli_query($db, "SELECT * FROM master_jenkel WHERE IdJenKel = '$JenKel' ");
                                        $DataJenKel = mysqli_fetch_assoc($QueryJenKel);
                                        $JenisKelamin = ($DataJenKel && isset($DataJenKel['Keterangan'])) ? $DataJenKel['Keterangan'] : '';
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
                                        $Pendidikan = ($DataPendidikan && isset($DataPendidikan['JenisPendidikan'])) ? $DataPendidikan['JenisPendidikan'] : '';
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

<!-- JavaScript untuk DataTables dengan filter dropdown -->
<script <?php echo CSPHandler::scriptNonce(); ?>>
$(document).ready(function() {
    console.log('Initializing DataTable with custom filters...');
                        
                        // Mapping objects to store ID to Name relationships
                        var kecamatanMap = {};
                        var desaMap = {};
                        
                        // Load Kecamatan data via AJAX
                        $.ajax({
                            type: 'POST',
                            url: "Report/Mutasi/GetKecamatan.php",
                            cache: false,
                            success: function(msg) {
                                $("#kecamatanFilter").html(msg);
                                
                                // Build kecamatan mapping (ID -> Name)
                                $("#kecamatanFilter option").each(function() {
                                    if ($(this).val() !== '') {
                                        kecamatanMap[$(this).val()] = $(this).text();
                                    }
                                });
                                console.log('Kecamatan loaded:', Object.keys(kecamatanMap).length);
                            },
                            error: function(xhr, status, error) {
                                console.error("Error loading kecamatan:", error);
                                $("#kecamatanFilter").html("<option value=''>Error loading data</option>");
                            }
                        });
                        
                        // Handle Kecamatan change to load Desa
                        $(document).on('change', '#kecamatanFilter', function() {
                            var kecamatanId = $(this).val();
                            
                            console.log('Loading desa for kecamatan ID:', kecamatanId);
                            
                            // Reset desa filter
                            $('#desaFilter').html('<option value="">Filter Desa</option>');
                            $('#desaFilterMoved').html('<option value="">Filter Desa</option>');
                            desaMap = {};
                            
                            if (kecamatanId && kecamatanId !== '') {
                                $.ajax({
                                    type: 'POST',
                                    url: "Report/Mutasi/GetDesa.php",
                                    data: { Kecamatan: kecamatanId },
                                    cache: false,
                                    success: function(msg) {
                                        // Update both hidden and visible dropdowns
                                        $("#desaFilter").html(msg);
                                        $("#desaFilterMoved").html(msg);
                                        
                                        // Build desa mapping (ID -> Name)
                                        $("#desaFilter option").each(function() {
                                            if ($(this).val() !== '') {
                                                desaMap[$(this).val()] = $(this).text();
                                            }
                                        });
                                        console.log('Desa loaded:', Object.keys(desaMap).length);
                                    },
                                    error: function(xhr, status, error) {
                                        console.error("Error loading desa:", error);
                                        $("#desaFilter").html("<option value=''>Error loading data</option>");
                                        $("#desaFilterMoved").html("<option value=''>Error loading data</option>");
                                    }
                                });
                            }
                        });
                        
                        // Check if DataTable already exists and destroy it
                        if ($.fn.DataTable.isDataTable('#pegawaiTable')) {
                            console.log('DataTable already exists, destroying...');
                            $('#pegawaiTable').DataTable().destroy();
                        }
                        
                        // Initialize DataTable dengan konfigurasi yang tepat
                        var table = $('#pegawaiTable').DataTable({
                            "dom": '<"row"<"col-sm-6"B><"col-sm-6"<"custom-filters">>>rt<"bottom"ip><"clear">',
                            "pageLength": 50,
                            "searching": true,
                            "paging": true,
                            "info": true,
                            "lengthChange": true,
                            "destroy": true, // Allow reinitialisation
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
                                        // Get selected IDs from hidden dropdowns (which contain the actual IDs)
                                        var kecamatanId = $('#kecamatanFilter').val();
                                        var desaId = $('#desaFilter').val();
                                        
                                        // Determine which PDF to generate based on filters
                                        if (desaId && desaId !== '') {
                                            // If desa is selected, generate PDF per Desa
                                            var pdfUrl = 'Report/Pdf/PdfPegawaiFilterDesa.php?Proses=1&Kecamatan=' + 
                                                encodeURIComponent(kecamatanId) + '&Desa=' + encodeURIComponent(desaId);
                                            window.open(pdfUrl, '_blank');
                                        } else if (kecamatanId && kecamatanId !== '') {
                                            // If only kecamatan is selected, generate PDF per Kecamatan
                                            var pdfUrl = 'Report/Pdf/PdfPegawaiFilterKecamatan.php?Proses=1&Kecamatan=' + 
                                                encodeURIComponent(kecamatanId);
                                            window.open(pdfUrl, '_blank');
                                        } else {
                                            // No filter selected
                                            alert('Silakan pilih filter Kecamatan atau Desa terlebih dahulu untuk mencetak PDF');
                                        }
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

                        // Move custom filters to the right container
                        setTimeout(function() {
                            // Create the filter HTML
                            var filterHtml = '<div style="text-align: right; padding-top: 5px;">' +
                                '<select class="form-control input-sm" style="display: inline-block; width: 150px; margin-right: 10px;" id="kecamatanFilterMoved">' +
                                $('#kecamatanFilter').html() +
                                '</select>' +
                                '<select class="form-control input-sm" style="display: inline-block; width: 150px; margin-right: 10px;" id="desaFilterMoved">' +
                                $('#desaFilter').html() +
                                '</select>' +
                                '<input type="search" class="form-control input-sm" placeholder="Search:" style="display: inline-block; width: 200px;" id="customSearchMoved">' +
                                '</div>';
                            
                            // Insert into custom-filters container
                            $('.custom-filters').html(filterHtml);
                            
                            // Copy current values
                            $('#kecamatanFilterMoved').val($('#kecamatanFilter').val());
                            $('#desaFilterMoved').val($('#desaFilter').val());
                            $('#customSearchMoved').val($('#customSearch').val());
                            
                            console.log('Filters moved to custom container');
                            
                            // Setup event handler for moved kecamatan dropdown to load desa
                            $('#kecamatanFilterMoved').on('change', function() {
                                var kecamatanId = $(this).val();
                                console.log('Kecamatan changed (moved dropdown):', kecamatanId);
                                
                                $('#kecamatanFilter').val(kecamatanId).trigger('change');
                                
                                // Reset desa filter when kecamatan changes
                                $('#desaFilterMoved').val('');
                                
                                if (kecamatanId === '') {
                                    table.column(1).search('').draw();
                                } else {
                                    var kecamatanName = kecamatanMap[kecamatanId] || '';
                                    console.log('Filtering by kecamatan name:', kecamatanName);
                                    table.column(1).search(kecamatanName).draw();
                                }
                            });
                            
                            $('#desaFilterMoved').on('change', function() {
                                var desaId = $(this).val();
                                var kecamatanId = $('#kecamatanFilter').val();
                                console.log('Desa changed (moved dropdown):', desaId);
                                
                                $('#desaFilter').val(desaId);
                                
                                if (desaId === '') {
                                    // If no desa selected, filter by kecamatan only
                                    if (kecamatanId === '') {
                                        table.column(1).search('').draw();
                                    } else {
                                        var kecamatanName = kecamatanMap[kecamatanId] || '';
                                        table.column(1).search(kecamatanName).draw();
                                    }
                                } else {
                                    // Filter by both kecamatan and desa (urutan: Kecamatan -> Desa)
                                    var desaName = desaMap[desaId] || '';
                                    var kecamatanName = kecamatanMap[kecamatanId] || '';
                                    var searchTerm = kecamatanName + '.*' + desaName;
                                    console.log('Filtering by kecamatan + desa:', searchTerm);
                                    table.column(1).search(searchTerm, true, false).draw();
                                }
                            });
                        }, 500);

    // Custom search input (use event delegation for moved elements)
    $(document).on('keyup', '#customSearchMoved', function() {
        console.log('Search input:', this.value);
        table.search(this.value).draw();
    });
});
</script>