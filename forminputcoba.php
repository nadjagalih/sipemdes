<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit PTK - FARIHAH</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-datepicker@1.9.0/dist/css/bootstrap-datepicker.min.css" rel="stylesheet">
    <style>
        .form-section {
            background-color: #e3f2fd;
            border: 1px solid #bbdefb;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 20px;
        }
        .section-title {
            background-color: #2196f3;
            color: white;
            padding: 8px 15px;
            margin: -15px -15px 15px -15px;
            border-radius: 5px 5px 0 0;
            font-weight: bold;
        }
        .nav-tabs {
            background-color: #1976d2;
        }
        .nav-tabs .nav-link {
            color: white;
            border: none;
            background-color: #1976d2;
        }
        .nav-tabs .nav-link.active {
            background-color: #0d47a1;
            color: white;
            border: none;
        }
        .table-container {
            background-color: white;
            border-radius: 5px;
            padding: 15px;
        }
    </style>
</head>
<body class="bg-light">
    <div class="container-fluid mt-3">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="text-primary">
                <i class="fas fa-edit"></i> Edit PTK : FARIHAH
            </h4>
            <div>
                <button type="button" class="btn btn-outline-secondary">
                    <i class="fas fa-expand"></i>
                </button>
                <button type="button" class="btn btn-outline-secondary">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>

        <?php
        // Data default untuk form
        $data = [
            'nama' => 'FARIHAH',
            'nik' => '3527241048565227',
            'jenis_kelamin' => 'Perempuan',
            'tempat_lahir' => 'SAMPANG',
            'tanggal_lahir' => '01/04/1985',
            'nama_ibu_kandung' => 'SITI AMNA'
        ];

        // Data pendidikan
        $pendidikan = [
            ['bidang' => 'lainnya', 'jenjang' => 'SD / sederajat', 'gelar' => '', 'satuan' => 'SD', 'fakultas' => ''],
            ['bidang' => 'lainnya', 'jenjang' => 'SMP / sederajat', 'gelar' => '', 'satuan' => 'SMP', 'fakultas' => ''],
            ['bidang' => 'lainnya', 'jenjang' => 'SMA / sederajat', 'gelar' => '', 'satuan' => 'SMA', 'fakultas' => ''],
            ['bidang' => 'Pendidikan Kewarganegaraan', 'jenjang' => 'S1', 'gelar' => 'Sarjana Pendidikan', 'satuan' => 'Pendidikan Kewarganegaraan', 'fakultas' => 'Keguruan dan Ilmu Pendidikan']
        ];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Proses data form
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle"></i> Data PTK berhasil diperbarui!
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                  </div>';
        }
        ?>

        <form method="POST" action="">
            <!-- Form Identitas -->
            <div class="form-section">
                <div class="section-title">
                    <i class="fas fa-user"></i> Identitas
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="nama" name="nama" value="<?= $data['nama'] ?>" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="nik" class="form-label">NIK <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="nik" name="nik" value="<?= $data['nik'] ?>" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Jenis kelamin <span class="text-danger">*</span></label>
                            <div class="d-flex gap-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="jenis_kelamin" id="laki_laki" value="Laki-laki" <?= $data['jenis_kelamin'] == 'Laki-laki' ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="laki_laki">Laki-laki</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="jenis_kelamin" id="perempuan" value="Perempuan" <?= $data['jenis_kelamin'] == 'Perempuan' ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="perempuan">Perempuan</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="tempat_lahir" class="form-label">Tempat lahir <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" value="<?= $data['tempat_lahir'] ?>" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="tanggal_lahir" class="form-label">Tanggal lahir <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="text" class="form-control datepicker" id="tanggal_lahir" name="tanggal_lahir" value="<?= $data['tanggal_lahir'] ?>" required>
                                <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="nama_ibu_kandung" class="form-label">Nama ibu kandung <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="nama_ibu_kandung" name="nama_ibu_kandung" value="<?= $data['nama_ibu_kandung'] ?>" required>
                        </div>
                    </div>
                </div>

                <div class="text-end">
                    <button type="button" class="btn btn-primary">
                        <i class="fas fa-save"></i> Bantuan
                    </button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                </div>
            </div>

            <!-- Data Rincian dengan Tabs -->
            <div class="card">
                <div class="card-header p-0">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link" href="#test" data-bs-toggle="tab">
                                <i class="fas fa-vial"></i> Test
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#rw-gaji" data-bs-toggle="tab">
                                <i class="fas fa-money-bill"></i> Rw.Gaji Berkala
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#rw-jabatan" data-bs-toggle="tab">
                                <i class="fas fa-briefcase"></i> Rw.Jab.Struktural
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#rw-kepangkatan" data-bs-toggle="tab">
                                <i class="fas fa-star"></i> Rw.Kepangkatan
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="#rw-pendidikan" data-bs-toggle="tab">
                                <i class="fas fa-graduation-cap"></i> Rw.Pendidikan Formal
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#rw-sertifikasi" data-bs-toggle="tab">
                                <i class="fas fa-certificate"></i> Rw.Sertifikasi
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#rw-fungsional" data-bs-toggle="tab">
                                <i class="fas fa-cogs"></i> Rw.Jab.Fungsional
                            </a>
                        </li>
                    </ul>
                </div>
                
                <div class="card-body">
                    <div class="tab-content">
                        <!-- Tab Pendidikan Formal (Active) -->
                        <div class="tab-pane fade show active" id="rw-pendidikan">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="mb-0">Data Rincian</h5>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-outline-secondary btn-sm">
                                        <i class="fas fa-plus"></i> Tambah
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary btn-sm">
                                        <i class="fas fa-edit"></i> Ubah
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary btn-sm">
                                        <i class="fas fa-save"></i> Simpan
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary btn-sm">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead class="table-primary">
                                        <tr>
                                            <th>Bidang Studi</th>
                                            <th>Jenjang Pendidikan</th>
                                            <th>Gelar Akademik</th>
                                            <th>Satuan Pendidikan Formal</th>
                                            <th>Fakultas</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($pendidikan as $index => $row): ?>
                                        <tr class="<?= $index == 3 ? 'table-warning' : '' ?>">
                                            <td><?= $row['bidang'] ?></td>
                                            <td><?= $row['jenjang'] ?></td>
                                            <td><?= $row['gelar'] ?></td>
                                            <td><?= $row['satuan'] ?></td>
                                            <td><?= $row['fakultas'] ?></td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
                            <nav aria-label="Page navigation">
                                <ul class="pagination pagination-sm justify-content-center">
                                    <li class="page-item">
                                        <a class="page-link" href="#"><i class="fas fa-angle-double-left"></i></a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" href="#"><i class="fas fa-angle-left"></i></a>
                                    </li>
                                    <li class="page-item">
                                        <span class="page-link">Hal</span>
                                    </li>
                                    <li class="page-item active">
                                        <a class="page-link" href="#">1</a>
                                    </li>
                                    <li class="page-item">
                                        <span class="page-link">dari 1</span>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" href="#"><i class="fas fa-angle-right"></i></a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" href="#"><i class="fas fa-angle-double-right"></i></a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" href="#"><i class="fas fa-sync-alt"></i></a>
                                    </li>
                                </ul>
                            </nav>
                            
                            <p class="text-center text-muted small">Displaying data 1 - 4 of 4</p>
                        </div>

                        <!-- Tab lainnya (placeholder) -->
                        <div class="tab-pane fade" id="test">
                            <p>Konten Tab Test</p>
                        </div>
                        <div class="tab-pane fade" id="rw-gaji">
                            <p>Konten Tab Riwayat Gaji Berkala</p>
                        </div>
                        <div class="tab-pane fade" id="rw-jabatan">
                            <p>Konten Tab Riwayat Jabatan Struktural</p>
                        </div>
                        <div class="tab-pane fade" id="rw-kepangkatan">
                            <p>Konten Tab Riwayat Kepangkatan</p>
                        </div>
                        <div class="tab-pane fade" id="rw-sertifikasi">
                            <p>Konten Tab Riwayat Sertifikasi</p>
                        </div>
                        <div class="tab-pane fade" id="rw-fungsional">
                            <p>Konten Tab Riwayat Jabatan Fungsional</p>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-datepicker@1.9.0/dist/js/bootstrap-datepicker.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-datepicker@1.9.0/dist/locales/bootstrap-datepicker.id.min.js"></script>
    
    <script>
        $(document).ready(function() {
            // Initialize datepicker
            $('.datepicker').datepicker({
                format: 'dd/mm/yyyy',
                language: 'id',
                autoclose: true,
                todayHighlight: true
            });

            // Table row selection
            $('tbody tr').click(function() {
                $('tbody tr').removeClass('table-warning');
                $(this).addClass('table-warning');
            });
        });
    </script>
</body>
</html>