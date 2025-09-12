<?php
$QProfile = mysqli_query($db, "SELECT * FROM master_Setting_profile_dinas");
$DataProfile = mysqli_fetch_assoc($QProfile);
$Kabupaten = $DataProfile['Kabupaten'];
?>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Rekap Data Gender Pemerintahan Desa Kabupaten</h2>
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
                        <a href="?pg=ViewPdfGender">
                            <button type="button" class="btn btn-white" style="width:150px; text-align:center">
                                Filter Kecamatan
                            </button>
                        </a>

                        <!-- <a href="Report/Pdf/PdfUnitKerjaKabupaten" target="_BLANK">
                            <button type="button" class="btn btn-white" style="width:150px; text-align:center">
                                Cetak PDF Kabupaten
                            </button>
                        </a> -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Rekap Data Gender Pemerintah Desa Kabupaten <?php echo $Kabupaten; ?></h5>
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
                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover dataTables-kecamatan">
                                    <thead>
                                        <tr align="center">
                                            <th>No</th>
                                            <th>Gender</th>
                                            <th>Jumlah</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $Nomor = 1;
                                        $QueryPerangkat = mysqli_query($db, "SELECT
                                            master_jenkel.Keterangan,
                                            Count(master_pegawai.JenKel) AS JmlGender
                                        FROM
                                            master_pegawai
                                            INNER JOIN
                                            main_user
                                            ON
                                                master_pegawai.IdPegawaiFK = main_user.IdPegawai
                                            INNER JOIN
                                            history_mutasi
                                            ON
                                                master_pegawai.IdPegawaiFK = history_mutasi.IdPegawaiFK
                                            INNER JOIN
                                            master_jenkel
                                            ON
                                                master_pegawai.JenKel = master_jenkel.IdJenKel
                                        WHERE
                                            master_pegawai.Setting = 1 AND
                                            main_user.IdLevelUserFK <> 1 AND
                                            main_user.IdLevelUserFK <> 2 AND
                                            history_mutasi.Setting = 1
                                        GROUP BY
                                            master_pegawai.JenKel
                                        ORDER BY
                                            master_pegawai.JenKel ASC");
                                        while ($DataPerangkat = mysqli_fetch_assoc($QueryPerangkat)) {
                                            $Keterangan = $DataPerangkat['Keterangan'];
                                            $JmlGender = $DataPerangkat['JmlGender'];
                                        ?>
                                            <tr class="gradeX">
                                                <td align="center">
                                                    <?php echo $Nomor; ?>
                                                </td>
                                                <td>
                                                    <?php echo $Keterangan; ?>
                                                </td>
                                                <td align="right">
                                                    <strong><?php echo $JmlGender; ?></strong>
                                                </td>
                                            </tr>
                                        <?php $Nomor++;
                                        }
                                        ?>
                                    </tbody>
                                    <?php
                                    $QueryJumlah = mysqli_query($db, "SELECT
                                        master_jenkel.Keterangan,
                                        Count(master_pegawai.JenKel) AS JmlTotal
                                    FROM
                                        master_pegawai
                                        INNER JOIN
                                        main_user
                                        ON
                                            master_pegawai.IdPegawaiFK = main_user.IdPegawai
                                        INNER JOIN
                                        history_mutasi
                                        ON
                                            master_pegawai.IdPegawaiFK = history_mutasi.IdPegawaiFK
                                        INNER JOIN
                                        master_jenkel
                                        ON
                                            master_pegawai.JenKel = master_jenkel.IdJenKel
                                    WHERE
                                        master_pegawai.Setting = 1 AND
                                        main_user.IdLevelUserFK <> 1 AND
                                        main_user.IdLevelUserFK <> 2 AND
                                        history_mutasi.Setting = 1
                                    ORDER BY
                                        master_pegawai.JenKel ASC");

                                    $DataJmlTotal = mysqli_fetch_assoc($QueryJumlah);
                                    $TotalPerangkatKab = $DataJmlTotal['JmlTotal'];
                                    ?>
                                    <tfoot>
                                        <tr align="right">
                                            <th></th>
                                            <th>Total</th>
                                            <th><?php echo number_format($TotalPerangkatKab); ?></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Rekap Data Gender BPD Kabupaten <?php echo $Kabupaten; ?></h5>
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
                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover dataTables-kecamatan">
                                    <thead>
                                        <tr align="center">
                                            <th>No</th>
                                            <th>Gender</th>
                                            <th>Jumlah</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $Nomor = 1;
                                        $QueryBPD = mysqli_query($db, "SELECT
                                        master_jenkel.Keterangan,
                                        Count(master_pegawai_bpd.JenKel) AS JmlGenderBPD
                                    FROM
                                        master_pegawai_bpd
                                        INNER JOIN
                                        master_jenkel
                                        ON
                                            master_pegawai_bpd.JenKel = master_jenkel.IdJenKel
                                    GROUP BY
                                        master_pegawai_bpd.JenKel
                                    ORDER BY
                                        master_pegawai_bpd.JenKel ASC");
                                        while ($DataBPD = mysqli_fetch_assoc($QueryBPD)) {
                                            $NamaGender = $DataBPD['Keterangan'];
                                            $GenderBPD = $DataBPD['JmlGenderBPD'];
                                        ?>
                                            <tr class="gradeX">
                                                <td alight="center">
                                                    <?php echo $Nomor; ?>
                                                </td>
                                                <td>
                                                    <?php echo $NamaGender; ?>
                                                </td>
                                                <td align="right">
                                                    <strong><?php echo $GenderBPD; ?></strong>
                                                </td>
                                            </tr>
                                        <?php $Nomor++;
                                        }
                                        ?>
                                    </tbody>
                                    <?php
                                    $QueryJumlahBPD = mysqli_query($db, "SELECT
                                        master_jenkel.Keterangan,
                                        Count(master_pegawai_bpd.JenKel) AS JmlGenderBPD
                                    FROM
                                        master_pegawai_bpd
                                        INNER JOIN
                                        master_jenkel
                                        ON
                                            master_pegawai_bpd.JenKel = master_jenkel.IdJenKel
                                    ORDER BY
                                        master_pegawai_bpd.JenKel ASC");

                                    $DataJmlTotalBPD = mysqli_fetch_assoc($QueryJumlahBPD);
                                    $TotalBPDKab = $DataJmlTotalBPD['JmlGenderBPD'];
                                    ?>
                                    <tfoot>
                                        <tr align="right">
                                            <th></th>
                                            <th>Total</th>
                                            <th><?php echo number_format($TotalBPDKab); ?></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-6">
        <div id="GrafikDesaView"></div><br>
    </div>
    <div class="col-lg-6">
        <div id="GrafikBPDDesaView"></div>
    </div>
</div>


<script type="text/javascript">
    Highcharts.chart('GrafikDesaView', {
        chart: {
            type: 'column'
        },
        title: {
            text: '<strong>Grafik Jumlah Gender Pemerintah Desa Kabupaten <?php echo $Kabupaten; ?></strong>'
        },
        subtitle: {
            text: 'Statistik Kecamatan'
        },
        xAxis: {
            categories: ['Kecamatan '],
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
            $QueryPerangkat = mysqli_query($db, "SELECT
                                            master_jenkel.Keterangan,
                                            Count(master_pegawai.JenKel) AS JmlGender
                                        FROM
                                            master_pegawai
                                            INNER JOIN
                                            main_user
                                            ON
                                                master_pegawai.IdPegawaiFK = main_user.IdPegawai
                                            INNER JOIN
                                            history_mutasi
                                            ON
                                                master_pegawai.IdPegawaiFK = history_mutasi.IdPegawaiFK
                                            INNER JOIN
                                            master_jenkel
                                            ON
                                                master_pegawai.JenKel = master_jenkel.IdJenKel
                                        WHERE
                                            master_pegawai.Setting = 1 AND
                                            main_user.IdLevelUserFK <> 1 AND
                                            main_user.IdLevelUserFK <> 2 AND
                                            history_mutasi.Setting = 1
                                        GROUP BY
                                            master_pegawai.JenKel
                                        ORDER BY
                                            master_pegawai.JenKel ASC");
            while ($DataPerangkat = mysqli_fetch_assoc($QueryPerangkat)) {
                $Keterangan = $DataPerangkat['Keterangan'];
                $JmlGender = $DataPerangkat['JmlGender'];
            ?> {
                    name: '<?php echo $Keterangan; ?>',
                    data: [<?php echo $JmlGender; ?>]
                },
            <?php } ?>
        ]
    });
</script>

<script type="text/javascript">
    Highcharts.chart('GrafikBPDDesaView', {
        chart: {
            type: 'column'
        },
        title: {
            text: '<strong>Grafik Jumlah Gender BPD Kabupaten <?php echo $Kabupaten; ?></strong>'
        },
        subtitle: {
            text: 'Statistik Kecamatan'
        },
        xAxis: {
            categories: ['Kecamatan '],
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
            $QueryBPD = mysqli_query($db, "SELECT
                                        master_jenkel.Keterangan,
                                        Count(master_pegawai_bpd.JenKel) AS JmlGenderBPD
                                    FROM
                                        master_pegawai_bpd
                                        INNER JOIN
                                        master_jenkel
                                        ON
                                            master_pegawai_bpd.JenKel = master_jenkel.IdJenKel
                                    GROUP BY
                                        master_pegawai_bpd.JenKel
                                    ORDER BY
                                        master_pegawai_bpd.JenKel ASC");
            while ($DataBPD = mysqli_fetch_assoc($QueryBPD)) {
                $NamaGender = $DataBPD['Keterangan'];
                $GenderBPD = $DataBPD['JmlGenderBPD'];
            ?> {
                    name: '<?php echo $NamaGender; ?>',
                    data: [<?php echo $GenderBPD; ?>]
                },
            <?php } ?>
        ]
    });
</script>



<script>
    $(document).ready(function() {
        $('.DataView').click(function() {
            var id = $(this).attr("id");
            $.ajax({
                url: 'Report/UnitKerja/GetDataDesa.php',
                method: 'GET',
                data: {
                    id: id
                },
                success: function(data) {
                    $('#DataDesa').html(data);
                    $('#DetailDesa').modal("show");
                }
            });
        });
    });
</script>

<div class="modal inmodal" id="DetailDesa" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            </div>
            <div class="modal-body">
                <div id="DataDesa"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>