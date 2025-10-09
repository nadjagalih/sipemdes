<?php
include '../../../Module/Config/Env.php';
require_once '../../../Module/Security/CSPHandler.php';

if (isset($_GET['id'])) {
    $IdKecamatan = sql_injeksi($_GET['id']);

    $QueryKecamatan = mysqli_query($db, "SELECT * FROM master_kecamatan WHERE IdKecamatan ='$IdKecamatan' ");
    $DataKecamatan = mysqli_fetch_assoc($QueryKecamatan);
    $IdKecamatan = $DataKecamatan['IdKecamatan'];
    $NamaKecamatan = $DataKecamatan['Kecamatan'];

?>
    <div class="ibox-content">
        <h2><strong>Data Kecamatan <?php echo $NamaKecamatan; ?></strong></h2>
        <div class="row">
            <div class="col-lg-6">
                <h4><strong>Data Kades & Perangkat Desa</strong></h4>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dataTables-kecamatan">
                        <thead>
                            <tr align="center">
                                <th>No</th>
                                <th>Unit Kerja/Desa</th>
                                <th>Jumlah</th>
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
                            master_desa.IdKecamatanFK = '$IdKecamatan' AND
                            history_mutasi.Setting = 1
                        GROUP BY
                                        master_desa.NamaDesa
                                        ORDER BY
                                       master_desa.NamaDesa ASC");

                            while ($DataPerangkat = mysqli_fetch_assoc($QueryPerangkat)) {
                                $IdKecamatan = $DataPerangkat['IdKecamatanFK'];
                                $NamaDesa = $DataPerangkat['NamaDesa'];
                                $Jumlah = $DataPerangkat['JmlPerangkat'];
                            ?>
                                <tr class="gradeX">
                                    <td align="center">
                                        <?php echo $Nomor; ?>
                                    </td>
                                    <td>
                                        <?php echo $NamaDesa; ?>
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
                <h4><strong>Data BPD</strong></h4>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dataTables-kecamatan">
                        <thead>
                            <tr align="center">
                                <th>No</th>
                                <th>Unit Kerja/Desa</th>
                                <th>Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $Nomor = 1;
                            $QueryBPDDesa = mysqli_query($db, "SELECT
                            master_kecamatan.Kecamatan,
                            Count(master_pegawai_bpd.IdPegawaiFK) AS JmlBPD,
                            master_pegawai_bpd.IdPegawaiFK,
                            master_pegawai_bpd.Setting,
                            master_desa.IdDesa,
                            master_desa.NamaDesa,
                            master_desa.IdKecamatanFK,
                            master_kecamatan.IdKecamatan
                        FROM
                            master_pegawai_bpd
                            RIGHT JOIN
                            master_desa
                            ON
                                master_pegawai_bpd.IdDesaFK = master_desa.IdDesa
                            LEFT JOIN
                            master_kecamatan
                            ON
                                master_desa.IdKecamatanFK = master_kecamatan.IdKecamatan
                        WHERE
                            master_desa.IdKecamatanFK = '$IdKecamatan'
                        GROUP BY
                            master_desa.NamaDesa
                        ORDER BY
                            master_desa.NamaDesa ASC");

                            while ($DataBPDDesa = mysqli_fetch_assoc($QueryBPDDesa)) {
                                $IdKecamatanBPD = $DataBPDDesa['IdKecamatanFK'];
                                $NamaDesaBPD = $DataBPDDesa['NamaDesa'];
                                $JumlahBPD = $DataBPDDesa['JmlBPD'];
                            ?>
                                <tr class="gradeX">
                                    <td align="center">
                                        <?php echo $Nomor; ?>
                                    </td>
                                    <td>
                                        <?php echo $NamaDesaBPD; ?>
                                    </td>
                                    <td align="center">
                                        <strong><?php echo $JumlahBPD; ?></strong>
                                    </td>
                                </tr>
                            <?php $Nomor++;
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>


            <div class="col-lg-12">
                <div id="GrafikDesaV"></div><br><br>
                <div id="GrafikDesaVBPD">
                </div>

            </div>
        </div>
    <?php } ?>

    <script type="text/javascript" <?php echo CSPHandler::scriptNonce(); ?>>
        Highcharts.chart('GrafikDesaV', {
            chart: {
                type: 'column'
            },
            title: {
                text: '<strong>Grafik Data Kades & Perangkat Desa Kecamatan <?php echo $NamaKecamatan; ?></strong>'
            },
            subtitle: {
                text: 'Statistik Kecamatan'
            },
            xAxis: {
                categories: ['Desa '],
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
                        master_desa.IdKecamatanFK = '$IdKecamatan' AND
                        history_mutasi.Setting = 1
                    GROUP BY
                    master_desa.NamaDesa
                    ORDER BY
                    master_desa.NamaDesa ASC");
                while ($DataPerangkat = mysqli_fetch_assoc($QueryPerangkat)) {
                    $IdKecamatan = $DataPerangkat['IdKecamatanFK'];
                    $NamaDesa = $DataPerangkat['NamaDesa'];
                    $Jumlah = $DataPerangkat['JmlPerangkat'];
                ?> {
                        name: '<?php echo $NamaDesa; ?>',
                        data: [<?php echo $Jumlah; ?>]
                    },
                <?php } ?>
            ]
        });
    </script>

    <script type="text/javascript" <?php echo CSPHandler::scriptNonce(); ?>>
        Highcharts.chart('GrafikDesaVBPD', {
            chart: {
                type: 'column'
            },
            title: {
                text: '<strong>Grafik Data BPD Kecamatan <?php echo $NamaKecamatan; ?></strong>'
            },
            subtitle: {
                text: 'Statistik Kecamatan'
            },
            xAxis: {
                categories: ['Desa '],
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
                $QueryBPDDesa = mysqli_query($db, "SELECT
                            master_kecamatan.Kecamatan,
                            Count(master_pegawai_bpd.IdPegawaiFK) AS JmlBPD,
                            master_pegawai_bpd.IdPegawaiFK,
                            master_pegawai_bpd.Setting,
                            master_desa.IdDesa,
                            master_desa.NamaDesa,
                            master_desa.IdKecamatanFK,
                            master_kecamatan.IdKecamatan
                        FROM
                            master_pegawai_bpd
                            RIGHT JOIN
                            master_desa
                            ON
                                master_pegawai_bpd.IdDesaFK = master_desa.IdDesa
                            LEFT JOIN
                            master_kecamatan
                            ON
                                master_desa.IdKecamatanFK = master_kecamatan.IdKecamatan
                        WHERE
                            master_desa.IdKecamatanFK = '$IdKecamatan'
                        GROUP BY
                            master_desa.NamaDesa
                        ORDER BY
                            master_desa.NamaDesa ASC");

                while ($DataBPDDesa = mysqli_fetch_assoc($QueryBPDDesa)) {
                    $IdKecamatanBPD = $DataBPDDesa['IdKecamatanFK'];
                    $NamaDesaBPD = $DataBPDDesa['NamaDesa'];
                    $JumlahBPD = $DataBPDDesa['JmlBPD'];
                ?> {
                        name: '<?php echo $NamaDesaBPD; ?>',
                        data: [<?php echo $JumlahBPD; ?>]
                    },
                <?php } ?>
            ]
        });
    </script>