<script type="text/javascript">
    $(document).ready(function() {
        $.ajax({
            type: 'POST',
            url: "Report/Pegawai/GetKecamatan.php",
            cache: false,
            success: function(msg) {
                $("#Kecamatan").html(msg);
            }
        });
    });
</script>

<form action="?pg=TerkiniPegawaiFilterKecamatan" method="post" enctype="multipart/form-data">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Filter Data PerKecamatan </h5>
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
                            <button type="submit" name="Proses" value="Proses" class="btn btn-outline btn-primary">Tampilkan</button>
                            <a href="?pg=JabatanPegawaiTerkini"><button type="button" class="btn btn-outline btn-primary">Batal</button></a>
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
        $IdKecamatan = $DataKecamatan['IdKecamatan'];
        $NamaKecamatan = $DataKecamatan['Kecamatan'];

    ?>
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5>Kecamatan <?php echo $NamaKecamatan; ?><br>Data Terkini Pemerintah Desa Berdasarkan Jabatan</h5>
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
                                        <th rowspan="2">Jabatan</th>
                                        <th rowspan="2">Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $Nomor = 1;
                                    $QJabatan = mysqli_query($db, "SELECT * FROM master_jabatan ORDER BY IdJabatan");
                                    while ($DataJabatan = mysqli_fetch_assoc($QJabatan)) {
                                        $IdJabatan = $DataJabatan['IdJabatan'];
                                        $Jabatan = $DataJabatan['Jabatan'];
                                    ?>

                                        <tr class="gradeX">
                                            <td>
                                                <?php echo $Nomor; ?>
                                            </td>
                                            <td>
                                                <?php echo $Jabatan; ?>
                                            </td>
                                            <td align="right">
                                                <?php
                                                $QMutasi = mysqli_query($db, "SELECT
                                                history_mutasi.IdPegawaiFK,
                                                Count(history_mutasi.IdPegawaiFK) AS JmlJbatan,
                                                master_pegawai.IdPegawaiFK,
                                                history_mutasi.JenisMutasi,
                                                history_mutasi.Setting,
                                                master_pegawai.Setting,
                                                master_pegawai.IdDesaFK,
                                                master_desa.IdDesa,
                                                master_desa.IdKecamatanFK,
                                                master_kecamatan.IdKecamatan,
                                                master_desa.NamaDesa,
                                                master_kecamatan.Kecamatan,
                                                history_mutasi.IdJabatanFK
                                                FROM history_mutasi
                                                INNER JOIN master_pegawai ON master_pegawai.IdPegawaiFK = history_mutasi.IdPegawaiFK
                                                INNER JOIN master_desa ON master_pegawai.IdDesaFK = master_desa.IdDesa
                                                INNER JOIN master_kecamatan ON master_desa.IdKecamatanFK = master_kecamatan.IdKecamatan
                                                WHERE
                                                history_mutasi.IdJabatanFK = '$IdJabatan' AND
                                                history_mutasi.JenisMutasi <> 3 AND
                                                history_mutasi.JenisMutasi <> 4 AND
                                                history_mutasi.JenisMutasi <> 5 AND
                                                history_mutasi.Setting = 1 AND
                                                master_pegawai.Setting = 1 AND
                                                master_desa.IdKecamatanFK = '$Kecamatan'
                                                GROUP BY
                                                history_mutasi.IdJabatanFK");
                                                while ($Mutasi = mysqli_fetch_assoc($QMutasi)) {
                                                    $Jumlah = $Mutasi['JmlJbatan'];
                                                    if ($Jumlah <> 0) {
                                                        echo $Jumlah;
                                                    } else {
                                                        echo "0";
                                                    }
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                    <?php $Nomor++;
                                    }
                                    ?>

                                    <tr class="gradeX">
                                        <td></td>
                                        <td align="right"><strong>Total</strong></td>
                                        <td align="right"><strong>
                                                <?php
                                                $QMutasi1 = mysqli_query($db, "SELECT
                                                history_mutasi.IdPegawaiFK,
                                                Count(history_mutasi.IdPegawaiFK) AS JmlJbatan,
                                                master_pegawai.IdPegawaiFK,
                                                history_mutasi.JenisMutasi,
                                                history_mutasi.Setting,
                                                master_pegawai.Setting,
                                                master_pegawai.IdDesaFK,
                                                master_desa.IdDesa,
                                                master_desa.IdKecamatanFK,
                                                master_kecamatan.IdKecamatan,
                                                master_desa.NamaDesa,
                                                master_kecamatan.Kecamatan,
                                                history_mutasi.IdJabatanFK
                                                FROM history_mutasi
                                                INNER JOIN master_pegawai ON master_pegawai.IdPegawaiFK = history_mutasi.IdPegawaiFK
                                                INNER JOIN master_desa ON master_pegawai.IdDesaFK = master_desa.IdDesa
                                                INNER JOIN master_kecamatan ON master_desa.IdKecamatanFK = master_kecamatan.IdKecamatan
                                                WHERE
                                                history_mutasi.JenisMutasi <> 3 AND
                                                history_mutasi.JenisMutasi <> 4 AND
                                                history_mutasi.JenisMutasi <> 5 AND
                                                history_mutasi.Setting = 1 AND
                                                master_pegawai.Setting = 1 AND
                                                master_desa.IdKecamatanFK = '$Kecamatan'");
                                                while ($Mutasi1 = mysqli_fetch_assoc($QMutasi1)) {
                                                    $Jumlah1 = $Mutasi1['JmlJbatan'];
                                                    if ($Jumlah1 <> 0) {
                                                        echo number_format($Jumlah1, 0, ",", ".");
                                                    } else {
                                                        echo "0";
                                                    }
                                                }
                                                ?>
                                            </strong>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5>Grafik Kecamatan <?php echo $NamaKecamatan; ?><br>Data Terkini Pemerintah Desa Berdasarkan Jabatan</h5>
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
                        <div id="GrafikJabatan"></div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
</form>

<script type="text/javascript">
    Highcharts.chart('GrafikJabatan', {
        chart: {
            type: 'column'
        },
        title: {
            text: '<strong>Rekap Kecamatan <?php echo $NamaKecamatan; ?></strong>'
        },
        subtitle: {
            text: 'Berdasarkan Jabatan'
        },
        xAxis: {
            categories: ['Jabatan '],
            crosshair: false
        },

        yAxis: {
            min: 0,
            title: {
                text: 'Jumlah (Pegawai)'
            }
        },

        plotOptions: {
            series: {
                borderWidth: 0,
                dataLabels: {
                    enabled: true,
                    fontSize: '8px',
                    fontFamily: 'Tahoma',
                    rotation: -0,
                    align: 'center',
                    formatnumber: '{point.y:.0f}',
                    y: 0
                    /*format: '{point.y:.1f}%'*/
                }
            }
        },
        series: [
            <?php
            $Nomor = 1;
            $QJabatan = mysqli_query($db, "SELECT
                    history_mutasi.IdPegawaiFK,
                    Count(history_mutasi.IdPegawaiFK) AS JmlJbatan,
                    master_pegawai.IdPegawaiFK,
                    history_mutasi.JenisMutasi,
                    history_mutasi.Setting,
                    master_pegawai.Setting,
                    master_pegawai.IdDesaFK,
                    master_desa.IdDesa,
                    master_desa.IdKecamatanFK,
                    master_kecamatan.IdKecamatan,
                    master_desa.NamaDesa,
                    master_kecamatan.Kecamatan,
                    history_mutasi.IdJabatanFK,
                    master_jabatan.IdJabatan,
                    master_jabatan.Jabatan
                    FROM
                    history_mutasi
                    INNER JOIN master_pegawai ON master_pegawai.IdPegawaiFK = history_mutasi.IdPegawaiFK
                    INNER JOIN master_desa ON master_pegawai.IdDesaFK = master_desa.IdDesa
                    INNER JOIN master_kecamatan ON master_desa.IdKecamatanFK = master_kecamatan.IdKecamatan
                    INNER JOIN master_jabatan ON history_mutasi.IdJabatanFK = master_jabatan.IdJabatan
                    WHERE
                    history_mutasi.JenisMutasi <> 3 AND
                    history_mutasi.JenisMutasi <> 4 AND
                    history_mutasi.JenisMutasi <> 5 AND
                    history_mutasi.Setting = 1 AND
                    master_pegawai.Setting = 1 AND
                    master_desa.IdKecamatanFK = '$Kecamatan'
                    GROUP BY history_mutasi.IdJabatanFK");
            while ($DataJabatan = mysqli_fetch_assoc($QJabatan)) {
                $JabatanV = $DataJabatan['Jabatan'];
                $JmlJabatanV = $DataJabatan['JmlJbatan'];
            ?> {
                    name: '<?php echo $JabatanV; ?>',
                    data: [<?php echo $JmlJabatanV; ?>]
                },
            <?php } ?>
        ]
    });
</script>