<?php
session_start();
error_reporting(E_ALL ^ E_NOTICE);
error_reporting(E_ERROR | E_WARNING);


require_once "Module/Config/Env.php";
?>

<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>SIPEMDES | Kab. Trenggalek</title>
    <link href="Vendor/Media/Logo/pemkab.png" type="image/x-icon" rel="icon">
    <link href="Vendor/Assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="Vendor/Assets/font-awesome/css/font-awesome.css" rel="stylesheet">

    <!-- Morris -->
    <link href="Vendor/Assets/css/plugins/morris/morris-0.4.3.min.css" rel="stylesheet">

    <link href="Vendor/Assets/css/animate.css" rel="stylesheet">
    <link href="Vendor/Assets/css/style.css" rel="stylesheet">

    <link href="Vendor/Assets/css/plugins/dataTables/datatables.min.css" rel="stylesheet">
    <link href="Vendor/Assets/css/plugins/select2/select2.min.css" rel="stylesheet">
    <link href="Vendor/Assets/css/plugins/datapicker/datepicker3.css" rel="stylesheet">
    <link href="Vendor/Assets/sweetalert/sweetalert.css" rel="stylesheet">

    <!-- View Foto -->
    <script src="Vendor/Assets/foto-view/jquery-2.2.4.js"></script>

    <!-- Charts -->
    <script src="Vendor/Charts/code/highcharts.js"></script>
    <script src="Vendor/Charts/code/highcharts-3d.js"></script>
    <script src="Vendor/Charts/code/modules/exporting.js"></script>
    <script src="Vendor/Charts/code/modules/export-data.js"></script>
    <script src="Vendor/Charts/code/modules/accessibility.js"></script>

</head>

<body>
    <div class="loginColumns animated fadeInDown">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <div class="ibox-content" align="center">
                    <img style="width: 60px; height: auto" src="Vendor/Media/Logo/Kabupaten.png"><br><br>
                    <span style="color:black"><strong>Dinas Pemberdayaan Masyarakat dan Desa</strong></span><br><br>
                    <span style="color:black; font-size:16px;"><strong>APLIKASI SIPEMDES</strong></span><br>
                    <span style="color:black"><strong>Sistem Informasi Pemerintahan Desa</strong></span>
                    <br><br>

                    <form class="m-t" role="form" action="" method="post">
                        <div class="form-group row">
                            <label class="col-lg-12 col-form-label" style="color:black"><strong>==> PILIH UNIT AKSES <== </strong></label>
                        </div>
                    </form>

                    <a href="AuthDesa/SignIn"><button type="button" class="btn btn-full btn-primary" style="width:100px"><strong>Desa</strong></button></a>
                    <a href="AuthKecamatan/SignIn"><button type="button" class="btn btn-full btn-warning" style="width:100px"><strong>Kecamatan</strong></button></a>
                    <a href="AuthKabupaten/SignIn"><button type="button" class="btn btn-full btn-success" style="width:100px"><strong>Kabupaten</strong></button></a>
                </div>
            </div>
            <div class="col-md-3"></div>
        </div>
        <hr />
    </div>

    <!-- Mainly scripts -->
    <script src="Vendor/Assets/js/jquery-3.1.1.min.js"></script>
    <script src="Vendor/Assets/js/popper.min.js"></script>
    <script src="Vendor/Assets/js/bootstrap.js"></script>
    <script src="Vendor/Assets/js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="Vendor/Assets/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

    <!-- Flot -->
    <script src="Vendor/Assets/js/plugins/flot/jquery.flot.js"></script>
    <script src="Vendor/Assets/js/plugins/flot/jquery.flot.tooltip.min.js"></script>
    <script src="Vendor/Assets/js/plugins/flot/jquery.flot.spline.js"></script>
    <script src="Vendor/Assets/js/plugins/flot/jquery.flot.resize.js"></script>
    <script src="Vendor/Assets/js/plugins/flot/jquery.flot.pie.js"></script>
    <script src="Vendor/Assets/js/plugins/flot/jquery.flot.symbol.js"></script>
    <script src="Vendor/Assets/js/plugins/flot/curvedLines.js"></script>

    <!-- Peity -->
    <script src="Vendor/Assets/js/plugins/peity/jquery.peity.min.js"></script>
    <script src="Vendor/Assets/js/demo/peity-demo.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="Vendor/Assets/js/inspinia.js"></script>
    <script src="Vendor/Assets/js/plugins/pace/pace.min.js"></script>

    <!-- jQuery UI -->
    <script src="Vendor/Assets/js/plugins/jquery-ui/jquery-ui.min.js"></script>

    <!-- Jvectormap -->
    <script src="Vendor/Assets/js/plugins/jvectormap/jquery-jvectormap-2.0.2.min.js"></script>
    <script src="Vendor/Assets/js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>

    <!-- Sparkline -->
    <script src="Vendor/Assets/js/plugins/sparkline/jquery.sparkline.min.js"></script>

    <!-- Sparkline demo data  -->
    <script src="Vendor/Assets/js/demo/sparkline-demo.js"></script>

    <!-- ChartJS-->
    <script src="Vendor/Assets/js/plugins/chartJs/Chart.min.js"></script>

    <script src="Vendor/Assets/js/plugins/dataTables/datatables.min.js"></script>
    <script src="Vendor/Assets/js/plugins/dataTables/dataTables.bootstrap4.min.js"></script>
    <script src="Vendor/Assets/js/plugins/select2/select2.full.min.js"></script>
    <script src="Vendor/Assets/js/plugins/datapicker/bootstrap-datepicker.js"></script>
    <script src="Vendor/Assets/sweetalert/sweetalert.min.js"></script>
    <script>
        $(".select2_unit").select2();
    </script>

</body>

</html>