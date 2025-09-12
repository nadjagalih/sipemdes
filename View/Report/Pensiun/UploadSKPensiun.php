<?php
if (isset($_GET['Kode'])) {
    $IdTemp = sql_url($_GET['Kode']);

    $q = mysqli_query($db, "SELECT
        p.IdPegawaiFK,
        p.Nama,
        p.NIK,
        p.IdDesaFK,
        d.NamaDesa,
        d.IdKecamatanFK,
        k.Kecamatan,
        m.IdJabatanFK,
        m.Setting,
        j.Jabatan
        FROM master_pegawai p 
        LEFT JOIN master_desa d ON p.IdDesaFK = d.IdDesa
        LEFT JOIN master_kecamatan k ON d.IdKecamatanFK = k.IdKecamatan
        INNER JOIN history_mutasi m ON p.IdPegawaiFK = m.IdPegawaiFK
        INNER JOIN master_jabatan j ON m.IdJabatanFK = j.IdJabatan
        WHERE 
        p.IdPegawaiFK = '$IdTemp' AND
        m.Setting = 1");
    $DataPegawai = mysqli_fetch_assoc($q);
    $IdPegawaiFK = $DataPegawai['IdPegawaiFK'];
    $NamaPegawai = $DataPegawai['Nama'];
    $NIK = $DataPegawai['NIK'];
    $IdDesa = $DataPegawai['IdDesaFK'];
    $NamaDesa = $DataPegawai['NamaDesa'];
    $Kecamatan = $DataPegawai['Kecamatan'];
    $Jabatan = $DataPegawai['Jabatan'];
}
?>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Upload File SK Pensiun</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="">Dashboard</a></li>
            <li class="breadcrumb-item"><a>Dokumen</a></li>
            <li class="breadcrumb-item active"><strong>Upload File</strong></li>
        </ol>
    </div>
    <div class="col-lg-2"></div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-6">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Form Upload SK Pensiun</h5>
                </div>
                <div class="ibox-content">
                    <form action="Report/Pensiun/PostSKPensiun.php" method="POST" enctype="multipart/form-data" onsubmit="return validateFile()">
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label">Nama</label>
                            <div class="col-lg-8">
                                <input type="text" name="namapegawai" class="form-control" required readonly
                                    value="<?php echo $NamaPegawai; ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label">NIK</label>
                            <div class="col-lg-8">
                                <input type="text" name="nik" class="form-control" required readonly
                                    value="<?php echo $NIK; ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label">Unit Kerja</label>
                            <div class="col-lg-8">
                                <input type="text" name="unitkerja" class="form-control" required readonly
                                    value="<?php echo $NamaDesa . " - " . $Kecamatan; ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label">Jabatan</label>
                            <div class="col-lg-8">
                                <input type="text" name="namajabatan" class="form-control" required readonly
                                    value="<?php echo $Jabatan; ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label">Pilih File SK</label>
                            <div class="col-lg-8">
                                <input type="file" name="file" class="form-control" accept="application/pdf" required>
                            </div>
                        </div>
                        <input type="hidden" name="iddesa" value="<?php echo $IdDesa; ?>">
                        <input type="hidden" name="idpegawai" value="<?php echo $IdPegawaiFK; ?>">
                        <div class="form-group row">
                            <div class="col-lg-offset-2 col-lg-10">
                                <button class="btn btn-primary" type="submit" name="upload">Upload</button>
                            </div>
                        </div>
                    </form>
                    <script>
                        function validateFile() {
                            const fileInput = document.querySelector('input[name="file"]');
                            const filePath = fileInput.value;
                            const allowedExtensions = /(\.pdf)$/i;
                            if (!allowedExtensions.exec(filePath)) {
                                alert('Hanya file PDF yang diizinkan.');
                                fileInput.value = '';
                                return false;
                            }
                            return true;
                        }
                    </script>
                </div>
            </div>
        </div>
    </div>
</div>