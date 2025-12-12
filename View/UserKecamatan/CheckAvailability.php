<?php
// Include security configuration
require_once "../../Module/Security/Security.php";

// Set CORS headers for AJAX requests
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: text/html; charset=UTF-8');

// Handle preflight requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

// Start session only if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
error_reporting(E_ERROR | E_WARNING | E_PARSE);

// Use absolute path for database connection
require_once __DIR__ . "/../../Module/Config/Env.php";

if (!empty($_POST["UserNama"])) {
    // Escape input to prevent SQL injection
    $userNama = mysqli_real_escape_string($db, $_POST["UserNama"]);
    $Result = mysqli_query($db, "SELECT * FROM main_user_kecamatan WHERE NameAkses LIKE '$userNama'");
    $row = mysqli_fetch_row($Result);
    if ($row > 0) {
        echo "<span class='status-no-sukses'> <b>Username Sudah Terpakai, Silahkan Cari Yang Lain !!!!</b></span>";
    } else {
        echo "<span class='status-sukses'> <b>Username Dapat Dipakai, Silahkan Lanjut</b></span>";
?>
        <div class="form-group row"><label class="col-lg-4 col-form-label">Password</label>
            <div class="col-lg-8">
                <input type="password" name="Pass" id="Pass" placeholder="Masukkan Password" class="form-control" required autocomplete="off">
                <span class="form-text m-b-none" style="font-style: italic;">*) Minimal Panjang Password 5 Karakter</span>
            </div>
        </div>
        <div class="form-group row"><label class="col-lg-4 col-form-label">Hak Akses</label>
            <div class="col-lg-8">
                <?php 
                $EditIdUser = ''; // Define variable for new user (empty for add mode)
                include "../../App/Control/FunctionSelectAksesKecamatan.php"; 
                ?>
            </div>
        </div>
        <!-- <div class="form-group row"><label class="col-lg-4 col-form-label">NIK</label>
                            <script>
                                function hanyaAngka(evt) {
                                    var charCode = (evt.which) ? evt.which : event.keyCode
                                    if (charCode > 31 && (charCode < 48 || charCode > 57))

                                        return false;
                                    return true;
                                }
                            </script>
                            <div class="col-lg-8"><input type="text" name="NIK" id="NIK" placeholder="Masukkan NIK" class="form-control" required autocomplete="off" onkeypress="return hanyaAngka(event)">
                            </div>
                        </div> -->
        <div class="form-group row"><label class="col-lg-4 col-form-label">Nama</label>
            <div class="col-lg-8"><input type="text" name="Nama" id="Nama" placeholder="Masukkan Nama" class="form-control" required autocomplete="off">
            </div>
        </div>

        <div class="form-group row"><label class="col-lg-4 col-form-label">Kecamatan</label>
            <div class="col-lg-8">
                <?php 
                $EditIdKecamatanFK = ''; // Define variable for new user (empty for add mode)
                include "../../App/Control/FunctionSelectKecamatanKec.php"; 
                ?>
            </div>
        </div>

        <div class="form-group row"><label class="col-lg-4 col-form-label">Status Login</label>
            <div class="col-lg-8">
                <select name="Status" id="Status" style="width: 100%;" class="select2_akses form-control" required>
                    <option value="">Pilih Status</option>
                    <option value="1">AKTIF</option>
                    <option value="0">NON AKTIF</option>
                </select>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-lg-offset-2 col-lg-10">
                <button class="btn btn-primary" type="submit" name="Save" id="Save">Save</button>
                <a href="?pg=UserViewKecamatan" class="btn btn-success ">Batal</a>
            </div>
        </div>
<?php
    }
}
