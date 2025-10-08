<?php
if (isset($_GET['alert']) && $_GET['alert'] == 'Save') {
    echo
    "<script type='text/javascript'>
        setTimeout(function () {
            swal({
              title: '',
              text:  'Data Berhasil Disimpan',
              type: 'success',
              showConfirmButton: true
            });
        },10);
    </script>";
} elseif (isset($_GET['alert']) && $_GET['alert'] == 'Edit') {
    echo
    "<script type='text/javascript'>
        setTimeout(function () {
            swal({
                title: '',
                text:  'Data Berhasil Dikoreksi',
                type: 'success',
                showConfirmButton: true
            });
        },10);
    </script>";
} elseif (isset($_GET['alert']) && $_GET['alert'] == 'Delete') {
    echo
    "<script type='text/javascript'>
        setTimeout(function () {
            swal({
                title: '',
                text:  'Data Berhasil Dihapus',
                type: 'warning',
                showConfirmButton: true
            });
        },10);
    </script>";
} elseif (isset($_GET['alert']) && $_GET['alert'] == 'CekUser') {
    echo "<script type='text/javascript'>
                    setTimeout(function () {
                    swal({
                      title: '',
                      text:  'User Yang Anda Masukkan Sudah Terdaftar',
                      type: 'info',
                      showConfirmButton: true
                     });
                    },10);
            </script>";
} elseif (isset($_GET['alert']) && $_GET['alert'] == 'Karakter') {
    echo
    "<script type='text/javascript'>
                    setTimeout(function () {
                    swal({
                      title: '',
                      text:  'Panjang Minimal Password 5 Karakter',
                      type: 'warning',
                      showConfirmButton: true
                     });
                    },10);
        </script>";
} elseif (isset($_GET['alert']) && $_GET['alert'] == 'Reset') {
    echo
    "<script type='text/javascript'>
                    setTimeout(function () {
                    swal({
                      title: '',
                      text:  'Password Berhasil Direset',
                      type: 'warning',
                      showConfirmButton: true
                     });
                    },10);
        </script>";
} elseif (isset($_GET['alert']) && $_GET['alert'] == 'CekDelete') {
    echo
    "<script type='text/javascript'>
                    setTimeout(function () {
                    swal({
                      title: '',
                      text:  'Data Tidak Bisa Dihapus, Karena Sudah Mempunyai History',
                      type: 'warning',
                      showConfirmButton: true
                     });
                    },10);
        </script>";
}
?>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Data User Kecamatan</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="">Dashboard</a>
            </li>
            <li class="breadcrumb-item">
                <a>Setting</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>User Kecamatan</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2">

    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>List Data User</h5> <a href="?pg=UserAddKecamatan" class="btn btn-primary float-center"> Add User Kecamatan</a>
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
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-kecamatan">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Username</th>
                                    <th>Password</th>
                                    <th>Kecamatan</th>
                                    <th>Level</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php include "../App/Control/FunctionUserListKecamatan.php"; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>