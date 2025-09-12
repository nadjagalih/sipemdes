<?php
// Initialize variables
$IdPegawai = '';
$NamaPegawai = '';
$Siltap = 0;

// Get employee data if Kode parameter exists
if (isset($_GET['Kode'])) {
    $IdTemp = sql_url($_GET['Kode']);
    $QDataPegawai = mysqli_query($db, "SELECT IdPegawaiFK, Nama FROM master_pegawai WHERE IdPegawaiFK = '$IdTemp' ");
    
    if ($QDataPegawai && mysqli_num_rows($QDataPegawai) > 0) {
        $DataPegawai = mysqli_fetch_assoc($QDataPegawai);
        $IdPegawai = $DataPegawai['IdPegawaiFK'];
        $NamaPegawai = $DataPegawai['Nama'];
        
        // Get Siltap data if needed
        $QSiltap = mysqli_query($db, "SELECT Siltap FROM master_pegawai WHERE IdPegawaiFK = '$IdTemp' ");
        if ($QSiltap && mysqli_num_rows($QSiltap) > 0) {
            $DataSiltap = mysqli_fetch_assoc($QSiltap);
            $Siltap = number_format($DataSiltap['Siltap'], 0, ',', '.');
        }
    }
}

// Show success alert if data was saved
if (isset($_GET['alert']) && $_GET['alert'] == 'Save') {
    echo "<script type='text/javascript'>
        setTimeout(function () {
            swal({
              title: '',
              text: 'Data Berhasil Disimpan',
              type: 'success',
              showConfirmButton: true
            });
        }, 10);
    </script>";
}
?>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Data Suami/Istri</h2>
        <?php if (!empty($NamaPegawai)): ?>
            <small>Pegawai: <?php echo htmlspecialchars($NamaPegawai); ?></small>
        <?php endif; ?>
    </div>
    <div class="col-lg-2">
        <!-- Additional controls can be added here -->
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <a href="?pg=PegawaiViewSuamiIstriAdminDesa" class="btn btn-primary float-center"> Kembali</a>
                </div>

                <div class="row m-t-sm">
                    <div class="col-lg-12">
                        <div class="panel blank-panel">
                            <div class="panel-heading">
                                <div class="panel-options">
                                    <ul class="nav nav-tabs">
                                        <li><a class="nav-link active" href="#tab-1" data-toggle="tab">Pendidikan</a></li>
                                        <li><a class="nav-link" href="#tab-2" data-toggle="tab">Suami Istri</a></li>
                                        <li><a class="nav-link" href="#tab-3" data-toggle="tab">Anak</a></li>
                                        <li><a class="nav-link" href="#tab-4" data-toggle="tab">Orang Tua</a></li>
                                        <li><a class="nav-link" href="#tab-5" data-toggle="tab">Mutasi</a></li>
                                        <li><a class="nav-link" href="#tab-6" data-toggle="tab">Siltap</a></li>
                                    </ul>
                                </div>
                            </div>

                            <div class="panel-body">

                                <div class="tab-content">
                                    <div class="tab-pane active" id="tab-1">
                                        <div class="feed-activity-list">
                                            <?php include "../App/Control/FunctionProfilePendidikan.php" ?>
                                        </div>
                                    </div>

                                    <div class="tab-pane" id="tab-2">
                                        <?php include "../App/Control/FunctionProfileSuamiIstri.php" ?>
                                    </div>

                                    <div class="tab-pane" id="tab-3">
                                        <?php include "../App/Control/FunctionProfileAnak.php" ?>
                                    </div>

                                    <div class="tab-pane" id="tab-4">
                                        <?php include "../App/Control/FunctionProfileOrtu.php" ?>
                                    </div>

                                    <div class="tab-pane" id="tab-5">
                                        <?php include "../App/Control/FunctionProfileMutasi.php" ?>
                                    </div>

                                    <div class="tab-pane" id="tab-6">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered table-hover dataTables-kecamatan">
                                                <thead>
                                                    <tr>
                                                        <th>Penghasilan Tetap</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            Rp. <?php echo htmlspecialchars($Siltap); ?>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>