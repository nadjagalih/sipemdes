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
        },10);
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
        },10);
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
        },10);
    </script>";
} elseif ($_GET['alert'] == 'Kosong') {
    echo
        "<script type='text/javascript'>
        setTimeout(function () {
            swal({
                title: '',
                text:  'Tidak Ada File Yang Diupload',
                type: 'warning',
                showConfirmButton: true
            });
        },10);
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
        },10);
    </script>";
} elseif ($_GET['alert'] == 'CekDelete') {
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
        <h2>Data Kepala Desa & Perangkat Desa</h2>
    </div>
    <div class="col-lg-2">

    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <style>
        /* Custom styling untuk header tabel agar sesuai dengan warna sidebar */
        .dataTables-kecamatan thead th {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%) !important;
            color: white !important;
            font-weight: bold !important;
            text-align: center !important;
            border: 1px solid #1e3c72 !important;
            padding: 12px 8px !important;
        }
        
        .dataTables-kecamatan thead tr {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%) !important;
        }
        
        /* Override untuk DataTables sorting */
        .dataTables-kecamatan thead th.sorting,
        .dataTables-kecamatan thead th.sorting_asc,
        .dataTables-kecamatan thead th.sorting_desc {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%) !important;
            color: white !important;
        }
        
        /* Styling untuk baris tabel */
        .dataTables-kecamatan tbody tr:hover {
            background-color: #f0f8ff !important;
        }
        
        /* Styling untuk sel tabel */
        .dataTables-kecamatan td {
            border: 1px solid #dee2e6 !important;
            vertical-align: middle !important;
            padding: 8px !important;
        }
        
        /* Override Bootstrap default */
        .table-striped > thead > tr > th {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%) !important;
            color: white !important;
        }
    </style>
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-content">
                    
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-kecamatan">
                            <thead style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%) !important;">
                                <tr style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%) !important;">
                                    <th style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%) !important; color: white !important; font-weight: bold !important; text-align: center !important;">No</th>
                                    <th class="no-cetak" style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%) !important; color: white !important; font-weight: bold !important; text-align: center !important;">Foto</th>
                                    <th style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%) !important; color: white !important; font-weight: bold !important; text-align: center !important;">NIK</th>
                                    <th style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%) !important; color: white !important; font-weight: bold !important; text-align: center !important;">Nama<br>Alamat</th>
                                    <th style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%) !important; color: white !important; font-weight: bold !important; text-align: center !important;">Tanggal Lahir<br>Jenis Kelamin</th>
                                    <th style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%) !important; color: white !important; font-weight: bold !important; text-align: center !important;">Pendidikan</th>
                                    <th style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%) !important; color: white !important; font-weight: bold !important; text-align: center !important;">Unit Kerja<br>Kecamatan<br>Kabupaten</th>
                                    <th style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%) !important; color: white !important; font-weight: bold !important; text-align: center !important;">Jabatan</th>
                                    <th class="no-cetak" style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%) !important; color: white !important; font-weight: bold !important; text-align: center !important;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php include "../App/Control/FunctionPegawaiListAllAdminDesa.php"; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>