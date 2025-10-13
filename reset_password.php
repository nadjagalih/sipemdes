<?php
/**
 * Web Interface Reset Password User - SIPEMDES
 * Interface web untuk mereset password user di tabel main_user
 */

session_start();
error_reporting(E_ALL ^ E_NOTICE);

// Include konfigurasi database
require_once "Module/Config/Env.php";

// Initialize database connection
$db = mysqli_connect($host, $username, $password, $database);
if (!$db) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

// Function untuk mendapatkan daftar user dengan pagination dan search
function getUsers($db, $search = '', $page = 1, $limit = 10) {
    $offset = ($page - 1) * $limit;
    $whereClause = '';

    if (!empty($search)) {
        $search = sql_injeksi($search);
        $whereClause = "WHERE main_user.NameAkses LIKE '%$search%' OR master_pegawai.Nama LIKE '%$search%'";
    }

    $sql = "SELECT 
                main_user.IdUser,
                main_user.NameAkses,
                main_user.IdLevelUserFK,
                main_user.StatusLogin,
                master_pegawai.Nama,
                master_desa.NamaDesa,
                CASE 
                    WHEN main_user.IdLevelUserFK = 1 THEN 'Super Admin'
                    WHEN main_user.IdLevelUserFK = 2 THEN 'Admin Kabupaten'
                    WHEN main_user.IdLevelUserFK = 3 THEN 'Admin Kecamatan'
                    WHEN main_user.IdLevelUserFK = 4 THEN 'Admin Desa'
                    ELSE 'Unknown'
                END as JenisUser
            FROM main_user 
            INNER JOIN master_pegawai ON main_user.IdPegawai = master_pegawai.IdPegawaiFK
            LEFT JOIN master_desa ON master_pegawai.IdDesaFK = master_desa.IdDesa
            $whereClause
            ORDER BY main_user.NameAkses
            LIMIT $limit OFFSET $offset";

    return mysqli_query($db, $sql);
}

// Function untuk mendapatkan total user untuk pagination
function getTotalUsers($db, $search = '') {
    $whereClause = '';

    if (!empty($search)) {
        $search = sql_injeksi($search);
        $whereClause = "WHERE main_user.NameAkses LIKE '%$search%' OR master_pegawai.Nama LIKE '%$search%'";
    }

    $sql = "SELECT COUNT(*) as total
            FROM main_user 
            INNER JOIN master_pegawai ON main_user.IdPegawai = master_pegawai.IdPegawaiFK
            LEFT JOIN master_desa ON master_pegawai.IdDesaFK = master_desa.IdDesa
            $whereClause";

    $result = mysqli_query($db, $sql);
    $row = mysqli_fetch_assoc($result);
    return $row['total'];
}

// Function untuk reset password user
function resetUserPassword($db, $userId, $newPassword) {
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
    $updateSql = "UPDATE main_user SET NamePassword = '" . sql_injeksi($hashedPassword) . "' WHERE IdUser = '" . sql_injeksi($userId) . "'";

    return mysqli_query($db, $updateSql);
}

// Function untuk reset semua user
function resetAllUsers($db, $defaultPassword = "12345") {
    $sql = "SELECT IdUser, NameAkses FROM main_user WHERE StatusLogin = 1";
    $result = mysqli_query($db, $sql);

    $hashedPassword = password_hash($defaultPassword, PASSWORD_DEFAULT);
    $successCount = 0;
    $errorCount = 0;
    $results = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $updateSql = "UPDATE main_user SET NamePassword = '" . sql_injeksi($hashedPassword) . "' WHERE IdUser = '" . sql_injeksi($row['IdUser']) . "'";

        if (mysqli_query($db, $updateSql)) {
            $successCount++;
            $results[] = "✓ User '{$row['NameAkses']}' berhasil direset";
        } else {
            $errorCount++;
            $results[] = "✗ User '{$row['NameAkses']}' gagal direset: " . mysqli_error($db);
        }
    }

    return [
        'success' => $successCount,
        'error' => $errorCount,
        'results' => $results
    ];
}

// Process form submission
$message = '';
$messageType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'reset_single':
                $userId = sql_injeksi($_POST['user_id']);
                $password = sql_injeksi($_POST['password']);

                if (strlen($password) < 5) {
                    $message = 'Password harus minimal 5 karakter!';
                    $messageType = 'error';
                } else {
                    if (resetUserPassword($db, $userId, $password)) {
                        $message = 'Password berhasil direset!';
                        $messageType = 'success';
                    } else {
                        $message = 'Gagal mereset password: ' . mysqli_error($db);
                        $messageType = 'error';
                    }
                }
                break;

            case 'reset_all':
                $defaultPassword = sql_injeksi($_POST['default_password']);

                if (strlen($defaultPassword) < 5) {
                    $message = 'Password default harus minimal 5 karakter!';
                    $messageType = 'error';
                } else {
                    $resetResults = resetAllUsers($db, $defaultPassword);
                    $message = "Reset selesai! Berhasil: {$resetResults['success']} user, Gagal: {$resetResults['error']} user";
                    $messageType = $resetResults['error'] > 0 ? 'warning' : 'success';
                }
                break;
        }
    }
}

$search = isset($_GET['search']) ? $_GET['search'] : '';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 10;

$users = getUsers($db, $search, $page, $limit);
$totalUsers = getTotalUsers($db, $search);
$totalPages = ceil($totalUsers / $limit);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password User - SIPEMDES</title>
    <link href="Vendor/Assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="Vendor/Assets/font-awesome/css/font-awesome.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .container {
            margin-top: 20px;
        }
        .card {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border: none;
            border-radius: 10px;
        }
        .card-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 10px 10px 0 0 !important;
        }
        .table th {
            background-color: #f8f9fa;
            border-top: none;
        }
        .btn-reset {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            border: none;
            color: white;
        }
        .btn-reset:hover {
            background: linear-gradient(135deg, #f5576c 0%, #f093fb 100%);
            color: white;
        }
        .btn-reset-all {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            border: none;
            color: white;
        }
        .btn-reset-all:hover {
            background: linear-gradient(135deg, #00f2fe 0%, #4facfe 100%);
            color: white;
        }
        .alert {
            border-radius: 10px;
        }
        .password-input {
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="mb-0">
                            <i class="fa fa-key"></i> Reset Password User SIPEMDES
                        </h3>
                    </div>
                    <div class="card-body">
                        <?php if ($message): ?>
                            <div class="alert alert-<?php echo $messageType === 'error' ? 'danger' : ($messageType === 'warning' ? 'warning' : 'success'); ?> alert-dismissible fade show">
                                <strong><?php echo ucfirst($messageType); ?>!</strong> <?php echo $message; ?>
                                <button type="button" class="close" data-dismiss="alert">
                                    <span>&times;</span>
                                </button>
                            </div>
                        <?php endif; ?>

                        <!-- Reset All Users -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="card border-info">
                                    <div class="card-header bg-info text-white">
                                        <h5 class="mb-0"><i class="fa fa-users"></i> Reset Semua User</h5>
                                    </div>
                                    <div class="card-body">
                                        <form method="POST" onsubmit="return confirm('Yakin ingin mereset password SEMUA user aktif?')">
                                            <input type="hidden" name="action" value="reset_all">
                                            <div class="form-group">
                                                <label>Password Default:</label>
                                                <input type="text" name="default_password" class="form-control password-input" value="12345" required>
                                                <small class="text-muted">Minimal 5 karakter</small>
                                            </div>
                                            <button type="submit" class="btn btn-reset-all btn-block">
                                                <i class="fa fa-refresh"></i> Reset Semua User
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- User List -->
                        <div class="card">
                            <div class="card-header bg-secondary text-white">
                                <h5 class="mb-0"><i class="fa fa-list"></i> Daftar User</h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="input-group">
                                                <input type="text" id="searchInput" class="form-control" placeholder="Cari username atau nama..." value="<?php echo htmlspecialchars($search); ?>">
                                                <div class="input-group-append">
                                                    <span class="input-group-text">
                                                        <i class="fa fa-search"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 text-right">
                                            <small class="text-muted">
                                                Menampilkan <?php echo (($page - 1) * $limit) + 1; ?> - <?php echo min($page * $limit, $totalUsers); ?> dari <?php echo $totalUsers; ?> user
                                            </small>
                                        </div>
                                    </div>
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>Username</th>
                                                <th>Nama</th>
                                                <th>Unit Kerja</th>
                                                <th>Level</th>
                                                <th>Status</th>
                                                <th>Jenis User</th>
                                                <th>Reset Password</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php while ($row = mysqli_fetch_assoc($users)): ?>
                                                <?php
                                                $status = $row['StatusLogin'] == 1 ? "Aktif" : "Non-Aktif";
                                                $statusClass = $row['StatusLogin'] == 1 ? "badge-success" : "badge-secondary";
                                                $unitKerja = $row['NameDesa'] ?? "Kabupaten";
                                                ?>
                                                <tr>
                                                    <td><strong><?php echo htmlspecialchars($row['NameAkses']); ?></strong></td>
                                                    <td><?php echo htmlspecialchars($row['Nama']); ?></td>
                                                    <td><?php echo htmlspecialchars($unitKerja); ?></td>
                                                    <td><span class="badge badge-info"><?php echo htmlspecialchars($row['IdLevelUserFK']); ?></span></td>
                                                    <td><span class="badge <?php echo $statusClass; ?>"><?php echo $status; ?></span></td>
                                                    <td><?php echo htmlspecialchars($row['JenisUser']); ?></td>
                                                    <td>
                                                        <form method="POST" style="display: inline-block;" onsubmit="return confirm('Yakin reset password user <?php echo htmlspecialchars($row['NameAkses']); ?>?')">
                                                            <input type="hidden" name="action" value="reset_single">
                                                            <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($row['IdUser']); ?>">
                                                            <div class="input-group input-group-sm" style="width: 200px;">
                                                                <input type="text" name="password" class="form-control password-input" placeholder="Password baru" value="12345" required>
                                                                <div class="input-group-append">
                                                                    <button type="submit" class="btn btn-reset btn-sm">
                                                                        <i class="fa fa-key"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </td>
                                                </tr>
                                            <?php endwhile; ?>
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Pagination -->
                                <?php if ($totalPages > 1): ?>
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <nav aria-label="Navigasi halaman">
                                            <ul class="pagination pagination-sm mb-0">
                                                <?php if ($page > 1): ?>
                                                    <li class="page-item">
                                                        <a class="page-link" href="?page=1&search=<?php echo urlencode($search); ?>" aria-label="Pertama">
                                                            <span aria-hidden="true">&laquo;&laquo;</span>
                                                        </a>
                                                    </li>
                                                    <li class="page-item">
                                                        <a class="page-link" href="?page=<?php echo $page - 1; ?>&search=<?php echo urlencode($search); ?>" aria-label="Sebelumnya">
                                                            <span aria-hidden="true">&laquo;</span>
                                                        </a>
                                                    </li>
                                                <?php endif; ?>

                                                <?php
                                                // Smart pagination - show max 5 pages
                                                $start = max(1, $page - 2);
                                                $end = min($totalPages, $page + 2);

                                                // Adjust if we're at the beginning or end
                                                if ($page <= 3) {
                                                    $end = min($totalPages, 5);
                                                }
                                                if ($page > $totalPages - 3) {
                                                    $start = max(1, $totalPages - 4);
                                                }

                                                for ($i = $start; $i <= $end; $i++): ?>
                                                    <li class="page-item <?php echo $i == $page ? 'active' : ''; ?>">
                                                        <a class="page-link" href="?page=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>"><?php echo $i; ?></a>
                                                    </li>
                                                <?php endfor; ?>

                                                <?php if ($page < $totalPages): ?>
                                                    <li class="page-item">
                                                        <a class="page-link" href="?page=<?php echo $page + 1; ?>&search=<?php echo urlencode($search); ?>" aria-label="Selanjutnya">
                                                            <span aria-hidden="true">&raquo;</span>
                                                        </a>
                                                    </li>
                                                    <li class="page-item">
                                                        <a class="page-link" href="?page=<?php echo $totalPages; ?>&search=<?php echo urlencode($search); ?>" aria-label="Terakhir">
                                                            <span aria-hidden="true">&raquo;&raquo;</span>
                                                        </a>
                                                    </li>
                                                <?php endif; ?>
                                            </ul>
                                        </nav>
                                    </div>
                                    <div class="col-md-6 text-right">
                                        <small class="text-muted mt-2 d-inline-block">
                                            Halaman <?php echo $page; ?> dari <?php echo $totalPages; ?> halaman
                                        </small>
                                    </div>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="mt-3">
                            <div class="alert alert-info">
                                <strong><i class="fa fa-info-circle"></i> Informasi:</strong>
                                <ul class="mb-0 mt-2">
                                    <li>Password default adalah "12345"</li>
                                    <li>Password akan di-hash secara otomatis untuk keamanan</li>
                                    <li>Hanya user dengan status "Aktif" yang bisa direset secara massal</li>
                                    <li>Pastikan konfirmasi sebelum melakukan reset</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="Vendor/Assets/js/jquery-3.7.1.min.js"></script>
    <script src="Vendor/Assets/js/popper.min.js"></script>
    <script src="Vendor/Assets/js/bootstrap.js"></script>

    <script>
    $(document).ready(function() {
        // Live search functionality
        let searchTimeout;

        $('#searchInput').on('input', function() {
            clearTimeout(searchTimeout);
            const searchTerm = $(this).val();

            // Debounce search to avoid too many requests
            searchTimeout = setTimeout(function() {
                // Redirect to first page with search term
                const currentUrl = window.location.href.split('?')[0];
                if (searchTerm.trim() === '') {
                    window.location.href = currentUrl;
                } else {
                    window.location.href = currentUrl + '?search=' + encodeURIComponent(searchTerm) + '&page=1';
                }
            }, 500); // Wait 500ms after user stops typing
        });

        // Clear search when pressing Escape
        $('#searchInput').on('keydown', function(e) {
            if (e.key === 'Escape') {
                $(this).val('');
                const currentUrl = window.location.href.split('?')[0];
                window.location.href = currentUrl;
            }
        });

        // Focus on search input when page loads (if not searching)
        <?php if (empty($search)): ?>
        $('#searchInput').focus();
        <?php endif; ?>
    });
    </script>
</body>
</html>
