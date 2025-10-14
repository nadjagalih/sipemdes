<?php
if (empty($_GET['alert'])) {
    echo "";
} elseif (isset($_GET['alert']) && $_GET['alert'] == 'UploadSukses') {
    echo "<script type='text/javascript'>
            setTimeout(function () {
                swal({
                    title: 'Upload Berhasil',
                    text: 'File telah berhasil diupload.',
                    type: 'success'
                });
            }, 100);
          </script>";
} elseif (isset($_GET['alert']) && $_GET['alert'] == 'FileMax') {
    echo "<script type='text/javascript'>
            setTimeout(function () {
                swal({
                    title: 'Upload gagal',
                    text: 'File melebihi 5 MB.',
                    type: 'warning'
                });
            }, 100);
          </script>";
} elseif (isset($_GET['alert']) && $_GET['alert'] == 'FileExt') {
    echo "<script type='text/javascript'>
            setTimeout(function () {
                swal({
                    title: 'Upload gagal',
                    text: 'Tipe File Tidak Didukung (hanya file pdf).',
                    type: 'warning'
                });
            }, 100);
          </script>";
} elseif (isset($_GET['alert']) && $_GET['alert'] == 'DeleteSuccess') {
    echo "<script type='text/javascript'>
            setTimeout(function () {
                swal({
                    title: 'Hapus Berhasil',
                    text: 'File telah berhasil dihapus.',
                    type: 'success'
                });
            }, 100);
          </script>";
} elseif (isset($_GET['alert']) && $_GET['alert'] == 'DeleteError') {
    echo "<script type='text/javascript'>
            setTimeout(function () {
                swal({
                    title: 'Hapus Gagal',
                    text: 'Terjadi kesalahan saat menghapus file.',
                    type: 'error'
                });
            }, 100);
          </script>";
} elseif (isset($_GET['alert']) && $_GET['alert'] == 'InvalidID') {
    echo "<script type='text/javascript'>
            setTimeout(function () {
                swal({
                    title: 'ID Tidak Valid',
                    text: 'ID file yang dipilih tidak valid.',
                    type: 'warning'
                });
            }, 100);
          </script>";
}

$IdKecamatan = $_SESSION['IdKecamatan'] ?? '';

if (!empty($IdKecamatan)) {
    $QHeader = mysqli_query($db, "SELECT * FROM master_kecamatan WHERE IdKecamatan = '$IdKecamatan'");
    $DataHeader = mysqli_fetch_assoc($QHeader);
    $NamaKecamatanHeader = ($DataHeader && isset($DataHeader['Kecamatan'])) ? $DataHeader['Kecamatan'] : 'Data Tidak Ditemukan';
} else {
    $NamaKecamatanHeader = 'Session Tidak Valid';
}

?>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Daftar File Kabupaten</h2>
    </div>
    <div class="col-lg-2"></div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">

    <div class="col-lg-12">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>Upload File Kabupaten</h5>
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
                <div class="text-left" style="margin-bottom:15px;">
                    <a href="?pg=FileUploadAdmin">
                        <button type="button" class="btn btn-primary" style="width:150px; text-align:center">
                            Upload File
                        </button>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- File Kabupaten -->
    <div class="col-lg-12">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>Data File Kabupaten</h5>
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
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama File</th>
                                <th>Kategori</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $downloadDir = '../';
                            $IdKecamatan = $_SESSION['IdKecamatan'] ?? '';
                            $Nomor = 1;
                            $q = mysqli_query($db, "SELECT f.*, k.KategoriFile 
                                    FROM file f
                                    JOIN master_file_kategori k ON f.IdFileKategoriFK = k.IdFileKategori
                                    WHERE f.IdLevelFileFK = '1'
                                    ORDER BY f.IdFile DESC");
                            if ($q) {
                                while ($row = mysqli_fetch_assoc($q)) {
                                    echo "<tr>
                                            <td>{$Nomor}</td>
                                            <td>{$row['Nama']}</td>
                                            <td>{$row['KategoriFile']}</td>
                                            <td>
                                                <a href='{$downloadDir}Module/File/View.php?id={$row['IdFile']}' target='_blank' class='btn btn-info btn-sm'>
                                                    <i class='fa fa-eye'></i> Lihat File
                                                </a>
                                                <a href='File/DeleteFile.php?id={$row['IdFile']}' class='btn btn-danger btn-sm delete-file-btn' data-filename='{$row['Nama']}'>
                                                    <i class='fa fa-trash'></i> Hapus
                                                </a>
                                            </td>
                                        </tr>";
                                    $Nomor++;
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- File Kecamatan -->
    <div class="col-lg-12">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>Data File Kecamatan</h5>
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
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama File</th>
                                <th>Kategori</th>
                                <th>Kecamatan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $downloadDir = '../';
                            $IdKecamatan = $_SESSION['IdKecamatan'] ?? '';
                            $Nomor = 1;
                            $q = mysqli_query($db, "SELECT f.*, k.KategoriFile, kc.Kecamatan
                                    FROM file f
                                    JOIN master_file_kategori k ON f.IdFileKategoriFK = k.IdFileKategori
                                    JOIN master_kecamatan kc ON f.IdKecamatanFK = kc.IdKecamatan
                                    ORDER BY f.IdFile DESC");
                            if ($q) {
                                while ($row = mysqli_fetch_assoc($q)) {
                                    echo "<tr>
                                            <td>{$Nomor}</td>
                                            <td>{$row['Nama']}</td>
                                            <td>{$row['KategoriFile']}</td>
                                            <td>{$row['Kecamatan']}</td>
                                            <td>
                                                <a href='{$downloadDir}Module/File/View.php?id={$row['IdFile']}' target='_blank' class='btn btn-info btn-sm'>
                                                    <i class='fa fa-eye'></i> Lihat File
                                                </a>
                                                <a href='File/DeleteFile.php?id={$row['IdFile']}' class='btn btn-danger btn-sm delete-file-btn' data-filename='{$row['Nama']}'>
                                                    <i class='fa fa-trash'></i> Hapus
                                                </a>
                                            </td>
                                        </tr>";
                                    $Nomor++;
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <!-- File Desa -->
    <div class="col-lg-12">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>Data File Desa</h5>
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
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama File</th>
                                <th>Kategori</th>
                                <th>Kecamatan</th>
                                <th>Desa</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $downloadDir = '../';
                            $IdKecamatan = $_SESSION['IdKecamatan'] ?? '';
                            $Nomor = 1;
                            $q = mysqli_query($db, "SELECT f.*, k.KategoriFile, d.NamaDesa, kc.Kecamatan
                                    FROM file f
                                    JOIN master_file_kategori k ON f.IdFileKategoriFK = k.IdFileKategori
                                    JOIN master_desa d ON f.IdDesaFK = d.IdDesa
                                    JOIN master_kecamatan kc ON d.IdKecamatanFK = kc.IdKecamatan
                                    ORDER BY f.IdFile DESC");
                            if ($q) {
                                while ($row = mysqli_fetch_assoc($q)) {
                                echo "<tr>
                                        <td>{$Nomor}</td>
                                        <td>{$row['Nama']}</td>
                                        <td>{$row['KategoriFile']}</td>
                                        <td>{$row['Kecamatan']}</td>
                                        <td>{$row['NamaDesa']}</td>
                                        <td>
                                            <a href='{$downloadDir}Module/File/View.php?id={$row['IdFile']}' target='_blank' class='btn btn-info btn-sm'>
                                                <i class='fa fa-eye'></i> Lihat File
                                            </a>
                                            <a href='File/DeleteFile.php?id={$row['IdFile']}' class='btn btn-danger btn-sm delete-file-btn' data-filename='{$row['Nama']}'>
                                                <i class='fa fa-trash'></i> Hapus
                                            </a>
                                        </td>
                                    </tr>";
                                $Nomor++;
                            }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
$(document).ready(function() {
    // Handle delete file button clicks
    $('.delete-file-btn').on('click', function(e) {
        e.preventDefault();
        
        const deleteUrl = $(this).attr('href');
        const filename = $(this).data('filename');
        
        swal({
            title: 'Konfirmasi Hapus',
            text: `Apakah Anda yakin ingin menghapus file "${filename}"?`,
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.value) {
                // If confirmed, redirect to delete URL
                window.location.href = deleteUrl;
            }
        });
    });
});
</script>