<?php
// Notifikasi SweetAlert - CSPHandler sudah di-include di v.php
if (isset($_GET['alert'])) {
    $alertType = $_GET['alert'];
    $alertConfig = [];
    
    switch($alertType) {
        case 'AddKategori':
            $alertConfig = ['title' => 'Berhasil!', 'text' => 'Kategori File Berhasil Ditambahkan', 'type' => 'success'];
            break;
        case 'EditKategori':
            $alertConfig = ['title' => 'Berhasil!', 'text' => 'Kategori File Berhasil Diperbarui', 'type' => 'success'];
            break;
        case 'DeleteKategori':
            $alertConfig = ['title' => 'Berhasil!', 'text' => 'Kategori File Berhasil Dihapus', 'type' => 'success'];
            break;
        case 'Edit':
            $alertConfig = ['title' => 'Berhasil!', 'text' => 'Kategori File Berhasil Diperbarui', 'type' => 'success'];
            break;
        case 'Save':
            $alertConfig = ['title' => 'Berhasil!', 'text' => 'Kategori File Berhasil Ditambahkan', 'type' => 'success'];
            break;
        case 'Delete':
            $alertConfig = ['title' => 'Berhasil!', 'text' => 'Kategori File Berhasil Dihapus', 'type' => 'success'];
            break;
        case 'Cek':
            $alertConfig = ['title' => 'Peringatan!', 'text' => 'Data Tidak Bisa Dihapus, Karena Sudah Terpakai Di Master File', 'type' => 'warning'];
            break;
        case 'Error':
            $alertConfig = ['title' => 'Error!', 'text' => 'Terjadi kesalahan saat memproses data', 'type' => 'error'];
            break;
        case 'NotFound':
            $alertConfig = ['title' => 'Peringatan!', 'text' => 'Data yang dicari tidak ditemukan', 'type' => 'warning'];
            break;
        case 'Duplicate':
            $alertConfig = ['title' => 'Peringatan!', 'text' => 'Kategori File sudah ada', 'type' => 'warning'];
            break;
    }
    
    if (!empty($alertConfig)) {
        echo "<script " . CSPHandler::scriptNonce() . ">
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        title: '" . addslashes($alertConfig['title']) . "',
                        text: '" . addslashes($alertConfig['text']) . "',
                        icon: '" . $alertConfig['type'] . "',
                        confirmButtonText: 'OK'
                    });
                } else if (typeof swal !== 'undefined') {
                    swal({
                        title: '" . addslashes($alertConfig['title']) . "',
                        text: '" . addslashes($alertConfig['text']) . "',
                        type: '" . $alertConfig['type'] . "',
                        showConfirmButton: true,
                        confirmButtonText: 'OK'
                    });
                } else {
                    alert('" . addslashes($alertConfig['title']) . "\\n" . addslashes($alertConfig['text']) . "');
                }
            }, 500);
        });
        </script>";
    }
}
?>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Data Kategori File</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="">Dashboard</a>
            </li>
            <li class="breadcrumb-item">
                <a>Setting</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Kategori File</strong>
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
                    <h5>List Data Kategori File</h5> <a href="?pg=FileKategoriAdd" class="btn btn-primary float-center"> Add File Kategori</a>
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
                                    <th>Kategori File</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php include "../App/Control/FunctionKategoriFileList.php"; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>