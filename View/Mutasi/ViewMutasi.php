<?php
// Include safe helpers for production-ready error handling
require_once __DIR__ . '/../../helpers/safe_helpers.php';
// Include CSP Handler untuk nonce support
require_once __DIR__ . '/../../Module/Security/CSPHandler.php';

// Notifikasi SweetAlert - CSPHandler sudah di-include
if (isset($_GET['alert'])) {
    $alertType = $_GET['alert'];
    $alertConfig = [];
    
    switch($alertType) {
        case 'Cek':
            $alertConfig = ['title' => 'Peringatan!', 'text' => 'Extention Yang Dimasukkan Tidak Sesuai', 'type' => 'warning'];
            break;
        case 'Edit':
            $alertConfig = ['title' => 'Berhasil!', 'text' => 'Data Mutasi Berhasil Dikoreksi', 'type' => 'success'];
            break;
        case 'Delete':
            $alertConfig = ['title' => 'Berhasil!', 'text' => 'Data Mutasi Berhasil Dihapus', 'type' => 'success'];
            break;
        case 'Save':
            $alertConfig = ['title' => 'Berhasil!', 'text' => 'Data Mutasi Berhasil Disimpan', 'type' => 'success'];
            break;
        case 'FileMax':
            $alertConfig = ['title' => 'Peringatan!', 'text' => 'Data Tidak Dapat Disimpan, Ukuran File Melebihi 2 MB', 'type' => 'warning'];
            break;
        case 'Setting':
            $alertConfig = ['title' => 'Berhasil!', 'text' => 'Data Mutasi Berhasil Disetting', 'type' => 'success'];
            break;
    }
    
    if (!empty($alertConfig)) {
        echo "<script " . CSPHandler::scriptNonce() . ">
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        title: '" . addslashes($alertConfig['title']) . "',
                        text: '" . addslashes($alertConfig['text']) . "',
                        icon: '" . $alertConfig['type'] . "',
                        confirmButtonText: 'OK'
                    });
                } else if (typeof swal !== 'undefined') {
                    swal({
                        title: '" . addslashes($alertConfig['title']) . "',
                        text: '" . addslashes($alertConfig['text']) . "',
                        type: '" . $alertConfig['type'] . "',
                        showConfirmButton: true,
                        confirmButtonText: 'OK'
                    });
                } else {
                    alert('" . addslashes($alertConfig['title']) . "\\n" . addslashes($alertConfig['text']) . "');
                }
            }, 500);
        });
        </script>";
    }
}
?>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Data Mutasi</h2>
    </div>
    <div class="col-lg-2">

    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <style>
        /* Custom styling untuk header tabel agar sesuai dengan warna sidebar */
        .mutasi-table thead th {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%) !important;
            color: white !important;
            font-weight: bold !important;
            text-align: center !important;
            border: 1px solid #1e3c72 !important;
            padding: 12px 8px !important;
        }
        
        .mutasi-table thead tr {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%) !important;
        }
        
        /* Override untuk DataTables sorting */
        .mutasi-table thead th.sorting,
        .mutasi-table thead th.sorting_asc,
        .mutasi-table thead th.sorting_desc {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%) !important;
            color: white !important;
        }
        
        /* Styling untuk baris tabel */
        .mutasi-table tbody tr:hover {
            background-color: #f0f8ff !important;
        }
        
        /* Styling untuk sel tabel */
        .mutasi-table td {
            border: 1px solid #dee2e6 !important;
            vertical-align: middle !important;
            padding: 8px !important;
        }
        
        /* Override Bootstrap default */
        .mutasi-table > thead > tr > th {
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
                    <h5>List Semua Data Mutasi</h5>
                </div>

                <div class="ibox-content">
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
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover mutasi-table" id="mutasiTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Foto</th>
                                    <th>NIK</th>
                                    <th>Nama<br>Tanggal Lahir<br>Jenis Kelamin</th>
                                    <th>Jenis Mutasi</th>
                                    <th>Jabatan</th>
                                    <th>Unit Kerja<br>Kecamatan<br>Kabupaten</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php include "../App/Control/FunctionPegawaiListAllMutasi.php"; ?>
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
    if ($.fn.DataTable.isDataTable('#mutasiTable')) {
        console.log('DataTable already exists, destroying...');
        $('#mutasiTable').DataTable().destroy();
    }
    
    // Initialize DataTable dengan konfigurasi yang tepat
    var table = $('#mutasiTable').DataTable({
        "dom": '<"row"<"col-sm-6"B><"col-sm-6"<"custom-filters">>>rt<"bottom"ip><"clear">',
        "pageLength": 50,
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
                    // Get selected IDs from hidden dropdowns (which contain the actual IDs)
                    var kecamatanId = $('#kecamatanFilter').val();
                    var desaId = $('#desaFilter').val();
                    
                    // Determine which PDF to generate based on filters
                    if (desaId && desaId !== '') {
                        // If desa is selected, generate PDF per Desa
                        var pdfUrl = 'Report/Mutasi/PdfPegawaiFilterDesaMutasi.php?Proses=1&Kecamatan=' + 
                            encodeURIComponent(kecamatanId) + '&Desa=' + encodeURIComponent(desaId);
                        window.open(pdfUrl, '_blank');
                    } else if (kecamatanId && kecamatanId !== '') {
                        // If only kecamatan is selected, generate PDF per Kecamatan
                        var pdfUrl = 'Report/Mutasi/PdfPegawaiFilterKecamatanMutasi.php?Proses=1&Kecamatan=' + 
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

    console.log('DataTable initialized successfully');

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
                table.column(6).search('').draw();
            } else {
                var kecamatanName = kecamatanMap[kecamatanId] || '';
                console.log('Filtering by kecamatan name:', kecamatanName);
                table.column(6).search(kecamatanName).draw();
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
                    table.column(6).search('').draw();
                } else {
                    var kecamatanName = kecamatanMap[kecamatanId] || '';
                    table.column(6).search(kecamatanName).draw();
                }
            } else {
                // Filter by both desa and kecamatan
                var desaName = desaMap[desaId] || '';
                var kecamatanName = kecamatanMap[kecamatanId] || '';
                var searchTerm = desaName + '.*' + kecamatanName;
                console.log('Filtering by desa + kecamatan:', searchTerm);
                table.column(6).search(searchTerm, true, false).draw();
            }
        });
    }, 500);

    // Custom search input (use event delegation for moved elements)
    $(document).on('keyup', '#customSearchMoved', function() {
        console.log('Search input:', this.value);
        table.search(this.value).draw();
    });

    // Debug: Check if elements exist
    setTimeout(function() {
        console.log('Moved kecamatan dropdown exists:', $('#kecamatanFilterMoved').length > 0);
        console.log('Moved desa dropdown exists:', $('#desaFilterMoved').length > 0);
        console.log('Moved search input exists:', $('#customSearchMoved').length > 0);
        console.log('Custom filters container exists:', $('.custom-filters').length > 0);
    }, 200);
});
</script>