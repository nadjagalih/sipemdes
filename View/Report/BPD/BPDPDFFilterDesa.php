<?php
require_once "../Module/Security/CSPHandler.php";
?>
<script type="text/javascript" <?php echo CSPHandler::scriptNonce(); ?>>
    $(document).ready(function() {
        console.log("Document ready - BPDPDFFilterDesa");
        console.log("jQuery version:", $.fn.jquery);
        console.log("Kecamatan element found:", $("#Kecamatan").length);
        console.log("Desa element found:", $("#Desa").length);
        
        // Function to load Desa based on Kecamatan
        function loadDesa(kecamatanId) {
            console.log("loadDesa called with ID: " + kecamatanId);
            
            if(kecamatanId != '' && kecamatanId != null && kecamatanId != undefined) {
                console.log("Making AJAX call to load Desa options");
                $("#Desa").html('<option value="">Loading desa...</option>');
                
                $.ajax({
                    type: 'POST',
                    url: "Report/BPD/GetDesa.php",
                    data: {
                        Kecamatan: kecamatanId
                    },
                    cache: false,
                    timeout: 10000, // 10 second timeout
                    beforeSend: function() {
                        console.log("AJAX beforeSend - Request starting for Kecamatan:", kecamatanId);
                    },
                    success: function(msg) {
                        console.log("AJAX Success!");
                        console.log("Response length:", msg.length);
                        console.log("Response content:", msg);
                        $("#Desa").html(msg);
                        console.log("Desa dropdown updated with", $("#Desa option").length, "options");
                    },
                    error: function(xhr, status, error) {
                        console.log("AJAX Error occurred!");
                        console.log("Status:", status);
                        console.log("Error:", error);
                        console.log("XHR Status:", xhr.status);
                        console.log("XHR Status Text:", xhr.statusText);
                        console.log("Response Text:", xhr.responseText);
                        $("#Desa").html('<option value="">Error: ' + status + ' - ' + error + '</option>');
                    },
                    complete: function() {
                        console.log("AJAX request completed");
                    }
                });
            } else {
                console.log("Kecamatan is empty/null/undefined, resetting Desa dropdown");
                $("#Desa").html('<option value="">Filter Desa</option>');
            }
        }
        
        // Handle Kecamatan change - bind to both change and select2 events
        $("#Kecamatan").on('change', function() {
            var kecamatanId = $(this).val();
            console.log("Kecamatan change event fired, value: '" + kecamatanId + "'");
            loadDesa(kecamatanId);
        });
        
        // Also bind to select2 specific events if select2 is being used
        $("#Kecamatan").on('select2:select', function() {
            var kecamatanId = $(this).val();
            console.log("Select2 select event fired, value: '" + kecamatanId + "'");
            loadDesa(kecamatanId);
        });
        
        // Test initial state
        setTimeout(function() {
            var initialValue = $("#Kecamatan").val();
            console.log("Initial Kecamatan value after 1 second:", initialValue);
            if (initialValue && initialValue !== '') {
                console.log("Initial value found, loading desa");
                loadDesa(initialValue);
            }
        }, 1000);
        
        // Debug: Log all option values in Kecamatan dropdown
        $("#Kecamatan option").each(function(index) {
            console.log("Kecamatan option " + index + ": value='" + $(this).val() + "' text='" + $(this).text() + "'");
        });
    });
</script>

<?php
// Handle form submission to get selected kecamatan
$selectedKecamatan = '';
if (isset($_POST['selected_kecamatan'])) {
    $selectedKecamatan = sql_injeksi($_POST['selected_kecamatan']);
} elseif (isset($_GET['Kecamatan'])) {
    $selectedKecamatan = sql_injeksi($_GET['Kecamatan']);
} elseif (isset($_POST['Kecamatan'])) {
    $selectedKecamatan = sql_injeksi($_POST['Kecamatan']);
}

// Load kecamatan data directly with PHP
$kecamatanOptions = '<option value="">Filter Kecamatan</option>';
try {
    $QueryKecamatanDirect = mysqli_query($db, "SELECT * FROM master_kecamatan ORDER BY Kecamatan ASC");
    if ($QueryKecamatanDirect) {
        while ($DataKecamatanDirect = mysqli_fetch_assoc($QueryKecamatanDirect)) {
            $IdKecamatan = htmlspecialchars($DataKecamatanDirect['IdKecamatan']);
            $NamaKecamatan = htmlspecialchars($DataKecamatanDirect['Kecamatan']);
            $selected = ($selectedKecamatan == $IdKecamatan) ? 'selected' : '';
            $kecamatanOptions .= "<option value=\"$IdKecamatan\" $selected>$NamaKecamatan</option>";
        }
    }
} catch (Exception $e) {
    error_log("BPDPDFFilterDesa: Error loading kecamatan - " . $e->getMessage());
}

// Load desa data for selected kecamatan
$desaOptions = '<option value="">Filter Desa</option>';
if (!empty($selectedKecamatan)) {
    try {
        $QueryDesaDirect = mysqli_query($db, "SELECT * FROM master_desa WHERE IdKecamatanFK = '$selectedKecamatan' ORDER BY NamaDesa ASC");
        if ($QueryDesaDirect) {
            while ($DataDesaDirect = mysqli_fetch_assoc($QueryDesaDirect)) {
                $IdDesa = htmlspecialchars($DataDesaDirect['IdDesa']);
                $NamaDesa = htmlspecialchars($DataDesaDirect['NamaDesa']);
                $selected = (isset($_POST['Desa']) && $_POST['Desa'] == $IdDesa) ? 'selected' : '';
                $desaOptions .= "<option value=\"$IdDesa\" $selected>$NamaDesa</option>";
            }
        }
    } catch (Exception $e) {
        error_log("BPDPDFFilterDesa: Error loading desa - " . $e->getMessage());
    }
}
?>

<form action="Report/Pdf/PdfBPDFilterDesa" method="GET" enctype="multipart/form-data" target="_BLANK">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Filter Data BPD Desa PerDesa </h5>
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
                                        <?php echo $kecamatanOptions; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row"><label class="col-lg-2 col-form-label">Desa</label>
                                <div class="col-lg-6">
                                    <select name="Desa" id="Desa" style="width: 100%;" class="select2_desa form-control" required>
                                        <?php echo $desaOptions; ?>
                                    </select>
                                </div>
                            </div>
                            <button type="submit" name="Proses" value="Proses" class="btn btn-outline btn-primary">Cetak PDF</button>
                            <a href="?pg=ReportBPD"><button type="button" class="btn btn-outline btn-primary">Batal</button></a>
                        </div>

                        <div class="col-lg-6"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- FILTERING -->
    <?php
    if (isset($_POST['Proses'])) {
        $Kecamatan = sql_injeksi($_POST['Kecamatan']);
        $Desa = sql_injeksi($_POST['Desa']);

        $QueryDesa = mysqli_query($db, "SELECT * FROM master_desa WHERE IdDesa ='$Desa' ");
        $DataDesa = mysqli_fetch_assoc($QueryDesa);
        $NamaDesa = $DataDesa['NamaDesa'];

        $QueryKecamatan = mysqli_query($db, "SELECT * FROM master_kecamatan WHERE IdKecamatan ='$Kecamatan' ");
        $DataKecamatan = mysqli_fetch_assoc($QueryKecamatan);
        $NamaKecamatan = $DataKecamatan['Kecamatan'];
    } ?>
</form>