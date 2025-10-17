<script type="text/javascript">
    $(document).ready(function() {
        // Options are now loaded directly in PHP, but keep the change event for the chart
        $("#Kecamatan").change(function() {
            var Kecamatan = $("#Kecamatan").val();
            $.ajax({
                type: 'POST',
                url: "Report/UnitKerja/RekapDesaGrafikGender.php",
                data: {
                    Kecamatan: Kecamatan
                },
                cache: false,
                success: function(msg) {
                    $("#RekapDesaGrafikGender").html(msg);
                }
            });
        });
    });
</script>

<form action="Report/Pdf/PdfUnitKerjaKecamatan" method="GET" enctype="multipart/form-data" target="_BLANK">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Filter Data Gender Pemerintahan Desa PerKecamatan </h5>
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
                                        <option value="">Filter Kecamatan</option>
                                        <?php
                                        $QueryKecamatanList = mysqli_query($db, "SELECT * FROM master_kecamatan ORDER BY Kecamatan ASC");
                                        while ($RowKecamatanList = mysqli_fetch_assoc($QueryKecamatanList)) {
                                            $IdKecamatanList = isset($RowKecamatanList['IdKecamatan']) ? $RowKecamatanList['IdKecamatan'] : '';
                                            $NamaKecamatanList = isset($RowKecamatanList['Kecamatan']) ? $RowKecamatanList['Kecamatan'] : '';
                                        ?>
                                            <option value="<?php echo htmlspecialchars($IdKecamatanList); ?>"><?php echo htmlspecialchars($NamaKecamatanList); ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <button type="submit" name="Proses" value="Proses" class="btn btn-outline btn-primary">Cetak PDF</button>
                            <a href="?pg=ViewCustomGender"><button type="button" class="btn btn-outline btn-primary">Batal</button></a>
                        </div>

                        <div class="col-lg-6"></div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="row">
        <div class="col-lg-12">
            <div id="RekapDesaGrafikGender"></div>
        </div>
    </div>

    <!-- FILTERING -->
    <?php
    if (isset($_GET['Proses'])) {
        $Kecamatan = sql_injeksi($_GET['Kecamatan']);

        $QueryKecamatan = mysqli_query($db, "SELECT * FROM master_kecamatan WHERE IdKecamatan ='$Kecamatan' ");
        $DataKecamatan = mysqli_fetch_assoc($QueryKecamatan);
        $IdKecamatan = $DataKecamatan['IdKecamatan'];
        $NamaKecamatan = $DataKecamatan['Kecamatan'];
    } ?>
</form>