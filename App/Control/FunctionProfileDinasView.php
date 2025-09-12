<?php
$QueryDinas = mysqli_query($db, "SELECT * FROM master_setting_profile_dinas");
$DataDinas = mysqli_fetch_assoc($QueryDinas);
$IdKabupaten = $DataDinas['IdKabupatenProfile'];
$Kabupaten = $DataDinas['Kabupaten'];
$Dinas = $DataDinas['PerangkatDaerah'];
$Alamat = $DataDinas['Alamat'];
