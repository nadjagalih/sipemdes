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
</head>

<body>
    <div class="loginColumns animated fadeInDown">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <div class="ibox-content" align="center">
                    <img style="width: 60px; height: auto" src="../Vendor/Media/Logo/Kabupaten.png"><br><br>
                    <span style="color:black"><strong>Dinas Pemberdayaan Masyarakat dan Desa</strong></span><br><br>
                    <span style="color:black; font-size:16px;"><strong>APLIKASI SIPEMDES</strong></span><br>
                    <span style="color:black"><strong>Sistem Informasi Pemerintahan Desa</strong></span><br><br>
                    <span style="color:brown; font-size:14px;"><strong>Unit Akses Kabupaten</strong></span>

                    <!-- Debug Info -->
                    <div style="background: #f0f8ff; padding: 10px; margin: 10px 0; border-radius: 5px; font-size: 12px;">
                        <strong>🔧 Debug Mode Active</strong><br>
                        Form akan dikirim ke CekDebug.php untuk troubleshooting
                    </div>

                    <form class="m-t" role="form" action="CekDebug.php" method="POST" enctype="application/x-www-form-urlencoded">
                        <div class="form-group">
                            <input type="text"
                                   class="form-control"
                                   name="NameAkses"
                                   placeholder="Masukkan Username"
                                   value="admindpmd"
                                   autocomplete="off"
                                   required>
                        </div>

                        <div class="form-group">
                            <input type="text"
                                   class="form-control"
                                   name="NamePassword"
                                   placeholder="Masukkan Password"
                                   value="12345"
                                   autocomplete="off"
                                   required>
                        </div>

                        <button type="submit" class="btn btn-full btn-primary">Login</button>
                        <a href="../" class="btn btn-full btn-danger">Back</a>
                    </form>

                    <!-- Test Manual -->
                    <div style="margin-top: 20px; padding: 10px; background: #fff3cd; border-radius: 5px;">
                        <strong>🧪 Manual Test:</strong><br>
                        <small>Username dan password sudah diisi otomatis untuk testing</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3"></div>
        </div>
        <hr />
    </div>

    <script src="../Vendor/Assets/sweetalert/sweetalert.min.js"></script>

    <!-- Alert handling -->
    <?php
    if (empty($_GET['alert'])) {
        echo "";
    } elseif ($_GET['alert'] == 'Kosong') {
        echo "<script type='text/javascript'>
                        setTimeout(function () {
                        swal({
                          title: 'Login Failed',
                          text:  'Username atau password kosong',
                          type: 'warning',
                          showConfirmButton: true
                         });
                        },10);
                 </script>";
    } elseif ($_GET['alert'] == 'Password') {
        echo "<script type='text/javascript'>
                        setTimeout(function () {
                        swal({
                          title: 'Password Salah',
                          text:  'Silahkan periksa kembali password Anda',
                          type: 'error',
                          showConfirmButton: true
                         });
                        },10);
                 </script>";
    } elseif ($_GET['alert'] == 'User') {
        echo "<script type='text/javascript'>
                        setTimeout(function () {
                        swal({
                          title: 'User Tidak Ditemukan',
                          text:  'Username tidak terdaftar dalam sistem',
                          type: 'error',
                          showConfirmButton: true
                         });
                        },10);
                 </script>";
    } elseif ($_GET['alert'] == 'Level') {
        echo "<script type='text/javascript'>
                        setTimeout(function () {
                        swal({
                          title: 'Level User Tidak Sesuai',
                          text:  'Anda tidak memiliki akses ke halaman Kabupaten',
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
</body>
</html>
