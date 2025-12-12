<script <?php echo CSPHandler::scriptNonce(); ?> type="text/javascript">
    $(document).ready(function() {
        $.ajax({
            type: 'POST',
            url: "Report/Mutasi/GetKecamatan.php",
            cache: false,
            success: function(msg) {
                $("#Kecamatan").html(msg);
            },
            error: function(xhr, status, error) {
                console.error("Error loading kecamatan:", error);
                console.error("Status:", status);
                console.error("Response:", xhr.responseText);
                $("#Kecamatan").html("<option value=''>Error loading data</option>");
            }
        });
        
        $("#Kecamatan").change(function() {
            var Kecamatan = $("#Kecamatan").val();
            $.ajax({
                type: 'POST',
                url: "Report/Mutasi/GetDesa.php",
                data: {
                    Kecamatan: Kecamatan
                },
                cache: false,
                success: function(msg) {
                    $("#Desa").html(msg);
                },
                error: function(xhr, status, error) {
                    console.error("Error loading desa:", error);
                    console.error("Status:", status);
                    console.error("Response:", xhr.responseText);
                    $("#Desa").html("<option value=''>Error loading data</option>");
                }
            });
        });
    });
</script>

<form action="?pg=PegawaiFilterDesaMutasi" method="post" enctype="multipart/form-data">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Filter Data Mutasi PerKecamatan </h5>
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
                    <div class=row>
                        <div class="col-lg-6">
                            <div class="form-group row"><label class="col-lg-2 col-form-label">Kecamatan</label>
                                <div class="col-lg-6">
                                    <select name="Kecamatan" id="Kecamatan" style="width: 100%;" class="select2_kecamatan form-control" required>
                                        <option value="">Filter Kecamatan</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row"><label class="col-lg-2 col-form-label">Desa</label>
                                <div class="col-lg-6">
                                    <select name="Desa" id="Desa" style="width: 100%;" class="select2_desa form-control" required>
                                        <option value="">Filter Desa</option>
                                    </select>
                                </div>
                            </div>
                            <button type="submit" name="Proses" value="Proses" class="btn btn-outline btn-primary">Tampilkan</button>
                            <a href="?pg=ViewMutasi"><button type="button" class="btn btn-outline btn-primary">Batal</button></a>
                        </div>

                        <div class="col-lg-6"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- FILTERING -->
    <?php
    if (isset($_POST['Proses'])) {
        $Kecamatan = sql_injeksi($_POST['Kecamatan']);
        $Desa = sql_injeksi($_POST['Desa']);

        $QueryDesa = mysqli_query($db, "SELECT * FROM master_desa WHERE IdDesa ='$Desa' ");
        $DataDesa = mysqli_fetch_assoc($QueryDesa);
        $NamaDesa = $DataDesa['NamaDesa'];

        $QueryKecamatan = mysqli_query($db, "SELECT * FROM master_kecamatan WHERE IdKecamatan ='$Kecamatan' ");
        $DataKecamatan = mysqli_fetch_assoc($QueryKecamatan);
        $NamaKecamatan = $DataKecamatan['Kecamatan'];

    ?>
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5>Hasil Data Mutasi Filter Desa <?php echo $NamaDesa; ?> Kecamatan <?php echo $NamaKecamatan; ?></h5>
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
                                        <th>Nama<br>Tanggal Lahir<br>Jenis Kelamin</th>
                                        <th>Jenis Mutasi</th>
                                        <th>Jabatan</th>
                                        <th>Unit Kerja<br>Kecamatan<br>Kabupaten</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $Nomor = 1;
                                    $QueryPegawai = mysqli_query($db, "SELECT
                                    master_pegawai.IdPegawaiFK,
                                    master_pegawai.Foto,
                                    master_pegawai.NIK,
                                    master_pegawai.Nama,
                                    master_pegawai.TanggalLahir,
                                    master_pegawai.JenKel,
                                    master_pegawai.IdDesaFK,
                                    master_pegawai.Setting,
                                    master_desa.IdDesa,
                                    master_desa.NamaDesa,
                                    master_desa.IdKecamatanFK,
                                    master_kecamatan.IdKecamatan,
                                    master_kecamatan.Kecamatan,
                                    master_kecamatan.IdKabupatenFK,
                                    master_setting_profile_dinas.IdKabupatenProfile,
                                    master_setting_profile_dinas.Kabupaten,
                                    main_user.IdPegawai,
                                    main_user.IdLevelUserFK
                                    FROM
                                    master_pegawai
                                    LEFT JOIN master_desa ON master_pegawai.IdDesaFK = master_desa.IdDesa
                                    LEFT JOIN master_kecamatan ON master_desa.IdKecamatanFK = master_kecamatan.IdKecamatan
                                    LEFT JOIN master_setting_profile_dinas ON master_kecamatan.IdKabupatenFK = master_setting_profile_dinas.IdKabupatenProfile
                                    INNER JOIN main_user ON master_pegawai.IdPegawaiFK = main_user.IdPegawai
                                    WHERE main_user.IdLevelUserFK <> 1 and
                                    main_user.IdLevelUserFK <> 2 and
                                    master_kecamatan.IdKecamatan = '$Kecamatan' AND
                                    master_pegawai.IdDesaFK = '$Desa'
                                    ORDER BY
                                    master_kecamatan.IdKecamatan ASC,
                                    master_desa.NamaDesa ASC");
                                    while ($DataPegawai = mysqli_fetch_assoc($QueryPegawai)) {
                                        $IdPegawaiFK = $DataPegawai['IdPegawaiFK'];
                                        $Foto = $DataPegawai['Foto'];
                                        $NIK = $DataPegawai['NIK'];
                                        $Nama = $DataPegawai['Nama'];
                                        $TanggalLahir = $DataPegawai['TanggalLahir'];
                                        $exp = explode('-', $TanggalLahir);
                                        $ViewTglLahir = $exp[2] . "-" . $exp[1] . "-" . $exp[0];
                                        $JenKel = $DataPegawai['JenKel'];
                                        $NamaDesa = $DataPegawai['NamaDesa'];
                                        $Kecamatan = $DataPegawai['Kecamatan'];
                                        $Kabupaten = $DataPegawai['Kabupaten'];
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
                                                <a href="?pg=DetailMutasi&Kode=<?php echo $IdPegawaiFK; ?>" class=" float-center" data-toggle="tooltip" title="Detail Data"><?php echo $NIK; ?></a>
                                            </td>

                                            <td>
                                                <strong><?php echo $Nama; ?></strong><br><br>
                                                <?php echo $ViewTglLahir; ?><br>
                                                <?php
                                                $QueryJenKel = mysqli_query($db, "SELECT * FROM master_jenkel WHERE IdJenKel = '$JenKel' ");
                                                $DataJenKel = mysqli_fetch_assoc($QueryJenKel);
                                                $JenisKelamin = $DataJenKel['Keterangan'];
                                                echo $JenisKelamin;
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                $Id = 1;
                                                $QMutasi = mysqli_query($db, "SELECT
                                                history_mutasi.JenisMutasi,
                                                master_mutasi.IdMutasi,
                                                master_mutasi.Mutasi,
                                                history_mutasi.TanggalMutasi,
                                                history_mutasi.IdMutasi,
                                                history_mutasi.Setting
                                                FROM
                                                history_mutasi
                                                INNER JOIN master_mutasi ON history_mutasi.JenisMutasi = master_mutasi.IdMutasi
                                                WHERE IdPegawaiFK = '$IdPegawaiFK'
                                                ORDER BY history_mutasi.IdMutasi DESC, history_mutasi.TanggalMutasi DESC");
                                                while ($DataMutasi = mysqli_fetch_assoc($QMutasi)) {
                                                    $JenjangMutasi = $DataMutasi['Mutasi'];
                                                    $SettingMutasi = $DataMutasi['Setting'];
                                                ?>
                                                    <br>
                                                    <?php if ($SettingMutasi == 0) { ?>
                                                        <?php echo $JenjangMutasi; ?>
                                                    <?php } elseif ($SettingMutasi == 1) { ?>
                                                        <span class="label label-success float-left"><?php echo $JenjangMutasi; ?></span>
                                                    <?php } ?>
                                                <?php $Id++;
                                                } ?>
                                            </td>
                                            <td>

                                                <?php
                                                $Id = 1;
                                                $QJabatan = mysqli_query($db, "SELECT
                                                history_mutasi.IdJabatanFK,
                                                master_jabatan.IdJabatan,
                                                master_jabatan.Jabatan,
                                                history_mutasi.TanggalMutasi,
                                                history_mutasi.IdMutasi,
                                                history_mutasi.JenisMutasi,
                                                history_mutasi.Setting
                                                FROM history_mutasi
                                                INNER JOIN master_jabatan ON history_mutasi.IdJabatanFK = master_jabatan.IdJabatan
                                                WHERE IdPegawaiFK = '$IdPegawaiFK'
                                                ORDER BY history_mutasi.IdMutasi DESC, history_mutasi.TanggalMutasi DESC");
                                                while ($DataJabatan = mysqli_fetch_assoc($QJabatan)) {
                                                    $JenjangJabatan = $DataJabatan['Jabatan'];
                                                    $SettingJabatan = $DataJabatan['Setting'];
                                                ?>
                                                    <br>
                                                    <?php if ($SettingJabatan == 0) { ?>
                                                        <?php echo $Id; ?>. <?php echo $JenjangJabatan; ?>
                                                    <?php } elseif ($SettingJabatan == 1) { ?>
                                                        <span class="label label-success float-left"><?php echo $Id; ?>. <?php echo $JenjangJabatan; ?></span>
                                                    <?php } ?>
                                                <?php $Id++;
                                                } ?>
                                            </td>
                                            <td>
                                                <?php echo $NamaDesa; ?><br>
                                                <?php echo $Kecamatan; ?><br>
                                                <?php echo $Kabupaten; ?>
                                            </td>
                                            <td>

                                                <a href="?pg=AddMutasi&Kode=<?php echo $IdPegawaiFK; ?>">
                                                    <button class="btn btn-outline btn-success btn-xs" data-toggle="tooltip" title="Tambah Data"><i class="fa fa-folder-open-o"></i></button>
                                                </a>

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
    <?php } ?>
</form>