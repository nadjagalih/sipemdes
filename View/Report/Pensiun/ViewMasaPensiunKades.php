<?php
// Include CSP Handler untuk nonce support
require_once __DIR__ . '/../../../Module/Security/CSPHandler.php';
?>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Data Kepala Desa Mendekati Masa Pensiun</h2>
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

    <div class="col-lg-12">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>List Semua Data Mendekati Masa Pensiun</h5>
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
                    <table class="table table-striped table-bordered table-hover" id="pensiunTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Foto</th>
                                <th>NIK</th>
                                <th>Nama<br>Jabatan<br>Alamat</th>
                                <th>Tanggal Lahir<br>Jenis Kelamin</th>
                                <th>Tanggal Mutasi</th>
                                <th>Tanggal Pensiun<br>Sisa Pensiun</th>
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
                                            history_mutasi.Setting = 1
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
                                        if ($TglSekarang1 >= $TanggalPensiun && $Setting == 1) {
                                            ?>
                                            <?php
                                            if (!is_null($IdFilePengajuanPensiunFK) && $StatusPensiunKecamatan === '1') {
                                                $qFile = mysqli_query($db, "SELECT * FROM file WHERE IdFile = '$IdFilePengajuanPensiunFK'");
                                                $dataFile = mysqli_fetch_assoc($qFile);
                                                ?>
                                                <a href="../Module/File/ViewFilePengajuan.php?id=<?= $IdFilePengajuanPensiunFK ?>"
                                                    target="_blank" class="btn btn-xs btn-info" style="margin-bottom:5px;">
                                                    Lihat File Pengajuan
                                                </a>
                                                <?php
                                            } else if (!is_null($IdFilePengajuanPensiunFK) && $StatusPensiunDesa === null) {
                                                ?>
                                                    <a href="#"><span class="label label-warning float-left">MENUNGGU PERSETUJUAN
                                                            DESA</span></a>
                                                <?php
                                            } else if ($StatusPensiunDesa === '0') {
                                                ?>
                                                        <a href="#"><span class="label label-danger float-left">PENGAJUAN DITOLAK
                                                                DESA</span></a>
                                                <?php
                                            } else if (!is_null($IdFilePengajuanPensiunFK) && $StatusPensiunKecamatan === null) {
                                                ?>
                                                            <a href="#"><span class="label label-warning float-left">MENUNGGU PERSETUJUAN
                                                                    KECAMATAN</span></a>
                                                <?php
                                            } else if ($StatusPensiunKecamatan === '0') {
                                                ?>
                                                                <a href="#"><span class="label label-danger float-left">PENGAJUAN DITOLAK
                                                                        KECAMATAN</span></a>
                                                <?php
                                            } else if (!is_null($IdFilePengajuanPensiunFK) && $StatusPensiunDesa === null) {
                                                ?>
                                                                    <a href="#"><span class="label label-warning float-left">MENUNGGU PERSETUJUAN
                                                                            DESA</span></a>
                                                <?php
                                            } else if ($StatusPensiunDesa === '0') {
                                                ?>
                                                                        <a href="#"><span class="label label-danger float-left">PENGAJUAN DITOLAK
                                                                                DESA</span></a>
                                                <?php
                                            } else {
                                                ?>
                                                                        <a href="#"><span class="label label-danger float-left">PENSIUN BELUM
                                                                                MENGAJUKAN</span></a>
                                                <?php
                                            }

                                            if (is_null($StatusPensiunKabupaten) && !is_null($IdFilePengajuanPensiunFK) && $StatusPensiunKecamatan === '1') {
                                                ?>
                                                <form method="POST" action="Report/Pensiun/UpdateStatusPengajuan.php"
                                                    style="margin-top: 5px;">
                                                    <input type="hidden" name="IdPegawaiFK" value="<?= $IdPegawaiFK ?>">
                                                    <a href="?pg=AddMutasi&Kode=<?php echo $IdPegawaiFK; ?>&TipeMutasi=3">
                                                        <button type="submit" name="setujui"
                                                            class="btn btn-xs btn-success">Setujui</button>
                                                    </a>
                                                    <button type="submit" name="tolak" class="btn btn-xs btn-danger">Tolak</button>
                                                </form>
                                                <?php
                                            } else if ($StatusPensiunKabupaten === '1') {
                                                echo "<span class='label label-success'>Disetujui Kabupaten</span>";
                                            } elseif ($StatusPensiunKabupaten === '0') {
                                                echo "<span class='label label-danger'>Ditolak Kabupaten</span>";
                                            }

                                            if ($StatusPensiunKabupaten == 1) {
                                                ?>
                                                <a href="?pg=AddMutasi&Kode=<?php echo $IdPegawaiFK; ?>&TipeMutasi=3">
                                                    <button type="button" class="btn btn-xs btn-primary" style="margin-top:5px;">Upload SK Pensiun</button>
                                                </a>
                                                <?php
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
    if ($.fn.DataTable.isDataTable('#pensiunTable')) {
        console.log('DataTable already exists, destroying...');
        $('#pensiunTable').DataTable().destroy();
    }
    
    // Initialize DataTable dengan konfigurasi yang tepat
    var table = $('#pensiunTable').DataTable({
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
                    
                    if (kecamatanId && kecamatanId !== '') {
                        // PDF per Kecamatan - langsung cetak
                        var pdfUrl = 'Report/Pdf/PdfMasaPensiunKecamatanKades?Kecamatan=' + 
                            encodeURIComponent(kecamatanId) + '&Proses=Proses';
                        window.open(pdfUrl, '_blank');
                    } else {
                        // PDF Kabupaten (semua data)
                        window.open('Report/Pdf/PdfMasaPensiunFilterKabupatenKades', '_blank');
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
        
        // Setup event handler for moved kecamatan dropdown
        $('#kecamatanFilterMoved').on('change', function() {
            var kecamatanId = $(this).val();
            console.log('Kecamatan changed (moved dropdown):', kecamatanId);
            
            $('#kecamatanFilter').val(kecamatanId).trigger('change');
            
            // Reset desa filter when kecamatan changes
            $('#desaFilterMoved').val('');
            
            if (kecamatanId === '') {
                table.column(8).search('').draw();
            } else {
                var kecamatanName = kecamatanMap[kecamatanId] || '';
                console.log('Filtering by kecamatan name:', kecamatanName);
                table.column(8).search(kecamatanName).draw();
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
                    table.column(8).search('').draw();
                } else {
                    var kecamatanName = kecamatanMap[kecamatanId] || '';
                    table.column(8).search(kecamatanName).draw();
                }
            } else {
                // Filter by both desa and kecamatan
                var desaName = desaMap[desaId] || '';
                var kecamatanName = kecamatanMap[kecamatanId] || '';
                var searchTerm = desaName + '.*' + kecamatanName;
                console.log('Filtering by desa + kecamatan:', searchTerm);
                table.column(8).search(searchTerm, true, false).draw();
            }
        });
    }, 500);

    // Custom search input
    $(document).on('keyup', '#customSearchMoved', function() {
        console.log('Search input:', this.value);
        table.search(this.value).draw();
    });
});
</script>
