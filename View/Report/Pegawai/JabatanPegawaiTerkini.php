<?php
$QProfile = mysqli_query($db, "SELECT * FROM master_Setting_profile_dinas");
$DataProfile = mysqli_fetch_assoc($QProfile);
$Kabupaten = $DataProfile['Kabupaten'];
?>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Data Jabatan Terkini Pemerintah Desa Kabupaten <?php echo $Kabupaten; ?></h2>
    </div>
    <div class="col-lg-2">

    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">

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
                    <a href="?pg=TerkiniPegawaiFilterKecamatan">
                        <button type="button" class="btn btn-white" style="width:150px; text-align:center">
                            Filter Kecamatan
                        </button>
                    </a>
                    <a href="?pg=TerkiniPegawaiFilterDesa">
                        <button type="button" class="btn btn-white" style="width:150px; text-align:center">
                            Filter Desa
                        </button>
                    </a>
                    <a href="?pg=TerkiniPegawaiPDFFilterKecamatan">
                        <button type="button" class="btn btn-white" style="width:150px; text-align:center">
                            PDF Kecamatan
                        </button>
                    </a>
                    <a href="?pg=TerkiniPegawaiPDFFilterDesa">
                        <button type="button" class="btn btn-white" style="width:150px; text-align:center">
                            PDF Desa
                        </button>
                    </a>
                    <a href="Report/Pdf/PdfTerkiniPegawaiFilterKabupaten" target="_BLANK">
                        <button type="button" class="btn btn-white" style="width:150px; text-align:center">
                            PDF Kabupaten
                        </button>
                    </a>
                </div>
            </div>
        </div>
    </div>


    <div class="col-lg-12">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>Rekap Kabupaten <?php echo $Kabupaten; ?><br>Data Terkini Pemerintah Desa Berdasarkan Jabatan</h5>
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
                                        $QMutasi = mysqli_query($db, "SELECT count(IdPegawaiFK) AS Jumlah, IdJabatanFK, Setting FROM history_mutasi
                                            WHERE
                                            Setting = 1 AND
                                            JenisMutasi <> 3 AND
                                            JenisMutasi <> 4 AND
                                            JenisMutasi <> 5 AND
                                            IdJabatanFK = '$IdJabatan'
                                            GROUP BY IdJabatanFK");
                                        while ($Mutasi = mysqli_fetch_assoc($QMutasi)) {
                                            $Jumlah = $Mutasi['Jumlah'];
                                            if ($Jumlah <> 0) {
                                                echo number_format($Jumlah, 0, ",", ".");
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
                            <tr class="gradeX" align="right">
                                <td></td>
                                <td><strong>Total</strong></td>
                                <?php
                                $QMutasi1 = mysqli_query($db, "SELECT count(IdPegawaiFK) AS Jumlah1, IdJabatanFK, Setting FROM history_mutasi
                                            WHERE
                                            Setting = 1 AND
                                            JenisMutasi <> 3 AND
                                            JenisMutasi <> 4 AND
                                            JenisMutasi <> 5 ");
                                $Mutasi1 = mysqli_fetch_assoc($QMutasi1);
                                $Jumlah1 = $Mutasi1['Jumlah1'];

                                ?>
                                <td><strong><?php echo number_format($Jumlah1, 0, ",", "."); ?></strong></td>
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
                <h5>Grafik Kabupaten <?php echo $Kabupaten; ?><br>Data Terkini Pemerintah Desa Berdasarkan Jabatan</h5>
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

<script type="text/javascript">
    Highcharts.chart('GrafikJabatan', {
        chart: {
            type: 'column'
        },
        title: {
            text: '<strong>Rekap Kabupaten <?php echo $Kabupaten; ?></strong>'
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
                text: 'Jumlah (Perangkat)'
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
            $QJabatan = mysqli_query($db, "SELECT
                        master_jabatan.IdJabatan,
                        master_jabatan.Jabatan,
                        history_mutasi.IdJabatanFK,
                        Count(history_mutasi.IdPegawaiFK) AS JmlJabatan,
                        history_mutasi.Setting,
                        history_mutasi.JenisMutasi
                        FROM
                        master_jabatan
                        INNER JOIN history_mutasi ON history_mutasi.IdJabatanFK = master_jabatan.IdJabatan
                        WHERE
                        history_mutasi.Setting = 1 AND
                        history_mutasi.JenisMutasi <> 3 AND
                        history_mutasi.JenisMutasi <> 4 AND
                        history_mutasi.JenisMutasi <> 5
                        GROUP BY history_mutasi.IdJabatanFK");
            while ($DataJabatan = mysqli_fetch_assoc($QJabatan)) {
                $Jabatan = $DataJabatan['Jabatan'];
                $JmlJabatan = $DataJabatan['JmlJabatan'];
            ?> {
                    name: '<?php echo $Jabatan; ?>',
                    data: [<?php echo $JmlJabatan; ?>]
                },
            <?php } ?>
        ]
    });
</script>