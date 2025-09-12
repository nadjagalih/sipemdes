<?php
$QProfile = mysqli_query($db, "SELECT * FROM master_Setting_profile_dinas");
$DataProfile = mysqli_fetch_assoc($QProfile);
$Kabupaten = $DataProfile['Kabupaten'];
?>

<script type="text/javascript">
    $(document).ready(function() {
        $.ajax({
            type: 'POST',
            url: "Report/Pendidikan/GetKecamatan.php",
            cache: false,
            success: function(msg) {
                $("#Kecamatan").html(msg);
            }
        });
        $("#Kecamatan").change(function() {
            var Kecamatan = $("#Kecamatan").val();
            $.ajax({
                type: 'POST',
                url: "Report/Pendidikan/GetDesa.php",
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

<form action="?pg=PendidikanFilterDesa" method="post" enctype="multipart/form-data">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Filter Data Pendidikan PerDesa </h5>
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
                            <a href="?pg=ReportPendidikan"><button type="button" class="btn btn-outline btn-primary">Batal</button></a>
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
                        <h5>Filter Data Pendidikan Desa <?php echo $NamaDesa; ?> Kecamatan <?php echo $NamaKecamatan; ?></h5>
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
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover dataTables-kecamatan">
                                        <thead>
                                            <tr align="center">
                                                <th>No</th>
                                                <th>Pendidikan</th>
                                                <th>Jumlah</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $Nomor = 1;
                                            $QueryPendidikan = mysqli_query($db, "SELECT
                                    history_pendidikan.IdPendidikanFK,
                                    history_pendidikan.Setting,
                                    master_pendidikan.IdPendidikan,
                                    master_pendidikan.JenisPendidikan,
                                    history_pendidikan.IdPegawaiFK,
                                    master_pegawai.Setting,
                                    master_pegawai.IdPegawaiFK,
                                    Count(history_pendidikan.IdPegawaiFK) AS JmlPendidikan,
                                    master_pegawai.IdDesaFK,
                                    master_desa.IdDesa,
                                    master_desa.IdKecamatanFK,
                                    history_mutasi.Setting AS SettingMut,
                                    history_mutasi.IdPegawaiFK
                                    FROM
                                    history_pendidikan
                                    INNER JOIN master_pendidikan ON history_pendidikan.IdPendidikanFK = master_pendidikan.IdPendidikan
                                    INNER JOIN master_pegawai ON master_pegawai.IdPegawaiFK = history_pendidikan.IdPegawaiFK
                                    INNER JOIN master_desa ON master_desa.IdDesa = master_pegawai.IdDesaFK
                                    INNER JOIN history_mutasi ON history_pendidikan.IdPegawaiFK = history_mutasi.IdPegawaiFK
                                    WHERE
                                    history_pendidikan.Setting = 1 AND
                                    master_pegawai.Setting = 1 AND
                                    master_desa.IdKecamatanFK = '$Kecamatan' AND
                                    master_desa.IdDesa ='$Desa' AND
                                    history_mutasi.Setting = 1
                                    GROUP BY
                                    history_pendidikan.IdPendidikanFK
                                    ORDER BY
                                    master_pendidikan.IdPendidikan ASC");
                                            while ($DataPendidikan = mysqli_fetch_assoc($QueryPendidikan)) {
                                                $IdPendidikan = $DataPendidikan['IdPendidikanFK'];
                                                $Pendidikan = $DataPendidikan['JenisPendidikan'];
                                                $Jumlah = $DataPendidikan['JmlPendidikan'];
                                            ?>
                                                <tr class="gradeX">
                                                    <td>
                                                        <?php echo $Nomor; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $Pendidikan; ?>
                                                    </td>
                                                    <td align="center">
                                                        <strong><?php echo $Jumlah; ?></strong>
                                                    </td>
                                                </tr>
                                            <?php $Nomor++;
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div id="GrafikPendidikan"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
</form>

<script type="text/javascript">
    Highcharts.chart('GrafikPendidikan', {
        chart: {
            type: 'column'
        },
        title: {
            text: '<strong>Grafik Pendidikan Kecamatan <?php echo $NamaKecamatan; ?></strong> <br><strong>Kabupaten <?php echo $Kabupaten; ?></strong>'
        },
        subtitle: {
            text: 'Statistik Pendidikan'
        },
        xAxis: {
            categories: ['Pendidikan '],
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
            $QueryPendidikan = mysqli_query($db, "SELECT
                                    history_pendidikan.IdPendidikanFK,
                                    history_pendidikan.Setting,
                                    master_pendidikan.IdPendidikan,
                                    master_pendidikan.JenisPendidikan,
                                    history_pendidikan.IdPegawaiFK,
                                    master_pegawai.Setting,
                                    master_pegawai.IdPegawaiFK,
                                    Count(history_pendidikan.IdPegawaiFK) AS JmlPendidikan,
                                    master_pegawai.IdDesaFK,
                                    master_desa.IdDesa,
                                    master_desa.IdKecamatanFK,
                                    history_mutasi.Setting AS SettingMut,
                                    history_mutasi.IdPegawaiFK
                                    FROM
                                    history_pendidikan
                                    INNER JOIN master_pendidikan ON history_pendidikan.IdPendidikanFK = master_pendidikan.IdPendidikan
                                    INNER JOIN master_pegawai ON master_pegawai.IdPegawaiFK = history_pendidikan.IdPegawaiFK
                                    INNER JOIN master_desa ON master_desa.IdDesa = master_pegawai.IdDesaFK
                                    INNER JOIN history_mutasi ON history_pendidikan.IdPegawaiFK = history_mutasi.IdPegawaiFK
                                    WHERE
                                    history_pendidikan.Setting = 1 AND
                                    master_pegawai.Setting = 1 AND
                                    master_desa.IdKecamatanFK = '$Kecamatan' AND
                                    master_desa.IdDesa ='$Desa' AND
                                    history_mutasi.Setting = 1
                                    GROUP BY
                                    history_pendidikan.IdPendidikanFK
                                    ORDER BY
                                    master_pendidikan.IdPendidikan ASC");
            while ($DataPendidikan = mysqli_fetch_assoc($QueryPendidikan)) {
                $IdPendidikan = $DataPendidikan['IdPendidikanFK'];
                $Pendidikan = $DataPendidikan['JenisPendidikan'];
                $Jumlah = $DataPendidikan['JmlPendidikan'];
            ?> {
                    name: '<?php echo $Pendidikan; ?>',
                    data: [<?php echo $Jumlah; ?>]
                },
            <?php } ?>
        ]
    });
</script>