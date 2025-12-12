<?php
require_once "../Module/Security/CSPHandler.php";
?>
<script type="text/javascript" <?php echo CSPHandler::scriptNonce(); ?>>
    $(document).ready(function() {
        $("#Kecamatan").change(function() {
            var Kecamatan = $("#Kecamatan").val();
            console.log("Kecamatan selected: " + Kecamatan);
            if(Kecamatan != '') {
                $.ajax({
                    type: 'POST',
                    url: "Report/Pegawai/GetDesa.php",
                    data: {
                        Kecamatan: Kecamatan
                    },
                    cache: false,
                    success: function(msg) {
                        console.log("AJAX Success response: ", msg);
                        $("#Desa").html(msg);
                    },
                    error: function(xhr, status, error) {
                        console.log("AJAX Error: " + error);
                        console.log("XHR Status: " + xhr.status);
                        console.log("Response Text: " + xhr.responseText);
                        $("#Desa").html('<option value="">Error loading desa</option>');
                    }
                });
            } else {
                $("#Desa").html('<option value="">Filter Desa</option>');
            }
        });
    });
</script>

<form action="?pg=PegawaiFilterDesa" method="post" enctype="multipart/form-data">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Filter Data PerDesa </h5>
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
                            <div class="form-group row"><label class="col-lg-2 col-form-label">Desa</label>
                                <div class="col-lg-6">
                                    <select name="Desa" id="Desa" style="width: 100%;" class="select2_desa form-control" required>
                                        <option value="">Filter Desa</option>
                                    </select>
                                </div>
                            </div>
                            <button type="submit" name="Proses" value="Proses" class="btn btn-outline btn-primary">Tampilkan</button>
                            <a href="?pg=ViewPegawaiReport"><button type="button" class="btn btn-outline btn-primary">Batal</button></a>
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
                                    <tr align="center">
                                        <th rowspan="2">No</th>
                                        <th rowspan="2">Kecamatan<br>Desa<br>Kode Desa</th>
                                        <th rowspan="2">Foto</th>
                                        <th rowspan="2">NIK</th>
                                        <th rowspan="2">Nama Pegawai<br>Alamat</th>
                                        <th rowspan="2">Tgl Lahir<br>Jenis Kelamin</th>
                                        <th rowspan="2">Pendidikan</th>
                                        <th colspan="2">SK Pengangkatan</th>
                                        <th rowspan="2">Jabatan</th>
                                        <th rowspan="2">Keterangan</th>
                                        <th rowspan="2">Siltap (Rp.)</th>
                                        <th rowspan="2">Telp</th>
                                    </tr>
                                    <tr align="center">
                                        <th>No SK</th>
                                        <th>Tgl SK</th>
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
                            master_pegawai.Siltap,
                            master_pegawai.NoTelp,
                            master_desa.IdDesa,
                            master_desa.KodeDesa,
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
                            history_mutasi.NomorSK,
                            history_mutasi.TanggalMutasi,
                            history_mutasi.IdJabatanFK,
                            history_mutasi.KeteranganJabatan,
                            history_mutasi.Setting,
                            master_jabatan.IdJabatan,
                            master_jabatan.Jabatan
                            FROM
                            master_pegawai
                            LEFT JOIN master_desa ON master_pegawai.IdDesaFK = master_desa.IdDesa
                            LEFT JOIN master_kecamatan ON master_desa.IdKecamatanFK = master_kecamatan.IdKecamatan
                            LEFT JOIN master_setting_profile_dinas ON master_kecamatan.IdKabupatenFK = master_setting_profile_dinas.IdKabupatenProfile
                            INNER JOIN main_user ON master_pegawai.IdPegawaiFK = main_user.IdPegawai
                            INNER JOIN history_mutasi ON master_pegawai.IdPegawaiFK = history_mutasi.IdPegawaiFK
                            INNER JOIN master_jabatan ON history_mutasi.IdJabatanFK = master_jabatan.IdJabatan
                            WHERE
                            master_pegawai.Setting = 1 AND
                            main_user.IdLevelUserFK <> 1 AND
                            main_user.IdLevelUserFK <> 2 AND
                            history_mutasi.Setting = 1 AND
                            master_kecamatan.IdKecamatan = '$Kecamatan' AND
                            master_pegawai.IdDesaFK = '$Desa'
                            GROUP BY
                            master_pegawai.IdPegawaiFK
                            ORDER BY
                            master_kecamatan.IdKecamatan ASC,
                            master_desa.NamaDesa ASC,
                            history_mutasi.IdJabatanFK ASC");
                                    while ($DataPegawai = mysqli_fetch_assoc($QueryPegawai)) {
                                        $IdPegawaiFK = $DataPegawai['IdPegawaiFK'];
                                        $Foto = $DataPegawai['Foto'];
                                        $NIK = $DataPegawai['NIK'];
                                        $Nama = $DataPegawai['Nama'];

                                        $TanggalLahir = isset($DataPegawai['TanggalLahir']) ? $DataPegawai['TanggalLahir'] : '';
                                        if (!empty($TanggalLahir)) {
                                            $exp = explode('-', $TanggalLahir);
                                            $ViewTglLahir = (isset($exp[2]) && isset($exp[1]) && isset($exp[0])) ? 
                                                $exp[2] . "-" . $exp[1] . "-" . $exp[0] : $TanggalLahir;
                                        } else {
                                            $ViewTglLahir = '-';
                                        }

                                        $TanggalPensiun = isset($DataPegawai['TanggalPensiun']) ? $DataPegawai['TanggalPensiun'] : '';
                                        if (!empty($TanggalPensiun)) {
                                            $exp1 = explode('-', $TanggalPensiun);
                                            $ViewTglPensiun = (isset($exp1[2]) && isset($exp1[1]) && isset($exp1[0])) ? 
                                                $exp1[2] . "-" . $exp1[1] . "-" . $exp1[0] : $TanggalPensiun;
                                        } else {
                                            $ViewTglPensiun = '-';
                                        }

                                        //HITUNG DETAIL TANGGAL PENSIUN
                                        if (!empty($TanggalPensiun) && $TanggalPensiun != '0000-00-00') {
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
                                        } else {
                                            // No pension date or invalid date
                                            $HasilTahun = '-';
                                            $HasilBulan = '-';
                                            $HasilHari = '-';
                                        }
                                        //SELESAI

                                        $JenKel = isset($DataPegawai['JenKel']) ? $DataPegawai['JenKel'] : '';
                                        $KodeDesa = isset($DataPegawai['KodeDesa']) ? $DataPegawai['KodeDesa'] : '';
                                        $NamaDesa = isset($DataPegawai['NamaDesa']) ? $DataPegawai['NamaDesa'] : '';
                                        $Kecamatan = isset($DataPegawai['Kecamatan']) ? $DataPegawai['Kecamatan'] : '';
                                        $Kabupaten = isset($DataPegawai['Kabupaten']) ? $DataPegawai['Kabupaten'] : '';
                                        $Alamat = isset($DataPegawai['Alamat']) ? $DataPegawai['Alamat'] : '';
                                        $RT = isset($DataPegawai['RT']) ? $DataPegawai['RT'] : '';
                                        $RW = isset($DataPegawai['RW']) ? $DataPegawai['RW'] : '';

                                        $Lingkungan = isset($DataPegawai['Lingkungan']) ? $DataPegawai['Lingkungan'] : '';
                                        if (!empty($Lingkungan)) {
                                            $AmbilDesa = mysqli_query($db, "SELECT * FROM master_desa WHERE IdDesa = '$Lingkungan' ");
                                            $LingkunganBPD = mysqli_fetch_assoc($AmbilDesa);
                                            $Komunitas = isset($LingkunganBPD['NamaDesa']) ? $LingkunganBPD['NamaDesa'] : '';
                                        } else {
                                            $Komunitas = '';
                                        }

                                        $KecamatanBPD = isset($DataPegawai['Kec']) ? $DataPegawai['Kec'] : '';
                                        if (!empty($KecamatanBPD)) {
                                            $AmbilKecamatan = mysqli_query($db, "SELECT * FROM master_kecamatan WHERE IdKecamatan = '$KecamatanBPD' ");
                                            $KecamatanBPD = mysqli_fetch_assoc($AmbilKecamatan);
                                            $KomunitasKec = isset($KecamatanBPD['Kecamatan']) ? $KecamatanBPD['Kecamatan'] : '';
                                        } else {
                                            $KomunitasKec = '';
                                        }

                                        $Address = $Alamat . " RT." . $RT . "/RW." . $RW . " " . $Komunitas . " Kecamatan " . $KomunitasKec;
                                        $Setting = isset($DataPegawai['Setting']) ? $DataPegawai['Setting'] : '';
                                        $JenisMutasi = isset($DataPegawai['JenisMutasi']) ? $DataPegawai['JenisMutasi'] : '';

                                        $TglSKMutasi = isset($DataPegawai['TanggalMutasi']) ? $DataPegawai['TanggalMutasi'] : '';
                                        if (!empty($TglSKMutasi)) {
                                            $exp2 = explode('-', $TglSKMutasi);
                                            $TanggalMutasi = (isset($exp2[2]) && isset($exp2[1]) && isset($exp2[0])) ? 
                                                $exp2[2] . "-" . $exp2[1] . "-" . $exp2[0] : $TglSKMutasi;
                                        } else {
                                            $TanggalMutasi = '-';
                                        }

                                        $NomorSK = isset($DataPegawai['NomorSK']) ? $DataPegawai['NomorSK'] : '';
                                        $SKMutasi = isset($DataPegawai['FileSKMutasi']) ? $DataPegawai['FileSKMutasi'] : '';
                                        $Jabatan = isset($DataPegawai['Jabatan']) ? $DataPegawai['Jabatan'] : '';
                                        $KetJabatan = isset($DataPegawai['KeteranganJabatan']) ? $DataPegawai['KeteranganJabatan'] : '';
                                        $Siltap = isset($DataPegawai['Siltap']) ? number_format($DataPegawai['Siltap'], 0, ",", ".") : '0';
                                        $Telp = isset($DataPegawai['NoTelp']) ? $DataPegawai['NoTelp'] : '';

                                    ?>

                                        <tr class="gradeX">
                                            <td>
                                                <?php echo $Nomor; ?>
                                            </td>
                                            <td>
                                                <?php echo $Kecamatan; ?><br>
                                                <span style="color:blue"><strong><?php echo $NamaDesa; ?></strong></span><br>
                                                <?php echo $KodeDesa; ?>
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
                                            
                                            <td style="width:250px;">
                                                <strong><?php echo $NIK; ?></strong>
                                            </td>

                                            <td style="width:250px;">
                                                <strong><?php echo $Nama; ?></strong><br><br>
                                                <?php echo $Address; ?>
                                            </td>
                                            <td style="width:70px;">
                                                <?php echo $ViewTglLahir; ?><br>
                                                <?php
                                                $QueryJenKel = mysqli_query($db, "SELECT * FROM master_jenkel WHERE IdJenKel = '$JenKel' ");
                                                $DataJenKel = mysqli_fetch_assoc($QueryJenKel);
                                                $JenisKelamin = '';
                                                if ($DataJenKel && isset($DataJenKel['Keterangan'])) {
                                                    $JenisKelamin = $DataJenKel['Keterangan'];
                                                } else {
                                                    $JenisKelamin = '-';
                                                }
                                                echo $JenisKelamin;
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                $QPendidikan = mysqli_query($db, "SELECT
                                                history_pendidikan.IdPegawaiFK,
                                                history_pendidikan.IdPendidikanFK,
                                                master_pendidikan.IdPendidikan,
                                                master_pendidikan.JenisPendidikan,
                                                history_pendidikan.Setting
                                                FROM
                                                history_pendidikan
                                                INNER JOIN master_pendidikan ON history_pendidikan.IdPendidikanFK = master_pendidikan.IdPendidikan
                                        WHERE history_pendidikan.IdPegawaiFK = '$IdPegawaiFK' AND  history_pendidikan.Setting=1 ");
                                                $DataPendidikan = mysqli_fetch_assoc($QPendidikan);
                                                $Pendidikan = '';
                                                if ($DataPendidikan && isset($DataPendidikan['JenisPendidikan'])) {
                                                    $Pendidikan = $DataPendidikan['JenisPendidikan'];
                                                } else {
                                                    $Pendidikan = '-';
                                                }
                                                echo $Pendidikan;
                                                ?>
                                            </td>
                                            <td style="width:160px;">
                                                <?php echo $NomorSK  ?>
                                            </td>
                                            <td style="width:70px;">
                                                <?php echo $TanggalMutasi; ?><br>
                                            </td>
                                            <td><?php echo $Jabatan; ?></td>
                                            <td><?php echo $KetJabatan; ?></td>
                                            <td><?php echo $Siltap; ?></td>
                                            <td><?php echo $Telp; ?></td>
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