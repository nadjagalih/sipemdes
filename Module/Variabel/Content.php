<?php
//PROFILE DINAS
if ($_GET['pg'] == 'ProfileDinasView') {
    include "ProfileDinas/ProfileDinasView.php";
}
if ($_GET['pg'] == 'ProfileDinasEdit') {
    include "ProfileDinas/ProfileDinasEdit.php";
}

//KECAMATAN
if ($_GET['pg'] == 'KecamatanView') {
    include "Kecamatan/KecamatanView.php";
}
if ($_GET['pg'] == 'KecamatanAdd') {
    include "Kecamatan/KecamatanAdd.php";   
}
if ($_GET['pg'] == 'KecamatanEdit') {
    include "Kecamatan/KecamatanEdit.php";
}

//DESA
if ($_GET['pg'] == 'DesaView') {
    include "Desa/DesaView.php";
}
if ($_GET['pg'] == 'DesaAdd') {
    include "Desa/DesaAdd.php";
}
if ($_GET['pg'] == 'DesaEdit') {
    include "Desa/DesaEdit.php";
}

//USER
if ($_GET['pg'] == 'UserView') {
    include "User/UserView.php";
}
if ($_GET['pg'] == 'UserAdd') {
    include "User/UserAdd.php";
}
if ($_GET['pg'] == 'UserEdit') {
    include "User/UserEdit.php";
}
if ($_GET['pg'] == 'UserReset') {
    include "User/UserReset.php";
}

//PEGAWAI
if ($_GET['pg'] == 'PegawaiViewAll') {
    include "Pegawai/PegawaiViewAll.php";
}
if ($_GET['pg'] == 'PegawaiAdd') {
    include "Pegawai/PegawaiAdd.php";
}
if ($_GET['pg'] == 'PegawaiEdit') {
    include "Pegawai/PegawaiEdit.php";
}
if ($_GET['pg'] == 'ViewFoto') {
    include "Pegawai/ViewFoto.php";
}
if ($_GET['pg'] == 'PegawaiDetail') {
    include "Pegawai/PegawaiDetail.php";
}

//JABATAN
if ($_GET['pg'] == 'JabatanView') {
    include "Jabatan/JabatanView.php";
}
if ($_GET['pg'] == 'JabatanAdd') {
    include "Jabatan/JabatanAdd.php";
}
if ($_GET['pg'] == 'JabatanEdit') {
    include "Jabatan/JabatanEdit.php";
}

//HOSTORY DATA SUAMI/ISTRI PEGAWAI
if ($_GET['pg'] == 'PegawaiViewSuamiIstri') {
    include "SuamiIstri/PegawaiViewSuamiIstri.php";
}
if ($_GET['pg'] == 'PegawaiAddSuamiIstri') {
    include "SuamiIstri/PegawaiAddSuamiIstri.php";
}
if ($_GET['pg'] == 'PegawaiDetailSuamiIstri') {
    include "SuamiIstri/PegawaiDetailSuamiIstri.php";
}
if ($_GET['pg'] == 'PegawaiEditSuamiIstri') {
    include "SuamiIstri/PegawaiEditSuamiIstri.php";
}

//HISTORY ANAK PEGAWAI
if ($_GET['pg'] == 'PegawaiViewAnak') {
    include "Anak/PegawaiViewAnak.php";
}
if ($_GET['pg'] == 'PegawaiAddAnak') {
    include "Anak/PegawaiAddAnak.php";
}
if ($_GET['pg'] == 'PegawaiDetailAnak') {
    include "Anak/PegawaiDetailAnak.php";
}
if ($_GET['pg'] == 'PegawaiEditAnak') {
    include "Anak/PegawaiEditAnak.php";
}

//HISTORY ORTU PEGAWAI
if ($_GET['pg'] == 'PegawaiViewOrtu') {
    include "OrangTua/PegawaiViewOrtu.php";
}
if ($_GET['pg'] == 'PegawaiAddOrtu') {
    include "OrangTua/PegawaiAddOrtu.php";
}
if ($_GET['pg'] == 'PegawaiDetailOrtu') {
    include "OrangTua/PegawaiDetailOrtu.php";
}
if ($_GET['pg'] == 'PegawaiEditOrtu') {
    include "OrangTua/PegawaiEditOrtu.php";
}

//JENIS MUTASI
if ($_GET['pg'] == 'MutasiView') {
    include "JenisMutasi/MutasiView.php";
}
if ($_GET['pg'] == 'MutasiAdd') {
    include "JenisMutasi/MutasiAdd.php";
}
if ($_GET['pg'] == 'MutasiEdit') {
    include "JenisMutasi/MutasiEdit.php";
}

//JENIS SEKOLAH
if ($_GET['pg'] == 'PegawaiViewPendidikan') {
    include "Pendidikan/PegawaiViewPendidikan.php";
}
if ($_GET['pg'] == 'PegawaiAddPendidikan') {
    include "Pendidikan/PegawaiAddPendidikan.php";
}
if ($_GET['pg'] == 'PegawaiDetailPendidikan') {
    include "Pendidikan/PegawaiDetailPendidikan.php";
}
if ($_GET['pg'] == 'PegawaiEditPendidikan') {
    include "Pendidikan/PegawaiEditPendidikan.php";
}
if ($_GET['pg'] == 'PegawaiEditPendidikan') {
    include "Pendidikan/PegawaiEditPendidikan.php";
}

//MUTASI
if ($_GET['pg'] == 'ViewMutasi') {
    include "Mutasi/ViewMutasi.php";
}
if ($_GET['pg'] == 'AddMutasi') {
    include "Mutasi/AddMutasi.php";
}
if ($_GET['pg'] == 'DetailMutasi') {
    include "Mutasi/DetailMutasi.php";
}
if ($_GET['pg'] == 'EditMutasi') {
    include "Mutasi/EditMutasi.php";
}
if ($_GET['pg'] == 'EditMutasiSK') {
    include "Mutasi/EditMutasiSK.php";
}

//PEGAWAI BPD
if ($_GET['pg'] == 'PegawaiBPDViewAll') {
    include "PegawaiBPD/PegawaiBPDViewAll.php";
}
if ($_GET['pg'] == 'PegawaiBPDAdd') {
    include "PegawaiBPD/PegawaiBPDAdd.php";
}
if ($_GET['pg'] == 'PegawaiBPDEdit') {
    include "PegawaiBPD/PegawaiBPDEdit.php";
}
if ($_GET['pg'] == 'BPDViewFoto') {
    include "PegawaiBPD/BPDViewFoto.php";
}

//REPORT MASA PENSIUN
if ($_GET['pg'] == 'ViewMasaPensiun') {
    include "Report/Pensiun/ViewMasaPensiun.php";
}
if ($_GET['pg'] == 'ViewMasaPensiunKades') {
    include "Report/Pensiun/ViewMasaPensiunKades.php";
}
if ($_GET['pg'] == 'FilterKecamatan') {
    include "Report/Pensiun/FilterKecamatan.php";
}
if ($_GET['pg'] == 'FilterKecamatanKades') {
    include "Report/Pensiun/FilterKecamatanKades.php";
}
if ($_GET['pg'] == 'PDFFilterKecamatan') {
    include "Report/Pensiun/PDFFilterKecamatan.php";
}
if ($_GET['pg'] == 'PDFFilterKecamatanKades') {
    include "Report/Pensiun/PDFFilterKecamatanKades.php";
}
if ($_GET['pg'] == 'FilterDesa') {
    include "Report/Pensiun/FilterDesa.php";
}
if ($_GET['pg'] == 'PDFFilterDesa') {
    include "Report/Pensiun/PDFFilterDesa.php";
}

// REPORT PENSIUN
if ($_GET['pg'] == 'ViewPensiun') {
    include "Report/Pensiun/ViewPensiun.php";
}
if ($_GET['pg'] == 'PensiunFilterKecamatan') {
    include "Report/Pensiun/PensiunFilterKecamatan.php";
}
if ($_GET['pg'] == 'PensiunPDFFilterKecamatan') {
    include "Report/Pensiun/PensiunPDFFilterKecamatan.php";
}
if ($_GET['pg'] == 'PensiunFilterDesa') {
    include "Report/Pensiun/PensiunFilterDesa.php";
}
if ($_GET['pg'] == 'PensiunPDFFilterDesa') {
    include "Report/Pensiun/PensiunPDFFilterDesa.php";
}

//REPORT PEGAWAI
if ($_GET['pg'] == 'ViewPegawaiReport') {
    include "Report/Pegawai/ViewPegawaiReport.php";
}
if ($_GET['pg'] == 'PegawaiFilterKecamatan') {
    include "Report/Pegawai/PegawaiFilterKecamatan.php";
}
if ($_GET['pg'] == 'PegawaiPDFFilterKecamatan') {
    include "Report/Pegawai/PegawaiPDFFilterKecamatan.php";
}
if ($_GET['pg'] == 'PegawaiFilterDesa') {
    include "Report/Pegawai/PegawaiFilterDesa.php";
}
if ($_GET['pg'] == 'PegawaiPDFFilterDesa') {
    include "Report/Pegawai/PegawaiPDFFilterDesa.php";
}

if ($_GET['pg'] == 'JabatanPegawaiTerkini') {
    include "Report/Pegawai/JabatanPegawaiTerkini.php";
}
if ($_GET['pg'] == 'TerkiniPegawaiFilterKecamatan') {
    include "Report/Pegawai/TerkiniPegawaiFilterKecamatan.php";
}
if ($_GET['pg'] == 'TerkiniPegawaiPDFFilterKecamatan') {
    include "Report/Pegawai/TerkiniPegawaiPDFFilterKecamatan.php";
}
if ($_GET['pg'] == 'TerkiniPegawaiFilterDesa') {
    include "Report/Pegawai/TerkiniPegawaiFilterDesa.php";
}
if ($_GET['pg'] == 'TerkiniPegawaiPDFFilterDesa') {
    include "Report/Pegawai/TerkiniPegawaiPDFFilterDesa.php";
}
if ($_GET['pg'] == 'TerkiniPegawaiPDFFilterKabupaten') {
    include "Report/Pegawai/TerkiniPegawaiPDFFilterKabupaten.php";
}


//REPORT BPD
if ($_GET['pg'] == 'ReportBPD') {
    include "Report/BPD/ReportBPD.php";
}
if ($_GET['pg'] == 'BPDFilterKecamatan') {
    include "Report/BPD/BPDFilterKecamatan.php";
}
if ($_GET['pg'] == 'BPDFilterDesa') {
    include "Report/BPD/BPDFilterDesa.php";
}
if ($_GET['pg'] == 'BPDPDFFilterKecamatan') {
    include "Report/BPD/BPDPDFFilterKecamatan.php";
}
if ($_GET['pg'] == 'BPDPDFFilterDesa') {
    include "Report/BPD/BPDPDFFilterDesa.php";
}

//REPORT PENDIDIKAN
if ($_GET['pg'] == 'ReportPendidikan') {
    include "Report/Pendidikan/ReportPendidikan.php";
}
if ($_GET['pg'] == 'PendidikanFilterKecamatan') {
    include "Report/Pendidikan/PendidikanFilterKecamatan.php";
}
if ($_GET['pg'] == 'PendidikanFilterDesa') {
    include "Report/Pendidikan/PendidikanFilterDesa.php";
}
if ($_GET['pg'] == 'PendidikanPDFFilterKecamatan') {
    include "Report/Pendidikan/PendidikanPDFFilterKecamatan.php";
}
if ($_GET['pg'] == 'PendidikanPDFFilterDesa') {
    include "Report/Pendidikan/PendidikanPDFFilterDesa.php";
}

//REPORT UNIT KERJA
if ($_GET['pg'] == 'ReportUnitKerja') {
    include "Report/UnitKerja/ReportUnitKerja.php";
}
if ($_GET['pg'] == 'ViewPdfUnitKerjaKecamatan') {
    include "Report/UnitKerja/ViewPdfUnitKerjaKecamatan.php";
}

if ($_GET['pg'] == 'ViewPdfGender') {
    include "Report/UnitKerja/ViewPdfGender.php";
}

//DASHBOARD
if ($_GET['pg'] == 'SAdmin') {
    include "Dashboard/SAdmin.php";
}


//ADMIN DESA ==================================
if ($_GET['pg'] == 'Admin') {
    include "AdminDesa/Dashboard/Admin.php";
}

//USER DESA
if ($_GET['pg'] == 'UserViewAdminDesa') {
    include "AdminDesa/User/UserView.php";
}
if ($_GET['pg'] == 'UserAddAdminDesa') {
    include "AdminDesa/User/UserAdd.php";
}
if ($_GET['pg'] == 'UserEditAdminDesa') {
    include "AdminDesa/User/UserEdit.php";
}
if ($_GET['pg'] == 'UserResetAdminDesa') {
    include "AdminDesa/User/UserReset.php";
}

//PEGAWAI DESA
if ($_GET['pg'] == 'PegawaiViewAllAdminDesa') {
    include "AdminDesa/Pegawai/PegawaiViewAll.php";
}
if ($_GET['pg'] == 'PegawaiAddAdminDesa') {
    include "AdminDesa/Pegawai/PegawaiAdd.php";
}
if ($_GET['pg'] == 'PegawaiEditAdminDesa') {
    include "AdminDesa/Pegawai/PegawaiEdit.php";
}
if ($_GET['pg'] == 'ViewFotoAdminDesa') {
    include "AdminDesa/Pegawai/ViewFoto.php";
}
if ($_GET['pg'] == 'PegawaiDetailAdminDesa') {
    include "AdminDesa/Pegawai/PegawaiDetail.php";
}

//PEGAWAI BPD
if ($_GET['pg'] == 'PegawaiBPDViewAllAdminDesa') {
    include "AdminDesa/PegawaiBPD/PegawaiBPDViewAll.php";
}
if ($_GET['pg'] == 'PegawaiBPDAddAdminDesa') {
    include "AdminDesa/PegawaiBPD/PegawaiBPDAdd.php";
}
if ($_GET['pg'] == 'PegawaiBPDEditAdminDesa') {
    include "AdminDesa/PegawaiBPD/PegawaiBPDEdit.php";
}
if ($_GET['pg'] == 'BPDViewFotoAdminDesa') {
    include "AdminDesa/PegawaiBPD/BPDViewFoto.php";
}

//HOSTORY DATA SUAMI/ISTRI PEGAWAI
if ($_GET['pg'] == 'PegawaiViewSuamiIstriAdminDesa') {
    include "AdminDesa/SuamiIstri/PegawaiViewSuamiIstri.php";
}
if ($_GET['pg'] == 'PegawaiAddSuamiIstriAdminDesa') {
    include "AdminDesa/SuamiIstri/PegawaiAddSuamiIstri.php";
}
if ($_GET['pg'] == 'PegawaiDetailSuamiIstriAdminDesa') {
    include "AdminDesa/SuamiIstri/PegawaiDetailSuamiIstri.php";
}
if ($_GET['pg'] == 'PegawaiEditSuamiIstriAdminDesa') {
    include "AdminDesa/SuamiIstri/PegawaiEditSuamiIstri.php";
}

//HISTORY ANAK PEGAWAI
if ($_GET['pg'] == 'PegawaiViewAnakAdminDesa') {
    include "AdminDesa/Anak/PegawaiViewAnak.php";
}
if ($_GET['pg'] == 'PegawaiAddAnakAdminDesa') {
    include "AdminDesa/Anak/PegawaiAddAnak.php";
}
if ($_GET['pg'] == 'PegawaiDetailAnakAdminDesa') {
    include "AdminDesa/Anak/PegawaiDetailAnak.php";
}
if ($_GET['pg'] == 'PegawaiEditAnakAdminDesa') {
    include "AdminDesa/Anak/PegawaiEditAnak.php";
}

//HISTORY ORTU PEGAWAI
if ($_GET['pg'] == 'PegawaiViewOrtuAdminDesa') {
    include "AdminDesa/OrangTua/PegawaiViewOrtu.php";
}
if ($_GET['pg'] == 'PegawaiAddOrtuAdminDesa') {
    include "AdminDesa/OrangTua/PegawaiAddOrtu.php";
}
if ($_GET['pg'] == 'PegawaiDetailOrtuAdminDesa') {
    include "AdminDesa/OrangTua/PegawaiDetailOrtu.php";
}
if ($_GET['pg'] == 'PegawaiEditOrtuAdminDesa') {
    include "AdminDesa/OrangTua/PegawaiEditOrtu.php";
}

//JENIS SEKOLAH
if ($_GET['pg'] == 'PegawaiViewPendidikanAdminDesa') {
    include "AdminDesa/Pendidikan/PegawaiViewPendidikan.php";
}
if ($_GET['pg'] == 'PegawaiAddPendidikanAdminDesa') {
    include "AdminDesa/Pendidikan/PegawaiAddPendidikan.php";
}
if ($_GET['pg'] == 'PegawaiDetailPendidikanAdminDesa') {
    include "AdminDesa/Pendidikan/PegawaiDetailPendidikan.php";
}
if ($_GET['pg'] == 'PegawaiEditPendidikanAdminDesa') {
    include "AdminDesa/Pendidikan/PegawaiEditPendidikan.php";
}

//MUTASI
if ($_GET['pg'] == 'ViewMutasiAdminDesa') {
    include "AdminDesa/Mutasi/ViewMutasi.php";
}
if ($_GET['pg'] == 'AddMutasiAdminDesa') {
    include "AdminDesa/Mutasi/AddMutasi.php";
}
if ($_GET['pg'] == 'DetailMutasiAdminDesa') {
    include "AdminDesa/Mutasi/DetailMutasi.php";
}
if ($_GET['pg'] == 'EditMutasiAdminDesa') {
    include "AdminDesa/Mutasi/EditMutasi.php";
}
if ($_GET['pg'] == 'EditMutasiSKAdminDesa') {
    include "AdminDesa/Mutasi/EditMutasiSK.php";
}

//REPORT PEGAWAI
if ($_GET['pg'] == 'ViewPegawaiReportAdminDesa') {
    include "AdminDesa/Report/Pegawai/ViewPegawaiReport.php";
}
//REPORT MASA PENSIUN
if ($_GET['pg'] == 'ViewMasaPensiunAdminDesa') {
    include "AdminDesa/Report/Pensiun/ViewMasaPensiun.php";
}
if ($_GET['pg'] == 'ViewMasaPensiunAdminDesaKades') {
    include "AdminDesa/Report/Pensiun/ViewMasaPensiunKades.php";
}
// REPORT PENSIUN
if ($_GET['pg'] == 'ViewPensiunAdminDesa') {
    include "AdminDesa/Report/Pensiun/ViewPensiun.php";
}
if ($_GET['pg'] == 'ViewAllMasaPensiunAdminDesa') {
    include "AdminDesa/Report/Pensiun/ViewAllMasaPensiunAdminDesa.php";
}
//JABATAN TERKINI
if ($_GET['pg'] == 'JabatanPegawaiTerkiniAdminDesa') {
    include "AdminDesa/Report/Pegawai/JabatanPegawaiTerkini.php";
}

//REPORT PENDIDIKAN
if ($_GET['pg'] == 'ReportPendidikanAdminDesa') {
    include "AdminDesa/Report/Pendidikan/ReportPendidikan.php";
}

//REPORT CUSTOM
if ($_GET['pg'] == 'ViewCustomUmur') {
    include "Report/Custom/ViewCustomUmur.php";
}
if ($_GET['pg'] == 'CustomUmurPDFFilterKecamatan') {
    include "Report/Custom/CustomUmurPDFFilterKecamatan.php";
}

if ($_GET['pg'] == 'ViewCustomSiltap') {
    include "Report/Custom/ViewCustomSiltap.php";
}
if ($_GET['pg'] == 'CustomSiltapPDFFilterKecamatan') {
    include "Report/Custom/CustomSiltapPDFFilterKecamatan.php";
}

if ($_GET['pg'] == 'ViewCustomGender') {
    include "Report/Custom/ViewCustomGender.php";
}


//REPORT BPD
if ($_GET['pg'] == 'ReportBPDAdminDesa') {
    include "AdminDesa/Report/BPD/ReportBPD.php";
}

//USER DASHBOARD
if ($_GET['pg'] == 'User') {
    include "UserDesa/Dashboard/User.php";
}

//MUTASI REPORT KECAMATAN DESA
if ($_GET['pg'] == 'PegawaiFilterKecamatanMutasi') {
    include "Report/Mutasi/PegawaiFilterKecamatanMutasi.php";
}
if ($_GET['pg'] == 'PegawaiPDFFilterKecamatanMutasi') {
    include "Report/Mutasi/PegawaiPDFFilterKecamatanMutasi.php";
}
if ($_GET['pg'] == 'PegawaiFilterDesaMutasi') {
    include "Report/Mutasi/PegawaiFilterDesaMutasi.php";
}
if ($_GET['pg'] == 'PegawaiPDFFilterDesaMutasi') {
    include "Report/Mutasi/PegawaiPDFFilterDesaMutasi.php";
}

if ($_GET['pg'] == 'Pass') {
    include "Pass/Pass.php";
}

if ($_GET['pg'] == 'PassKecamatan') {
    include "UserKecamatan/Pass/Pass.php";
}


if ($_GET['pg'] == 'PegawaiEditAdminAplikasi') {
    include "AdminDesa/Aplikasi/AdminEdit.php";
}

if ($_GET['pg'] == 'PegawaiEditAdminAplikasiKab') {
    include "Aplikasi/AdminEditKab.php";
}

if ($_GET['pg'] == 'ViewAdminAplikasi') {
    include "Aplikasi/ViewAdminAplikasi.php";
}

//USER DASHBOARD
if ($_GET['pg'] == 'Kecamatan') {
    include "UserKecamatan/Dashboard/AdminKecamatan.php";
}

//USER KECAMATAN
if ($_GET['pg'] == 'UserViewKecamatan') {
    include "UserKecamatan/UserViewKecamatan.php";
}
if ($_GET['pg'] == 'UserAddKecamatan') {
    include "UserKecamatan/UserAddKecamatan.php";
}
if ($_GET['pg'] == 'UserEditKecamatan') {
    include "UserKecamatan/UserEditKecamatan.php";
}
if ($_GET['pg'] == 'UserResetKecamatan') {
    include "UserKecamatan/UserResetKecamatan.php";
}


//=========================================
//REPORT KECAMATAN
if ($_GET['pg'] == 'ViewPegawaiReportKec') {
    include "UserKecamatan/Report/ViewPegawaiReport.php";
}

if ($_GET['pg'] == 'PegawaiFilterDesaKec') {
    include "UserKecamatan/Report/PegawaiFilterDesa.php";
}
if ($_GET['pg'] == 'PegawaiPDFFilterDesaKec') {
    include "UserKecamatan/Report/PegawaiPDFFilterDesa.php";
}

//REPORT MASA PENSIUN KECAMATAN
if ($_GET['pg'] == 'ViewMasaPensiunKec') {
    include "UserKecamatan/Report/Pensiun/ViewMasaPensiun.php";
}
if ($_GET['pg'] == 'ViewMasaPensiunKadesKec') {
    include "UserKecamatan/Report/Pensiun/ViewMasaPensiunKades.php";
}

if ($_GET['pg'] == 'PDFFilterKecamatanKadesKec') {
    include "UserKecamatan/Report/Pensiun/PDFFilterKecamatanKades.php";
}

// REPORT PENSIUN KECAMATAN
if ($_GET['pg'] == 'ViewPensiunKec') {
    include "UserKecamatan/Report/Pensiun/ViewPensiun.php";
}
if ($_GET['pg'] == 'PensiunFilterDesaKec') {
    include "UserKecamatan/Report/Pensiun/PensiunFilterDesa.php";
}
if ($_GET['pg'] == 'PensiunPDFFilterDesaKec') {
    include "UserKecamatan/Report/Pensiun/PensiunPDFFilterDesa.php";
}

if ($_GET['pg'] == 'FilterDesaKec') {
    include "UserKecamatan/Report/MasaPensiun/FilterDesa.php";
}
if ($_GET['pg'] == 'PDFFilterDesaKec') {
    include "UserKecamatan/Report/MasaPensiun/PDFFilterDesa.php";
}

if ($_GET['pg'] == 'ReportBPDKec') {
    include "UserKecamatan/BPD/ReportBPD.php";
}

if ($_GET['pg'] == 'BPDFilterDesaKec') {
    include "UserKecamatan/BPD/BPDFilterDesa.php";
}

if ($_GET['pg'] == 'BPDPDFFilterDesaKec') {
    include "UserKecamatan/BPD/BPDPDFFilterDesa.php";
}

//REPORT EXCEL
if ($_GET['pg'] == 'ViewPegawaiReportExcel') {
    include "Report/Pegawai/ViewPegawaiReportExcel.php";
}

//FILE UPLOAD DESA
if($_GET['pg'] == 'FileUploadDesa') {
    include "AdminDesa/File/FileUploadDesa.php";
}
if($_GET['pg'] == 'FileViewDesa') {
    include "AdminDesa/File/FileViewDesa.php";
}

//FILE UPLOAD KECAMATAN
if($_GET['pg'] == 'FileUploadKecamatan') {
    include "UserKecamatan/File/FileUploadKecamatan.php";
}
if($_GET['pg'] == 'FileViewKecamatan') {
    include "UserKecamatan/File/FileViewKecamatan.php";
}

//FILE UPLOAD KABUPATEN
if($_GET['pg'] == 'FileUploadAdmin') {
    include "File/FileUpload.php";
}
if($_GET['pg'] == 'FileViewAdmin') {
    include "File/FileView.php";
}

//UPLOAD SK PENSIUN KABUPATEN
if ($_GET['pg'] == 'UploadSKPensiun') {
    include "Report/Pensiun/UploadSKPensiun.php";
}

//USER FILE UPLOAD
if ($_GET['pg'] == 'FileUploadPengajuan') {
    include "UserDesa/FileUpload/FileUploadPengajuan.php";
}

// DATA MASTER KATEGORI FILE
if ($_GET['pg'] == 'FileKategoriAdd') {
    include "File/FileKategoriAdd.php";
}
if ($_GET['pg'] == 'FileKategoriEdit') {
    include "File/FileKategoriEdit.php";
}
if ($_GET['pg'] == 'FileKategoriView') {
    include "File/FileKategoriView.php";
}