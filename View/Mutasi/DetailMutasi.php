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
        <h2>
            Data Mutasi <strong><?php echo $NamaPegawai; ?></strong>
        </h2>

    </div>
    <div class="col-lg-2">

    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <a href="?pg=ViewMutasi" class="btn btn-primary float-center"> Batal</a>
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

                <?php
                if ($_SESSION['IdLevelUserFK'] == 1) {
                ?>
                    <div class="ibox-content">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover dataTables-kecamatan">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Jenis Mutasi</th>
                                        <th>Jabatan</th>
                                        <th>Tanggal Mutasi</th>
                                        <th>Nomor SK <br>SK Mutasi</th>
                                        <th>Set Mutasi</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $No = 1;
                                    $QMutasiView = mysqli_query($db, "SELECT
                                        history_mutasi.JenisMutasi,
                                        history_mutasi.IdMutasi,
                                        master_mutasi.Mutasi,
                                        history_mutasi.IdJabatanFK,
                                        master_jabatan.IdJabatan,
                                        master_jabatan.Jabatan,
                                        history_mutasi.NomorSK,
                                        history_mutasi.TanggalMutasi,
                                        history_mutasi.FileSKMutasi,
                                        history_mutasi.Setting,
                                        history_mutasi.KeteranganJabatan,
                                        master_mutasi.IdMutasi AS MasterId,
                                        history_mutasi.IdPegawaiFK
                                        FROM history_mutasi
                                        INNER JOIN master_mutasi ON history_mutasi.JenisMutasi = master_mutasi.IdMutasi
                                        INNER JOIN master_jabatan ON history_mutasi.IdJabatanFK = master_jabatan.IdJabatan
                                        WHERE history_mutasi.IdPegawaiFK = '$IdTemp'
                                        ORDER BY history_mutasi.TanggalMutasi DESC");
                                    while ($DataView = mysqli_fetch_assoc($QMutasiView)) {
                                        $IdMutasi = $DataView['IdMutasi'];
                                        $JenisMutasi = $DataView['Mutasi'];
                                        $Jabatan = $DataView['Jabatan'];
                                        $TglMutasi = $DataView['TanggalMutasi'];
                                        $exp = explode('-', $TglMutasi);
                                        $TanggalMutasi = $exp[2] . "-" . $exp[1] . "-" . $exp[0];
                                        $NomorSK = $DataView['NomorSK'];
                                        $SKMutasi = $DataView['FileSKMutasi'];
                                        $SetMutasi = $DataView['Setting'];
                                    ?>
                                        <tr class="gradeX">
                                            <td><?php echo $No; ?> </td>
                                            <td><?php echo $JenisMutasi; ?> </td>
                                            <td><?php echo $Jabatan; ?> </td>
                                            <td><?php echo $TanggalMutasi; ?> </td>
                                            <td>Nomor SK : <?php echo $NomorSK; ?>
                                                <br>
                                                <a target='_BLANK' href='../Module/Variabel/ViewFileBLOB?File=<?php echo $SKMutasi; ?>'>Lihat File SK</a>
                                            </td>

                                            <td>
                                                <?php if ($SetMutasi == 0) { ?>
                                                    <a href="../App/Model/ExcHistoryMutasi?Act=SettingOn&Kode=<?php echo $IdMutasi; ?>">
                                                        <span class="label label-warning float-left">NON AKTIF</span>
                                                    </a>
                                                <?php } elseif ($SetMutasi == 1) { ?>
                                                    <span class="label label-success float-left">AKTIF</span>
                                                <?php } ?>
                                            </td>
                                            <td>
                                                <?php if ($SetMutasi == 0) { ?>
                                                    <button type="button" class="btn btn-outline btn-default"><i class="fa fa-edit"></i></button>
                                                    <button type="button" class="btn btn-outline btn-default"><i class="fa fa-book"></i></button>
                                                    <!-- <button type="button" class="btn btn-outline btn-default"><i class="fa fa-eraser"></i></button> -->
                                                    <a href="../App/Model/ExcHistoryMutasi?Act=Delete&Kode=<?php echo $IdMutasi; ?>" onclick="return confirm('Anda yakin ingin menghapus jabatan NON-AKTIF dengan ID: <?php echo $IdMutasi; ?>?');">
                                                        <button class="btn btn-outline btn-danger  btn-md" data-toggle="tooltip" title="Delete"><i class="fa fa-eraser"></i></button>
                                                    </a>
                                                <?php } elseif ($SetMutasi == 1) { ?>
                                                    <a href="?pg=EditMutasi&Kode=<?php echo $IdMutasi; ?>">
                                                        <button class="btn btn-outline btn-success btn-md" data-toggle="tooltip" title="Edit Data"><i class="fa fa-edit"></i></button>
                                                    </a>
                                                    <a href="?pg=EditMutasiSK&Kode=<?php echo $IdMutasi; ?>">
                                                        <button class="btn btn-outline btn-success btn-md" data-toggle="tooltip" title="Upload SK"><i class="fa fa-book"></i></button>
                                                    </a>
                                                    <a href="../App/Model/ExcHistoryMutasi?Act=Delete&Kode=<?php echo $IdMutasi; ?>" onclick="return confirm('Anda yakin ingin menghapus jabatan AKTIF dengan ID: <?php echo $IdMutasi; ?>? \n\nJika dihapus, jabatan NON-AKTIF terbaru akan otomatis diaktifkan.');">
                                                        <button class="btn btn-outline btn-danger  btn-md" data-toggle="tooltip" title="Delete"><i class="fa fa-eraser"></i></button>
                                                    </a>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                    <?php $No++;
                                    } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <?php  } else {
                    $JenMutasi = 0; // Inisialisasi variabel
                    $CekMutasi = mysqli_query($db, "SELECT * FROM history_mutasi WHERE IdPegawaiFK = '$IdTemp' ");
                    if ($CekMutasi && mysqli_num_rows($CekMutasi) > 0) {
                        while ($Result = mysqli_fetch_assoc($CekMutasi)) {
                            $IdPeg = isset($Result['IdPegawaiFK']) ? $Result['IdPegawaiFK'] : '';
                            $JenMutasi = isset($Result['JenisMutasi']) ? $Result['JenisMutasi'] : 0;
                        }
                    }

                    if ($JenMutasi == 3 or $JenMutasi == 4 or $JenMutasi == 5) { ?>
                        <div class="ibox-content">
                            <div class="row" style="color: brown;">
                                <div class="col-lg-12">
                                    <h5>DATA MUTASI TIDAK DAPAT DI TAMBAHKAN <br>
                                        SILAHKAN HUBUNGI ADMIN DINAS PEMBERDAYAAN MASYARAKAT DESA
                                    </h5>
                                </div>
                            </div>
                        </div>
                    <?php } else { ?>

                        <div class="ibox-content">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover dataTables-kecamatan">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Jenis Mutasi</th>
                                            <th>Jabatan</th>
                                            <th>Tanggal Mutasi</th>
                                            <th>Nomor SK <br>SK Mutasi</th>
                                            <th>Set Mutasi</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $No = 1;
                                        $QMutasiView = mysqli_query($db, "SELECT
                                        history_mutasi.JenisMutasi,
                                        history_mutasi.IdMutasi,
                                        master_mutasi.Mutasi,
                                        history_mutasi.IdJabatanFK,
                                        master_jabatan.IdJabatan,
                                        master_jabatan.Jabatan,
                                        history_mutasi.NomorSK,
                                        history_mutasi.TanggalMutasi,
                                        history_mutasi.FileSKMutasi,
                                        history_mutasi.Setting,
                                        history_mutasi.KeteranganJabatan,
                                        master_mutasi.IdMutasi AS MasterId,
                                        history_mutasi.IdPegawaiFK
                                        FROM history_mutasi
                                        INNER JOIN master_mutasi ON history_mutasi.JenisMutasi = master_mutasi.IdMutasi
                                        INNER JOIN master_jabatan ON history_mutasi.IdJabatanFK = master_jabatan.IdJabatan
                                        WHERE history_mutasi.IdPegawaiFK = '$IdTemp'
                                        ORDER BY history_mutasi.TanggalMutasi DESC");
                                        while ($DataView = mysqli_fetch_assoc($QMutasiView)) {
                                            $IdMutasi = $DataView['IdMutasi'];
                                            $JenisMutasi = $DataView['Mutasi'];
                                            $Jabatan = $DataView['Jabatan'];
                                            $TglMutasi = $DataView['TanggalMutasi'];
                                            $exp = explode('-', $TglMutasi);
                                            $TanggalMutasi = $exp[2] . "-" . $exp[1] . "-" . $exp[0];
                                            $NomorSK = $DataView['NomorSK'];
                                            $SKMutasi = $DataView['FileSKMutasi'];
                                            $SetMutasi = $DataView['Setting'];
                                        ?>
                                            <tr class="gradeX">
                                                <td><?php echo $No; ?> </td>
                                                <td><?php echo $JenisMutasi; ?> </td>
                                                <td><?php echo $Jabatan; ?> </td>
                                                <td><?php echo $TanggalMutasi; ?> </td>
                                                <td>Nomor SK : <?php echo $NomorSK; ?>
                                                    <br>
                                                    <a target='_BLANK' href='../Module/Variabel/ViewFileBLOB?File=<?php echo $SKMutasi; ?>'>Lihat File SK</a>
                                                </td>

                                                <td>
                                                    <?php if ($SetMutasi == 0) { ?>
                                                        <a href="../App/Model/ExcHistoryMutasi?Act=SettingOn&Kode=<?php echo $IdMutasi; ?>">
                                                            <span class="label label-warning float-left">NON AKTIF</span>
                                                        </a>
                                                    <?php } elseif ($SetMutasi == 1) { ?>
                                                        <span class="label label-success float-left">AKTIF</span>
                                                    <?php } ?>
                                                </td>
                                                <td>
                                                    <?php if ($SetMutasi == 0) { ?>
                                                        <button type="button" class="btn btn-outline btn-default"><i class="fa fa-edit"></i></button>
                                                        <button type="button" class="btn btn-outline btn-default"><i class="fa fa-book"></i></button>
                                                        <button type="button" class="btn btn-outline btn-default"><i class="fa fa-eraser"></i></button>
                                                    <?php } elseif ($SetMutasi == 1) { ?>
                                                        <a href="?pg=EditMutasi&Kode=<?php echo $IdMutasi; ?>">
                                                            <button class="btn btn-outline btn-success btn-md" data-toggle="tooltip" title="Edit Data"><i class="fa fa-edit"></i></button>
                                                        </a>
                                                        <a href="?pg=EditMutasiSK&Kode=<?php echo $IdMutasi; ?>">
                                                            <button class="btn btn-outline btn-success btn-md" data-toggle="tooltip" title="Upload SK"><i class="fa fa-book"></i></button>
                                                        </a>
                                                        <a href="../App/Model/ExcHistoryMutasi?Act=Delete&Kode=<?php echo $IdMutasi; ?>" onclick="return confirm('Anda yakin ingin menghapus jabatan AKTIF dengan ID: <?php echo $IdMutasi; ?>? \n\nJika dihapus, jabatan NON-AKTIF terbaru akan otomatis diaktifkan.');">
                                                            <button class="btn btn-outline btn-danger  btn-md" data-toggle="tooltip" title="Delete"><i class="fa fa-eraser"></i></button>
                                                        </a>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                        <?php $No++;
                                        } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                <?php }
                } ?>
            </div>
        </div>
    </div>
</div>