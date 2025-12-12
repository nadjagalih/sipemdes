<?php
// Sistem Notifikasi Universal untuk PegawaiBPD - mengikuti pola PegawaiDetail.php
if (isset($_GET['alert'])) {
    $alert = isset($_GET['alert']) ? sql_injeksi($_GET['alert']) : '';
    
    // Konfigurasi pesan berdasarkan jenis alert
    $notifications = [
        'Cek' => ['title' => 'Peringatan!', 'message' => 'Extention Yang Dimasukkan Tidak Sesuai', 'icon' => 'warning'],
        'Edit' => ['title' => 'Berhasil!', 'message' => 'Data BPD berhasil disimpan', 'icon' => 'success'],
        'Save' => ['title' => 'Berhasil!', 'message' => 'Data BPD berhasil disimpan', 'icon' => 'success'],
        'Delete' => ['title' => 'Berhasil!', 'message' => 'Data BPD berhasil dihapus', 'icon' => 'success'],
        'Kosong' => ['title' => 'Peringatan!', 'message' => 'Tidak Ada File Yang Diupload', 'icon' => 'warning'],
        'FileMax' => ['title' => 'Peringatan!', 'message' => 'Data Tidak Dapat Disimpan, Ukuran File Melebihi 2 MB', 'icon' => 'warning'],
    ];
    
    // Cek apakah alert ada dalam konfigurasi
    if (array_key_exists($alert, $notifications)) {
        $notification = $notifications[$alert];
        $swalType = ($notification['icon'] == 'success') ? 'success' : (($notification['icon'] == 'error') ? 'error' : 'warning');
        
        // Enhanced CSP nonce generation with fallback - sama seperti PegawaiDetail.php
        $nonce = '';
        $nonceAttr = '';
        
        if (class_exists('CSPHandler')) {
            try {
                $nonce = CSPHandler::scriptNonce();
                $nonceAttr = $nonce;
            } catch (Exception $e) {
                error_log("CSPHandler error in notification: " . $e->getMessage());
                $nonceAttr = ''; // Fallback tanpa nonce
            }
        } else {
            // Manual nonce generation sebagai fallback
            if (function_exists('random_bytes')) {
                $manualNonce = base64_encode(random_bytes(16));
                $nonceAttr = 'nonce="' . $manualNonce . '"';
                error_log("Manual nonce generated for notification: " . $manualNonce);
            } else {
                error_log("No CSP nonce available for notification script");
                $nonceAttr = ''; // Fallback tanpa nonce
            }
        }
        
        echo '<script ' . $nonceAttr . '>
            document.addEventListener("DOMContentLoaded", function() {
                // Debug untuk memastikan script dipanggil dengan CSP compliance
                console.log("CSP-compliant notification script loaded with alert: ' . $alert . '");
                
                // Pastikan SweetAlert2 sudah ter-load
                if (typeof Swal !== "undefined") {
                    console.log("SweetAlert2 detected, showing CSP-compliant notification");
                    Swal.fire({
                        title: "' . addslashes($notification['title']) . '",
                        text: "' . addslashes($notification['message']) . '",
                        icon: "' . $swalType . '",
                        showConfirmButton: true,
                        confirmButtonText: "OK",
                        confirmButtonColor: "#3085d6",
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        customClass: {
                            container: "notification-swal"
                        },
                        zIndex: 10000
                    });
                } else {
                    console.error("SweetAlert2 not available, using fallback");
                    alert("' . addslashes($notification['title']) . ': ' . addslashes($notification['message']) . '");
                }
            });
        </script>';
    }
}
?>


<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Data BPD</h2>
    </div>
    <div class="col-lg-2">

    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <style>
        /* Custom styling untuk header tabel agar sesuai dengan warna sidebar */
        .dataTables-kecamatan thead th {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%) !important;
            color: white !important;
            font-weight: bold !important;
            text-align: center !important;
            border: 1px solid #1e3c72 !important;
            padding: 12px 8px !important;
        }
        
        .dataTables-kecamatan thead tr {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%) !important;
        }
        
        /* Override untuk DataTables sorting */
        .dataTables-kecamatan thead th.sorting,
        .dataTables-kecamatan thead th.sorting_asc,
        .dataTables-kecamatan thead th.sorting_desc {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%) !important;
            color: white !important;
        }
        
        /* Styling untuk baris tabel */
        .dataTables-kecamatan tbody tr:hover {
            background-color: #f0f8ff !important;
        }
        
        /* Styling untuk sel tabel */
        .dataTables-kecamatan td {
            border: 1px solid #dee2e6 !important;
            vertical-align: middle !important;
            padding: 8px !important;
        }
        
        /* Override Bootstrap default */
        .table-striped > thead > tr > th {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%) !important;
            color: white !important;
        }
    </style>
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-content">
                    <div class="ibox">
                        <a href="?pg=PegawaiBPDAddAdminDesa" class="btn btn-primary btn-xl"> 
                            <i class="fa fa-plus"></i> Add Pegawai BPD
                        </a>
                        <a href="AdminDesa/PegawaiBPD/PdfReportBPD" target="_blank" class="btn btn-success btn-xl" style="margin-left: 10px;">
                            <i class="fa fa-file-pdf-o"></i> Cetak PDF
                        </a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-kecamatan">
                            <thead style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%) !important;">
                                <tr style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%) !important;">
                                    <th style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%) !important; color: white !important; font-weight: bold !important; text-align: center !important;">No</th>
                                    <th style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%) !important; color: white !important; font-weight: bold !important; text-align: center !important;">Foto</th>
                                    <th style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%) !important; color: white !important; font-weight: bold !important; text-align: center !important;">NIK</th>
                                    <th style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%) !important; color: white !important; font-weight: bold !important; text-align: center !important;">Nama<br>Alamat</th> 
                                    <th style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%) !important; color: white !important; font-weight: bold !important; text-align: center !important;">Tanggal Lahir<br>Jenis Kelamin</th>
                                    <th style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%) !important; color: white !important; font-weight: bold !important; text-align: center !important;">No Telepon</th>
                                    <th style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%) !important; color: white !important; font-weight: bold !important; text-align: center !important;">Unit Kerja<br>Kecamatan<br>Kabupaten</th>
                                    <th style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%) !important; color: white !important; font-weight: bold !important; text-align: center !important;">Jabatan</th>
                                    <th style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%) !important; color: white !important; font-weight: bold !important; text-align: center !important;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php include "../App/Control/FunctionPegawaiBPDListAllAdminDesa.php"; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Script untuk mengatasi masalah pace loading yang tidak selesai -->
<script <?php echo class_exists('CSPHandler') ? CSPHandler::scriptNonce() : ''; ?>>
    // Force pace loading to complete after page is fully loaded
    window.addEventListener('load', function() {
        // Wait a bit for all scripts to finish
        setTimeout(function() {
            // Force pace to complete if it's still running
            if (typeof Pace !== 'undefined' && Pace.running) {
                Pace.stop();
            }
            // Add pace-done class to body if not already present
            if (!document.body.classList.contains('pace-done')) {
                document.body.classList.add('pace-done');
            }
            // Hide any remaining pace elements
            var paceElements = document.querySelectorAll('.pace');
            paceElements.forEach(function(el) {
                el.style.display = 'none';
            });
        }, 1000); // Wait 1 second after page load
    });

    // Fallback - force pace to complete after DOM is ready
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(function() {
            if (typeof Pace !== 'undefined' && Pace.running) {
                Pace.stop();
            }
            document.body.classList.add('pace-done');
        }, 2000); // Wait 2 seconds after DOM ready
    });
    
    // Function untuk close notification bar
    function closeNotificationBar() {
        const notifBar = document.querySelector('.notification-bar');
        if (notifBar) {
            notifBar.style.animation = 'slideUp 0.3s ease-out forwards';
            setTimeout(() => {
                notifBar.style.display = 'none';
                // Store in localStorage untuk session ini
                localStorage.setItem('notifBarClosed', 'true');
            }, 300);
        }
    }
    
    // Check apakah notification bar sudah di-close sebelumnya
    document.addEventListener('DOMContentLoaded', function() {
        if (localStorage.getItem('notifBarClosed') === 'true') {
            const notifBar = document.querySelector('.notification-bar');
            if (notifBar) {
                notifBar.style.display = 'none';
            }
        }
    });
    
    
    // Event delegation untuk tombol delete - lebih aman untuk CSP
    document.addEventListener('click', function(e) {
        if (e.target.closest('.delete-btn')) {
            e.preventDefault();
            const button = e.target.closest('.delete-btn');
            const idPegawai = button.getAttribute('data-id');
            const namaPegawai = button.getAttribute('data-nama');
            
            if (typeof Swal !== 'undefined' && typeof Swal.fire === 'function') {
                Swal.fire({
                    title: 'Konfirmasi Hapus',
                    text: 'Anda yakin ingin menghapus data: ' + namaPegawai + '?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal',
                    allowOutsideClick: false,
                    allowEscapeKey: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Redirect ke URL delete
                        window.location.href = '../App/Model/ExcPegawaiBPDAdminDesa?Act=Delete&Kode=' + idPegawai;
                    }
                });
            } else {
                // Fallback ke confirm biasa jika SweetAlert tidak tersedia
                if (confirm('Anda yakin ingin menghapus data: ' + namaPegawai + '?')) {
                    window.location.href = '../App/Model/ExcPegawaiBPDAdminDesa?Act=Delete&Kode=' + idPegawai;
                }
            }
        }
    });
</script>