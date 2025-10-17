<?php
// Include CSP Handler for nonce
require_once '../Module/Security/CSPHandler.php';

if (empty($_GET['alert'])) {
    echo "";
} elseif (isset($_GET['alert']) && $_GET['alert'] == 'UploadSukses') {
    echo "<script type='text/javascript' nonce='" . CSPHandler::getNonce() . "'>
            setTimeout(function () {
                Swal.fire({
                    title: 'Upload Berhasil',
                    text: 'File telah berhasil diupload.',
                    icon: 'success'
                });
            }, 100);
          </script>";
} elseif (isset($_GET['alert']) && $_GET['alert'] == 'FileMax') {
    echo "<script type='text/javascript' nonce='" . CSPHandler::getNonce() . "'>
            setTimeout(function () {
                Swal.fire({
                    title: 'Upload Gagal',
                    text: 'File melebihi 5 MB.',
                    icon: 'warning'
                });
            }, 100);
          </script>";
} elseif (isset($_GET['alert']) && $_GET['alert'] == 'FileExt') {
    echo "<script type='text/javascript' nonce='" . CSPHandler::getNonce() . "'>
            setTimeout(function () {
                Swal.fire({
                    title: 'Upload Gagal',
                    text: 'Tipe File Tidak Didukung (hanya file pdf).',
                    icon: 'warning'
                });
            }, 100);
          </script>";
} elseif (isset($_GET['alert']) && $_GET['alert'] == 'DeleteSuccess') {
    echo "<script type='text/javascript' nonce='" . CSPHandler::getNonce() . "'>
            setTimeout(function () {
                Swal.fire({
                    title: 'Hapus Berhasil',
                    text: 'File telah berhasil dihapus.',
                    icon: 'success'
                });
            }, 100);
          </script>";
} elseif (isset($_GET['alert']) && $_GET['alert'] == 'DeleteError') {
    echo "<script type='text/javascript' nonce='" . CSPHandler::getNonce() . "'>
            setTimeout(function () {
                Swal.fire({
                    title: 'Hapus Gagal',
                    text: 'Terjadi kesalahan saat menghapus file.',
                    icon: 'error'
                });
            }, 100);
          </script>";
} elseif (isset($_GET['alert']) && $_GET['alert'] == 'InvalidID') {
    echo "<script type='text/javascript' nonce='" . CSPHandler::getNonce() . "'>
            setTimeout(function () {
                Swal.fire({
                    title: 'Error',
                    text: 'ID file tidak valid.',
                    icon: 'error'
                });
            }, 100);
          </script>";
} elseif (isset($_GET['alert']) && $_GET['alert'] == 'FileNotFound') {
    echo "<script type='text/javascript' nonce='" . CSPHandler::getNonce() . "'>
            setTimeout(function () {
                Swal.fire({
                    title: 'File Tidak Ditemukan',
                    text: 'File yang ingin dihapus tidak ditemukan atau tidak memiliki akses.',
                    icon: 'error'
                });
            }, 100);
          </script>";
} elseif (isset($_GET['alert']) && $_GET['alert'] == 'SystemError') {
    echo "<script type='text/javascript' nonce='" . CSPHandler::getNonce() . "'>
            setTimeout(function () {
                Swal.fire({
                    title: 'Error Sistem',
                    text: 'Terjadi kesalahan sistem. Silakan coba lagi atau hubungi administrator.',
                    icon: 'error'
                });
            }, 100);
          </script>";
} elseif (isset($_GET['alert']) && $_GET['alert'] == 'CSRFError') {
    echo "<script type='text/javascript' nonce='" . CSPHandler::getNonce() . "'>
            setTimeout(function () {
                Swal.fire({
                    title: 'Token Keamanan Tidak Valid',
                    text: 'Silakan muat ulang halaman dan coba lagi.',
                    icon: 'error'
                });
            }, 100);
          </script>";
} elseif (isset($_GET['alert']) && $_GET['alert'] == 'InvalidRequest') {
    echo "<script type='text/javascript' nonce='" . CSPHandler::getNonce() . "'>
            setTimeout(function () {
                Swal.fire({
                    title: 'Permintaan Tidak Valid',
                    text: 'Metode request tidak diizinkan.',
                    icon: 'error'
                });
            }, 100);
          </script>";
}

$IdKecamatan = $_SESSION['IdKecamatan'];

$QHeader = mysqli_query($db, "SELECT * FROM master_kecamatan WHERE IdKecamatan = '$IdKecamatan'");
$DataHeader = mysqli_fetch_assoc($QHeader);
$NamaKecamatanHeader = $DataHeader['Kecamatan'];

?>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Daftar File Kecamatan <?php echo $NamaKecamatanHeader ?></h2>
    </div>
    <div class="col-lg-2"></div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">

    <div class="col-lg-12">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>Upload File Kecamatan <?php echo $NamaKecamatanHeader ?></h5>
            </div>

            <div class="ibox-content">
                <div class="text-left" style="margin-bottom:15px;">
                    <a href="?pg=FileUploadKecamatan">
                        <button type="button" class="btn btn-primary" style="width:150px; text-align:center">
                            Upload File
                        </button>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- File Kecamatan -->
    <div class="col-lg-12">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>Data File Kecamatan <?php echo $NamaKecamatanHeader ?></h5>
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
                            $IdKecamatan = $_SESSION['IdKecamatan'];
                            $Nomor = 1;
                            $q = mysqli_query($db, "SELECT f.*, k.KategoriFile, f.IdLevelFileFK
                                    FROM file f
                                    JOIN master_file_kategori k ON f.IdFileKategoriFK = k.IdFileKategori
                                    WHERE f.IdKecamatanFK = '{$IdKecamatan}'
                                    AND f.IdLevelFileFK = 2
                                    ORDER BY f.IdFile DESC");
                            while ($row = mysqli_fetch_assoc($q)) {
                                echo "<tr>
                                        <td>{$Nomor}</td>
                                        <td>{$row['Nama']}</td>
                                        <td>{$row['KategoriFile']}</td>
                                        <td>
                                            <a href='{$downloadDir}Module/File/View.php?id={$row['IdFile']}' target='_blank' class='btn btn-info btn-sm' style='margin-right: 5px;'>
                                                <i class='fa fa-eye'></i> Lihat File
                                            </a>
                                            <form method='POST' action='UserKecamatan/File/DeleteFileKecamatan.php' style='display: inline-block;' class='delete-file-form' data-filename='{$row['Nama']}'>
                                                <input type='hidden' name='id' value='{$row['IdFile']}'>
                                                " . CSRFProtection::getTokenField() . "
                                                <button type='submit' class='btn btn-danger btn-sm delete-file-btn'>
                                                    <i class='fa fa-trash'></i> Hapus
                                                </button>
                                            </form>
                                        </td>
                                    </tr>";
                                $Nomor++;
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- File Desa di Kecamatan -->
    <div class="col-lg-12">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>Data File Desa Kecamatan <?php echo $NamaKecamatanHeader ?></h5>
            </div>
            <div class="ibox-content">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama File</th>
                                <th>Kategori</th>
                                <th>Desa</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $downloadDir = '../';
                            $IdKecamatan = $_SESSION['IdKecamatan'];
                            $Nomor = 1;
                            $q = mysqli_query($db, "SELECT f.*, k.KategoriFile, d.NamaDesa, f.IdLevelFileFK
                                    FROM file f
                                    JOIN master_file_kategori k ON f.IdFileKategoriFK = k.IdFileKategori
                                    JOIN master_desa d ON f.IdDesaFK = d.IdDesa
                                    WHERE d.IdKecamatanFK = '{$IdKecamatan}' 
                                    AND f.IdLevelFileFK = 3
                                    ORDER BY f.IdFile DESC");
                            while ($row = mysqli_fetch_assoc($q)) {
                                echo "<tr>
                                        <td>{$Nomor}</td>
                                        <td>{$row['Nama']}</td>
                                        <td>{$row['KategoriFile']}</td>
                                        <td>{$row['NamaDesa']}</td>
                                        <td>
                                            <a href='{$downloadDir}Module/File/View.php?id={$row['IdFile']}' target='_blank' class='btn btn-info btn-sm' style='margin-right: 5px;'>
                                                <i class='fa fa-eye'></i> Lihat File
                                            </a>
                                            <form method='POST' action='UserKecamatan/File/DeleteFileDesaKecamatan.php' style='display: inline-block;' class='delete-file-form' data-filename='{$row['Nama']}'>
                                                <input type='hidden' name='id' value='{$row['IdFile']}'>
                                                " . CSRFProtection::getTokenField() . "
                                                <button type='submit' class='btn btn-danger btn-sm delete-file-btn'>
                                                    <i class='fa fa-trash'></i> Hapus
                                                </button>
                                            </form>
                                        </td>
                                    </tr>";
                                $Nomor++;
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>

<script type="text/javascript" nonce="<?php echo CSPHandler::getNonce(); ?>">
$(document).ready(function() {
    // Handle delete file form submissions
    $('.delete-file-form').on('submit', function(e) {
        e.preventDefault();
        
        const form = $(this);
        const filename = form.data('filename');
        
        Swal.fire({
            title: 'Konfirmasi Hapus',
            text: `Apakah Anda yakin ingin menghapus file "${filename}"?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // If confirmed, submit the form
                form.off('submit').submit();
            }
        });
    });
});
</script>