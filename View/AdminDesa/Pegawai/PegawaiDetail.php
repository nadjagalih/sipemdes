 <div class="row wrapper border-bottom white-bg page-heading">
     <div class="col-lg-10">
         <h2>Data Profile</h2>
     </div>
 </div>

 <div class="wrapper wrapper-content animated fadeInRight">
     <div class="col-lg-12">
         <div class="ibox ">
             <div class="ibox-title">
                 <h5>Profile</h5>&nbsp;
                 <a href="?pg=PegawaiViewAllAdminDesa">
                     <button type="button" class="btn btn-warning" style="width:100px; text-align:center">
                         Back
                     </button>
                 </a>
                 <?php include "../App/Control/FunctionProfilePegawai.php" ?>
                 <form action="AdminDesa/Pegawai/PdfProfile" method="GET" target="_BLANK" enctype="multipart/form-data" style="display:inline;">
                     <input type="hidden" name="Kode" id="Kode" value="<?php echo $IdPegawaiFK; ?>" />
                     <button type="submit" name="Proses" value="Proses" class="btn btn-success">Cetak PDF</button>
                 </form>
             </div>

                 <div class="ibox-content">
                     <div class="row">
                         <div class="col-lg-12">
                             <div class="wrapper wrapper-content animated fadeInUp">
                                 <div class="ibox">
                                     <div class="row">
                                         <div class="col-lg-12">
                                             <div class="m-b-md">
                                                 <h2><strong><?php echo $Nama; ?></strong></h2>
                                             </div>

                                         </div>
                                     </div>
                                     <div class="row">

                                         <div class="col-lg-4" id="cluster_info">
                                             <dl class="row mb-0">
                                                 <div class="col-sm-4 text-sm-right">
                                                     <?php
                                                        if (empty($Foto)) {
                                                        ?>
                                                         <dt>
                                                             <img style="width:200px; height:auto" alt="image" class="message-avatar" src="../Vendor/Media/Pegawai/no-image.jpg">
                                                         </dt>
                                                     <?php } else { ?>
                                                         <dt>
                                                             <img style="width:200px; height:auto" alt="image" class="message-avatar" src="../Vendor/Media/Pegawai/<?php echo $Foto; ?>">
                                                         </dt>
                                                     <?php } ?>
                                                 </div>
                                             </dl>

                                         </div>

                                         <div class="col-lg-8">
                                             <dl class="row mb-0">
                                                 <div class="col-sm-4 text-sm-right">
                                                     <dt>NIK : </dt>
                                                 </div>
                                                 <div class="col-sm-8 text-sm-left">
                                                     <dd class="mb-1"><span class="label label-primary"><?php echo $NIK; ?></span></dd>
                                                 </div>
                                             </dl>
                                             <dl class="row mb-0">
                                                 <div class="col-sm-4 text-sm-right">
                                                     <dt>Tempat Lahir :</dt>
                                                 </div>
                                                 <div class="col-sm-8 text-sm-left">
                                                     <dd class="mb-1"><?php echo $TempatLahir; ?></dd>
                                                 </div>
                                             </dl>
                                             <dl class="row mb-0">
                                                 <div class="col-sm-4 text-sm-right">
                                                     <dt>Tanggal Lahir :</dt>
                                                 </div>
                                                 <div class="col-sm-8 text-sm-left">
                                                     <dd class="mb-1"> <?php echo $TanggalLahir; ?></dd>
                                                 </div>
                                             </dl>
                                             <dl class="row mb-0">
                                                 <div class="col-sm-4 text-sm-right">
                                                     <dt>Jenis Kelamin :</dt>
                                                 </div>
                                                 <div class="col-sm-8 text-sm-left">
                                                     <dd class="mb-1"> <?php echo $DetailNamaJenKel; ?> </dd>
                                                 </div>
                                             </dl>
                                             <dl class="row mb-0">
                                                 <div class="col-sm-4 text-sm-right">
                                                     <dt>Agama :</dt>
                                                 </div>
                                                 <div class="col-sm-8 text-sm-left">
                                                     <dd class="mb-1"> <?php echo $DetailNamaAgama; ?> </dd>
                                                 </div>
                                             </dl>
                                             <dl class="row mb-0">
                                                 <div class="col-sm-4 text-sm-right">
                                                     <dt>Golongan Darah :</dt>
                                                 </div>
                                                 <div class="col-sm-8 text-sm-left">
                                                     <dd class="mb-1"> <?php echo $DetailNamaGolDarah; ?> </dd>
                                                 </div>
                                             </dl>
                                             <dl class="row mb-0">
                                                 <div class="col-sm-4 text-sm-right">
                                                     <dt>Alamat :</dt>
                                                 </div>
                                                 <div class="col-sm-8 text-sm-left">
                                                     <dd class="mb-1">
                                                         <?php echo $Alamat; ?>
                                                         RT <?php echo $RT; ?> /
                                                         RW <?php echo $RW; ?>
                                                         <?php echo $DetailNamaDesa; ?>
                                                         <?php echo $DetailNamaKecamatan; ?>
                                                     </dd>
                                                 </div>
                                             </dl>
                                             <dl class="row mb-0">
                                                 <div class="col-sm-4 text-sm-right">
                                                     <dt>Status Pernikahan :</dt>
                                                 </div>
                                                 <div class="col-sm-8 text-sm-left">
                                                     <dd class="mb-1"> <?php echo $DetailNamaSTNikah; ?> </dd>
                                                 </div>
                                             </dl>
                                             <dl class="row mb-0">
                                                 <div class="col-sm-4 text-sm-right">
                                                     <dt>No Telp :</dt>
                                                 </div>
                                                 <div class="col-sm-8 text-sm-left">
                                                     <dd class="mb-1"> <?php echo $Telp; ?> </dd>
                                                 </div>
                                             </dl>
                                             <dl class="row mb-0">
                                                 <div class="col-sm-4 text-sm-right">
                                                     <dt>Status Kepegawaian :</dt>
                                                 </div>
                                                 <div class="col-sm-8 text-sm-left">
                                                     <dd class="mb-1"> <?php echo $DetailNamaSTPegawai; ?> </dd>
                                                 </div>
                                             </dl>
                                             <dl class="row mb-0">
                                                 <div class="col-sm-4 text-sm-right">
                                                     <dt>Unit Kerja :</dt>
                                                 </div>
                                                 <div class="col-sm-8 text-sm-left">
                                                     <dd class="mb-1">
                                                         Kelurahan/Desa <?php echo $DetailNamaUnitKerja; ?> - Kecamatan <?php echo $DetailNamaKecamatanUnitKerja; ?>
                                                     </dd>
                                                 </div>
                                             </dl>

                                         </div>

                                     </div>
                                     <div class="row">
                                         <div class="col-lg-12">
                                             <dl class="row mb-0">
                                                 <div class="col-sm-2 text-sm-right">
                                                     <dt>Completed:</dt>
                                                 </div>
                                                 <div class="col-sm-10 text-sm-left">
                                                     <dd>
                                                         <div class="progress m-b-1">
                                                             <div style="width: 100%;" class="progress-bar progress-bar-striped progress-bar-animated"></div>
                                                         </div>
                                                         <small>Profile completed in <strong>100%</strong></small>
                                                     </dd>
                                                 </div>
                                             </dl>
                                         </div>
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
                                                                                 Rp. <?php echo $Siltap; ?>
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
                 </div>
             </div>
         </div>
     </div>
         <?php
            if (isset($_POST['Proses'])) {
                $Kode = sql_injeksi($_POST['Kode']);
            } ?>

<!-- Script untuk mengaktifkan tab berdasarkan parameter URL -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Mendapatkan parameter tab dari URL
    const urlParams = new URLSearchParams(window.location.search);
    const activeTab = urlParams.get('tab');
    
    if (activeTab) {
        // Menghapus class active dari semua nav-link dan tab-pane
        document.querySelectorAll('.nav-link').forEach(link => {
            link.classList.remove('active');
        });
        document.querySelectorAll('.tab-pane').forEach(pane => {
            pane.classList.remove('active');
        });
        
        // Mengaktifkan tab yang sesuai
        const targetLink = document.querySelector(`a[href="#${activeTab}"]`);
        const targetPane = document.getElementById(activeTab);
        
        if (targetLink && targetPane) {
            targetLink.classList.add('active');
            targetPane.classList.add('active');
        }
    }
});
</script>