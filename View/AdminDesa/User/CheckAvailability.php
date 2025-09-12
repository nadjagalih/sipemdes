<?php
session_start();
error_reporting(E_ALL ^ E_NOTICE);

require_once "../../../Module/Config/Env.php";

if (!empty($_POST["UserNama"])) {
    $Result = mysqli_query($db, "SELECT * FROM main_user WHERE NameAkses LIKE '" . $_POST["UserNama"] . "'");
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
                <?php include "../../../App/Control/FunctionSelectAksesAdminDesa.php"; ?>
            </div>
        </div>

        <div class="form-group row"><label class="col-lg-4 col-form-label">Nama</label>
            <div class="col-lg-8"><input type="text" name="Nama" id="Nama" placeholder="Masukkan Nama" class="form-control" required autocomplete="off">
            </div>
        </div>
        <div class="form-group row"><label class="col-lg-4 col-form-label">Unit Kerja Desa/Kelurahan</label>
            <div class="col-lg-8">
                <?php include "../../../App/Control/FunctionSelectUnitKerjaAdminDesa.php"; ?>
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
                <a href="?pg=UserViewAdminDesa" class="btn btn-success ">Batal</a>
            </div>
        </div>
<?php
    }
}
?>