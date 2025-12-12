<?php
// Include CSP Handler untuk nonce support
require_once __DIR__ . '/../../../Module/Security/CSPHandler.php';

$QProfile = mysqli_query($db, "SELECT * FROM master_Setting_profile_dinas");
$DataProfile = mysqli_fetch_assoc($QProfile);
$Kabupaten = $DataProfile['Kabupaten'];
?>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Data BPD</h2>
    </div>
    <div class="col-lg-2">

    </div>
</div>


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

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Data BPD Kabupaten <?php echo $Kabupaten; ?></h5>
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
                        <table class="table table-striped table-bordered table-hover" id="bpdTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Foto</th>
                                    <th>NIK</th>
                                    <th>Nama<br>Alamat</th>
                                    <th>Tanggal Lahir<br>Jenis Kelamin</th>
                                    <th>Unit Kerja<br>Kecamatan<br>Kabupaten</th>
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
                                    ORDER BY
                                    master_kecamatan.IdKecamatan ASC,
                                    master_desa.NamaDesa ASC");
                                while ($DataPegawai = mysqli_fetch_assoc($QueryPegawai)) {
                                    $IdPegawaiFK = $DataPegawai['IdPegawaiFK'];
                                    $Foto = $DataPegawai['Foto'];
                                    $NIK = $DataPegawai['NIK'];
                                    $Nama = $DataPegawai['Nama'];
                                    $TanggalLahir = $DataPegawai['TanggalLahir'];
                                    $exp = explode('-', $TanggalLahir);
                                    $ViewTglLahir = $exp[2] . "-" . $exp[1] . "-" . $exp[0];
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

                                    $Address = $Alamat . " RT." . $RT . "/RW." . $RW . " " . $Komunitas . " Kecamatan " . $KomunitasKec
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
                                            <?php echo $NIK; ?>
                                        </td>
                                        <td>
                                            <strong><?php echo $Nama; ?></strong><br><br>
                                            <?php echo $Address; ?>
                                        </td>
                                        <td>
                                            <?php echo $ViewTglLahir; ?><br>
                                            <?php
                                            $QueryJenKel = mysqli_query($db, "SELECT * FROM master_jenkel WHERE IdJenKel = '$JenKel' ");
                                            $DataJenKel = mysqli_fetch_assoc($QueryJenKel);
                                            $JenisKelamin = $DataJenKel['Keterangan'];
                                            echo $JenisKelamin;
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
</div>

<!-- JavaScript untuk DataTables dengan filter dropdown -->
<script <?php echo CSPHandler::scriptNonce(); ?>>
$(document).ready(function() {
    console.log('Initializing DataTable with custom filters...');
    
    var kecamatanMap = {};
    var desaMap = {};
    
    // Load Kecamatan data via AJAX
    $.ajax({
        type: 'POST',
        url: "Report/Mutasi/GetKecamatan.php",
        cache: false,
        success: function(msg) {
            $("#kecamatanFilter").html(msg);
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
                    $("#desaFilter").html(msg);
                    $("#desaFilterMoved").html(msg);
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
    
    if ($.fn.DataTable.isDataTable('#bpdTable')) {
        console.log('DataTable already exists, destroying...');
        $('#bpdTable').DataTable().destroy();
    }
    
    var table = $('#bpdTable').DataTable({
        "dom": '<"row"<"col-sm-6"B><"col-sm-6"<"custom-filters">>>rt<"bottom"ip><"clear">',
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
                    var kecamatanId = $('#kecamatanFilter').val();
                    var desaId = $('#desaFilter').val();
                    
                    if (desaId && desaId !== '') {
                        var pdfUrl = 'Report/Pdf/PdfBPDFilterDesa?Kecamatan=' + 
                            encodeURIComponent(kecamatanId) + '&Desa=' + encodeURIComponent(desaId) + '&Proses=Proses';
                        window.open(pdfUrl, '_blank');
                    } else if (kecamatanId && kecamatanId !== '') {
                        var pdfUrl = 'Report/Pdf/PdfBPDFilterKecamatan?Kecamatan=' + 
                            encodeURIComponent(kecamatanId) + '&Proses=Proses';
                        window.open(pdfUrl, '_blank');
                    } else {
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

    setTimeout(function() {
        var filterHtml = '<div style="text-align: right; padding-top: 5px;">' +
            '<select class="form-control input-sm" style="display: inline-block; width: 150px; margin-right: 10px;" id="kecamatanFilterMoved">' +
            $('#kecamatanFilter').html() +
            '</select>' +
            '<select class="form-control input-sm" style="display: inline-block; width: 150px; margin-right: 10px;" id="desaFilterMoved">' +
            $('#desaFilter').html() +
            '</select>' +
            '<input type="search" class="form-control input-sm" placeholder="Search:" style="display: inline-block; width: 200px;" id="customSearchMoved">' +
            '</div>';
        
        $('.custom-filters').html(filterHtml);
        
        $('#kecamatanFilterMoved').val($('#kecamatanFilter').val());
        $('#desaFilterMoved').val($('#desaFilter').val());
        $('#customSearchMoved').val($('#customSearch').val());
        
        console.log('Filters moved to custom container');
        
        $('#kecamatanFilterMoved').on('change', function() {
            var kecamatanId = $(this).val();
            console.log('Kecamatan changed (moved dropdown):', kecamatanId);
            
            $('#kecamatanFilter').val(kecamatanId).trigger('change');
            
            // Reset desa filter when kecamatan changes
            $('#desaFilterMoved').val('');
            
            if (kecamatanId === '') {
                table.column(5).search('').draw();
            } else {
                var kecamatanName = kecamatanMap[kecamatanId] || '';
                console.log('Filtering by kecamatan name:', kecamatanName);
                table.column(5).search(kecamatanName).draw();
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
                    table.column(5).search('').draw();
                } else {
                    var kecamatanName = kecamatanMap[kecamatanId] || '';
                    table.column(5).search(kecamatanName).draw();
                }
            } else {
                // Filter by both desa and kecamatan
                var desaName = desaMap[desaId] || '';
                var kecamatanName = kecamatanMap[kecamatanId] || '';
                var searchTerm = desaName + '.*' + kecamatanName;
                console.log('Filtering by desa + kecamatan:', searchTerm);
                table.column(5).search(searchTerm, true, false).draw();
            }
        });
    }, 500);

    $(document).on('keyup', '#customSearchMoved', function() {
        console.log('Search input:', this.value);
        table.search(this.value).draw();
    });
});
</script>