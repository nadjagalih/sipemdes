<?php
// Notifikasi SweetAlert - CSPHandler sudah di-include di v.php
if (isset($_GET['alert'])) {
    $alertType = $_GET['alert'];
    $alertConfig = [];
    
    switch($alertType) {
        case 'AddPegawai':
            $alertConfig = ['title' => 'Berhasil!', 'text' => 'Data Pegawai Berhasil Ditambahkan', 'type' => 'success'];
            break;
        case 'EditPegawai':
            $alertConfig = ['title' => 'Berhasil!', 'text' => 'Data Pegawai Berhasil Diperbarui', 'type' => 'success'];
            break;
        case 'DeletePegawai':
            $alertConfig = ['title' => 'Berhasil!', 'text' => 'Data Pegawai Berhasil Dihapus', 'type' => 'success'];
            break;
        case 'Cek':
            $alertConfig = ['title' => 'Peringatan!', 'text' => 'Extention Yang Dimasukkan Tidak Sesuai', 'type' => 'warning'];
            break;
        case 'Edit':
            $alertConfig = ['title' => 'Berhasil!', 'text' => 'Data Pegawai Berhasil Diperbarui', 'type' => 'success'];
            break;
        case 'Save':
            $alertConfig = ['title' => 'Berhasil!', 'text' => 'Data Pegawai Berhasil Ditambahkan', 'type' => 'success'];
            break;
        case 'Delete':
            $alertConfig = ['title' => 'Berhasil!', 'text' => 'Data Pegawai Berhasil Dihapus', 'type' => 'success'];
            break;
        case 'Kosong':
            $alertConfig = ['title' => 'Peringatan!', 'text' => 'Tidak Ada File Yang Diupload', 'type' => 'warning'];
            break;
        case 'FileMax':
            $alertConfig = ['title' => 'Peringatan!', 'text' => 'Data Tidak Dapat Disimpan, Ukuran File Melebihi 2 MB', 'type' => 'warning'];
            break;
        case 'CekDelete':
            $alertConfig = ['title' => 'Peringatan!', 'text' => 'Data Tidak Bisa Dihapus, Karena Sudah Mempunyai History', 'type' => 'warning'];
            break;
        case 'Error':
            $alertConfig = ['title' => 'Error!', 'text' => 'Terjadi kesalahan saat memproses data', 'type' => 'error'];
            break;
        case 'NotFound':
            $alertConfig = ['title' => 'Peringatan!', 'text' => 'Data yang dicari tidak ditemukan', 'type' => 'warning'];
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
        <h2>Data Kepala Desa & Perangkat Desa</h2>
    </div>
    <div class="col-lg-2">

    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
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
                                    <th>Foto</th>
                                    <th>NIK</th>
                                    <th>Nama<br>Alamat</th>
                                    <th>Tanggal Lahir<br>Jenis Kelamin</th>
                                    <th>Unit Kerja<br>Kecamatan<br>Kabupaten</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php include "../App/Control/FunctionPegawaiListAll.php"; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>