<script type="text/javascript">
    $(document).ready(function() {
        $.ajax({
            type: 'POST',
            url: "Report/Pensiun/GetKecamatan.php",
            cache: false,
            success: function(msg) {
                $("#Kecamatan").html(msg);
            }
        });

        $("#Kecamatan").change(function() {
            var Kecamatan = $("#Kecamatan").val();
            $.ajax({
                type: 'POST',
                url: "Report/Pensiun/GetDesa.php",
                data: {
                    Kecamatan: Kecamatan
                },
                cache: false,
                success: function(msg) {
                    $("#Desa").html(msg);
                }
            });
        });
    });
</script>

<form action="?pg=PensiunFilterDesa" method="post" enctype="multipart/form-data">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Filter Data Pensiun PerDesa </h5>
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
                            <a href="?pg=ViewPensiun"><button type="button" class="btn btn-outline btn-primary">Batal</button></a>
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
                        <h5>Hasil Data Filter Desa <?php echo $NamaDesa; ?> Kecamatan <?php echo $NamaKecamatan; ?></h5>
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
                                        <th>Tgl Pensiun</th>
                                        <th>Tgl SK Pensiun</th>
                                        <th>No SK Pensiun</th>
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
                                            history_mutasi.JenisMutasi,
                                            history_mutasi.TanggalMutasi,
                                            history_mutasi.NomorSK,
                                            history_mutasi.FileSKMutasi,
                                            history_mutasi.IdJabatanFK,
                                            master_jabatan.IdJabatan,
                                            master_jabatan.Jabatan,
                                            history_mutasi.Setting
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
                                            master_pegawai.Setting = 0 AND
                                            main_user.IdLevelUserFK <> 1 AND
                                            main_user.IdLevelUserFK <> 2 AND
                                            history_mutasi.JenisMutasi = 3 AND
                                            history_mutasi.Setting = 1 AND
                                    master_pegawai.Kecamatan = '$Kecamatan' AND
                                    master_pegawai.IdDesaFK = '$Desa'
                                    ORDER BY master_pegawai.TanggalPensiun DESC");

                                    while ($DataPegawai = mysqli_fetch_assoc($QueryPegawai)) {
                                        $IdPegawaiFK = $DataPegawai['IdPegawaiFK'];
                                        $Foto = $DataPegawai['Foto'];
                                        $NIK = $DataPegawai['NIK'];
                                        $Nama = $DataPegawai['Nama'];
                                        $Jabatan = $DataPegawai['Jabatan'];

                                        $TanggalLahir = $DataPegawai['TanggalLahir'];
                                        $exp = explode('-', $TanggalLahir);
                                        $ViewTglLahir = $exp[2] . "-" . $exp[1] . "-" . $exp[0];

                                        $TanggalPensiun = $DataPegawai['TanggalPensiun'];
                                        $exp1 = explode('-', $TanggalPensiun);
                                        $ViewTglPensiun = $exp1[2] . "-" . $exp1[1] . "-" . $exp1[0];

                                        //HITUNG DETAIL TANGGAL PENSIUN
                                        $TglPensiun = date_create($TanggalPensiun);
                                        $TglSekarang = date_create();
                                        $Temp = date_diff($TglSekarang, $TglPensiun);

                                        //CEK TANGGAL ASLI SAAT INI
                                        $TglSekarang1 = Date('Y-m-d');

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
                                        $JenisMutasi = $DataPegawai['JenisMutasi'];

                                        $TglSKMutasi = $DataPegawai['TanggalMutasi'];
                                        $exp2 = explode('-', $TglSKMutasi);
                                        $TanggalMutasi = $exp2[2] . "-" . $exp2[1] . "-" . $exp2[0];

                                        $NomorSK = $DataPegawai['NomorSK'];
                                        $SKMutasi = $DataPegawai['FileSKMutasi'];
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
                                                <?php echo $Nama; ?><br>
                                                <?php echo $Jabatan; ?><br>
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
                                                <?php echo $ViewTglPensiun; ?><br>
                                            </td>
                                            <td style="width:160px;">
                                                <?php echo $TanggalMutasi  ?>
                                            </td>
                                            <td>
                                                <?php echo $NomorSK; ?><br>
                                                <a target='_BLANK' href='../Module/Variabel/Download?File=<?php echo $SKMutasi; ?>'>Lihat File SK</a>
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