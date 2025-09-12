<?php
if ($_GET['alert'] == 'Cek') {
    echo
        "<script type='text/javascript'>
        setTimeout(function () {
            swal({
              title: '',
              text:  'Extention Yang Dimasukkan Tidak Sesuai',
              type: 'warning',
              showConfirmButton: true
            });
        },10000);
    </script>";
} elseif ($_GET['alert'] == 'Edit') {
    echo
        "<script type='text/javascript'>
        setTimeout(function () {
            swal({
                title: '',
                text:  'Data Berhasil Dikoreksi',
                type: 'success',
                showConfirmButton: true
            });
        },10000);
    </script>";
} elseif ($_GET['alert'] == 'Delete') {
    echo
        "<script type='text/javascript'>
        setTimeout(function () {
            swal({
                title: '',
                text:  'Data Berhasil Dihapus',
                type: 'warning',
                showConfirmButton: true
            });
        },10000);
    </script>";
} elseif ($_GET['alert'] == 'Save') {
    echo
        "<script type='text/javascript'>
        setTimeout(function () {
            swal({
                title: '',
                text:  'Data Berhasil Disimpan',
                type: 'success',
                showConfirmButton: true
            });
        },10000);
    </script>";
} elseif ($_GET['alert'] == 'FileMax') {
    echo
        "<script type='text/javascript'>
        setTimeout(function () {
            swal({
                title: '',
                text:  'Data Tidak Dapat Disimpan, Ukuran File Melebihi 2 MB',
                type: 'warning',
                showConfirmButton: true
            });
        },10000);
    </script>";
} elseif ($_GET['alert'] == 'Setting') {
    echo
        "<script type='text/javascript'>
        setTimeout(function () {
            swal({
                title: '',
                text:  'Data Mutasi Berhasil Disetting',
                type: 'success',
                showConfirmButton: true
            });
        },10000);
    </script>";
}
?>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Data Mutasi</h2>
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
                    <div class="text-left">
                        <a href="?pg=PegawaiFilterKecamatanMutasi">
                            <button type="button" class="btn btn-white" style="width:150px; text-align:center">
                                Filter Kecamatan
                            </button>
                        </a>
                        <a href="?pg=PegawaiFilterDesaMutasi">
                            <button type="button" class="btn btn-white" style="width:150px; text-align:center">
                                Filter Desa
                            </button>
                        </a>
                        <a href="?pg=PegawaiPDFFilterKecamatanMutasi">
                            <button type="button" class="btn btn-white" style="width:150px; text-align:center">
                                PDF Kecamatan
                            </button>
                        </a>
                        <a href="?pg=PegawaiPDFFilterDesaMutasi">
                            <button type="button" class="btn btn-white" style="width:150px; text-align:center">
                                PDF Desa
                            </button>
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
                                    <th>Nama<br>Tanggal Lahir<br>Jenis Kelamin</th>
                                    <th>Jenis Mutasi</th>
                                    <th>Jabatan</th>
                                    <th>Unit Kerja<br>Kecamatan<br>Kabupaten</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php include "../App/Control/FunctionPegawaiListAllMutasi.php"; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>