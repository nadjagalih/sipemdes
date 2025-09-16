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

        <style>
        /* Style Select2 untuk consistency dengan form design */
        .select2-container--default .select2-selection--single {
            border: 2px solid #e9ecef !important;
            border-radius: 8px !important;
            height: 45px !important;
            line-height: 41px !important;
            padding: 0 !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #495057 !important;
            padding-left: 15px !important;
            padding-right: 30px !important;
            line-height: 41px !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__placeholder {
            color: #6c757d !important;
            line-height: 41px !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 41px !important;
            right: 10px !important;
        }

        .select2-container--default.select2-container--focus .select2-selection--single {
            border-color: #007bff !important;
            box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25) !important;
        }

        .select2-dropdown {
            border: 1px solid #ced4da !important;
            border-radius: 8px !important;
        }
        </style>

        <script>
        $(document).ready(function() {
            // Initialize Select2 untuk semua dropdown dengan delay untuk memastikan DOM ready
            setTimeout(function() {
                // Destroy existing select2 instances if any
                if ($('#Status').hasClass('select2-hidden-accessible')) {
                    $('#Status').select2('destroy');
                }
                if ($('#Akses').hasClass('select2-hidden-accessible')) {
                    $('#Akses').select2('destroy');
                }
                if ($('#UnitKerja').hasClass('select2-hidden-accessible')) {
                    $('#UnitKerja').select2('destroy');
                }

                // Initialize dengan style yang consistent
                $('#Status').select2({
                    placeholder: "Pilih Status",
                    allowClear: true,
                    width: '100%',
                    minimumResultsForSearch: Infinity // Hide search box for simple dropdowns
                });

                $('#Akses').select2({
                    placeholder: "Pilih Hak Akses", 
                    allowClear: true,
                    width: '100%',
                    minimumResultsForSearch: Infinity
                });

                $('#UnitKerja').select2({
                    allowClear: false,
                    width: '100%',
                    minimumResultsForSearch: Infinity
                });

                // Initialize by class juga untuk backup
                $('.select2_akses').not('.select2-hidden-accessible').select2({
                    placeholder: "Pilih Opsi",
                    allowClear: true,
                    width: '100%',
                    minimumResultsForSearch: Infinity
                });

                $('.select2_desa').not('.select2-hidden-accessible').select2({
                    allowClear: false,
                    width: '100%',
                    minimumResultsForSearch: Infinity
                });

                console.log('Select2 initialized with consistent styling');
            }, 300);

            // Event handlers untuk debugging
            $(document).on('select2:select', '#Status', function (e) {
                console.log('Status selected: ' + e.params.data.text);
            });

            $(document).on('select2:select', '#Akses', function (e) {
                console.log('Akses selected: ' + e.params.data.text);
            });
        });
        </script>
<?php
    }
}
?>