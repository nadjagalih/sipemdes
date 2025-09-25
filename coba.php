<?php
// --- Contoh Data dari PHP Sisi Server ---
$nama = "IHWAN";
$jabatan = "KEPALA RUMAH TANGGA";
$provinsi = "Bantul";
$kabupaten = "Bantul";
$kecamatan = "PUNDONG";
$desa = "SRIHARDONO";
$alamat = "Potrobayan RT.006";

// Data untuk tombol/tab
$tombol = [
    ['teks' => '1 Keluarga', 'aktif' => true],
    ['teks' => '2 ART', 'aktif' => false],
    ['teks' => 'DTKS', 'aktif' => false],
    ['teks' => 'Usulan', 'aktif' => false],
    ['teks' => 'Data Daerah', 'aktif' => false],
];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Pengguna Sederhana</title>
    <style>
        :root {
            --warna-primer: #007bff; /* Warna biru untuk tombol aktif */
            --warna-sekunder: #6c757d; /* Abu-abu untuk tombol non-aktif */
            --warna-bg: #f8f9fa; /* Latar belakang ringan */
            --warna-text: #343a40;
            --warna-garis: #dee2e6;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: var(--warna-bg);
            padding: 20px;
        }

        .profil-container {
            max-width: 800px;
            margin: 0 auto;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        /* Bagian Header Profil */
        .profil-header {
            display: flex;
            align-items: flex-start; /* Mengatur align ke atas agar teks tidak terlalu turun */
            gap: 20px;
            margin-bottom: 20px;
        }

        .profil-avatar {
            /* Gaya dasar ilustrasi avatar */
            width: 100px;
            height: 100px;
            background: linear-gradient(to bottom, #f08080, #ffa07a); /* Contoh gradien untuk ilustrasi */
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 40px;
            color: white;
            overflow: hidden; /* Penting jika menggunakan gambar/ilustrasi kompleks */
        }
        /* Mengganti .profil-avatar dengan placeholder ilustrasi */
        .profil-ilustrasi {
             width: 100px;
             height: 100px;
             /* Placeholder Ilustrasi */
             background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="%23f08080" d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>');
             background-repeat: no-repeat;
             background-position: center;
             background-size: cover;
             border-radius: 50%;
        }

        .profil-info {
            flex-grow: 1;
        }

        .profil-info h1 {
            margin: 0 0 5px 0;
            font-size: 1.8em;
            color: var(--warna-text);
        }

        .profil-info p {
            margin: 0 0 15px 0;
            font-size: 0.9em;
            color: var(--warna-sekunder);
        }

        /* Tombol Navigasi/Tab */
        .tombol-nav {
            display: flex;
            flex-wrap: wrap; /* Penting untuk responsivitas */
            gap: 10px;
            margin-bottom: 30px;
        }

        .tombol-item {
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.85em;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s, color 0.3s;
            border: 1px solid var(--warna-primer); /* Default border */
        }

        .tombol-aktif {
            background-color: var(--warna-primer);
            color: white;
            border-color: var(--warna-primer);
        }

        .tombol-nonaktif {
            background-color: white;
            color: var(--warna-primer);
            border-color: var(--warna-primer);
        }

        /* Detail Alamat/Data Area */
        .detail-area {
            border-top: 1px solid var(--warna-garis);
            padding-top: 20px;
        }

        .detail-baris {
            display: flex;
            padding: 8px 0;
            align-items: center; /* Memastikan teks sejajar secara vertikal */
        }

        .detail-label {
            width: 150px; /* Lebar tetap untuk label */
            color: var(--warna-sekunder);
            font-weight: bold;
            font-size: 0.95em;
        }

        .detail-nilai {
            flex-grow: 1;
            color: var(--warna-text);
            font-weight: 500;
        }
    </style>
</head>
<body>

    <div class="profil-container">
        <div class="profil-header">
            <div class="profil-avatar">
                <img src="path/to/placeholder/image.png" alt="IHWAN Avatar" style="width:100%; height:100%; object-fit:cover; border-radius:50%;">
                </div>
            
            <div class="profil-info">
                <h1><?php echo htmlspecialchars($nama); ?></h1>
                <p><?php echo htmlspecialchars($jabatan); ?></p>
                
                <div class="tombol-nav">
                    <?php foreach ($tombol as $t): ?>
                        <span class="tombol-item <?php echo $t['aktif'] ? 'tombol-aktif' : 'tombol-nonaktif'; ?>">
                            <?php echo htmlspecialchars($t['teks']); ?>
                        </span>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <div class="detail-area">
            <div class="detail-baris">
                <span class="detail-label">Provinsi</span>
                <span class="detail-nilai"><?php echo htmlspecialchars($provinsi); ?></span>
            </div>
            <div class="detail-baris">
                <span class="detail-label">Kabupaten</span>
                <span class="detail-nilai"><?php echo htmlspecialchars($kabupaten); ?></span>
            </div>
            <div class="detail-baris">
                <span class="detail-label">Kecamatan</span>
                <span class="detail-nilai"><?php echo htmlspecialchars($kecamatan); ?></span>
            </div>
            <div class="detail-baris">
                <span class="detail-label">Desa</span>
                <span class="detail-nilai"><?php echo htmlspecialchars($desa); ?></span>
            </div>
            <div class="detail-baris">
                <span class="detail-label">Alamat</span>
                <span class="detail-nilai"><?php echo htmlspecialchars($alamat); ?></span>
            </div>
        </div>
    </div>

</body>
</html>