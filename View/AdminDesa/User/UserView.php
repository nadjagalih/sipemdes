<?php
// Universal notification system using SweetAlert2 (Swal.fire) - CSP compliant
$alert = isset($_GET['alert']) ? $_GET['alert'] : '';

if (!empty($alert)) {
    $notifications = [
        'Save' => ['title' => 'Berhasil!', 'text' => 'Data berhasil disimpan', 'icon' => 'success'],
        'Edit' => ['title' => 'Berhasil!', 'text' => 'Data berhasil diubah', 'icon' => 'success'],
        'Delete' => ['title' => 'Berhasil!', 'text' => 'Data berhasil dihapus', 'icon' => 'success'],
        'Reset' => ['title' => 'Berhasil!', 'text' => 'Password berhasil direset', 'icon' => 'success'],
        'CekUser' => ['title' => 'Perhatian', 'text' => 'Username yang Anda masukkan sudah terdaftar', 'icon' => 'warning'],
        'Karakter' => ['title' => 'Perhatian', 'text' => 'Panjang minimal password 5 karakter', 'icon' => 'warning'],
        'NoPasswordChange' => ['title' => 'Info', 'text' => 'Password tidak diubah. Masukkan password baru untuk mengubah password.', 'icon' => 'info'],
        'EmptyPassword' => ['title' => 'Info', 'text' => 'Password tidak boleh kosong. Silakan masukkan password baru.', 'icon' => 'info'],
        'CekDelete' => ['title' => 'Tidak Dapat Dihapus', 'text' => 'Data tidak bisa dihapus, karena sudah mempunyai history', 'icon' => 'warning'],
        'ErrorDelete' => ['title' => 'Gagal', 'text' => 'Terjadi kesalahan saat menghapus data', 'icon' => 'error'],
        'NoRowsAffected' => ['title' => 'Error', 'text' => 'Reset password gagal - User ID tidak ditemukan', 'icon' => 'error'],
        'QueryError' => ['title' => 'Error', 'text' => 'Reset password gagal - Database query error', 'icon' => 'error']
    ];
    
    if (array_key_exists($alert, $notifications)) {
        $notif = $notifications[$alert];
        
        echo "<script " . CSPHandler::scriptNonce() . ">\n";
        echo "  document.addEventListener('DOMContentLoaded', function() {\n";
        echo "    if (typeof Swal !== 'undefined') {\n";
        echo "      Swal.fire({\n";
        echo "        title: '" . addslashes($notif['title']) . "',\n";
        echo "        text: '" . addslashes($notif['text']) . "',\n";
        echo "        icon: '" . $notif['icon'] . "',\n";
        echo "        confirmButtonText: 'OK',\n";
        echo "        confirmButtonColor: '#3085d6'\n";
        echo "      });\n";
        echo "    } else {\n";
        echo "      alert('" . addslashes($notif['title'] . ' - ' . $notif['text']) . "');\n";
        echo "    }\n";
        echo "  });\n";
        echo "</script>\n";
    }
}
?>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Data User</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="">Dashboard</a>
            </li>
            <li class="breadcrumb-item">
                <a>Setting</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>User</strong>
            </li>
        </ol>
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
        .dataTables-user tbody tr:hover {
            background-color: #f0f8ff !important;
        }
        
        /* Styling untuk sel tabel */
        .dataTables-user td {
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
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-user">
                            <thead style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%) !important;">
                                <tr style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%) !important;">
                                    <th style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%) !important; color: white !important; font-weight: bold !important; text-align: center !important;">No</th>
                                    <th style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%) !important; color: white !important; font-weight: bold !important; text-align: center !important;">Nama</th>
                                    <th style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%) !important; color: white !important; font-weight: bold !important; text-align: center !important;">Username</th>
                                    <th style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%) !important; color: white !important; font-weight: bold !important; text-align: center !important;">Password</th>
                                    <th style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%) !important; color: white !important; font-weight: bold !important; text-align: center !important;">Unit Kerja</th>
                                    <th style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%) !important; color: white !important; font-weight: bold !important; text-align: center !important;">Level</th>
                                    <th style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%) !important; color: white !important; font-weight: bold !important; text-align: center !important;">Status</th>
                                    <th style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%) !important; color: white !important; font-weight: bold !important; text-align: center !important;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php include "../App/Control/FunctionUserListAdminDesa.php"; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Script untuk mengatasi masalah pace loading yang tidak selesai -->
<script <?php echo CSPHandler::scriptNonce(); ?>>
    // Override DataTables configuration untuk halaman User - no buttons, no search
    $(document).ready(function() {
        // Destroy existing DataTable if any (dengan class yang berbeda)
        if ($.fn.DataTable.isDataTable('.dataTables-user')) {
            $('.dataTables-user').DataTable().destroy();
        }
        
        // Reinitialize dengan config khusus untuk User page
        $('.dataTables-user').DataTable({
            pageLength: 25,
            responsive: true,
            dom: 'rtip', // Hanya render: (r)esults, (t)able, (i)nfo, (p)agination - NO search (f), NO buttons (B)
            searching: false, // Disable search
            lengthChange: false,
            paging: true,
            info: true,
            order: [[0, 'asc']], // Sort by No column
            language: {
                paginate: {
                    previous: "Sebelumnya",
                    next: "Selanjutnya"
                },
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                infoEmpty: "Menampilkan 0 sampai 0 dari 0 data",
                zeroRecords: "Tidak ada data yang ditemukan"
            }
        });
    });

    // Function untuk konfirmasi hapus dengan SweetAlert2
    function confirmDelete(userId, userName) {
        console.log('confirmDelete called with:', userId, userName);
        
        // Check if SweetAlert2 is available
        if (typeof Swal === 'undefined') {
            console.error('SweetAlert2 not loaded, using browser confirm');
            if (confirm('Anda yakin ingin menghapus user: ' + userName + '?\n\nPerhatian: Semua data history terkait user ini akan ikut terhapus!')) {
                window.location.href = "../App/Model/ExcUserAdminDesa?Act=Delete&Kode=" + userId;
            }
            return;
        }

        Swal.fire({
            title: 'Konfirmasi Hapus',
            html: 'Anda yakin ingin menghapus user: <strong>' + userName + '</strong>?<br><br><span style="color: #dc3545;">⚠️ Perhatian: Semua data history terkait user ini akan ikut terhapus!</span>',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
            reverseButtons: true,
            focusCancel: true
        }).then((result) => {
            console.log('SweetAlert result:', result);
            if (result.isConfirmed) {
                // Show loading
                Swal.fire({
                    title: 'Menghapus Data...',
                    text: 'Mohon tunggu, sedang menghapus data user...',
                    icon: 'info',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                
                // Redirect to delete URL after short delay
                setTimeout(() => {
                    window.location.href = "../App/Model/ExcUserAdminDesa?Act=Delete&Kode=" + userId;
                }, 500);
            }
        }).catch((error) => {
            console.error('SweetAlert error:', error);
        });
    }

    // Alternative event listener approach
    document.addEventListener('DOMContentLoaded', function() {
        // Add click event listeners to all delete buttons
        const deleteButtons = document.querySelectorAll('[data-user-id]');
        deleteButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const userId = this.getAttribute('data-user-id');
                const userName = this.getAttribute('data-user-name');
                console.log('Delete button clicked via event listener:', userId, userName);
                confirmDelete(userId, userName);
            });
        });
        
        // Debug: Check if SweetAlert2 is loaded
        console.log('SweetAlert2 loaded:', typeof Swal !== 'undefined');
        console.log('Delete buttons found:', deleteButtons.length);
    });

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
</script>