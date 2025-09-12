<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Data Admin Aplikasi SIPEMDES</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="">Dashboard</a>
            </li>
            <li class="breadcrumb-item">
                <a>Setting</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Admin</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2">

    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>List Data Admin</h5>
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
                                    <th>Foto</th>
                                    <th>NIK</th>
                                    <th>Nama</th>
                                    <th>Jabatan</th>
                                    <th>Telp</th>
                                    <th>Desa</th>
                                    <th>Kecamatan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $Nomor = 1;
                                $QueryAdmin = mysqli_query($db, "SELECT
                                master_pegawai.Foto,
                                master_pegawai.NIK,
                                master_pegawai.Nama,
                                master_jabatan.Jabatan,
                                master_desa.NamaDesa,
                                master_kecamatan.Kecamatan,
                                master_pegawai.NoTelp
                            FROM
                                master_pegawai
                                INNER JOIN
                                master_admin_aplikasi
                                ON
                                    master_pegawai.IdPegawaiFK = master_admin_aplikasi.IdPegawaiFK
                                INNER JOIN
                                master_jabatan
                                ON
                                    master_admin_aplikasi.IdJabatanFK = master_jabatan.IdJabatan
                                INNER JOIN
                                main_user
                                ON
                                    master_pegawai.IdPegawaiFK = main_user.IdPegawai
                                INNER JOIN
                                master_desa
                                ON
                                    master_pegawai.IdDesaFK = master_desa.IdDesa
                                INNER JOIN
                                master_kecamatan
                                ON
                                    master_desa.IdKecamatanFK = master_kecamatan.IdKecamatan
                            WHERE
                                main_user.IdLevelUserFK = 2
                            ORDER BY
                                master_kecamatan.Kecamatan ASC,
                                master_desa.NamaDesa ASC");
                                while ($DataAdmin = mysqli_fetch_assoc($QueryAdmin)) {
                                    $Foto = $DataAdmin['Foto'];
                                    $NIK = $DataAdmin['NIK'];
                                    $Nama = $DataAdmin['Nama'];
                                    $Jabatan = $DataAdmin['Jabatan'];
                                    $NoTelp = $DataAdmin['NoTelp'];
                                    $NamaDesa = $DataAdmin['NamaDesa'];
                                    $Kecamatan = $DataAdmin['Kecamatan'];

                                ?>
                                    <tr class="gradeX">
                                        <td>
                                            <?php echo $Nomor; ?>
                                        </td>
                                        <?php
                                        if (empty($Foto)) {
                                        ?>
                                            <td>
                                                <img style="width:80px; height:auto" alt="image" class="message-avatar" src="../Vendor/Media/Pegawai/no-image.jpg">
                                            </td>
                                        <?php } else { ?>
                                            <td>
                                                <img style="width:80px; height:auto" alt="image" class="message-avatar" src="../Vendor/Media/Pegawai/<?php echo $Foto; ?>">
                                            </td>
                                        <?php } ?>
                                        <td>
                                            <?php echo $NIK; ?>
                                        </td>
                                        <td>
                                            <?php echo $Nama; ?>
                                        </td>
                                        <td>
                                            <?php echo $Jabatan; ?>
                                        </td>
                                        <td>
                                            <?php echo $NoTelp; ?>
                                        </td>
                                        <td>
                                            <?php echo $NamaDesa; ?>
                                        </td>
                                        <td>
                                            <?php echo $Kecamatan; ?>
                                        </td>
                                    </tr>
                                <?php $Nomor++;
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>