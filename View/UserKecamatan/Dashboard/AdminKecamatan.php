<?php
if (empty($_GET['alert'])) {
    echo "";
} elseif ($_GET['alert'] == 'Sukses') {
    echo "<script type='text/javascript'>
            setTimeout(function () {
                swal({
                    title: 'Sukses Ajukan SK Pensiun',
                    text: 'SK Pensiun telah berhasil diajukan.',
                    type: 'success'
                });
            }, 100);
          </script>";
} elseif ($_GET['alert'] == 'Gagal') {
    echo "<script type='text/javascript'>
            setTimeout(function () {
                swal({
                    title: 'Gagal Ajukan SK Pensiun',
                    text: 'SK Pensiun telah gagal diajukan.',
                    type: 'warning'
                });
            }, 100);
          </script>";
}

include "../App/Control/FunctionProfileDinasView.php";

$IdKecamatan = $_SESSION['IdKecamatan'];

$QHeader = mysqli_query($db, "SELECT * FROM master_kecamatan WHERE IdKecamatan = '$IdKecamatan'");
$DataHeader = mysqli_fetch_assoc($QHeader);
$NamaKecamatanHeader = $DataHeader['Kecamatan'];

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
                            history_mutasi.Setting = 1");

$DataPerangkat = mysqli_fetch_assoc($QueryPerangkat);
$Jumlah = $DataPerangkat['JmlPerangkat'];
$TglSaatIni = date('d-m-Y');
?>


<div class="row">
    <div class="col-lg-12">
        <div class="ibox ">
            <div class="ibox-content text-center p-md">
                <img style="width:80px; height:auto" alt="image" src="../Vendor/Media/Logo/Kabupaten.png" />
                <h2><span class="text-navy">Sistem Informasi Pemerintahan Desa</span>
                    <br><?php echo $Dinas; ?> <br />Kabupaten <?php echo $Kabupaten; ?>
                    <br>
                    <br><b>Rekap Data Pemerintahan Desa Kecamatan <?php echo $NamaKecamatanHeader; ?></b>
                </h2>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-4">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>Pemerintah Desa Aktif</h5>
            </div>
            <div class="ibox-content">
                <img src="../Vendor/Media/Logo/Pria.png" class="rounded-circle" width="70" height="70" align="left" />
                <img src="../Vendor/Media/Logo/Perempuan.png" class="rounded-circle" width="70" height="70" align="left" />
                <h1 class="no-margins" align="right"><strong><?php echo $Jumlah; ?></strong></h1>
                <div class="font-bold text-success" align="right">Orang<br>Per Tanggal <?php echo $TglSaatIni; ?></div>
            </div>
        </div>
    </div>

    <?php
    $QJK = mysqli_query($db, "SELECT
                master_jenkel.Keterangan,
                Count(master_pegawai.IdPegawaiFK) AS JumlahJKL,
                master_pegawai.JenKel,
                master_pegawai.IdDesaFK,
                master_pegawai.Setting,
                master_desa.IdDesa,
                master_desa.NamaDesa,
                master_desa.IdKecamatanFK,
                master_kecamatan.IdKecamatan,
                master_kecamatan.Kecamatan,
                main_user.IdPegawai,
                main_user.IdLevelUserFK,
                master_jenkel.IdJenKel,
                history_mutasi.IdPegawaiFK,
                history_mutasi.Setting AS SettingMutasi
                FROM
                master_pegawai
                LEFT JOIN master_desa ON master_pegawai.IdDesaFK = master_desa.IdDesa
                LEFT JOIN master_kecamatan ON master_desa.IdKecamatanFK = master_kecamatan.IdKecamatan
                INNER JOIN main_user ON main_user.IdPegawai = master_pegawai.IdPegawaiFK
                INNER JOIN master_jenkel ON master_pegawai.JenKel = master_jenkel.IdJenKel
                INNER JOIN history_mutasi ON master_pegawai.IdPegawaiFK = history_mutasi.IdPegawaiFK
                WHERE master_pegawai.Setting = 1 AND
                main_user.IdLevelUserFK <> 1 AND
                main_user.IdLevelUserFK <> 2 AND
                master_pegawai.JenKel = 1 AND
                master_desa.IdKecamatanFK = '$IdKecamatan' AND
                history_mutasi.Setting = 1
                GROUP BY master_pegawai.JenKel");
    $DataJK = mysqli_fetch_assoc($QJK);
    $LakiLaki = $DataJK['JumlahJKL'];
    if ($LakiLaki == 0) {
        $LakiLaki = 0;
    } else {
        $LakiLaki;
    }
    ?>

    <div class="col-lg-4">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>Laki-Laki</h5>
            </div>
            <div class="ibox-content">
                <img src="../Vendor/Media/Logo/Pria.png" class="rounded-circle" width="70" height="70" align="left" />
                <h1 class="no-margins" align="right"><strong><?php echo $LakiLaki; ?></strong></h1>
                <div class="font-bold text-success" align="right">Orang<br>Per Tanggal <?php echo $TglSaatIni; ?></div>
            </div>
        </div>
    </div>

    <?php
    $QJKP = mysqli_query($db, "SELECT
                master_jenkel.Keterangan,
                Count(master_pegawai.IdPegawaiFK) AS JumlahJKP,
                master_pegawai.JenKel,
                master_pegawai.IdDesaFK,
                master_pegawai.Setting,
                master_desa.IdDesa,
                master_desa.NamaDesa,
                master_desa.IdKecamatanFK,
                master_kecamatan.IdKecamatan,
                master_kecamatan.Kecamatan,
                main_user.IdPegawai,
                main_user.IdLevelUserFK,
                master_jenkel.IdJenKel,
                history_mutasi.Setting AS SettingMutasi
                FROM
                master_pegawai
                LEFT JOIN master_desa ON master_pegawai.IdDesaFK = master_desa.IdDesa
                LEFT JOIN master_kecamatan ON master_desa.IdKecamatanFK = master_kecamatan.IdKecamatan
                INNER JOIN main_user ON main_user.IdPegawai = master_pegawai.IdPegawaiFK
                INNER JOIN master_jenkel ON master_pegawai.JenKel = master_jenkel.IdJenKel
                INNER JOIN history_mutasi ON master_pegawai.IdPegawaiFK = history_mutasi.IdPegawaiFK
                WHERE master_pegawai.Setting = 1 AND
                main_user.IdLevelUserFK <> 1 AND
                main_user.IdLevelUserFK <> 2 AND
                master_pegawai.JenKel = 2 AND
                master_desa.IdKecamatanFK = '$IdKecamatan' AND
                history_mutasi.Setting = 1
                GROUP BY master_pegawai.JenKel");
    $DataJKP = mysqli_fetch_assoc($QJKP);
    $Perempuan = $DataJKP['JumlahJKP'];

    if ($Perempuan == 0) {
        $Perempuan = 0;
    } else {
        $Perempuan;
    }
    ?>

    <div class="col-lg-4">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>Perempuan</h5>
            </div>
            <div class="ibox-content">
                <img src="../Vendor/Media/Logo/Perempuan.png" class="rounded-circle" width="70" height="70" align="left" />
                <h1 class="no-margins" align="right"><strong><?php echo $Perempuan; ?></strong></h1>
                <div class="font-bold text-success" align="right">Orang<br>Per Tanggal <?php echo $TglSaatIni; ?></div>
            </div>
        </div>
    </div>

</div>

<!-- ============= -->
<?php
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
                            <th>Jml Perangkat</th>
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
                            history_mutasi.Setting AS SettingMutasi,
                            history_mutasi.IdPegawaiFK
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
                            $JumlahPerangkat = $DataPerangkat['JmlPerangkat'];
                        ?>
                            <tr class="gradeX">
                                <td align="center">
                                    <?php echo $Nomor; ?>
                                </td>
                                <td>
                                    <?php echo $NamaDesa; ?>
                                </td>

                                <td align="right">
                                    <strong><?php echo $JumlahPerangkat; ?></strong>
                                </td>
                            </tr>
                        <?php $Nomor++;
                        }
                        ?>
                    </tbody>

                    <?php
                    $QueryJumlah = mysqli_query($db, "SELECT
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
                                        history_mutasi.Setting = 1 AND
                                        master_desa.IdKecamatanFK = '$IdKecamatan'
                                    GROUP BY
                                        master_kecamatan.IdKecamatan
                                    ORDER BY
                                        master_kecamatan.Kecamatan ASC");
                    $DataJumlah = mysqli_fetch_assoc($QueryJumlah);
                    $IdKecamatan = $DataJumlah['IdKecamatanFK'];
                    $Kecamatan = $DataJumlah['Kecamatan'];
                    $Jumlah = $DataJumlah['JmlPerangkat'];
                    ?>
                    <tr class="gradeX">
                        <td></td>
                        <td align="right"><strong>Total</strong></td>
                        <td align="right">
                            <strong><?php echo $Jumlah; ?></strong>
                        </td>
                    </tr>

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
                                <td align="right">
                                    <strong><?php echo $JumlahBPD; ?></strong>
                                </td>
                            </tr>
                        <?php $Nomor++;
                        }
                        ?>
                    </tbody>
                    <?php
                    $QueryJumlahBPD = mysqli_query($db, "SELECT
                        master_pegawai_bpd.*,
                        master_desa.*,
                        count(master_pegawai_bpd.IdPegawaiFK) AS JmlBPD
                    FROM
                        master_pegawai_bpd
                        INNER JOIN
                        master_desa
                        ON
                            master_pegawai_bpd.IdDesaFK = master_desa.IdDesa
                    WHERE
                        master_desa.IdKecamatanFK = '$IdKecamatan'");

                    $DataJmlTotalBPD = mysqli_fetch_assoc($QueryJumlahBPD);
                    $TotalBPDKab = $DataJmlTotalBPD['JmlBPD'];
                    ?>
                    <tfoot>
                        <tr align="right">
                            <td></td>
                            <td align="right"><strong>Total</strong></td>
                            <td align="right">
                            <strong><?php echo $TotalBPDKab; ?></strong>
                        </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

<br>
<div class="row">
    <div class="col-lg-12">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>Statistik Desa</h5>
            </div>
            <div class="ibox-content">
                <div class="row">
                    <div class="col-lg-12">
                        <div id="GrafikDesaV"></div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>


<script type="text/javascript">
    Highcharts.chart('GrafikDesaV', {
        chart: {
            type: 'column',
            backgroundColor: '#f9fafb', // warna background chart
            borderRadius: 10,
            style: {
                fontFamily: 'Tahoma'
            }
        },
        title: {
            text: '<strong>Grafik Data Kades & Perangkat Desa Kecamatan <?php echo $NamaKecamatan; ?></strong>',
            style: {
                color: '#111827',
                fontSize: '16px'
            }
        },
        xAxis: {
            categories: ['Desa '],
            crosshair: false,
            labels: {
                style: { fontSize: '12px', color: '#374151' }
            }
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Jumlah Pegawai',
                style: { color: '#374151' }
            },
            gridLineColor: '#e5e7eb'
        },
        colors: [
            '#3b82f6', // biru
            '#10b981', // hijau
            '#f59e0b', // kuning
            '#ef4444', // merah
            '#8b5cf6', // ungu
            '#14b8a6', // teal
            '#d946ef', // pink
            '#64748b'  // abu
        ],
        plotOptions: {
            column: {
                borderRadius: 5,
                pointPadding: 0.2,
                borderWidth: 0,
                dataLabels: {
                    enabled: true,
                    style: {
                        fontSize: '11px',
                        fontWeight: 'bold',
                        color: '#111827'
                    }
                }
            }
        },
        tooltip: {
            backgroundColor: '#ffffff',
            borderColor: '#d1d5db',
            borderRadius: 6,
            style: { color: '#111827' },
            formatter: function () {
                return '<b>' + this.series.name + '</b><br/>' +
                       'Jumlah: <b>' + this.y + '</b> orang';
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
                        LEFT JOIN master_desa ON master_pegawai.IdDesaFK = master_desa.IdDesa
                        LEFT JOIN master_kecamatan ON master_desa.IdKecamatanFK = master_kecamatan.IdKecamatan
                        INNER JOIN main_user ON master_pegawai.IdPegawaiFK = main_user.IdPegawai
                        INNER JOIN history_mutasi ON master_pegawai.IdPegawaiFK = history_mutasi.IdPegawaiFK
                    WHERE
                        master_pegawai.Setting = 1 AND
                        main_user.IdLevelUserFK <> 1 AND
                        main_user.IdLevelUserFK <> 2 AND
                        master_desa.IdKecamatanFK = '$IdKecamatan' AND
                        history_mutasi.Setting = 1
                    GROUP BY master_desa.NamaDesa
                    ORDER BY master_desa.NamaDesa ASC");
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

<!-- ================= -->

<div class="row">
    <div class="col-lg-12">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>Statistik Pendidikan</h5>
            </div>
            <div class="ibox-content">
                <div class="row">
                    <div class="col-lg-12">
                        <div id="StatistikPendidikan"></div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>Statistik Jabatan</h5>
            </div>
            <div class="ibox-content">
                <div class="row">
                    <div class="col-lg-12">
                        <div id="StatistikJabatan"></div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>


<script type="text/javascript">
    Highcharts.chart('StatistikPendidikan', {
    chart: {
            type: 'column',
            backgroundColor: '#f9fafb', // warna background chart
            borderRadius: 10,
            style: {
                fontFamily: 'Tahoma'
            }
        },
    title: {
            text: '<strong>📊 Pendidikan Pemerintah Desa di Kecamatan <?php echo $NamaKecamatan; ?></strong>',
            style: {
                color: '#111827',
                fontSize: '16px'
            }
        },
    xAxis: {
        categories: ['Jumlah'] // hanya 1 kategori di sumbu X
    },
    yAxis: { min: 0, title: { text: 'Jumlah Pegawai' } },
    tooltip: { pointFormat: '<b>{point.y} orang</b>' },
    plotOptions: { column: { borderRadius: 5 } },
    colors: ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b'],
    series: [
        <?php
        $QueryPendidikan = mysqli_query($db, "SELECT
            master_pendidikan.JenisPendidikan,
            Count(history_pendidikan.IdPegawaiFK) AS JmlPendidikan
        FROM history_pendidikan
            INNER JOIN master_pendidikan
            ON history_pendidikan.IdPendidikanFK = master_pendidikan.IdPendidikan
            INNER JOIN master_pegawai
            ON master_pegawai.IdPegawaiFK = history_pendidikan.IdPegawaiFK
            INNER JOIN master_desa
            ON master_desa.IdDesa = master_pegawai.IdDesaFK
            INNER JOIN history_mutasi
            ON history_pendidikan.IdPegawaiFK = history_mutasi.IdPegawaiFK
        WHERE history_pendidikan.Setting = 1 
          AND master_pegawai.Setting = 1 
          AND master_desa.IdKecamatanFK = '$IdKecamatan' 
          AND history_mutasi.Setting = 1
        GROUP BY history_pendidikan.IdPendidikanFK
        ORDER BY master_pendidikan.IdPendidikan ASC");

        $series = [];
        while ($DataPendidikan = mysqli_fetch_assoc($QueryPendidikan)) {
            $series[] = "{ name: '" . $DataPendidikan['JenisPendidikan'] . "', data: [" . $DataPendidikan['JmlPendidikan'] . "] }";
        }
        echo implode(",", $series);
        ?>
    ]
});
</script>

<script type="text/javascript">
Highcharts.chart('StatistikJabatan', {
    chart: {
        type: 'column',
        backgroundColor: '#f9fafb', // background lembut
        style: {
            fontFamily: 'Tahoma'
        }
    },
    title: {
        text: '<strong>📊 Grafik Jabatan Pemerintah Desa</strong>',
        style: { fontSize: '16px' }
    },
    xAxis: {
        categories: ['Jumlah Jabatan'],
        crosshair: false,
        labels: {
            style: { fontSize: '11px' }
        }
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Jumlah Pegawai',
            style: { fontSize: '12px' }
        },
        gridLineColor: '#e6e6e6'
    },
    tooltip: {
        backgroundColor: '#fff',
        borderColor: '#ccc',
        borderRadius: 8,
        shadow: true,
        headerFormat: '<span style="font-size:10px">{point.key}</span><br/>',
        pointFormat: '<b>{series.name}</b>: {point.y} orang'
    },
    legend: {
        layout: 'horizontal',
        align: 'center',
        verticalAlign: 'bottom',
        borderWidth: 0,
        itemStyle: {
            fontSize: '11px'
        }
    },
    plotOptions: {
        column: {
            borderRadius: 5, // rounded bar
            dataLabels: {
                enabled: true,
                style: { fontSize: '10px', fontWeight: 'bold' },
                format: '{point.y}'
            }
        }
    },
    // 🎨 Warna custom biar tidak biru semua
    colors: ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b', '#858796'],
    
    series: [
        <?php
        $QJabatan = mysqli_query($db, "SELECT
            master_jabatan.IdJabatan,
            master_jabatan.Jabatan,
            history_mutasi.IdJabatanFK,
            Count(history_mutasi.IdPegawaiFK) AS JmlJabatan,
            history_mutasi.Setting,
            history_mutasi.JenisMutasi,
            master_pegawai.IdPegawaiFK,
            master_pegawai.IdDesaFK,
            master_desa.IdKecamatanFK,
            master_desa.IdDesa
        FROM master_jabatan
            INNER JOIN history_mutasi ON history_mutasi.IdJabatanFK = master_jabatan.IdJabatan
            INNER JOIN master_pegawai ON master_pegawai.IdPegawaiFK = history_mutasi.IdPegawaiFK
            INNER JOIN master_desa ON master_pegawai.IdDesaFK = master_desa.IdDesa
            INNER JOIN master_kecamatan ON master_desa.IdKecamatanFK = master_kecamatan.IdKecamatan
        WHERE history_mutasi.Setting = 1 
          AND history_mutasi.JenisMutasi NOT IN (3,4,5) 
          AND master_desa.IdKecamatanFK = '$IdKecamatan'
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


<div class="row">
    <div class="col-lg-12">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>Statistik BPD</h5>
            </div>
            <div class="ibox-content">
                <div class="row">
                    <div class="col-lg-12">
                        <div id="GrafikDesaVBPD"></div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script type="text/javascript">
Highcharts.chart('GrafikDesaVBPD', {
    chart: {
        type: 'column',
        backgroundColor: '#f9fafb', // background lembut
        style: {
            fontFamily: 'Tahoma'
        }
    },
    title: {
        text: '<strong>📊 Grafik Data BPD Kecamatan <?php echo $NamaKecamatan; ?></strong>',
        style: { fontSize: '16px' }
    },
    xAxis: {
        categories: ['Jumlah BPD'],
        crosshair: false,
        labels: {
            style: { fontSize: '11px' }
        }
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Jumlah Pegawai',
            style: { fontSize: '12px' }
        },
        gridLineColor: '#e6e6e6'
    },
    tooltip: {
        backgroundColor: '#fff',
        borderColor: '#ccc',
        borderRadius: 8,
        shadow: true,
        headerFormat: '<span style="font-size:10px">{point.key}</span><br/>',
        pointFormat: '<b>{series.name}</b>: {point.y} orang'
    },
    legend: {
        layout: 'horizontal',
        align: 'center',
        verticalAlign: 'bottom',
        borderWidth: 0,
        itemStyle: {
            fontSize: '11px'
        }
    },
    plotOptions: {
        column: {
            borderRadius: 5, // rounded bar
            dataLabels: {
                enabled: true,
                style: { fontSize: '10px', fontWeight: 'bold' },
                format: '{point.y}'
            }
        }
    },
    // 🎨 Warna custom
    colors: ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b', '#858796'],

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
                    FROM master_pegawai_bpd
                        RIGHT JOIN master_desa ON master_pegawai_bpd.IdDesaFK = master_desa.IdDesa
                        LEFT JOIN master_kecamatan ON master_desa.IdKecamatanFK = master_kecamatan.IdKecamatan
                    WHERE master_desa.IdKecamatanFK = '$IdKecamatan'
                    GROUP BY master_desa.NamaDesa
                    ORDER BY master_desa.NamaDesa ASC");

        while ($DataBPDDesa = mysqli_fetch_assoc($QueryBPDDesa)) {
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
