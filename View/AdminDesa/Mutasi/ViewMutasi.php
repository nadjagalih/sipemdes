<?php
if (isset($_GET['alert']) && $_GET['alert'] == 'Cek') {
    echo
        "<script type='text/javascript'>
        setTimeout(function () {
            swal({
              title: '',
              text:  'Extention Yang Dimasukkan Tidak Sesuai',
              type: 'warning',
              showConfirmButton: true
            });
        },1000);
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
        },1000);
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
        },1000);
    </script>";
} elseif (isset($_GET['alert']) && $_GET['alert'] == 'Save') {
    echo
        "<script type='text/javascript'>
        setTimeout(function () {
            swal({
                title: '',
                text:  'Data Berhasil Disimpan',
                type: 'success',
                showConfirmButton: true
            });
        },1000);
    </script>";
} elseif (isset($_GET['alert']) && $_GET['alert'] == 'FileMax') {
    echo
        "<script type='text/javascript'>
        setTimeout(function () {
            swal({
                title: '',
                text:  'Data Tidak Dapat Disimpan, Ukuran File Melebihi 2 MB',
                type: 'warning',
                showConfirmButton: true
            });
        },1000);
    </script>";
} elseif (isset($_GET['alert']) && $_GET['alert'] == 'Setting') {
    echo
        "<script type='text/javascript'>
        setTimeout(function () {
            swal({
                title: '',
                text:  'Data Mutasi Berhasil Disetting',
                type: 'success',
                showConfirmButton: true
            });
        },1000);
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
                                <?php include "../App/Control/FunctionPegawaiListAllMutasiAdminDesa.php"; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>