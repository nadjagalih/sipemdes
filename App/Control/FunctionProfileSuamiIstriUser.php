<div class="table-responsive">
    <table class="table table-striped table-bordered table-hover dataTables-kecamatan">
        <thead>
            <tr>
                <th>No</th>
                <th>NIK</th>
                <th>Nama</th>
                <th>Tempat<br>Tanggal Lahir</th>
                <th>Hubungan<br>Tanggal Nikah</th>
                <th>Pendidikan</th>
                <th>Pekerjaan</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $IdTemp = $_SESSION['IdUser'];
            $Nomor = 1;
            $QuerySuamiIstri = mysqli_query($db, "SELECT
                hiskel_suami_istri.IdPegawaiFK,
                master_pegawai.IdPegawaiFK,
                hiskel_suami_istri.IdPendidikanFK,
                master_pendidikan.IdPendidikan,
                hiskel_suami_istri.IdSuamiIstri,
                hiskel_suami_istri.NIK,
                hiskel_suami_istri.Nama,
                hiskel_suami_istri.Tempat,
                hiskel_suami_istri.TanggalLahir,
                hiskel_suami_istri.StatusHubungan,
                hiskel_suami_istri.TanggalNikah,
                master_pendidikan.JenisPendidikan,
                hiskel_suami_istri.Pekerjaan
                FROM
                hiskel_suami_istri
                INNER JOIN master_pegawai ON master_pegawai.IdPegawaiFK = hiskel_suami_istri.IdPegawaiFK
                INNER JOIN master_pendidikan ON hiskel_suami_istri.IdPendidikanFK = master_pendidikan.IdPendidikan
                WHERE
                hiskel_suami_istri.IdPegawaiFK = '$IdTemp'");
            while ($DataSuamiIstri = mysqli_fetch_assoc($QuerySuamiIstri)) {
                $IdSuamiIstri = $DataSuamiIstri['IdSuamiIstri'];
                $NIK = $DataSuamiIstri['NIK'];
                $Nama = $DataSuamiIstri['Nama'];
                $Tempat = $DataSuamiIstri['Tempat'];

                $TglLahir = $DataSuamiIstri['TanggalLahir'];
                $exp = explode('-', $TglLahir);
                $TanggalLahir = $exp[2] . "-" . $exp[1] . "-" . $exp[0];

                $Hubungan = $DataSuamiIstri['StatusHubungan'];

                $TglNikah = $DataSuamiIstri['TanggalNikah'];
                $exp = explode('-', $TglNikah);
                $TanggalNikah = $exp[2] . "-" . $exp[1] . "-" . $exp[0];

                $Pendidikan = $DataSuamiIstri['JenisPendidikan'];
                $Pekerjaan = $DataSuamiIstri['Pekerjaan'];

            ?>
                <tr class="gradeX">
                    <td>
                        <?php echo $Nomor; ?>
                    </td>
                    <td>
                        <?php echo $NIK; ?>
                    </td>
                    <td>
                        <?php echo $Nama; ?>
                    </td>
                    <td>
                        <?php echo $Tempat; ?><br>
                        <?php echo $TanggalLahir; ?>
                    </td>
                    <td>
                        <?php echo $Hubungan; ?><br>
                        <?php echo $TanggalNikah; ?>
                    </td>
                    <td>
                        <?php echo $Pendidikan; ?>
                    </td>
                    <td>
                        <?php echo $Pekerjaan; ?>
                    </td>
                </tr>
            <?php $Nomor++;
            }
            ?>
        </tbody>
    </table>
</div>