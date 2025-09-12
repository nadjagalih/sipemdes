<?php
if (isset($_GET['Kode'])) {
    $IdTemp = sql_url($_GET['Kode']);
    $QDataPegawai = mysqli_query($db, "SELECT IdPegawaiFK, Nama FROM master_pegawai WHERE IdPegawaiFK = '$IdTemp' ");
    $DataPegawai = mysqli_fetch_assoc($QDataPegawai);
    $IdPegawai = $DataPegawai['IdPegawaiFK'];
    $NamaPegawai = $DataPegawai['Nama'];
} ?>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Data Pendidikan</h2>
    </div>
    <div class="col-lg-2">

    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <a href="?pg=PegawaiViewPendidikanAdminDesa" class="btn btn-primary float-center"> Batal</a>
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
                                    <th>Pendidikan</th>
                                    <th>Nama Sekolah</th>
                                    <th>Jurusan</th>
                                    <th>Tahun Masuk - Tahun Keluar</th>
                                    <th>Set Pendidikan</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php include "../App/Control/FunctionPegawaiDetailPendidikanAdminDesa.php"; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>