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

    <style>
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }
        body {
            background: linear-gradient(135deg, rgba(13,71,161,0.9) 0%, rgba(25,118,210,0.9) 100%), url('Vendor/Media/Background/trenggalek.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .loginColumns {
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px 0;
        }
        .row {
            width: 100%;
            margin: 0;
            display: flex;
            justify-content: center;
        }
        .col-md-6 {
            width: 100%;
            max-width: 420px;
            margin: 0 auto;
            padding: 0 15px;
        }
        .ibox-content {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.18);
            padding: 35px;
            width: 100%;
            margin: 0 auto;
            text-align: center;
        }
        .ibox-content img {
            width: 85px !important;
            height: auto;
            margin-bottom: 20px;
        }
        .ibox-content h5 {
            font-size: 22px;
            margin-bottom: 12px !important;
            color: #1976d2;
            font-weight: 700;
        }
        .ibox-content p {
            margin-bottom: 30px !important;
            font-size: 15px;
            color: #333;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .btn-full {
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
            padding: 12px 20px;
            width: 100%;
            font-size: 14px;
        }
        .btn-full:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }
        .btn-primary {
            background-color: #1976d2;
            border-color: #1976d2;
        }
        .form-control {
            height: calc(2.2rem + 2px);
            border-radius: 6px;
        }
        .input-group-text {
            border-radius: 6px 0 0 6px;
            background: #f8f9fa;
        }
        .select2-container .select2-selection--single {
            height: calc(2.2rem + 2px) !important;
            border-color: #ced4da;
        }
        .select2-container--default .select2-selection--single {
            border-radius: 6px;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: calc(2.2rem + 2px) !important;
            color: #495057;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: calc(2.2rem + 2px) !important;
        }
        @media (max-width: 768px) {
            .col-md-6 { padding: 0 20px; }
            .ibox-content { padding: 30px 20px; }
        }
    </style>

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
                    <img style="width: 70px; height: auto" src="Vendor/Media/Logo/Kabupaten.png" alt="Logo SIPEMDES" />
                    <p style="color:#333;font-size:15px;margin-bottom:20px;">
                        <strong>Dinas Pemberdayaan Masyarakat dan Desa</strong><br>
                        <h5 class="mb-3 mt-3" style="color:#1976d2;font-weight:700;">SIPEMDES</h5>
                        <strong>Sistem Informasi Pemerintahan Desa</strong>
                    </p>

                    <form class="m-t" role="form" method="post" id="loginForm">
                        <div class="form-group">
                            <select class="form-control select2_unit" name="unit_akses" required style="width: 100%">
                                <option value="" selected disabled>Pilih Unit Akses</option>
                                <option value="desa">Desa</option>
                                <option value="kecamatan">Kecamatan</option>
                                <option value="kabupaten">Kabupaten</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-user"></i></span>
                                </div>
                                <input type="text" class="form-control" name="NameAkses" placeholder="Masukkan Username" required autocomplete="off">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-lock"></i></span>
                                </div>
                                <input type="password" class="form-control" name="NamePassword" placeholder="Masukkan Password" required autocomplete="off">
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary btn-full" style="width: 100%"><strong>Login</strong></button>
                    </form>

                    <?php
                    if (isset($_GET['alert'])) {
                        $alert = $_GET['alert'];
                        $message = '';
                        $type = 'warning';
                        
                        switch ($alert) {
                            case 'Kosong':
                                $message = 'Username dan Password tidak boleh kosong';
                                break;
                            case 'Cek':
                                $message = 'Username atau Password salah';
                                break;
                            case 'Status':
                                $message = 'User sudah tidak aktif';
                                break;
                            case 'SignOut':
                                $message = 'Berhasil Logout';
                                $type = 'success';
                                break;
                            case 'GantiPassword':
                                $message = 'Berhasil ganti password, silakan login ulang';
                                $type = 'success';
                                break;
                            case 'SignOutTime':
                                $message = 'Waktu login habis, silakan login ulang';
                                break;
                        }
                        
                        if ($message) {
                            echo "<script>
                                  setTimeout(function() {
                                      swal({
                                          title: '$message',
                                          text: '',
                                          type: '$type',
                                          showConfirmButton: true
                                      });
                                  }, 10);
                                  </script>";
                        }
                    }
                    ?>

                    <script>
                    $(document).ready(function() {
                        $('.select2_unit').select2({
                            minimumResultsForSearch: Infinity // Menyembunyikan search box
                        });

                        $('#loginForm').on('submit', function(e) {
                            e.preventDefault();
                            var unit = $('.select2_unit').val();
                            var username = $('input[name="NameAkses"]').val();
                            var password = $('input[name="NamePassword"]').val();
                            
                            if (!unit) {
                                swal('Peringatan', 'Silakan pilih unit akses terlebih dahulu', 'warning');
                                return false;
                            }

                            // Menentukan URL berdasarkan unit
                            var authUrl;
                            switch(unit) {
                                case 'desa':
                                    authUrl = 'AuthDesa/Cek.php';
                                    break;
                                case 'kecamatan':
                                    authUrl = 'AuthKecamatan/Cek.php';
                                    break;
                                case 'kabupaten':
                                    authUrl = 'AuthKabupaten/Cek.php';
                                    break;
                            }

                            // Submit form ke halaman yang sesuai
                            this.action = authUrl;
                            this.submit();
                        });

                        // Set selected unit based on URL if coming back from failed login
                        var params = new URLSearchParams(window.location.search);
                        var from = params.get('from');
                        if (from) {
                            $('.select2_unit').val(from).trigger('change');
                        }
                    });
                    </script>
                </div>
            </div>
            <div class="col-md-3"></div>
        </div>
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