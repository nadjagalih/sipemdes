<?php
include '../../../Module/Config/Env.php';
$$IdTemp = isset($_POST['Kecamatan']) ? sql_injeksi($_POST['Kecamatan']) : '';
$QueryKecamatan = mysqli_query($db, "SELECT * FROM master_kecamatan WHERE IdKecamatan ='$IdTemp' ");
$DataKecamatan = mysqli_fetch_assoc($QueryKecamatan);
$IdKecamatan = $DataKecamatan['IdKecamatan'];
$NamaKecamatan = $DataKecamatan['Kecamatan'];
?>
<div class="ibox-content">
    <h4><strong>Data Gender Pemerintah Desa Kecamatan <?php echo $NamaKecamatan; ?></strong></h4>
    <div class="row">
        <div class="col-lg-6">
            <h4><strong>Laki-Laki</strong></h4>
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover dataTables-kecamatan">
                    <thead>
                        <tr align="center">
                            <th>No</th>
                            <th>Unit Kerja/Desa</th>
                            <th>Laki-laki</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $Nomor = 1;
                        $QueryPerangkat = mysqli_query($db, "SELECT
                            master_desa.NamaDesa,
                            master_desa.IdKecamatanFK,
                            master_desa.IdDesa
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
                            INNER JOIN
                            master_jenkel
                            ON
                                master_pegawai.JenKel = master_jenkel.IdJenKel
                        WHERE
                            master_pegawai.Setting = 1 AND
                            main_user.IdLevelUserFK <> 1 AND
                            main_user.IdLevelUserFK <> 2 AND
                            history_mutasi.Setting = 1 AND
                            master_desa.IdKecamatanFK = '$IdTemp'
                        GROUP BY
                            master_desa.NamaDesa
                        ORDER BY
                            master_desa.NamaDesa ASC");
                        while ($DataPerangkat = mysqli_fetch_assoc($QueryPerangkat)) {
                            $IdKecamatanCek = $DataPerangkat['IdKecamatanFK'];
                            $IdDesaGenderCek = $DataPerangkat['IdDesa'];
                            $NamaDesa = $DataPerangkat['NamaDesa'];
                        ?>
                            <tr class="gradeX">
                                <td align="center">
                                    <?php echo $Nomor; ?>
                                </td>
                                <td>
                                    <?php echo $NamaDesa; ?>
                                </td>

                                <?php
                                $QueryDetailGender = mysqli_query($db, "SELECT
                                        master_desa.NamaDesa,
                                        master_desa.IdKecamatanFK,
                                        master_desa.IdDesa,
                                        count(master_pegawai.JenKel) AS JmlGenderV
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
                                        INNER JOIN
                                        master_jenkel
                                        ON
                                            master_pegawai.JenKel = master_jenkel.IdJenKel
                                    WHERE
                                        master_pegawai.Setting = 1 AND
                                        main_user.IdLevelUserFK <> 1 AND
                                        main_user.IdLevelUserFK <> 2 AND
                                        history_mutasi.Setting = 1 AND
                                        master_desa.IdKecamatanFK = '$IdTemp' AND
                                        master_desa.IdDesa = '$IdDesaGenderCek' AND
	                                    master_pegawai.JenKel = 1
                                    GROUP BY
                                        master_desa.NamaDesa
                                    ORDER BY
                                        master_desa.NamaDesa ASC");

                                while ($DataPerangkatDetail = mysqli_fetch_assoc($QueryDetailGender)) {
                                    $LakiLaki = $DataPerangkatDetail['JmlGenderV'];
                                ?>
                                    <td align="center">
                                        <strong><?php echo $LakiLaki; ?></strong>
                                    </td>
                                <?php } ?>
                            </tr>
                        <?php $Nomor++;
                        }
                        ?>
                    </tbody>
                    <?php
                    $QueryDetailGenderPria = mysqli_query($db, "SELECT
                                        master_desa.NamaDesa,
                                        master_desa.IdKecamatanFK,
                                        master_desa.IdDesa,
                                        count(master_pegawai.JenKel) AS JmlGenderVPria
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
                                        INNER JOIN
                                        master_jenkel
                                        ON
                                            master_pegawai.JenKel = master_jenkel.IdJenKel
                                    WHERE
                                        master_pegawai.Setting = 1 AND
                                        main_user.IdLevelUserFK <> 1 AND
                                        main_user.IdLevelUserFK <> 2 AND
                                        history_mutasi.Setting = 1 AND
                                        master_desa.IdKecamatanFK = '$IdTemp' AND
	                                    master_pegawai.JenKel = 1");

                    $TotalPriaDesa = mysqli_fetch_assoc($QueryDetailGenderPria);
                    $PriaDesaPerangkat = $TotalPriaDesa['JmlGenderVPria'];
                    ?>
                    <tfood>
                        <tr align="center">
                            <th></th>
                            <th>Total</th>
                            <th><?php echo $PriaDesaPerangkat; ?></th>
                        </tr>
                        </thead>
                </table>
            </div>
        </div>

        <div class="col-lg-6">
            <h4><strong>Perempuan</strong></h4>
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover dataTables-kecamatan">
                    <thead>
                        <tr align="center">
                            <th>No</th>
                            <th>Unit Kerja/Desa</th>
                            <th>Perempuan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $Nomor = 1;
                        $QueryPerangkatP = mysqli_query($db, "SELECT
                            master_desa.NamaDesa,
                            master_desa.IdKecamatanFK,
                            master_desa.IdDesa
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
                            INNER JOIN
                            master_jenkel
                            ON
                                master_pegawai.JenKel = master_jenkel.IdJenKel
                        WHERE
                            master_pegawai.Setting = 1 AND
                            main_user.IdLevelUserFK <> 1 AND
                            main_user.IdLevelUserFK <> 2 AND
                            history_mutasi.Setting = 1 AND
                            master_desa.IdKecamatanFK = '$IdTemp'
                        GROUP BY
                            master_desa.NamaDesa
                        ORDER BY
                            master_desa.NamaDesa ASC");
                        while ($DataPerangkatP = mysqli_fetch_assoc($QueryPerangkatP)) {
                            $IdKecamatanCekP = $DataPerangkatP['IdKecamatanFK'];
                            $IdDesaGenderCekP = $DataPerangkatP['IdDesa'];
                            $NamaDesaP = $DataPerangkatP['NamaDesa'];
                        ?>
                            <tr class="gradeX">
                                <td align="center">
                                    <?php echo $Nomor; ?>
                                </td>
                                <td>
                                    <?php echo $NamaDesaP; ?>
                                </td>

                                <?php
                                $QueryDetailGenderP = mysqli_query($db, "SELECT
                                        master_desa.NamaDesa,
                                        master_desa.IdKecamatanFK,
                                        master_desa.IdDesa,
                                        count(master_pegawai.JenKel) AS JmlGenderVP
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
                                        INNER JOIN
                                        master_jenkel
                                        ON
                                            master_pegawai.JenKel = master_jenkel.IdJenKel
                                    WHERE
                                        master_pegawai.Setting = 1 AND
                                        main_user.IdLevelUserFK <> 1 AND
                                        main_user.IdLevelUserFK <> 2 AND
                                        history_mutasi.Setting = 1 AND
                                        master_desa.IdKecamatanFK = '$IdTemp' AND
                                        master_desa.IdDesa = '$IdDesaGenderCekP' AND
	                                    master_pegawai.JenKel = 2
                                    GROUP BY
                                        master_desa.NamaDesa
                                    ORDER BY
                                        master_desa.NamaDesa ASC");

                                while ($DataPerangkatDetailP = mysqli_fetch_assoc($QueryDetailGenderP)) {
                                    $PerempuanG = $DataPerangkatDetailP['JmlGenderVP'];
                                ?>
                                    <td align="center">
                                        <strong><?php echo $PerempuanG; ?></strong>
                                    </td>
                                <?php } ?>
                            </tr>
                        <?php $Nomor++;
                        }
                        ?>
                    </tbody>
                    <?php
                    $QueryDetailGenderPriaV = mysqli_query($db, "SELECT
                                        master_desa.NamaDesa,
                                        master_desa.IdKecamatanFK,
                                        master_desa.IdDesa,
                                        count(master_pegawai.JenKel) AS JmlGenderVPriaV
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
                                        INNER JOIN
                                        master_jenkel
                                        ON
                                            master_pegawai.JenKel = master_jenkel.IdJenKel
                                    WHERE
                                        master_pegawai.Setting = 1 AND
                                        main_user.IdLevelUserFK <> 1 AND
                                        main_user.IdLevelUserFK <> 2 AND
                                        history_mutasi.Setting = 1 AND
                                        master_desa.IdKecamatanFK = '$IdTemp' AND
	                                    master_pegawai.JenKel = 2");

                    $TotalPriaDesaP = mysqli_fetch_assoc($QueryDetailGenderPriaV);
                    $PriaDesaPerangkatP = $TotalPriaDesaP['JmlGenderVPriaV'];
                    ?>
                    <tfood>
                        <tr align="center">
                            <th></th>
                            <th>Total</th>
                            <th><?php echo $PriaDesaPerangkatP; ?></th>
                        </tr>
                        </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div id="GrafikDesa"></div><br>
    </div>
</div>

<script type="text/javascript">
    Highcharts.chart('GrafikDesa', {
        chart: {
            type: 'column'
        },
        title: {
            text: '<strong>Grafik Gender Pemerintah Desa Kecamatan <?php echo $NamaKecamatan; ?></strong>'
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
            $QueryPerangkatGR = mysqli_query($db, "SELECT
                master_jenkel.Keterangan,
                count(master_pegawai.JenKel) AS JmlGenderVPR
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
                INNER JOIN
                master_jenkel
                ON
                    master_pegawai.JenKel = master_jenkel.IdJenKel
            WHERE
                master_pegawai.Setting = 1 AND
                main_user.IdLevelUserFK <> 1 AND
                main_user.IdLevelUserFK <> 2 AND
                history_mutasi.Setting = 1 AND
                master_desa.IdKecamatanFK = '$IdTemp'
            GROUP BY
                master_pegawai.JenKel");
            while ($DataPerangkatGR = mysqli_fetch_assoc($QueryPerangkatGR)) {
                $GenderGR = $DataPerangkatGR['Keterangan'];
                $JumlahGR = $DataPerangkatGR['JmlGenderVPR'];
            ?> {
                    name: '<?php echo $GenderGR; ?>',
                    data: [<?php echo $JumlahGR; ?>]
                },
            <?php } ?>
        ]
    });
</script>



<!-- GENDER BPD -->
<div class="ibox-content">
    <h4><strong>Data Gender BPD Kecamatan <?php echo $NamaKecamatan; ?></strong></h4>
    <div class="row">
        <div class="col-lg-6">
            <h4><strong>Laki-Laki</strong></h4>
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover dataTables-kecamatan">
                    <thead>
                        <tr align="center">
                            <th>No</th>
                            <th>Unit Kerja/Desa</th>
                            <th>Laki-laki</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $Nomor = 1;
                        $QueryBPD = mysqli_query($db, "SELECT
                            master_desa.NamaDesa,
                            master_desa.IdKecamatanFK,
                            master_desa.IdDesa
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
                            INNER JOIN
                            master_jenkel
                            ON
                                master_pegawai_bpd.JenKel = master_jenkel.IdJenKel
                        WHERE
                            master_desa.IdKecamatanFK = '$IdTemp'
                        GROUP BY
                            master_desa.NamaDesa
                        ORDER BY
                            master_desa.NamaDesa ASC");
                        while ($DataBPDV = mysqli_fetch_assoc($QueryBPD)) {
                            $IdKecamatanBPD = $DataBPDV['IdKecamatanFK'];
                            $IdDesaGenderBPD = $DataBPDV['IdDesa'];
                            $NamaDesaBPD = $DataBPDV['NamaDesa'];
                        ?>
                            <tr class="gradeX">
                                <td align="center">
                                    <?php echo $Nomor; ?>
                                </td>
                                <td>
                                    <?php echo $NamaDesaBPD; ?>
                                </td>

                                <?php
                                $QueryDetailGenderBPD = mysqli_query($db, "SELECT
                                    master_desa.NamaDesa,
                                    master_desa.IdKecamatanFK,
                                    master_desa.IdDesa,
                                    count(master_pegawai_bpd.JenKel) AS JmlGenderVBPD
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
                                    INNER JOIN
                                    master_jenkel
                                    ON
                                        master_pegawai_bpd.JenKel = master_jenkel.IdJenKel
                                WHERE
                                        master_desa.IdKecamatanFK = '$IdTemp' AND
                                        master_desa.IdDesa = '$IdDesaGenderBPD' AND
	                                    master_pegawai_bpd.JenKel = 1
                                GROUP BY
                                    master_desa.NamaDesa
                                ORDER BY
                                    master_desa.NamaDesa ASC");

                                while ($DataPerangkatDetailBPD = mysqli_fetch_assoc($QueryDetailGenderBPD)) {
                                    $LakiLakiBPD = $DataPerangkatDetailBPD['JmlGenderVBPD'];
                                ?>
                                    <td align="center">
                                        <strong><?php echo $LakiLakiBPD; ?></strong>
                                    </td>
                                <?php } ?>
                            </tr>
                        <?php $Nomor++;
                        }
                        ?>
                    </tbody>
                    <?php
                    $QueryDetailGenderPriaBPD = mysqli_query($db, "SELECT
                                        master_desa.NamaDesa,
                                        master_desa.IdKecamatanFK,
                                        master_desa.IdDesa,
                                        count(master_pegawai_bpd.JenKel) AS JmlGenderVPria
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
                                        INNER JOIN
                                        master_jenkel
                                        ON
                                            master_pegawai_bpd.JenKel = master_jenkel.IdJenKel
                                    WHERE
                                        master_desa.IdKecamatanFK = '$IdTemp' AND
	                                    master_pegawai_bpd.JenKel = 1");

                    $TotalPriaDesaBPD = mysqli_fetch_assoc($QueryDetailGenderPriaBPD);
                    $PriaDesaPerangkatBPD = $TotalPriaDesaBPD['JmlGenderVPria'];
                    ?>
                    <tfood>
                        <tr align="center">
                            <th></th>
                            <th>Total</th>
                            <th><?php echo $PriaDesaPerangkatBPD; ?></th>
                        </tr>
                        </thead>
                </table>
            </div>
        </div>

        <div class="col-lg-6">
            <h4><strong>Perempuan</strong></h4>
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover dataTables-kecamatan">
                    <thead>
                        <tr align="center">
                            <th>No</th>
                            <th>Unit Kerja/Desa</th>
                            <th>Perempuan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $Nomor = 1;
                        $QueryBPDPerempuan = mysqli_query($db, "SELECT
                            master_desa.NamaDesa,
                            master_desa.IdKecamatanFK,
                            master_desa.IdDesa
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
                            INNER JOIN
                            master_jenkel
                            ON
                                master_pegawai_bpd.JenKel = master_jenkel.IdJenKel
                        WHERE
                            master_desa.IdKecamatanFK = '$IdTemp'
                        GROUP BY
                            master_desa.NamaDesa
                        ORDER BY
                            master_desa.NamaDesa ASC");
                        while ($DataBPDVPerempuan = mysqli_fetch_assoc($QueryBPDPerempuan)) {
                            $IdKecamatanBPDPerempuan = $DataBPDVPerempuan['IdKecamatanFK'];
                            $IdDesaGenderBPDPerempuan = $DataBPDVPerempuan['IdDesa'];
                            $NamaDesaBPDPerempuan = $DataBPDVPerempuan['NamaDesa'];
                        ?>
                            <tr class="gradeX">
                                <td align="center">
                                    <?php echo $Nomor; ?>
                                </td>
                                <td>
                                    <?php echo $NamaDesaBPDPerempuan; ?>
                                </td>

                                <?php
                                $QueryDetailGenderBPDPerempuan = mysqli_query($db, "SELECT
                                    master_desa.NamaDesa,
                                    master_desa.IdKecamatanFK,
                                    master_desa.IdDesa,
                                    count(master_pegawai_bpd.JenKel) AS JmlGenderVBPDPerempuan
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
                                    INNER JOIN
                                    master_jenkel
                                    ON
                                        master_pegawai_bpd.JenKel = master_jenkel.IdJenKel
                                WHERE
                                        master_desa.IdKecamatanFK = '$IdTemp' AND
                                        master_desa.IdDesa = '$IdDesaGenderBPDPerempuan' AND
	                                    master_pegawai_bpd.JenKel = 2
                                GROUP BY
                                    master_desa.NamaDesa
                                ORDER BY
                                    master_desa.NamaDesa ASC");

                                while ($DataPerangkatDetailBPDPerempuan = mysqli_fetch_assoc($QueryDetailGenderBPDPerempuan)) {
                                    $LakiLakiBPDPerempuan = $DataPerangkatDetailBPDPerempuan['JmlGenderVBPDPerempuan'];
                                ?>
                                    <td align="center">
                                        <strong><?php echo $LakiLakiBPDPerempuan; ?></strong>
                                    </td>
                                <?php } ?>
                            </tr>
                        <?php $Nomor++;
                        }
                        ?>
                    </tbody>
                    <?php
                    $QueryDetailGenderPriaBPDPerempuan = mysqli_query($db, "SELECT
                                        master_desa.NamaDesa,
                                        master_desa.IdKecamatanFK,
                                        master_desa.IdDesa,
                                        count(master_pegawai_bpd.JenKel) AS JmlGenderVPriaPerempuan
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
                                        INNER JOIN
                                        master_jenkel
                                        ON
                                            master_pegawai_bpd.JenKel = master_jenkel.IdJenKel
                                    WHERE
                                        master_desa.IdKecamatanFK = '$IdTemp' AND
	                                    master_pegawai_bpd.JenKel = 2");

                    $TotalPriaDesaBPDPerempuan = mysqli_fetch_assoc($QueryDetailGenderPriaBPDPerempuan);
                    $PriaDesaPerangkatBPDPerempuan = $TotalPriaDesaBPDPerempuan['JmlGenderVPriaPerempuan'];
                    ?>
                    <tfood>
                        <tr align="center">
                            <th></th>
                            <th>Total</th>
                            <th><?php echo $PriaDesaPerangkatBPDPerempuan; ?></th>
                        </tr>
                        </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div id="GrafikDesaBPD"></div><br>
    </div>
</div>

<script type="text/javascript">
    Highcharts.chart('GrafikDesaBPD', {
        chart: {
            type: 'column'
        },
        title: {
            text: '<strong>Grafik Gender BPD Kecamatan <?php echo $NamaKecamatan; ?></strong>'
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
            $QueryPerangkatGRBPD = mysqli_query($db, "SELECT
                master_jenkel.Keterangan,
                count(master_pegawai_bpd.JenKel) AS JmlGenderVPRBPD
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
                INNER JOIN
                master_jenkel
                ON
                    master_pegawai_bpd.JenKel = master_jenkel.IdJenKel
            WHERE
               master_desa.IdKecamatanFK = '$IdTemp'
            GROUP BY
                master_pegawai_bpd.JenKel");
            while ($DataPerangkatGRBPD = mysqli_fetch_assoc($QueryPerangkatGRBPD)) {
                $GenderGRBPD = $DataPerangkatGRBPD['Keterangan'];
                $JumlahGRBPD = $DataPerangkatGRBPD['JmlGenderVPRBPD'];
            ?> {
                    name: '<?php echo $GenderGRBPD; ?>',
                    data: [<?php echo $JumlahGRBPD; ?>]
                },
            <?php } ?>
        ]
    });
</script>