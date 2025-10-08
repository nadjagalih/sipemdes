<?php
if (empty($_GET['alert'])) {
    echo "";
} elseif (isset($_GET['alert']) && $_GET['alert'] == 'Ditolak') {
    echo "<script type='text/javascript'>
            setTimeout(function () {
                swal({
                    title: 'Pengajuan Ditolak',
                    text: 'Pengajuan Pensiun berhasil ditolak.',
                    type: 'success'
                });
            }, 1000);
          </script>";

} elseif (isset($_GET['alert']) && $_GET['alert'] == 'Gagal') {
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

// Implementasi Simple Caching untuk Dashboard SuperAdmin
$cache_file = '../cache/dashboard_sadmin_' . date('Y-m-d-H') . '.json';
$cache_duration = 3600; // 1 jam

// Buat folder cache jika belum ada
if (!is_dir('../cache')) {
    mkdir('../cache', 0755, true);
}

if (file_exists($cache_file) && (time() - filemtime($cache_file)) < $cache_duration) {
    // Load from cache
    $cache_data = json_decode(file_get_contents($cache_file), true);
    $Jumlah = $cache_data['total_perangkat'];
} else {
    // Query Optimized untuk menghitung total perangkat - hanya ambil yang dibutuhkan
    $QueryPerangkat = mysqli_query($db, "SELECT 
        COUNT(DISTINCT mp.IdPegawaiFK) AS JmlPerangkat
    FROM master_pegawai mp
    INNER JOIN main_user mu ON mp.IdPegawaiFK = mu.IdPegawai
    WHERE mp.Setting = 1 
        AND mu.IdLevelUserFK NOT IN (1, 2)");
    $DataPerangkat = mysqli_fetch_assoc($QueryPerangkat);
    $Jumlah = $DataPerangkat['JmlPerangkat'];
    
    // Save to cache
    $cache_data = ['total_perangkat' => $Jumlah, 'generated' => date('Y-m-d H:i:s')];
    file_put_contents($cache_file, json_encode($cache_data));
}

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
            // Query Optimized untuk Statistik Perangkat - mengurangi JOIN yang tidak perlu
            $QueryPerangkat = mysqli_query($db, "SELECT 
                mk.Kecamatan,
                COUNT(DISTINCT mp.IdPegawaiFK) AS JmlPerangkat
            FROM master_kecamatan mk
            LEFT JOIN master_desa md ON mk.IdKecamatan = md.IdKecamatanFK
            LEFT JOIN master_pegawai mp ON md.IdDesa = mp.IdDesaFK 
                AND mp.Setting = 1
            LEFT JOIN main_user mu ON mp.IdPegawaiFK = mu.IdPegawai 
                AND mu.IdLevelUserFK NOT IN (1, 2)
            LEFT JOIN history_mutasi hm ON mp.IdPegawaiFK = hm.IdPegawaiFK 
                AND hm.Setting = 1
            WHERE mp.IdPegawaiFK IS NOT NULL
            GROUP BY mk.IdKecamatan, mk.Kecamatan
            ORDER BY mk.Kecamatan ASC");
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
            // Query Optimized untuk Statistik Jabatan - mengurangi field yang tidak perlu
            $QJabatan = mysqli_query($db, "SELECT 
                mj.Jabatan,
                COUNT(hm.IdPegawaiFK) AS JmlJabatan
            FROM master_jabatan mj
            INNER JOIN history_mutasi hm ON mj.IdJabatan = hm.IdJabatanFK
            WHERE hm.Setting = 1 
                AND hm.JenisMutasi NOT IN (3, 4, 5)
            GROUP BY mj.IdJabatan, mj.Jabatan
            ORDER BY mj.Jabatan");
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
            // Query Optimized untuk Statistik BPD - mengurangi JOIN dan field yang tidak perlu
            $QueryPegawai = mysqli_query($db, "SELECT 
                mk.Kecamatan,
                COUNT(mpb.IdPegawaiFK) AS JmlBPD
            FROM master_kecamatan mk
            LEFT JOIN master_desa md ON mk.IdKecamatan = md.IdKecamatanFK
            LEFT JOIN master_pegawai_bpd mpb ON md.IdDesa = mpb.IdDesaFK
            GROUP BY mk.IdKecamatan, mk.Kecamatan
            ORDER BY mk.Kecamatan ASC");
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