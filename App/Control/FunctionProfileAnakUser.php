 <div class="table-responsive">
     <table class="table table-striped table-bordered table-hover dataTables-kecamatan">
         <thead>
             <tr>
                 <th>No</th>
                 <th>Anak Dari</th>
                 <th>NIK</th>
                 <th>Nama</th>
                 <th>Tempat<br>Tanggal Lahir</th>
                 <th>Hubungan</th>
                 <th>Jenis Kelamin</th>
                 <th>Pendidikan</th>
                 <th>Pekerjaan</th>
             </tr>
         </thead>
         <tbody>
             <?php
                $IdTemp = $_SESSION['IdUser'];
                $Nomor = 1;
                $QueryAnak = mysqli_query($db, "SELECT
                    hiskel_anak.IdPegawaiFK,
                    master_pegawai.IdPegawaiFK,
                    master_pegawai.Nama AS NamaPegawai,
                    hiskel_anak.IdPendidikanFK,
                    master_pendidikan.IdPendidikan,
                    hiskel_anak.IdAnak,
                    hiskel_anak.NIK,
                    hiskel_anak.Nama,
                    hiskel_anak.Tempat,
                    hiskel_anak.TanggalLahir,
                    hiskel_anak.StatusHubungan,
                    hiskel_anak.JenKel,
                    master_pendidikan.JenisPendidikan,
                    hiskel_anak.Pekerjaan
                    FROM
                    hiskel_anak
                    INNER JOIN master_pegawai ON master_pegawai.IdPegawaiFK = hiskel_anak.IdPegawaiFK
                    INNER JOIN master_pendidikan ON hiskel_anak.IdPendidikanFK = master_pendidikan.IdPendidikan
                    WHERE hiskel_anak.IdPegawaiFK = '$IdTemp'");
                while ($DataAnak = mysqli_fetch_assoc($QueryAnak)) {
                    $IdAnak = $DataAnak['IdAnak'];
                    $NamaPegawai = $DataAnak['NamaPegawai'];
                    $NIK = $DataAnak['NIK'];
                    $Nama = $DataAnak['Nama'];
                    $Tempat = $DataAnak['Tempat'];

                    $TglLahir = $DataAnak['TanggalLahir'];
                    $exp = explode('-', $TglLahir);
                    $TanggalLahir = $exp[2] . "-" . $exp[1] . "-" . $exp[0];

                    $Hubungan = $DataAnak['StatusHubungan'];
                    $JenKel = $DataAnak['JenKel'];

                    $Pendidikan = $DataAnak['JenisPendidikan'];
                    $Pekerjaan = $DataAnak['Pekerjaan'];

                ?>
                 <tr class="gradeX">
                     <td>
                         <?php echo $Nomor; ?>
                     </td>
                     <td>
                         <?php echo $NamaPegawai; ?>
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
                     </td>
                     <td>
                         <?php
                            $QJenKel = mysqli_query($db, "SELECT * FROM master_jenkel WHERE IdJenKel = '$JenKel' ");
                            $DataJenKel = mysqli_fetch_assoc($QJenKel);
                            echo $JenisKelamin = $DataJenKel['Keterangan'];
                            ?>

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