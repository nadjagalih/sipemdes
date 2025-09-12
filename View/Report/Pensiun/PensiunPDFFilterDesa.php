<script type="text/javascript">
    $(document).ready(function() {
        $.ajax({
            type: 'POST',
            url: "Report/Pensiun/GetKecamatan.php",
            cache: false,
            success: function(msg) {
                $("#Kecamatan").html(msg);
            }
        });

        $("#Kecamatan").change(function() {
            var Kecamatan = $("#Kecamatan").val();
            $.ajax({
                type: 'POST',
                url: "Report/Pensiun/GetDesa.php",
                data: {
                    Kecamatan: Kecamatan
                },
                cache: false,
                success: function(msg) {
                    $("#Desa").html(msg);
                }
            });
        });
    });
</script>

<form action="Report/pdf/PdfPensiunFilterDesa" method="GET" enctype="multipart/form-data" target="_BLANK">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Filter Data Pensiun PerDesa </h5>
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
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row"><label class="col-lg-2 col-form-label">Desa</label>
                                <div class="col-lg-6">
                                    <select name="Desa" id="Desa" style="width: 100%;" class="select2_desa form-control" required>
                                        <option value="">Filter Desa</option>
                                    </select>
                                </div>
                            </div>
                            <button type="submit" name="Proses" value="Proses" class="btn btn-outline btn-primary">Cetak PDF</button>
                            <a href="?pg=ViewPensiun"><button type="button" class="btn btn-outline btn-primary">Batal</button></a>
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

    ?>
    <?php } ?>
</form>