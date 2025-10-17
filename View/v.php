<?php
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);

// Include security configurations FIRST
require_once "../Module/Security/Security.php";
require_once "../Module/Config/Env.php";
require_once "../Module/Security/CSPHandler.php";

// Set CSP headers IMMEDIATELY before any output
CSPHandler::setCSPHeaders();

if (empty($_SESSION['NameUser']) && empty($_SESSION['PassUser'])) {
    echo "<meta http-equiv='refresh' content='0; url=../index'>";
}

// Batasan waktu sesion
$timeout = 1; // Set timeout menit
$logout_redirect_url = "../Auth/SignOutTime"; // Set logout URL

$timeout = $timeout * 1000; // Ubah menit ke detik
if (isset($_SESSION['start_time'])) {
    $elapsed_time = time() - $_SESSION['start_time'];
    if ($elapsed_time >= $timeout) {
        session_destroy();
        echo "<script " . CSPHandler::scriptNonce() . ">
            window.location = '$logout_redirect_url'
        </script>";
    }
}
$_SESSION['start_time'] = time();
?>

<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Prevent caching and back button access -->
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">

    <title>SIPEMDES | Kab. Trenggalek</title>
    <link href="../Vendor/Media/Logo/pemkab.png" type="image/x-icon" rel="icon">
    <link href="../Vendor/Assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="../Vendor/Assets/font-awesome/css/font-awesome.css" rel="stylesheet">

    <!-- Morris -->
    <link href="../Vendor/Assets/css/plugins/morris/morris-0.4.3.min.css" rel="stylesheet">

    <link href="../Vendor/Assets/css/animate.css" rel="stylesheet">
    <link href="../Vendor/Assets/css/style.css" rel="stylesheet">

    <link href="../Vendor/Assets/css/plugins/dataTables/datatables.min.css" rel="stylesheet">
    <link href="../Vendor/Assets/css/plugins/select2/select2.min.css" rel="stylesheet">
    <link href="../Vendor/Assets/css/plugins/datapicker/datepicker3.css" rel="stylesheet">
    <link href="../Vendor/Assets/sweetalert/sweetalert.css" rel="stylesheet">

    <!-- View Foto -->
    <script <?php echo CSPHandler::scriptNonce(); ?> src="../Vendor/Assets/foto-view/jquery-3.7.1.min.js"></script>

    <!-- Charts -->
    <script <?php echo CSPHandler::scriptNonce(); ?> src="../Vendor/Charts/code/highcharts.js"></script>
    <script <?php echo CSPHandler::scriptNonce(); ?> src="../Vendor/Charts/code/highcharts-3d.js"></script>
    <script <?php echo CSPHandler::scriptNonce(); ?> src="../Vendor/Charts/code/modules/exporting.js"></script>
    <script <?php echo CSPHandler::scriptNonce(); ?> src="../Vendor/Charts/code/modules/export-data.js"></script>
    <script <?php echo CSPHandler::scriptNonce(); ?> src="../Vendor/Charts/code/modules/accessibility.js"></script>

    <!-- Immediate session and back button protection -->
    <script <?php echo CSPHandler::scriptNonce(); ?>>
        // Immediate session check and back button prevention
        (function() {
            // Prevent back button immediately
            if (typeof(Storage) !== "undefined") {
                // Check if we came from logout
                if (sessionStorage.getItem('logout_performed') === 'true') {
                    // Clear storage and redirect
                    sessionStorage.clear();
                    localStorage.clear();
                    window.location.replace('../Auth/SignIn.php');
                    return;
                }
            }
            
            // Override browser navigation
            history.pushState(null, null, location.href);
            
            // Prevent popstate (back button) - simplified version
            window.addEventListener('popstate', function(event) {
                // Force forward navigation without aggressive session checking
                history.pushState(null, null, location.href);
                
                // Only check session if we're definitely in admin area and user has been logged in for a while
                if (window.location.href.indexOf('/v?') !== -1) {
                    // Small delay to allow for proper page transitions
                    setTimeout(function() {
                        var xhr = new XMLHttpRequest();
                        xhr.open('GET', '../Auth/CheckSession.php?t=' + Date.now(), true); // Asynchronous
                        xhr.onreadystatechange = function() {
                            if (xhr.readyState === 4 && xhr.status === 200) {
                                try {
                                    var response = JSON.parse(xhr.responseText);
                                    if (!response.valid) {
                                        // Session invalid, redirect
                                        if (typeof(Storage) !== "undefined") {
                                            sessionStorage.clear();
                                            localStorage.clear();
                                        }
                                        window.location.replace('../Auth/SignIn.php');
                                    }
                                } catch(e) {
                                    // If JSON parse fails, assume session is ok for now
                                }
                            }
                        };
                        xhr.send();
                    }, 500); // 500ms delay
                }
                
                // Prevent the back action
                history.go(1);
                return false;
            });
            
            // Disable browser cache
            window.addEventListener('beforeunload', function() {
                // Clear any cached data
                if (typeof(Storage) !== "undefined") {
                    sessionStorage.removeItem('isLoggedIn');
                }
            });
            
            // Check for browser refresh/reload
            window.addEventListener('pageshow', function(event) {
                if (event.persisted) {
                    // Page loaded from cache, force reload
                    window.location.reload(true);
                }
            });
            
        })();
    </script>

</head>

<body>
    <div id="wrapper">
        <nav class="navbar-default navbar-static-side" role="navigation">
            <?php
            if ($_SESSION['IdLevelUserFK'] == 1) {
                include "../Module/Menu/MenuLeftSAdmin.php";
            } elseif ($_SESSION['IdLevelUserFK'] == 2) {
                include "../Module/Menu/MenuLeftAdmin.php";
            } elseif ($_SESSION['IdLevelUserFK'] == 3) {
                include "../Module/Menu/MenuLeftUser.php";
            } elseif ($_SESSION['IdLevelUserFK'] == 4) {
                include "../Module/Menu/MenuLeftKecamatan.php";
            }
            ?>

        </nav>

        <div id="page-wrapper" class="gray-bg">
            <div class="row border-bottom">
                <?php
                if ($_SESSION['IdLevelUserFK'] == 4) {
                    include "../Module/Menu/MenuTopKecamatan.php";
                } else {
                    include "../Module/Menu/MenuTop.php";
                }
                ?>
            </div>


            <div class="wrapper wrapper-content">
                <?php include "../Module/Variabel/Content.php"; ?>
            </div>


            <div class="footer">
                <?php include "../Module/Menu/MenuFooter.php"; ?>
            </div>

        </div>
    </div>

    <!-- Mainly scripts -->
    <script <?php echo CSPHandler::scriptNonce(); ?> src="../Vendor/Assets/js/jquery-3.7.1.min.js"></script>
    <script <?php echo CSPHandler::scriptNonce(); ?> src="../Vendor/Assets/js/popper.min.js"></script>
    <script <?php echo CSPHandler::scriptNonce(); ?> src="../Vendor/Assets/js/bootstrap.js"></script>
    <script <?php echo CSPHandler::scriptNonce(); ?> src="../Vendor/Assets/js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script <?php echo CSPHandler::scriptNonce(); ?> src="../Vendor/Assets/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
    
    <!-- Secure Username Validation System -->
    <script <?php echo CSPHandler::scriptNonce(); ?> src="../Assets/js/username-validation.js"></script>

    <!-- Flot -->
    <script <?php echo CSPHandler::scriptNonce(); ?> src="../Vendor/Assets/js/plugins/flot/jquery.flot.js"></script>
    <script <?php echo CSPHandler::scriptNonce(); ?> src="../Vendor/Assets/js/plugins/flot/jquery.flot.tooltip.min.js"></script>
    <script <?php echo CSPHandler::scriptNonce(); ?> src="../Vendor/Assets/js/plugins/flot/jquery.flot.spline.js"></script>
    <script <?php echo CSPHandler::scriptNonce(); ?> src="../Vendor/Assets/js/plugins/flot/jquery.flot.resize.js"></script>
    <script <?php echo CSPHandler::scriptNonce(); ?> src="../Vendor/Assets/js/plugins/flot/jquery.flot.pie.js"></script>
    <script <?php echo CSPHandler::scriptNonce(); ?> src="../Vendor/Assets/js/plugins/flot/jquery.flot.symbol.js"></script>
    <script <?php echo CSPHandler::scriptNonce(); ?> src="../Vendor/Assets/js/plugins/flot/curvedLines.js"></script>

    <!-- Peity -->
    <script <?php echo CSPHandler::scriptNonce(); ?> src="../Vendor/Assets/js/plugins/peity/jquery.peity.min.js"></script>
    <script <?php echo CSPHandler::scriptNonce(); ?> src="../Vendor/Assets/js/demo/peity-demo.js"></script>

    <!-- Custom and plugin javascript -->
    <script <?php echo CSPHandler::scriptNonce(); ?> src="../Vendor/Assets/js/inspinia.js"></script>
    <script <?php echo CSPHandler::scriptNonce(); ?> src="../Vendor/Assets/js/plugins/pace/pace.min.js"></script>

    <!-- jQuery UI -->
    <script <?php echo CSPHandler::scriptNonce(); ?> src="../Vendor/Assets/js/plugins/jquery-ui/jquery-ui.min.js"></script>

    <!-- Jvectormap -->
    <script <?php echo CSPHandler::scriptNonce(); ?> src="../Vendor/Assets/js/plugins/jvectormap/jquery-jvectormap-2.0.2.min.js"></script>
    <script <?php echo CSPHandler::scriptNonce(); ?> src="../Vendor/Assets/js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>

    <!-- Sparkline -->
    <script <?php echo CSPHandler::scriptNonce(); ?> src="../Vendor/Assets/js/plugins/sparkline/jquery.sparkline.min.js"></script>

    <!-- Sparkline demo data  -->
    <script <?php echo CSPHandler::scriptNonce(); ?> src="../Vendor/Assets/js/demo/sparkline-demo.js"></script>

    <!-- ChartJS-->
    <script <?php echo CSPHandler::scriptNonce(); ?> src="../Vendor/Assets/js/plugins/chartJs/Chart.min.js"></script>

    <script <?php echo CSPHandler::scriptNonce(); ?> src="../Vendor/Assets/js/plugins/dataTables/datatables.min.js"></script>
    <script <?php echo CSPHandler::scriptNonce(); ?> src="../Vendor/Assets/js/plugins/dataTables/dataTables.bootstrap4.min.js"></script>
    <script <?php echo CSPHandler::scriptNonce(); ?> src="../Vendor/Assets/js/plugins/select2/select2.full.min.js"></script>
    <script <?php echo CSPHandler::scriptNonce(); ?> src="../Vendor/Assets/js/plugins/datapicker/bootstrap-datepicker.js"></script>
    <link href="../Vendor/Assets/sweetalert/sweetalert2.min.css" rel="stylesheet">
    <script <?php echo CSPHandler::scriptNonce(); ?> src="../Vendor/Assets/sweetalert/sweetalert2.min.js"></script>

    <script <?php echo CSPHandler::scriptNonce(); ?>>
        $(document).ready(function() {
            $('.dataTables-kecamatan').DataTable({
                pageLength: 25,
                responsive: true,
                dom: 'frtip',
                searching: true,
                lengthChange: false,
                paging: false,
                info: false
            });

        });
    </script>

    <script <?php echo CSPHandler::scriptNonce(); ?>>
        $(".select2_kabupaten").select2();
        $(".select2_kecamatan").select2();
        $(".select2_akses").select2();
        $(".select2_agama").select2();
        $(".select2_jenkel").select2();
        $(".select2_pendidikan").select2();
        $(".select2_goldarah").select2();
        $(".select2_pernikahan").select2();
        $(".select2_status_pegawai").select2();
        $(".select2_desa").select2();
        $(".select2_unitkerja").select2();
        $(".select2_hubungan").select2();
        $(".select2_pendidikan").select2();
    </script>

    <script <?php echo CSPHandler::scriptNonce(); ?>>
        $(document).ready(function() {
            var mem = $('#TanggalLahir .input-group.date').datepicker({
                todayBtn: "linked",
                keyboardNavigation: false,
                forceParse: false,
                calendarWeeks: true,
                autoclose: true,
                format: "dd-mm-yyyy"
            });
        });
    </script>
    <script <?php echo CSPHandler::scriptNonce(); ?>>
        $(document).ready(function() {
            var mem = $('#TanggalNikah .input-group.date').datepicker({
                todayBtn: "linked",
                keyboardNavigation: false,
                forceParse: false,
                calendarWeeks: true,
                autoclose: true,
                format: "dd-mm-yyyy"
            });
        });
    </script>

    <!-- Security Script: Prevent Back Button After Logout -->
    <script <?php echo CSPHandler::scriptNonce(); ?>>
        // Prevent back button functionality for logged-in users
        (function() {
            // Check if user is logged in
            if (typeof sessionStorage !== 'undefined') {
                sessionStorage.setItem('isLoggedIn', 'true');
            }
            
            // Session checking every 2 minutes (less aggressive)
            setInterval(function() {
                // Make an AJAX call to verify session is still valid
                var xhr = new XMLHttpRequest();
                xhr.open('GET', '../Auth/CheckSession.php?t=' + Date.now(), true);
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4) {
                        if (xhr.status === 200) {
                            try {
                                var response = JSON.parse(xhr.responseText);
                                if (!response.valid) {
                                    // Session invalid, redirect only if we're in admin area
                                    if (window.location.href.indexOf('/v?') !== -1) {
                                        if (typeof(Storage) !== "undefined") {
                                            sessionStorage.clear();
                                            localStorage.clear();
                                        }
                                        window.location.replace('../Auth/SignIn.php');
                                    }
                                }
                            } catch(e) {
                                // JSON parse error, redirect only if we're in admin area
                                if (window.location.href.indexOf('/v?') !== -1) {
                                    window.location.replace('../Auth/SignIn.php');
                                }
                            }
                        } else {
                            // Server error, redirect only if we're in admin area
                            if (window.location.href.indexOf('/v?') !== -1) {
                                window.location.replace('../Auth/SignIn.php');
                            }
                        }
                    }
                };
                xhr.send();
            }, 120000); // Check every 2 minutes instead of 30 seconds
            
            // Delayed session check on page load (only after user has been inactive)
            setTimeout(function() {
                // Only check session if page has been loaded for a while
                // This prevents interference with login process
                if (document.readyState === 'complete') {
                    var xhr = new XMLHttpRequest();
                    xhr.open('GET', '../Auth/CheckSession.php?t=' + Date.now(), true);
                    xhr.onreadystatechange = function() {
                        if (xhr.readyState === 4 && xhr.status === 200) {
                            try {
                                var response = JSON.parse(xhr.responseText);
                                if (!response.valid) {
                                    // Only redirect if we're not in a login process
                                    if (window.location.href.indexOf('/v?') !== -1) {
                                        window.location.replace('../Auth/SignIn.php');
                                    }
                                }
                            } catch(e) {
                                // Only redirect if we're not in a login process
                                if (window.location.href.indexOf('/v?') !== -1) {
                                    window.location.replace('../Auth/SignIn.php');
                                }
                            }
                        }
                    };
                    xhr.send();
                }
            }, 5000); // Check after 5 seconds instead of 1 second
            
        })();
    </script>

</body>

</html>