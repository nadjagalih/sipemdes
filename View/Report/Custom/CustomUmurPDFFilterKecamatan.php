<script type="text/javascript">
    $(document).ready(function() {
        $.ajax({
            type: 'POST',
            url: "Report/Pegawai/GetKecamatan.php",
            cache: false,
            success: function(msg) {
                $("#Kecamatan").html(msg);
            }
        });
    });
</script>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Data Kepala Desa & Perangkat Desa </h2>
    </div>
    <div class="col-lg-2">

    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <form action="Report/Custom/PdfCustomUmurKecamatan" method="GET" enctype="multipart/form-data" target="_BLANK">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Filter Kecamatan</h5>
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
                    <div class="text-left">
                        <div class="form-group row"><label class="col-lg-1 col-form-label">Kecamatan</label>
                            <div class="col-lg-3">
                                <select name="Kecamatan" id="Kecamatan" style="width: 100%;" class="select2_kecamatan form-control" required>
                                    <option value="">Filter Kecamatan</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row"><label class="col-lg-1 col-form-label">Jabatan</label>
                            <div class="col-lg-3">
                                <select name="Jabatan" id="Jabatan" style="width: 100%;" class="select2_pendidikan form-control" required>
                                    <option value="">Pilih Jabatan</option>
                                    <option value="1">Kepala Desa</option>
                                    <option value="2">Perangkat Desa</option>
                                </select>
                            </div>
                        </div>
                        <script>
                            function hanyaAngka(evt) {
                                var charCode = (evt.which) ? evt.which : event.keyCode
                                if (charCode > 31 && (charCode < 48 || charCode > 57))
                                    return false;
                                return true;
                            }
                        </script>
                        <div class="form-group row"><label class="col-lg-1 col-form-label">Umur</label>
                            <div class="col-lg-1"><input type="text" name="UmurAwal" id="UmurAwal" class="form-control" placeholder="Awal" autocomplete="off" required onkeypress="return hanyaAngka(event)"></div>
                            Sampai <div class="col-lg-1"><input type="text" name="UmurAkhir" id="UmurAkhir" class="form-control" placeholder="Akhir" autocomplete="off" required onkeypress="return hanyaAngka(event)"></div>
                        </div>
                        <button class="btn btn-outline btn-success" type="submit" name="ExportPDF" id="ExportPDF">Cetak PDF</button>
                        <a href="?pg=ViewCustomUmur"><button type="button" class="btn btn-outline btn-primary">Batal</button></a>
                    </div>
                </div>
            </div>
        </div>

        <?php
        if (isset($_POST['ExportPDF'])) {
            $AmbilJabatan = sql_injeksi($_POST['Jabatan']);
            $UmurAwal = sql_injeksi($_POST['UmurAwal']);
            $UmurAkhir = sql_injeksi($_POST['UmurAkhir']);

            $Kecamatan = sql_injeksi($_POST['Kecamatan']);

            $QueryKecamatan = mysqli_query($db, "SELECT * FROM master_kecamatan WHERE IdKecamatan ='$Kecamatan' ");
            $DataKecamatan = mysqli_fetch_assoc($QueryKecamatan);
            $NamaKecamatan = $DataKecamatan['Kecamatan'];
        }
        ?>
    </form>
</div>