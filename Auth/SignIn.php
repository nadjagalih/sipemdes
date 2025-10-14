<?php
// Security headers for login page
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

// Destroy any existing session
session_start();
session_unset();
session_destroy();
?>
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>SIPEMDES | Kab. Trenggalek</title>
    <link href="../Vendor/Media/Logo/Pemkab.png" type="image/x-icon" rel="icon">
    <link href="../Vendor/Assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="../Vendor/Assets/font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="../Vendor/Assets/css/animate.css" rel="stylesheet">
    <link href="../Vendor/Assets/css/style.css" rel="stylesheet">
    <link href="../Vendor/Assets/sweetalert/sweetalert.css" rel="stylesheet">

    <script language='Javascript'>
        (function(window, location) {
            history.replaceState(null, document.title, location.pathname + "#!/history");
            history.pushState(null, document.title, location.pathname);
            window.addEventListener("popstate",
                function() {
                    if (location.hash === "#!/history") {
                        history.replaceState(null, document.title, location.pathname);
                        setTimeout(function() {
                            location.replace("SignIn");
                        }, 0);
                    }
                }, false);
        }(window, location));
    </script>

    <script language='Javascript'>
        window.history.forward();

        function noBack() {
            window.history.forward();
        }
    </script>

</head>

<body>

    <div class="loginColumns animated fadeInDown">
        <div class="row">
            <!--
            <div class="col-md-6" style="text-align: center;">
                <h2 class="font-bold">SIPEMDES</h2>

                <p><br>
                    <img style="width: 200px; height: auto;" src="../Vendor/Media/Logo/LoginPicture.png">
                </p>
                <br>
                <h3>Sistem Informasi Pemerintahan Desa</h3>
            </div> -->
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <div class="ibox-content" align="center">
                    <img style="width: 60px; height: auto" src="../Vendor/Media/Logo/Kabupaten.png"><br><br>
                    <span style="color:black"><strong>Dinas Pemberdayaan Masyarakat dan Desa</strong></span><br><br>
                    <span style="color:black; font-size:16px;"><strong>APLIKASI SIPEMDES</strong></span><br>
                    <span style="color:black"><strong>Sistem Informasi Pemerintahan Desa</strong></span><br><br>
                    <span style="color:brown; font-size:14px;"><strong>Unit Akses Desa</strong></span>
                    <form class="m-t" role="form" action="Cek.php" name="SignIn" id="SignIn" method="post">
                        <div class="form-group">
                            <span style="color:black"><input type="text" class="form-control" name="NameAkses" placeholder="Masukkan Username" autocomplete="off"></span>
                        </div>

                        <div class="form-group">
                            <span style="color:black"><input type="password" class="form-control" name="NamePassword" placeholder="Masukkan Password" autocomplete="off"></span>
                        </div>

                        <button type="submit" class="btn btn-full btn-primary">Login</button>
                        <a href="../"><button type="button" class="btn btn-full btn-danger">Back</button></a>

                    </form>
                </div>
            </div>
            <div class="col-md-3"></div>
        </div>
        <hr />
    </div>

    <script src="../Vendor/Assets/sweetalert/sweetalert.min.js"></script>

</body>

</html>

<?php
if (empty($_GET['alert'])) {
    echo "";
} elseif ($_GET['alert'] == 'Kosong') {
    echo "<script type='text/javascript'>
                    setTimeout(function () {
                    swal({
                      title: 'Login Failed',
                      text:  '',
                      type: 'warning',
                      showConfirmButton: true
                     });
                    },10);
             </script>";
} elseif ($_GET['alert'] == 'SignOut') {
    echo "<script type='text/javascript'>
                    setTimeout(function () {
                    swal({
                      title: 'Berhasil Logout',
                      text:  '',
                      type: 'success',
                      showConfirmButton: true
                     });
                    },10);
             </script>";
} elseif ($_GET['alert'] == 'GantiPassword') {
    echo "<script type='text/javascript'>
                    setTimeout(function () {
                    swal({
                      title: 'Berhasil Ganti Password, Silahkan Login Ulang',
                      text:  '',
                      type: 'success',
                      showConfirmButton: true
                     });
                    },10);
             </script>";
} elseif ($_GET['alert'] == 'Cek') {
    echo "<script type='text/javascript'>
                    setTimeout(function () {
                    swal({
                      title: 'User & Password Salah',
                      text:  '',
                      type: 'warning',
                      showConfirmButton: true
                     });
                    },10);
             </script>";
} elseif ($_GET['alert'] == 'SignOutTime') {
    echo "<script type='text/javascript'>
                    setTimeout(function () {
                    swal({
                      title: 'Waktu Login Habis, Silahkan Login Ulang',
                      text:  '',
                      type: 'warning',
                      showConfirmButton: true
                     });
                    },10);
             </script>";
} elseif ($_GET['alert'] == 'Status') {
    echo "<script type='text/javascript'>
                    setTimeout(function () {
                    swal({
                      title: 'User Sudah Tidak Aktif',
                      text:  '',
                      type: 'warning',
                      showConfirmButton: true
                     });
                    },10);
             </script>";
}
?>