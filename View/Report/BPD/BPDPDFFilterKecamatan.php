<script type="text/javascript">
    $(document).ready(function() {
        console.log('BPDPDFFilterKecamatan: Document ready');
        
        // Load kecamatan data via AJAX with enhanced error handling
        $.ajax({
            type: 'POST',
            url: "Report/BPD/GetKecamatan.php",
            cache: false,
            success: function(msg) {
                console.log('BPDPDFFilterKecamatan: AJAX success', msg);
                $("#Kecamatan").html(msg);
            },
            error: function(xhr, status, error) {
                console.log('BPDPDFFilterKecamatan: AJAX error', error);
                $("#Kecamatan").html('<option value="">Error loading data</option>');
            }
        });
    });
</script>

<?php
// Load kecamatan data directly with PHP as backup
$kecamatanOptions = '<option value="">Filter Kecamatan</option>';
try {
    $QueryKecamatanDirect = mysqli_query($db, "SELECT * FROM master_kecamatan ORDER BY Kecamatan ASC");
    if ($QueryKecamatanDirect) {
        while ($DataKecamatanDirect = mysqli_fetch_assoc($QueryKecamatanDirect)) {
            $IdKecamatan = htmlspecialchars($DataKecamatanDirect['IdKecamatan']);
            $NamaKecamatan = htmlspecialchars($DataKecamatanDirect['Kecamatan']);
            $kecamatanOptions .= "<option value=\"$IdKecamatan\">$NamaKecamatan</option>";
        }
    }
} catch (Exception $e) {
    error_log("BPDPDFFilterKecamatan: Error loading kecamatan - " . $e->getMessage());
}
?>

<form action="Report/Pdf/PdfBPDFilterKecamatan" method="GET" enctype="multipart/form-data" target="_BLANK">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Filter Data BPD Desa PerKecamatan </h5>
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

        $QueryKecamatan = mysqli_query($db, "SELECT * FROM master_kecamatan WHERE IdKecamatan ='$Kecamatan' ");
        $DataKecamatan = mysqli_fetch_assoc($QueryKecamatan);
        $NamaKecamatan = $DataKecamatan['Kecamatan'];
    } ?>
</form>