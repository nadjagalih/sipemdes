<?php
// Include security configuration and database
require_once "../Module/Security/Security.php";
require_once "../Module/Config/Env.php";

// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Get IdKecamatan from session with fallback
$IdKecamatan = isset($_SESSION['IdKecamatan']) ? $_SESSION['IdKecamatan'] : '';

// Only execute query if IdKecamatan is available
if (!empty($IdKecamatan)) {
    // Use prepared statement for security
    $stmt = SQLProtection::prepare($db, "SELECT * FROM master_kecamatan WHERE IdKecamatan = ?", [$IdKecamatan]);
    $result = SQLProtection::execute($stmt);
    $DataHeader = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
    $NamaKecamatan = isset($DataHeader['Kecamatan']) ? XSSProtection::escape($DataHeader['Kecamatan']) : '';
} else {
    $NamaKecamatan = '';
}
?>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Upload File Desa</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="">Dashboard</a></li>
            <li class="breadcrumb-item"><a>Dokumen</a></li>
            <li class="breadcrumb-item active"><strong>Upload File</strong></li>
        </ol>
    </div>
    <div class="col-lg-2"></div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <?php
    // Handle alert messages
    if (isset($_GET['alert'])) {
        $alert = $_GET['alert'];
        $alertClass = '';
        $alertMessage = '';
        
        switch ($alert) {
            case 'UploadSukses':
                $alertClass = 'alert-success';
                $alertMessage = '<i class="fa fa-check-circle"></i> <strong>Berhasil!</strong> File berhasil diupload.';
                break;
            case 'EmptyFields':
                $alertClass = 'alert-warning';
                $alertMessage = '<i class="fa fa-exclamation-triangle"></i> <strong>Peringatan!</strong> Harap lengkapi semua field yang diperlukan.';
                break;
            case 'FileError':
                $alertClass = 'alert-danger';
                $alertMessage = '<i class="fa fa-times-circle"></i> <strong>Error!</strong> Terjadi kesalahan saat mengupload file.';
                break;
            case 'FileMax':
                $alertClass = 'alert-warning';
                $alertMessage = '<i class="fa fa-exclamation-triangle"></i> <strong>File Terlalu Besar!</strong> Ukuran file maksimal 5MB.';
                break;
            case 'FileExt':
                $alertClass = 'alert-warning';
                $alertMessage = '<i class="fa fa-exclamation-triangle"></i> <strong>Format Tidak Didukung!</strong> Hanya file PDF yang diizinkan.';
                break;
            case 'DatabaseError':
                $alertClass = 'alert-danger';
                $alertMessage = '<i class="fa fa-times-circle"></i> <strong>Error Database!</strong> Terjadi kesalahan saat menyimpan file ke database.';
                break;
        }
        
        if ($alertMessage) {
            echo '<div class="row"><div class="col-lg-12">';
            echo '<div class="alert ' . $alertClass . ' alert-dismissible fade show" role="alert">';
            echo $alertMessage;
            echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close">';
            echo '<span aria-hidden="true">&times;</span>';
            echo '</button>';
            echo '</div>';
            echo '</div></div>';
        }
    }
    ?>
    <div class="row">
        <div class="col-lg-6">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Form Upload File</h5>
                </div>
                <div class="ibox-content">
                    <form action="File/ProsesUpload.php" method="POST" enctype="multipart/form-data" id="uploadForm">
                        <?php echo CSRFProtection::getTokenField(); ?>
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label">Kategori File</label>
                            <div class="col-lg-8">
                                <select name="kategori" class="form-control" required>
                                    <option value="">Pilih Kategori</option>
                                    <?php
                                    $q = mysqli_query($db, "SELECT * FROM master_file_kategori");
                                    while ($row = mysqli_fetch_assoc($q)) {
                                        echo "<option value='" . XSSProtection::escapeAttr($row['IdFileKategori']) . "'>" . XSSProtection::escape($row['KategoriFile']) . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label">Kabupaten</label>
                            <div class="col-lg-8">
                                <input type="text" name="namakabupaten" class="form-control" required readonly
                                    value="Trenggalek">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label">Kecamatan</label>
                            <div class="col-lg-8">
                                <select name="idkecamatan" id="idkecamatan" class="form-control">
                                    <option value="">Pilih Kecamatan</option>
                                    <?php
                                    $q = mysqli_query($db, "SELECT * FROM master_kecamatan");
                                    while ($row = mysqli_fetch_assoc($q)) {
                                        echo "<option value='{$row['IdKecamatan']}'>{$row['Kecamatan']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label">Desa</label>
                            <div class="col-lg-8">
                                <select name="iddesa" id="iddesa" class="form-control">
                                    <option value="">Pilih Desa</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label">Nama File</label>
                            <div class="col-lg-8">
                                <input type="text" name="namafile" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label">Upload File</label>
                            <div class="col-lg-8">
                                <input type="file" name="file" class="form-control" accept="application/pdf" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-offset-2 col-lg-10">
                                <button class="btn btn-primary" type="submit" name="upload">Upload</button>
                                <a href="?pg=FileViewAdmin" class="btn btn-success">Lihat File</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script <?php echo CSPHandler::scriptNonce(); ?>>
$(document).ready(function() {
    console.log("Document ready, setting up dropdown handlers and form validation");
    
    // Attach change event using jQuery
    $('#idkecamatan').on('change', function() {
        var idKecamatan = $(this).val();
        console.log("Kecamatan changed to:", idKecamatan);
        loadDesa(idKecamatan);
    });
    
    // Form validation
    $('#uploadForm').on('submit', function(e) {
        return validateFile();
    });
    
    function loadDesa(idKecamatan) {
        console.log("loadDesa called with ID:", idKecamatan);
        
        if (idKecamatan === "") {
            $('#iddesa').html("<option value=''>Pilih Desa</option>");
            return;
        }

        // Show loading state
        $('#iddesa').html("<option value=''>Loading...</option>");
        
        // Use jQuery AJAX
        $.ajax({
            url: "File/get_desa.php",
            type: "GET",
            data: { idkecamatan: idKecamatan },
            success: function(response) {
                console.log("AJAX success, response:", response);
                $('#iddesa').html(response);
            },
            error: function(xhr, status, error) {
                console.error("AJAX error:", status, error);
                $('#iddesa').html("<option value=''>Error loading desa</option>");
            }
        });
    }
    
    function validateFile() {
        const fileInput = document.querySelector('input[name="file"]');
        if (!fileInput.files.length) {
            alert('Harap pilih file untuk diupload.');
            return false;
        }
        
        const filePath = fileInput.value;
        const allowedExtensions = /(\.pdf)$/i;
        if (!allowedExtensions.exec(filePath)) {
            alert('Hanya file PDF yang diizinkan.');
            fileInput.value = '';
            return false;
        }
        
        // Check file size (5MB)
        const fileSize = fileInput.files[0].size;
        const maxSize = 5 * 1024 * 1024; // 5MB
        if (fileSize > maxSize) {
            alert('Ukuran file maksimal 5MB.');
            fileInput.value = '';
            return false;
        }
        
        return true;
    }
    
    // Auto-hide alerts after 5 seconds
    setTimeout(function() {
        $('.alert').fadeOut('slow');
    }, 5000);
});
</script>