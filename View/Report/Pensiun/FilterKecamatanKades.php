<?php
require_once "../Module/Security/CSPHandler.php";
?>
<script type="text/javascript" <?php echo CSPHandler::scriptNonce(); ?>>
    $(document).ready(function() {
        console.log("Document ready - FilterKecamatanKades");
        $.ajax({
            type: 'POST',
            url: "Report/Pensiun/GetKecamatan.php",
            cache: false,
            success: function(msg) {
                console.log("AJAX Success for Kecamatan loading:", msg);
                $("#Kecamatan").html(msg);
            },
            error: function(xhr, status, error) {
                console.log("AJAX Error loading Kecamatan:", error);
                console.log("Response:", xhr.responseText);
            }
        });
    });
</script>

<form action="?pg=FilterKecamatanKades" method="post" enctype="multipart/form-data">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Filter Data Kepala Desa Mendekati Masa Pensiun PerKecamatan </h5>
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
                                        <?php
                                        $QueryKecamatanList = mysqli_query($db, "SELECT * FROM master_kecamatan ORDER BY Kecamatan ASC");
                                        while ($RowKecamatanList = mysqli_fetch_assoc($QueryKecamatanList)) {
                                            $IdKecamatanList = isset($RowKecamatanList['IdKecamatan']) ? $RowKecamatanList['IdKecamatan'] : '';
                                            $NamaKecamatanList = isset($RowKecamatanList['Kecamatan']) ? $RowKecamatanList['Kecamatan'] : '';
                                        ?>
                                            <option value="<?php echo htmlspecialchars($IdKecamatanList); ?>"><?php echo htmlspecialchars($NamaKecamatanList); ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <button type="submit" name="Proses" value="Proses" class="btn btn-outline btn-primary">Tampilkan</button>
                            <a href="?pg=ViewMasaPensiunKades"><button type="button" class="btn btn-outline btn-primary">Batal</button></a>
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

        $QueryKecamatan = mysqli_query($db, "SELECT * FROM master_kecamatan WHERE IdKecamatan ='$Kecamatan' ");
        $DataKecamatan = mysqli_fetch_assoc($QueryKecamatan);
        $NamaKecamatan = $DataKecamatan['Kecamatan'];

    ?>
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5>Hasil Data Filter Kepala Desa Kecamatan <?php echo $NamaKecamatan; ?></h5>
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
                                        <th>Nama<br>Jabatan<br>Alamat</th>
                                        <th>Tanggal Lahir<br>Jenis Kelamin</th>
                                        <th>Tanggal Mutasi</th>
                                        <th>Tanggal Pensiun<br>Sisa Pensiun</th>
                                        <th>Keterangan</th>
                                        <th>Unit Kerja<br>Kecamatan<br>Kabupaten</th>
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
                                            master_pegawai.Alamat,
                                            master_pegawai.RT,
                                            master_pegawai.RW,
                                            master_pegawai.Lingkungan,
                                            master_pegawai.Kecamatan AS Kec,
                                            master_pegawai.Kabupaten,
                                            master_pegawai.Setting,
                                            master_pegawai.TanggalPensiun,
                                            master_desa.IdDesa,
                                            master_desa.NamaDesa,
                                            master_desa.IdKecamatanFK,
                                            master_kecamatan.IdKecamatan,
                                            master_kecamatan.Kecamatan,
                                            master_kecamatan.IdKabupatenFK,
                                            master_setting_profile_dinas.IdKabupatenProfile,
                                            master_setting_profile_dinas.Kabupaten,
                                            main_user.IdPegawai,
                                            main_user.IdLevelUserFK,
                                            history_mutasi.IdPegawaiFK,
                                            history_mutasi.Setting,
											history_mutasi.TanggalMutasi,
                                            master_jabatan.IdJabatan,
                                            history_mutasi.IdJabatanFK,
                                            master_jabatan.Jabatan
                                        FROM
                                            master_pegawai
                                            LEFT JOIN
                                            master_desa
                                            ON
                                                master_pegawai.IdDesaFK = master_desa.IdDesa
                                            LEFT JOIN
                                            master_kecamatan
                                            ON
                                                master_desa.IdKecamatanFK = master_kecamatan.IdKecamatan
                                            LEFT JOIN
                                            master_setting_profile_dinas
                                            ON
                                                master_kecamatan.IdKabupatenFK = master_setting_profile_dinas.IdKabupatenProfile
                                            INNER JOIN
                                            main_user
                                            ON
                                                main_user.IdPegawai = master_pegawai.IdPegawaiFK
                                            INNER JOIN
                                            history_mutasi
                                            ON
                                                master_pegawai.IdPegawaiFK = history_mutasi.IdPegawaiFK
                                            INNER JOIN
                                            master_jabatan
                                            ON
                                                history_mutasi.IdJabatanFK = master_jabatan.IdJabatan
                                        WHERE
                                            master_pegawai.Setting = 1 AND
                                            main_user.IdLevelUserFK <> 1 AND
                                            main_user.IdLevelUserFK <> 2 AND
                                            history_mutasi.IdJabatanFK = 1 AND
                                            master_pegawai.Kecamatan = '$Kecamatan' AND
                                            history_mutasi.Setting = 1
                                        ORDER BY
                                            master_pegawai.TanggalPensiun ASC");
                                    while ($DataPegawai = mysqli_fetch_assoc($QueryPegawai)) {
                                        $IdPegawaiFK = $DataPegawai['IdPegawaiFK'];
                                        $Foto = $DataPegawai['Foto'];
                                        $NIK = $DataPegawai['NIK'];
                                        $Nama = $DataPegawai['Nama'];
                                        $Jabatan = $DataPegawai['Jabatan'];

                                        $TanggalLahir = $DataPegawai['TanggalLahir'];
                                        $exp = explode('-', $TanggalLahir);
                                        $ViewTglLahir = $exp[2] . "-" . $exp[1] . "-" . $exp[0];

                                        $TanggalMutasi = $DataPegawai['TanggalMutasi'];
                                        $exp1 = explode('-', $TanggalMutasi);
                                        $ViewTglMutasi = $exp1[2] . "-" . $exp1[1] . "-" . $exp1[0];
                                        // $AddTahun = $exp1[0] + 6;

                                        $TanggalPensiun = date('Y-m-d', strtotime('+6 year', strtotime($TanggalMutasi)));
                                        $ViewTglPensiun = date('d-m-Y', strtotime($TanggalPensiun));

                                        $TglPensiun = date_create($TanggalPensiun);
                                        $TglSekarang = date_create();
                                        $Temp = date_diff($TglSekarang, $TglPensiun);


                                        $TglSekarang1 = date('Y-m-d');

                                        if ($TglSekarang1 >= $TanggalPensiun) {
                                            $HasilTahun = 0 . ' Tahun ';
                                            $HasilBulan = 0 . ' Bulan ';
                                            $HasilHari = 0 . ' Hari ';
                                        } elseif ($TglSekarang1 < $TanggalPensiun) {
                                            $HasilTahun = $Temp->y . ' Tahun ';
                                            $HasilBulan = $Temp->m . ' Bulan ';
                                            $HasilHari = $Temp->d + 1 . ' Hari ';
                                        }
                                        //SELESAI

                                        $JenKel = $DataPegawai['JenKel'];
                                        $NamaDesa = $DataPegawai['NamaDesa'];
                                        $Kecamatan = $DataPegawai['Kecamatan'];
                                        $Kabupaten = $DataPegawai['Kabupaten'];
                                        $Alamat = $DataPegawai['Alamat'];
                                        $RT = $DataPegawai['RT'];
                                        $RW = $DataPegawai['RW'];

                                        $Lingkungan = $DataPegawai['Lingkungan'];
                                        $AmbilDesa = mysqli_query($db, "SELECT * FROM master_desa WHERE IdDesa = '$Lingkungan' ");
                                        $LingkunganBPD = mysqli_fetch_assoc($AmbilDesa);
                                        $Komunitas = $LingkunganBPD['NamaDesa'];

                                        $KecamatanBPD = $DataPegawai['Kec'];
                                        $AmbilKecamatan = mysqli_query($db, "SELECT * FROM master_kecamatan WHERE IdKecamatan = '$KecamatanBPD' ");
                                        $KecamatanBPD = mysqli_fetch_assoc($AmbilKecamatan);
                                        $KomunitasKec = $KecamatanBPD['Kecamatan'];

                                        $Address = $Alamat . " RT." . $RT . "/RW." . $RW . " " . $Komunitas . " Kecamatan " . $KomunitasKec;
                                        $Setting = $DataPegawai['Setting'];
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

                                            <td style="width:130px;">
                                                <?php echo $NIK; ?></a>
                                            </td>
                                            <td>
                                                <strong><?php echo $Nama; ?></strong><br>
                                                <strong><?php echo $Jabatan ?></strong><br><br>
                                                <?php echo $Address; ?>
                                            </td>
                                            <td style="width:110px;">
                                                <?php echo $ViewTglLahir; ?><br>
                                                <?php
                                                $QueryJenKel = mysqli_query($db, "SELECT * FROM master_jenkel WHERE IdJenKel = '$JenKel' ");
                                                $DataJenKel = mysqli_fetch_assoc($QueryJenKel);
                                                $JenisKelamin = $DataJenKel['Keterangan'];
                                                echo $JenisKelamin;
                                                ?>
                                            </td>
                                            <td>
                                                <?php echo $ViewTglMutasi; ?><br>
                                            </td>
                                            <td style="width:160px;">
                                                <?php echo $ViewTglPensiun; ?><br>
                                                <?php echo $HasilTahun . " " . $HasilBulan . " " . $HasilHari; ?>
                                            </td>
                                            <td>
                                                <?php
                                                if ($TglSekarang1 >= $TanggalPensiun and $Setting = 1) {
                                                ?>
                                                    <a href=""><span class="label label-danger float-left">PENSIUN BELUM ADA SK</span></a>
                                                <?php } elseif ($TglSekarang1 < $TanggalPensiun) {
                                                ?>
                                                    BELUM PENSIUN
                                                <?php } ?>
                                            </td>

                                            <td>
                                                <?php echo $NamaDesa; ?><br>
                                                <?php echo $Kecamatan; ?><br>
                                                <?php echo $Kabupaten; ?>
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