<?php
require_once '../Module/Security/CSPHandler.php';
$QProfile = mysqli_query($db, "SELECT * FROM master_Setting_profile_dinas");
$DataProfile = mysqli_fetch_assoc($QProfile);
$Kabupaten = $DataProfile['Kabupaten'];
?>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Rekap Data Pendidikan Pemerintah Desa Tingkat Kabupaten</h2>
    </div>
    <div class="col-lg-2">

    </div>
</div>


<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Filter</h5>
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

                    <div class="text-left">
                        <a href="?pg=PendidikanFilterKecamatan">
                            <button type="button" class="btn btn-white" style="width:150px; text-align:center">
                                Filter Kecamatan
                            </button>
                        </a>
                        <a href="?pg=PendidikanFilterDesa">
                            <button type="button" class="btn btn-white" style="width:150px; text-align:center">
                                Filter Desa
                            </button>
                        </a>
                        <a href="?pg=PendidikanPDFFilterKecamatan">
                            <button type="button" class="btn btn-white" style="width:150px; text-align:center">
                                PDF Kecamatan
                            </button>
                        </a>
                        <a href="?pg=PendidikanPDFFilterDesa">
                            <button type="button" class="btn btn-white" style="width:150px; text-align:center">
                                PDF Desa
                            </button>
                        </a>
                        <a href="Report/Pdf/PdfPendidikanKabupaten" target="_BLANK">
                            <button type="button" class="btn btn-white" style="width:150px; text-align:center">
                                PDF Kabupaten
                            </button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Rekap Data Pemerintah Desa</h5>
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
                                        history_mutasi.Setting AS SettingMut,
                                        history_mutasi.IdPegawaiFK
                                        FROM
                                        history_pendidikan
                                        INNER JOIN master_pendidikan ON history_pendidikan.IdPendidikanFK = master_pendidikan.IdPendidikan
                                        INNER JOIN master_pegawai ON master_pegawai.IdPegawaiFK = history_pendidikan.IdPegawaiFK
                                        INNER JOIN history_mutasi ON history_pendidikan.IdPegawaiFK = history_mutasi.IdPegawaiFK
                                        WHERE
                                        history_pendidikan.Setting = 1 AND
                                        master_pegawai.Setting = 1 AND
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
                                                <td align="right">
                                                    <strong><?php echo number_format($Jumlah, 0, ",", "."); ?></strong>
                                                </td>
                                            </tr>
                                        <?php $Nomor++;
                                        }
                                        ?>
                                    </tbody>
                                    <?php
                                    $QueryPendidikanTotal = mysqli_query($db, "SELECT
                                       Count(history_pendidikan.IdPegawaiFK) AS JmlPendidikanTotal
                                        FROM
                                        history_pendidikan
                                        INNER JOIN master_pendidikan ON history_pendidikan.IdPendidikanFK = master_pendidikan.IdPendidikan
                                        INNER JOIN master_pegawai ON master_pegawai.IdPegawaiFK = history_pendidikan.IdPegawaiFK
                                        WHERE
                                        history_pendidikan.Setting = 1 AND
                                        master_pegawai.Setting = 1");
                                    $DataTotPendidikan = mysqli_fetch_assoc($QueryPendidikanTotal);
                                    $TotalPendidikan = $DataTotPendidikan['JmlPendidikanTotal'];

                                    ?>
                                    <tfoot>
                                        <tr align="right">
                                            <th></th>
                                            <th>Total</th>
                                            <th><?php echo number_format($TotalPendidikan, 0, ",", "."); ?></th>
                                        </tr>
                                    </tfoot>

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
</div>

<script type="text/javascript" <?php echo CSPHandler::scriptNonce(); ?>>
    Highcharts.chart('GrafikPendidikan', {
        chart: {
            type: 'column'
        },
        title: {
            text: '<strong>Grafik Pemerintah Desa Berdasarkan Pendidikan <br>Kabupaten <?php echo $Kabupaten; ?></strong>'
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
            history_mutasi.Setting AS SettingMut,
            history_mutasi.IdPegawaiFK
            FROM
            history_pendidikan
            INNER JOIN master_pendidikan ON history_pendidikan.IdPendidikanFK = master_pendidikan.IdPendidikan
            INNER JOIN master_pegawai ON master_pegawai.IdPegawaiFK = history_pendidikan.IdPegawaiFK
            INNER JOIN history_mutasi ON history_pendidikan.IdPegawaiFK = history_mutasi.IdPegawaiFK
            WHERE
            history_pendidikan.Setting = 1 AND
            master_pegawai.Setting = 1 AND
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