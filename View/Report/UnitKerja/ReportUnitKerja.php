<?php
$QProfile = mysqli_query($db, "SELECT * FROM master_Setting_profile_dinas");
$DataProfile = mysqli_fetch_assoc($QProfile);
$Kabupaten = $DataProfile['Kabupaten'];
?>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Rekap Data Pemerintahan Desa PerUnit Kerja</h2>
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
                        <a href="?pg=ViewPdfUnitKerjaKecamatan">
                            <button type="button" class="btn btn-white" style="width:270px; text-align:center">
                                Data Pemerintah Desa Kecamatan
                            </button>
                        </a>

                        <a href="Report/Pdf/PdfUnitKerjaKabupaten" target="_BLANK">
                            <button type="button" class="btn btn-white" style="width:270px; text-align:center">
                                Data Pemerintah Desa Kabupaten - PDF
                            </button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Rekap Data Kades & Perangkat Desa PerKecamatan Kabupaten <?php echo $Kabupaten; ?></h5>
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
                                            <th>Kecamatan</th>
                                            <th>Jumlah</th>
                                            <th>Detail</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $Nomor = 1;
                                        $QueryPerangkat = mysqli_query($db, "SELECT
                                        master_kecamatan.Kecamatan,
                                        Count(master_pegawai.IdPegawaiFK) AS JmlPerangkat,
                                        master_pegawai.IdPegawaiFK,
                                        master_pegawai.Setting,
                                        master_desa.IdDesa,
                                        master_desa.NamaDesa,
                                        master_desa.IdKecamatanFK,
                                        master_kecamatan.IdKecamatan,
                                        main_user.IdPegawai,
                                        main_user.IdLevelUserFK,
                                        history_mutasi.IdPegawaiFK,
                                        history_mutasi.Setting AS SettingMutasi
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
                                        INNER JOIN
                                        main_user
                                        ON
                                            master_pegawai.IdPegawaiFK = main_user.IdPegawai
                                        INNER JOIN
                                        history_mutasi
                                        ON
                                            master_pegawai.IdPegawaiFK = history_mutasi.IdPegawaiFK
                                    WHERE
                                        master_pegawai.Setting = 1 AND
                                        main_user.IdLevelUserFK <> 1 AND
                                        main_user.IdLevelUserFK <> 2 AND
                                        history_mutasi.Setting = 1
                                    GROUP BY
                                        master_kecamatan.IdKecamatan
                                    ORDER BY
                                        master_kecamatan.Kecamatan ASC");
                                        while ($DataPerangkat = mysqli_fetch_assoc($QueryPerangkat)) {
                                            $IdKecamatan = $DataPerangkat['IdKecamatanFK'];
                                            $Kecamatan = $DataPerangkat['Kecamatan'];
                                            $Jumlah = $DataPerangkat['JmlPerangkat'];
                                        ?>
                                            <tr class="gradeX">
                                                <td>
                                                    <?php echo $Nomor; ?>
                                                </td>
                                                <td>
                                                    <?php echo $Kecamatan; ?>
                                                </td>
                                                <td align="right">
                                                    <strong><?php echo $Jumlah; ?></strong>
                                                </td>

                                                <td align="center">
                                                    <button type="button" class="DataView btn btn-success" id="<?php echo $IdKecamatan; ?>" data-target="#DetailDesa" data-toggle="modal">
                                                        Detail Desa
                                                    </button>
                                                </td>
                                            </tr>
                                        <?php $Nomor++;
                                        }
                                        ?>
                                    </tbody>
                                    <?php
                                    $QueryJumlah = mysqli_query($db, "SELECT
                                                Count(master_pegawai.IdPegawaiFK) AS JmlTotalP,
                                                master_pegawai.IdPegawaiFK,
                                                master_pegawai.Setting,
                                                main_user.IdPegawai,
                                                main_user.IdLevelUserFK,
                                                history_mutasi.IdPegawaiFK,
                                                history_mutasi.Setting AS SettingMutasi
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
                                            WHERE
                                                master_pegawai.Setting = 1 AND
                                                main_user.IdLevelUserFK <> 1 AND
                                                main_user.IdLevelUserFK <> 2 AND
                                                history_mutasi.Setting = 1 ");

                                    $DataJmlTotal = mysqli_fetch_assoc($QueryJumlah);
                                    $TotalPerangkatKab = $DataJmlTotal['JmlTotalP'];
                                    ?>
                                    <tfoot>
                                        <tr align="right">
                                            <th></th>
                                            <th>Total</th>
                                            <th><?php echo number_format($TotalPerangkatKab); ?></th>
                                            <th></th>
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
                    <h5>Rekap Data BPD PerKecamatan Kabupaten <?php echo $Kabupaten; ?></h5>
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
                                            <th>Kecamatan</th>
                                            <th>Jumlah</th>
                                            <th>Detail</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $Nomor = 1;
                                        $QueryBPD = mysqli_query($db, "SELECT
                                            master_kecamatan.Kecamatan,
                                            Count(master_pegawai_bpd.IdPegawaiFK) AS JmlBPD,
                                            master_pegawai_bpd.IdPegawaiFK,
                                            master_desa.IdDesa,
                                            master_desa.NamaDesa,
                                            master_desa.IdKecamatanFK,
                                            master_kecamatan.IdKecamatan
                                        FROM
                                            master_pegawai_bpd
                                            LEFT JOIN
                                            master_desa
                                            ON
                                                master_pegawai_bpd.IdDesaFK = master_desa.IdDesa
                                            LEFT JOIN
                                            master_kecamatan
                                            ON
                                                master_desa.IdKecamatanFK = master_kecamatan.IdKecamatan
                                        GROUP BY
                                            master_kecamatan.IdKecamatan
                                        ORDER BY
                                            master_kecamatan.Kecamatan ASC");
                                        while ($DataBPD = mysqli_fetch_assoc($QueryBPD)) {
                                            $IdKecamatanBPD = $DataBPD['IdKecamatanFK'];
                                            $KecamatanBPD = $DataBPD['Kecamatan'];
                                            $JumlahBPD = $DataBPD['JmlBPD'];
                                        ?>
                                            <tr class="gradeX">
                                                <td>
                                                    <?php echo $Nomor; ?>
                                                </td>
                                                <td>
                                                    <?php echo $KecamatanBPD; ?>
                                                </td>
                                                <td align="right">
                                                    <strong><?php echo $JumlahBPD; ?></strong>
                                                </td>

                                                <td align="center">
                                                    <button type="button" class="DataView btn btn-success" id="<?php echo $IdKecamatanBPD; ?>" data-target="#DetailDesa" data-toggle="modal">
                                                        Detail Desa
                                                    </button>
                                                </td>
                                            </tr>
                                        <?php $Nomor++;
                                        }
                                        ?>
                                    </tbody>
                                    <?php
                                    $QueryJumlahBPD = mysqli_query($db, "SELECT
                                    Count(master_pegawai_bpd.IdPegawaiFK) AS JmlBPD
                                FROM
                                    master_pegawai_bpd");

                                    $DataJmlTotalBPD = mysqli_fetch_assoc($QueryJumlahBPD);
                                    $TotalBPDKab = $DataJmlTotalBPD['JmlBPD'];
                                    ?>
                                    <tfoot>
                                        <tr align="right">
                                            <th></th>
                                            <th>Total</th>
                                            <th><?php echo number_format($TotalBPDKab); ?></th>
                                            <th></th>
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
    <div class="col-lg-12">
        <div id="GrafikDesaView"></div><br><br>
        <div id="GrafikBPDDesaView"></div><br><br>
    </div>
</div>


<script type="text/javascript">
    Highcharts.chart('GrafikDesaView', {
        chart: {
            type: 'column'
        },
        title: {
            text: '<strong>Grafik Jumlah Kades & Perangkat Desa Perkecamatan Kabupaten <?php echo $Kabupaten; ?></strong>'
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
	master_kecamatan.Kecamatan,
	Count(master_pegawai.IdPegawaiFK) AS JmlPerangkat,
	master_pegawai.IdPegawaiFK,
	master_pegawai.Setting,
	master_desa.IdDesa,
	master_desa.NamaDesa,
	master_desa.IdKecamatanFK,
	master_kecamatan.IdKecamatan,
	main_user.IdPegawai,
	main_user.IdLevelUserFK,
	history_mutasi.IdPegawaiFK,
	history_mutasi.Setting AS SettingMutasi
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
	INNER JOIN
	main_user
	ON
		master_pegawai.IdPegawaiFK = main_user.IdPegawai
	INNER JOIN
	history_mutasi
	ON
		master_pegawai.IdPegawaiFK = history_mutasi.IdPegawaiFK
WHERE
	master_pegawai.Setting = 1 AND
	main_user.IdLevelUserFK <> 1 AND
	main_user.IdLevelUserFK <> 2 AND
	history_mutasi.Setting = 1
GROUP BY
	master_kecamatan.IdKecamatan
ORDER BY
	master_kecamatan.Kecamatan ASC");
            while ($DataPerangkat = mysqli_fetch_assoc($QueryPerangkat)) {
                $Kecamatan = $DataPerangkat['Kecamatan'];
                $Jumlah = $DataPerangkat['JmlPerangkat'];
            ?> {
                    name: '<?php echo $Kecamatan; ?>',
                    data: [<?php echo $Jumlah; ?>]
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
            text: '<strong>Grafik Jumlah BPD Perkecamatan Kabupaten <?php echo $Kabupaten; ?></strong>'
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
                                            master_kecamatan.Kecamatan,
                                            Count(master_pegawai_bpd.IdPegawaiFK) AS JmlBPD,
                                            master_pegawai_bpd.IdPegawaiFK,
                                            master_desa.IdDesa,
                                            master_desa.NamaDesa,
                                            master_desa.IdKecamatanFK,
                                            master_kecamatan.IdKecamatan
                                        FROM
                                            master_pegawai_bpd
                                            LEFT JOIN
                                            master_desa
                                            ON
                                                master_pegawai_bpd.IdDesaFK = master_desa.IdDesa
                                            LEFT JOIN
                                            master_kecamatan
                                            ON
                                                master_desa.IdKecamatanFK = master_kecamatan.IdKecamatan
                                        GROUP BY
                                            master_kecamatan.IdKecamatan
                                        ORDER BY
                                            master_kecamatan.Kecamatan ASC");
            while ($DataBPD = mysqli_fetch_assoc($QueryBPD)) {
                $IdKecamatanBPD = $DataBPD['IdKecamatanFK'];
                $KecamatanBPD = $DataBPD['Kecamatan'];
                $JumlahBPD = $DataBPD['JmlBPD'];
            ?> {
                    name: '<?php echo $KecamatanBPD; ?>',
                    data: [<?php echo $JumlahBPD; ?>]
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