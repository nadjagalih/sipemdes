<?php
if (empty($_GET['alert'])) {
    echo "";
} elseif ($_GET['alert'] == 'Ditolak') {
    echo "<script type='text/javascript'>
            setTimeout(function () {
                swal({
                    title: 'Pengajuan Ditolak',
                    text: 'Pengajuan Pensiun berhasil ditolak.',
                    type: 'success'
                });
            }, 1000);
          </script>";

} elseif ($_GET['alert'] == 'Gagal') {
    echo "<script type='text/javascript'>
            setTimeout(function () {
                swal({
                    title: 'Gagal',
                    text: 'Terjadi kesalahan.',
                    type: 'error'
                });
            }, 1000);
          </script>";
}

include "../App/Control/FunctionProfileDinasView.php";
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
                    main_user.IdLevelUserFK
                    FROM
                    master_pegawai
                    LEFT JOIN master_desa ON master_pegawai.IdDesaFK = master_desa.IdDesa
                    LEFT JOIN master_kecamatan ON master_desa.IdKecamatanFK = master_kecamatan.IdKecamatan
                    INNER JOIN main_user ON master_pegawai.IdPegawaiFK = main_user.IdPegawai
                    WHERE
                    master_pegawai.Setting = 1 AND
                    main_user.IdLevelUserFK <> 1 AND
                    main_user.IdLevelUserFK <> 2");
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
                </h2>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>Statistik Pemerintah Desa</h5>
            </div>
            <div class="ibox-content">
                <div class="row">
                    <div class="col-lg-12">
                        <div id="StatistikPerangkat"></div>
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
                <h5>Statistik Jabatan Pemerintah Desa</h5>
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

<div class="row">
    <div class="col-lg-12">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>Statistik BPD</h5>
            </div>
            <div class="ibox-content">
                <div class="row">
                    <div class="col-lg-12">
                        <div id="StatistikBPD"></div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>


<script type="text/javascript">
    Highcharts.chart('StatistikPerangkat', {
        chart: {
            type: 'column'
        },
        title: {
            text: '<strong>Grafik Jumlah Kades & Perangkat Desa PerKecamatan</strong>'
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
    Highcharts.chart('StatistikJabatan', {
        chart: {
            type: 'column'
        },
        title: {
            text: '<strong>Grafik Jabatan Pemerintah Desa</strong>'
        },
        subtitle: {
            text: 'Statistik Jabatan'
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


<script type="text/javascript">
    Highcharts.chart('StatistikBPD', {
        chart: {
            type: 'column'
        },
        title: {
            text: '<strong>Grafik BPD Desa</strong>'
        },
        subtitle: {
            text: 'BPD Kecamatan'
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
            $QueryPegawai = mysqli_query($db, "SELECT
                count(master_pegawai_bpd.IdPegawaiFK) AS JmlBPD,
                master_pegawai_bpd.IdDesaFK,
                master_pegawai_bpd.Kecamatan AS Kec,
                master_pegawai_bpd.Kabupaten,
                master_desa.IdDesa,
                master_desa.NamaDesa,
                master_desa.IdKecamatanFK,
                master_kecamatan.IdKecamatan,
                master_kecamatan.Kecamatan,
                master_kecamatan.IdKabupatenFK,
                master_setting_profile_dinas.IdKabupatenProfile,
                master_setting_profile_dinas.Kabupaten
                FROM master_pegawai_bpd
                LEFT JOIN master_desa ON master_pegawai_bpd.IdDesaFK = master_desa.IdDesa
                LEFT JOIN master_kecamatan ON master_desa.IdKecamatanFK = master_kecamatan.IdKecamatan
                LEFT JOIN master_setting_profile_dinas ON master_kecamatan.IdKabupatenFK = master_setting_profile_dinas.IdKabupatenProfile
                GROUP BY master_kecamatan.IdKecamatan
                ORDER BY
                master_kecamatan.Kecamatan ASC");
            while ($DataPegawai = mysqli_fetch_assoc($QueryPegawai)) {
                $Jumlah = $DataPegawai['JmlBPD'];
                $Kecamatan = $DataPegawai['Kecamatan'];


            ?> {
                    name: '<?php echo $Kecamatan; ?>',
                    data: [<?php echo $Jumlah; ?>]
                },
            <?php } ?>
        ]
    });
</script>