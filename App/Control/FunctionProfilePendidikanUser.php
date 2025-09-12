<div class="table-responsive">
    <table class="table table-striped table-bordered table-hover dataTables-kecamatan">
        <thead>
            <tr>
                <th>No</th>
                <th>Tingkat</th>
                <th>Nama Sekolah</th>
                <th>Jurusan</th>
                <th>Thn Masuk - Thn Keluar</th>
                <th>Pendidikan Akhir</th>
                <th>No Ijasah <br>Tanggal Ijasah</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $IdTemp = $_SESSION['IdUser'];
            $Nomor = 1;
            $QueryPendidikan = mysqli_query($db, "SELECT
                master_pegawai.IdPegawaiFK,
                history_pendidikan.IdPegawaiFK,
                history_pendidikan.IdPendidikanFK,
                history_pendidikan.IdPendidikanPegawai,
                history_pendidikan.NamaSekolah,
                history_pendidikan.Jurusan,
                history_pendidikan.Setting,
                history_pendidikan.TahunMasuk,
                history_pendidikan.TahunLulus,
                history_pendidikan.NomorIjasah,
                history_pendidikan.TanggalIjasah,
                master_pendidikan.IdPendidikan,
                master_pegawai.NIK,
                master_pegawai.Nama,
                master_pendidikan.JenisPendidikan
                FROM
                master_pegawai
                INNER JOIN history_pendidikan ON master_pegawai.IdPegawaiFK = history_pendidikan.IdPegawaiFK
                INNER JOIN master_pendidikan ON history_pendidikan.IdPendidikanFK = master_pendidikan.IdPendidikan
                WHERE history_pendidikan.IdPegawaiFK = '$IdTemp'
                ORDER BY
                master_pendidikan.IdPendidikan DESC");
            while ($DataPendidikan = mysqli_fetch_assoc($QueryPendidikan)) {
                $IdPendidikanV = $DataPendidikan['IdPendidikanPegawai'];
                $NamaSekolah = $DataPendidikan['NamaSekolah'];
                $Jurusan = $DataPendidikan['Jurusan'];
                $JenjangPendidikan = $DataPendidikan['JenisPendidikan'];
                $Setting = $DataPendidikan['Setting'];
                $Masuk = $DataPendidikan['TahunMasuk'];
                $Lulus = $DataPendidikan['TahunLulus'];
                $NomorIjasah = $DataPendidikan['NomorIjasah'];
                $TglIjasah = $DataPendidikan['TanggalIjasah'];
                $exp = explode('-', $TglIjasah);
                $TanggalIjasah = $exp[2] . "-" . $exp[1] . "-" . $exp[0];

            ?>
                <tr class="gradeX">
                    <td>
                        <?php echo $Nomor; ?>
                    </td>
                    <td>
                        <?php echo $JenjangPendidikan; ?>

                    </td>
                    <td>
                        <?php echo $NamaSekolah; ?>
                    </td>
                    <td>
                        <?php echo $Jurusan; ?>
                    </td>
                    <td>
                        <?php echo $Masuk; ?> - <?php echo $Lulus; ?>
                    </td>
                    <td>
                        <?php if ($Setting == 0) { ?>
                            <span class="label label-warning float-left">NON AKTIF</span>
                            </a><?php } elseif ($Setting == 1) { ?>
                            <span class="label label-success float-left">AKTIF</span>
                        <?php } ?>
                    </td>
                    <td>
                        <?php echo $NomorIjasah; ?><br>
                        <?php echo $TanggalIjasah; ?>
                    </td>

                </tr>
            <?php $Nomor++;
            }
            ?>
        </tbody>
    </table>
</div>