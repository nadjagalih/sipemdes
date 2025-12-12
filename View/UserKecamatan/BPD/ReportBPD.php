<?php
// Include CSP Handler untuk nonce support
require_once __DIR__ . '/../../../Module/Security/CSPHandler.php';

$IdKec = isset($_SESSION['IdKecamatan']) ? $_SESSION['IdKecamatan'] : '';
$QueryKecamatan = mysqli_query($db, "SELECT 
    master_kecamatan.*,
    master_setting_profile_dinas.Kabupaten
    FROM master_kecamatan 
    LEFT JOIN master_setting_profile_dinas ON master_kecamatan.IdKabupatenFK = master_setting_profile_dinas.IdKabupatenProfile
    WHERE master_kecamatan.IdKecamatan = '$IdKec' ");
$DataQuery = mysqli_fetch_assoc($QueryKecamatan);
$Kecamatan = isset($DataQuery['Kecamatan']) ? $DataQuery['Kecamatan'] : 'Unknown';
$Kabupaten = isset($DataQuery['Kabupaten']) ? $DataQuery['Kabupaten'] : 'Unknown';
?>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Data BPD Kecamatan <?php echo $Kecamatan; ?></h2>
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

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Data BPD Kabupaten <?php echo $Kabupaten; ?></h5>
                </div>

                <div class="ibox-content">
                    <!-- Hidden elements for custom filters -->
                    <div style="display: none;">
                        <select id="desaFilter">
                            <option value="">Filter Desa</option>
                            <?php
                            $QueryDesaFilter = mysqli_query($db, "SELECT DISTINCT master_desa.IdDesa, master_desa.NamaDesa 
                                FROM master_desa 
                                INNER JOIN master_pegawai_bpd ON master_desa.IdDesa = master_pegawai_bpd.IdDesaFK 
                                WHERE master_desa.IdKecamatanFK = '$IdKec' 
                                ORDER BY master_desa.NamaDesa ASC");
                            while ($RowDesaFilter = mysqli_fetch_assoc($QueryDesaFilter)) {
                                echo "<option value='" . htmlspecialchars($RowDesaFilter['NamaDesa']) . "'>" . htmlspecialchars($RowDesaFilter['NamaDesa']) . "</option>";
                            }
                            ?>
                        </select>
                        <input type="search" id="customSearch" placeholder="Search:">
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover bpd-report-table" id="bpdTable">
                            <thead style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%) !important;">
                                <tr style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%) !important;">
                                    <th style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%) !important; color: white !important; font-weight: bold !important; text-align: center !important;">No</th>
                                    <th style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%) !important; color: white !important; font-weight: bold !important; text-align: center !important;">Foto</th>
                                    <th style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%) !important; color: white !important; font-weight: bold !important; text-align: center !important;">NIK</th>
                                    <th style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%) !important; color: white !important; font-weight: bold !important; text-align: center !important;">Nama<br>Alamat</th>
                                    <th style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%) !important; color: white !important; font-weight: bold !important; text-align: center !important;">Tanggal Lahir<br>Jenis Kelamin</th>
                                    <th style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%) !important; color: white !important; font-weight: bold !important; text-align: center !important;">Unit Kerja<br>Kecamatan<br>Kabupaten</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $Nomor = 1;
                                $QueryPegawai = mysqli_query($db, "SELECT
                                    master_pegawai_bpd.IdPegawaiFK,
                                    master_pegawai_bpd.Foto,
                                    master_pegawai_bpd.NIK,
                                    master_pegawai_bpd.Nama,
                                    master_pegawai_bpd.TanggalLahir,
                                    master_pegawai_bpd.JenKel,
                                    master_pegawai_bpd.IdDesaFK,
                                    master_pegawai_bpd.Alamat,
                                    master_pegawai_bpd.RT,
                                    master_pegawai_bpd.RW,
                                    master_pegawai_bpd.Lingkungan,
                                    master_pegawai_bpd.Kecamatan AS Kec,
                                    master_pegawai_bpd.Kabupaten,
                                    master_desa.IdDesa,
                                    master_desa.NamaDesa,
                                    master_desa.IdKecamatanFK,
                                    master_kecamatan.IdKecamatan,
                                    master_kecamatan.Kecamatan,
                                    master_kecamatan.IdKabupatenFK,
                                    master_setting_profile_dinas.IdKabupatenProfile,
                                    master_setting_profile_dinas.Kabupaten
                                    FROM master_pegawai_bpd
                                    LEFT JOIN master_desa ON master_pegawai_bpd.IdDesaFK = master_desa.IdDesa
                                    LEFT JOIN master_kecamatan ON master_desa.IdKecamatanFK = master_kecamatan.IdKecamatan
                                    LEFT JOIN master_setting_profile_dinas ON master_kecamatan.IdKabupatenFK = master_setting_profile_dinas.IdKabupatenProfile
                                    WHERE
                                    master_kecamatan.IdKecamatan = '$IdKec'
                                    ORDER BY
                                    master_kecamatan.IdKecamatan ASC,
                                    master_desa.NamaDesa ASC");
                                while ($DataPegawai = mysqli_fetch_assoc($QueryPegawai)) {
                                    // Direct data access with validation
                                    $IdPegawaiFK = isset($DataPegawai['IdPegawaiFK']) ? $DataPegawai['IdPegawaiFK'] : '';
                                    $Foto = isset($DataPegawai['Foto']) ? $DataPegawai['Foto'] : '';
                                    $NIK = isset($DataPegawai['NIK']) ? $DataPegawai['NIK'] : '';
                                    $Nama = isset($DataPegawai['Nama']) ? $DataPegawai['Nama'] : '';
                                    
                                    // Date formatting
                                    $TanggalLahir = isset($DataPegawai['TanggalLahir']) ? $DataPegawai['TanggalLahir'] : '';
                                    $ViewTglLahir = !empty($TanggalLahir) ? date('d-m-Y', strtotime($TanggalLahir)) : '';
                                    
                                    $JenKel = isset($DataPegawai['JenKel']) ? $DataPegawai['JenKel'] : '';
                                    $NamaDesa = isset($DataPegawai['NamaDesa']) ? $DataPegawai['NamaDesa'] : '';
                                    $KecamatanData = isset($DataPegawai['Kecamatan']) ? $DataPegawai['Kecamatan'] : '';
                                    $KabupatenData = isset($DataPegawai['Kabupaten']) ? $DataPegawai['Kabupaten'] : '';
                                    $Alamat = isset($DataPegawai['Alamat']) ? $DataPegawai['Alamat'] : '';
                                    $RT = isset($DataPegawai['RT']) ? $DataPegawai['RT'] : '';
                                    $RW = isset($DataPegawai['RW']) ? $DataPegawai['RW'] : '';

                                    $Lingkungan = isset($DataPegawai['Lingkungan']) ? $DataPegawai['Lingkungan'] : '';
                                    $AmbilDesa = mysqli_query($db, "SELECT * FROM master_desa WHERE IdDesa = '$Lingkungan' ");
                                    $LingkunganBPD = mysqli_fetch_assoc($AmbilDesa);
                                    $Komunitas = isset($LingkunganBPD['NamaDesa']) ? $LingkunganBPD['NamaDesa'] : '';

                                    $KecamatanBPD = isset($DataPegawai['Kec']) ? $DataPegawai['Kec'] : '';
                                    $AmbilKecamatan = mysqli_query($db, "SELECT * FROM master_kecamatan WHERE IdKecamatan = '$KecamatanBPD' ");
                                    $KecamatanBPD = mysqli_fetch_assoc($AmbilKecamatan);
                                    $KomunitasKec = isset($KecamatanBPD['Kecamatan']) ? $KecamatanBPD['Kecamatan'] : '';

                                    $Address = $Alamat . " RT." . $RT . "/RW." . $RW . " " . $Komunitas . " Kecamatan " . $KomunitasKec;
                                ?>

                                    <tr class="gradeX">
                                        <td>
                                            <?php echo $Nomor; ?>
                                        </td>

                                        <?php
                                        if (empty($Foto)) {
                                        ?>
                                            <td>
                                                <a href="?pg=BPDViewFoto&Kode=<?php echo $IdPegawaiFK; ?>" title="Edit Foto"><img style="width:80px; height:auto" alt="image" class="message-avatar" src="../Vendor/Media/Pegawai/no-image.jpg"></a>
                                            </td>
                                        <?php } else { ?>
                                            <td>
                                                <a href="?pg=BPDViewFoto&Kode=<?php echo $IdPegawaiFK; ?>" title="Edit Foto"><img style="width:80px; height:auto" alt="image" class="message-avatar" src="../Vendor/Media/Pegawai/<?php echo $Foto; ?>"></a>
                                            </td>
                                        <?php } ?>

                                        <td>
                                            <?php echo htmlspecialchars($NIK); ?>
                                        </td>
                                        <td>
                                            <strong><?php echo htmlspecialchars($Nama); ?></strong><br><br>
                                            <?php echo htmlspecialchars($Address); ?>
                                        </td>
                                        <td>
                                            <?php echo $ViewTglLahir; ?><br>
                                            <?php
                                            $QueryJenKel = mysqli_query($db, "SELECT * FROM master_jenkel WHERE IdJenKel = '$JenKel' ");
                                            $DataJenKel = mysqli_fetch_assoc($QueryJenKel);
                                            $JenisKelamin = isset($DataJenKel['Keterangan']) ? $DataJenKel['Keterangan'] : 'N/A';
                                            echo htmlspecialchars($JenisKelamin);
                                            ?>
                                        </td>
                                        <td>
                                            <?php echo htmlspecialchars($NamaDesa); ?><br>
                                            <?php echo htmlspecialchars($KecamatanData); ?><br>
                                            <?php echo htmlspecialchars($KabupatenData); ?>
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
</div>

<!-- JavaScript untuk filter dropdown -->
<script <?php echo CSPHandler::scriptNonce(); ?>>
$(document).ready(function() {
    console.log('Initializing BPD DataTable with custom filters...');
    
    // Check if DataTable already exists and destroy it
    if ($.fn.DataTable.isDataTable('#bpdTable')) {
        console.log('DataTable already exists, destroying...');
        $('#bpdTable').DataTable().destroy();
    }
    
    // Initialize DataTable dengan konfigurasi yang tepat
    var table = $('#bpdTable').DataTable({
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
                    var pdfUrl = 'UserKecamatan/BPD/PdfBPDReportAll.php';
                    
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

    console.log('BPD DataTable initialized successfully');

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
        
        console.log('BPD filters moved to custom container');
    }, 100);

    // Custom search input (use event delegation for moved elements)
    $(document).on('keyup', '#customSearchMoved', function() {
        console.log('BPD search input:', this.value);
        table.search(this.value).draw();
    });

    // Desa filter functionality (use event delegation for moved elements)
    $(document).on('change', '#desaFilterMoved', function() {
        var selectedDesa = $(this).val();
        console.log('BPD desa filter changed to:', selectedDesa);
        
        if (selectedDesa === '') {
            table.column(5).search('').draw(); // Column 5 is Unit Kerja column (contains desa name)
        } else {
            table.column(5).search(selectedDesa).draw();
        }
    });

    // Debug: Check if elements exist
    setTimeout(function() {
        console.log('BPD moved dropdown exists:', $('#desaFilterMoved').length > 0);
        console.log('BPD moved search input exists:', $('#customSearchMoved').length > 0);
        console.log('BPD custom filters container exists:', $('.custom-filters').length > 0);
    }, 200);
});
</script>