<?php
// Setting Profile Admin Desa - View dan Process
ob_start(); // Start output buffering
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);

// Include files
include_once "../App/Control/FunctionSettingProfileAdminKecamatan.php";

// Alert Handler seperti di PegawaiViewAll.php
if (isset($_GET['alert'])) {
    if (isset($_GET['alert']) && $_GET['alert'] == 'Edit') {
        echo "<script type='text/javascript'>
            setTimeout(function () {
                swal({
                    title: 'Berhasil!',
                    text: 'Data Profile Kecamatan Berhasil Diperbarui',
                    type: 'success',
                    showConfirmButton: true
                });
            },10);
        </script>";
    } elseif (isset($_GET['alert']) && $_GET['alert'] == 'Gagal') {
        echo "<script type='text/javascript'>
            setTimeout(function () {
                swal({
                    title: 'Gagal!',
                    text: 'Gagal Memperbarui Data Profile Kecamatan',
                    type: 'error',
                    showConfirmButton: true
                });
            },10);
        </script>";
    } elseif (isset($_GET['alert']) && $_GET['alert'] == 'ErrorTelepon') {
        echo "<script type='text/javascript'>
            setTimeout(function () {
                swal({
                    title: 'Peringatan!',
                    text: 'Nomor Telepon Harus Diisi',
                    type: 'warning',
                    showConfirmButton: true
                });
            },10);
        </script>";
    } elseif (isset($_GET['alert']) && $_GET['alert'] == 'ErrorKoordinat') {
        echo "<script type='text/javascript'>
            setTimeout(function () {
                swal({
                    title: 'Peringatan!',
                    text: 'Silakan Klik pada Peta untuk Menentukan Koordinat',
                    type: 'warning',
                    showConfirmButton: true
                });
            },10);
        </script>";
    }
}

// Debug: uncomment untuk cek session (hapus setelah testing)
// echo "<pre>"; print_r($_SESSION); echo "</pre>"; exit;
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Setting Profile Kecamatan</title>

<!-- Bootstrap CSS -->
<link href="../Assets/argon/argon.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@300;400;500;700&display=swap" rel="stylesheet">
<link href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" rel="stylesheet">

<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<!-- SweetAlert -->
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<style>
    /* Menggunakan struktur CSS yang sama dengan UserAdd.php */
    .wrapper-content .ibox {
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        border: 1px solid #e7eaec;
    }

    .wrapper-content .ibox-title {
        border-radius: 15px 15px 0 0;
        background: #ffffff;
        color: #495057;
        border-bottom: 1px solid #e7eaec;
    }

    .wrapper-content .ibox-title h5 {
        color: #495057;
        margin: 0;
        font-weight: 600;
    }

    .wrapper-content .ibox-content {
        border-radius: 0 0 15px 15px;
        background: #ffffff;
        padding: 30px;
    }

    .wrapper-content .form-control {
        border-radius: 8px;
        border: 2px solid #e9ecef;
        padding: 12px 15px;
        transition: all 0.3s ease;
    }

    .wrapper-content .form-control:focus {
        border-color: #007bff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, .25);
    }

    .wrapper-content .btn {
        border-radius: 25px;
        padding: 10px 25px;
        font-weight: 600;
    }

    .wrapper-content .guide-box {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border: 1px solid #dee2e6;
        border-radius: 15px;
        padding: 20px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .wrapper-content .guide-title {
        color: #495057;
        font-weight: bold;
        font-size: 16px;
        margin-bottom: 15px;
        padding-bottom: 10px;
        border-bottom: 2px solid #007bff;
        display: flex;
        align-items: center;
    }

    .wrapper-content .guide-title i {
        margin-right: 8px;
        color: #007bff;
    }

    .wrapper-content .guide-steps {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .wrapper-content .guide-steps li {
        background: white;
        margin-bottom: 10px;
        padding: 12px 15px;
        border-radius: 10px;
        border-left: 4px solid #007bff;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        position: relative;
        transition: all 0.3s ease;
    }

    .wrapper-content .guide-steps li:hover {
        transform: translateX(5px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .wrapper-content .step-number {
        background: #007bff;
        color: white;
        border-radius: 50%;
        width: 24px;
        height: 24px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        font-weight: bold;
        margin-right: 10px;
        flex-shrink: 0;
    }

    .wrapper-content .step-text {
        font-size: 14px;
        color: #495057;
        line-height: 1.4;
    }

    .wrapper-content .guide-note {
        background: #fff3cd;
        border: 1px solid #ffeaa7;
        border-radius: 10px;
        padding: 12px;
        margin-top: 15px;
        font-size: 13px;
        color: #856404;
    }

    .wrapper-content .guide-note i {
        color: #f39c12;
        margin-right: 8px;
    }

    .wrapper-content .map-container {
        height: 400px;
        border-radius: 0.5rem;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        border: 1px solid #e7eaec;
    }

    .wrapper-content #koordinatMap {
        height: 100%;
        width: 100%;
    }

    .wrapper-content .coordinate-info {
        background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
        padding: 15px;
        border-radius: 10px;
        border: 1px solid #2196f3;
        margin-bottom: 15px;
    }

    .wrapper-content .coordinate-display {
        font-family: 'Courier New', monospace;
        font-size: 0.9rem;
        color: #1976d2;
        font-weight: 600;
    }

    /* Search Autocomplete Styles - External */
    .search-section {
        background: linear-gradient(135deg, #e3f2fd 0%, #f8f9fa 100%);
        border-bottom: 1px solid #dee2e6;
    }

    .search-box-external {
        position: relative;
        max-width: 100%;
    }

    .search-input-external {
        border-radius: 25px 0 0 25px;
        border: 2px solid #007bff;
        padding: 14px 20px;
        font-size: 14px;
        transition: all 0.3s ease;
        box-shadow: 0 2px 4px rgba(0, 123, 255, 0.1);
    }

    .search-input-external:focus {
        border-color: #0056b3;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25), 0 4px 8px rgba(0, 123, 255, 0.15);
        transform: translateY(-1px);
    }

    .search-input-external::placeholder {
        color: #6c757d;
        font-style: italic;
    }

    .search-button-external {
        background: #1c84c6;
        border-radius: 0 25px 25px 0;
        border: 2px solid #007bff;
        border-left: none;
        padding: 14px 20px;
        color: white;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 2px 4px rgba(0, 123, 255, 0.2);
    }

    .search-button-external:hover {
        background: #0056b3;
        border-color: #0056b3;
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(0, 123, 255, 0.3);
        color: white;
    }

    .search-button-external:active {
        transform: translateY(0);
        box-shadow: 0 2px 4px rgba(0, 123, 255, 0.2);
    }

    .search-clear-external {
        background: linear-gradient(135deg, #6c757d 0%, #495057 100%);
        border-radius: 0;
        border: 2px solid #007bff;
        border-left: none;
        border-right: none;
        padding: 14px 16px;
        color: white;
        transition: all 0.3s ease;
        box-shadow: 0 2px 4px rgba(108, 117, 125, 0.2);
    }

    .search-clear-external:hover {
        background: linear-gradient(135deg, #495057 0%, #343a40 100%);
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(108, 117, 125, 0.3);
        color: white;
    }

    .search-clear-external:active {
        transform: translateY(0);
    }

    .search-results-external {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background: white;
        border-radius: 0 0 15px 15px;
        box-shadow: 0 8px 25px rgba(0, 123, 255, 0.15);
        max-height: 280px;
        overflow-y: auto;
        z-index: 1001;
        border: 2px solid #007bff;
        border-top: none;
        display: none;
        margin-top: 2px;
    }

    .search-result-item {
        padding: 15px 20px;
        cursor: pointer;
        border-bottom: 1px solid #e9ecef;
        font-size: 13px;
        transition: all 0.3s ease;
        position: relative;
    }

    .search-result-item:hover {
        background: linear-gradient(135deg, #e3f2fd 0%, #f8f9fa 100%);
        transform: translateX(5px);
        border-left: 4px solid #007bff;
        padding-left: 16px;
    }

    .search-result-item:last-child {
        border-bottom: none;
        border-radius: 0 0 13px 13px;
    }

    .search-result-title {
        font-weight: 700;
        color: #007bff;
        margin-bottom: 4px;
        font-size: 14px;
    }

    .search-result-description {
        color: #6c757d;
        font-size: 12px;
        line-height: 1.4;
    }

    .search-loading {
        padding: 20px;
        text-align: center;
        color: #007bff;
        font-style: italic;
        font-size: 13px;
        font-weight: 500;
    }

    .search-loading i {
        color: #007bff;
        margin-right: 8px;
    }

    .search-no-results {
        padding: 20px;
        text-align: center;
        color: #6c757d;
        font-style: italic;
        font-size: 13px;
    }

    /* Mobile responsive search */
    @media (max-width: 768px) {
        .search-section {
            padding: 12px 15px;
        }
        
        .search-input-external {
            font-size: 16px; /* Prevent zoom on iOS */
            padding: 12px 16px;
            border-radius: 20px 0 0 20px;
        }
        
        .search-button-external {
            padding: 12px 16px;
            border-radius: 0 20px 20px 0;
            font-size: 14px;
        }

        .search-clear-external {
            padding: 12px 12px;
        }
        
        .search-results-external {
            max-height: 220px;
            border-radius: 0 0 12px 12px;
        }
        
        .search-result-item {
            padding: 12px 15px;
        }

        .search-result-item:hover {
            transform: translateX(3px);
            padding-left: 12px;
        }

        .search-result-title {
            font-size: 13px;
        }

        .search-loading, .search-no-results {
            padding: 15px;
        }
    }

    /* Small mobile optimization */
    @media (max-width: 480px) {
        .search-input-external {
            padding: 10px 14px;
            font-size: 15px;
        }
        
        .search-button-external, .search-clear-external {
            padding: 10px 12px;
        }

        .search-button-external i {
            font-size: 14px;
        }
    }
</style>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Setting</h2>

    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="container-fluid">
        <form action="../App/Model/ExcSettingProfileAdminKecamatan.php?Act=Save" method="POST" id="koordinatForm">
            <div class="row">
                <div class="col-lg-4">
                    <div class="ibox ">
                        <div class="ibox-title">
                            <h5>Form Setting Profile Kecamatan</h5>
                        </div>
                        <div class="ibox-content">
                            <div class="form-group row">
                                <label class="col-lg-12 col-form-label">
                                    <i class="fas fa-phone"></i>
                                    Nomor Telepon Kecamatan
                                </label>
                                <div class="col-lg-12">
                                    <input type="text"
                                        class="form-control"
                                        name="NoTelepon"
                                        id="NoTelepon"
                                        value="<?php echo htmlspecialchars($currentNoTelepon); ?>"
                                        placeholder="Contoh: 0341-123456 / 08123456789"
                                        required
                                        autocomplete="off">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-12 col-form-label">
                                    <i class="fas fa-map-marker-alt"></i>
                                    Alamat Kantor
                                </label>
                                <div class="col-lg-12">
                                    <textarea 
                                        class="form-control"
                                        name="AlamatKantor"
                                        id="AlamatKantor"
                                        rows="3"
                                        placeholder="Masukkan alamat lengkap kantor..."
                                        autocomplete="off"><?php echo htmlspecialchars($AlamatKecamatan); ?></textarea>
                                </div>
                            </div>

                            <div class="coordinate-info">
                                <h6 style="margin-bottom: 0.75rem; color: #1976d2;">
                                    <i class="fas fa-crosshairs"></i>
                                    Koordinat Saat Ini
                                </h6>
                                <div class="coordinate-display">
                                    <div>Latitude: <span id="currentLat"><?php echo $currentLatitude ?: 'Belum diset'; ?></span></div>
                                    <div>Longitude: <span id="currentLng"><?php echo $currentLongitude ?: 'Belum diset'; ?></span></div>
                                </div>
                            </div>

                            <input type="hidden" name="Latitude" id="Latitude" value="<?php echo $currentLatitude; ?>">
                            <input type="hidden" name="Longitude" id="Longitude" value="<?php echo $currentLongitude; ?>">

                            <!-- Tombol -->
                            <div style="margin-top: 1.5rem;">
                                <button type="submit" name="Save" class="btn btn-primary" style="width: 100%; margin-bottom: 0.5rem;">
                                    <i class="fas fa-save"></i>
                                    Simpan Pengaturan
                                </button>
                                <a href="?pg=Kecamatan" class="btn btn-secondary" style="width: 100%;">
                                    <i class="fas fa-arrow-left"></i>
                                    Kembali ke Dashboard
                                </a>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="col-lg-8">
                    <div class="ibox">
                        <div class="ibox-title">
                            <h5>Pilih Lokasi pada Peta</h5>
                        </div>
                        
                        <!-- Search Bar - Outside Map -->
                        <div class="search-section" style="padding: 15px; border-bottom: 1px solid #e7eaec;">
                            <div class="search-box-external">
                                <div class="input-group">
                                    <input 
                                        type="text" 
                                        class="form-control search-input-external" 
                                        id="searchInput" 
                                        placeholder="🔍 Cari lokasi Desa" 
                                        autocomplete="off"
                                    >
                                    <button class="btn btn-outline-secondary search-clear-external" type="button" id="searchClear" style="display: none;">
                                        <i class="fas fa-times"></i>
                                    </button>
                                    <button class="btn btn-primary search-button-external" type="button" id="searchButton">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                                <div class="search-results-external" id="searchResults"></div>
                            </div>
                        </div>
                        
                        <div class="ibox-content" style="padding: 0;">
                            <div class="map-container">
                                <div id="koordinatMap"></div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </form>
    </div>
</div>

<!-- Map Script -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Koordinat default (Indonesia/Jawa)
        var defaultLat = <?php echo !empty($currentLatitude) ? $currentLatitude : '-8.055'; ?>;
        var defaultLng = <?php echo !empty($currentLongitude) ? $currentLongitude : '111.715'; ?>;

        // Initialize map
        var map = L.map('koordinatMap').setView([defaultLat, defaultLng], 13);

        // Add tile layer
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap'
        }).addTo(map);

        // Marker untuk menunjukkan lokasi yang dipilih
        var marker = null;
        
        // Search functionality
        var searchInput = document.getElementById('searchInput');
        var searchButton = document.getElementById('searchButton');
        var searchClear = document.getElementById('searchClear');
        var searchResults = document.getElementById('searchResults');
        var searchTimeout = null;

        // Show/hide clear button
        function toggleClearButton() {
            searchClear.style.display = searchInput.value.length > 0 ? 'block' : 'none';
        }

        // Search function using Nominatim API
        function searchLocation(query) {
            if (query.length < 3) {
                hideSearchResults();
                return;
            }

            // Show loading
            showSearchResults();
            searchResults.innerHTML = '<div class="search-loading"><i class="fas fa-spinner fa-spin"></i> Mencari lokasi...</div>';

            // Add bias towards Indonesia
            var nominatimUrl = 'https://nominatim.openstreetmap.org/search?' +
                'format=json' +
                '&q=' + encodeURIComponent(query) +
                '&countrycodes=id' + // Bias towards Indonesia
                '&limit=8' +
                '&addressdetails=1' +
                '&extratags=1' +
                '&namedetails=1';

            fetch(nominatimUrl)
                .then(response => response.json())
                .then(data => {
                    displaySearchResults(data);
                })
                .catch(error => {
                    console.error('Search error:', error);
                    searchResults.innerHTML = '<div class="search-no-results">Terjadi kesalahan saat mencari lokasi</div>';
                });
        }

        // Display search results
        function displaySearchResults(results) {
            searchResults.innerHTML = '';
            
            if (results.length === 0) {
                searchResults.innerHTML = '<div class="search-no-results">Lokasi tidak ditemukan</div>';
                return;
            }

            results.forEach(function(result) {
                var resultItem = document.createElement('div');
                resultItem.className = 'search-result-item';
                
                var title = result.display_name.split(',')[0]; // First part as title
                var description = result.display_name.split(',').slice(1, 3).join(','); // Next parts as description
                
                resultItem.innerHTML = 
                    '<div class="search-result-title">' + title + '</div>' +
                    '<div class="search-result-description">' + description + '</div>';
                
                resultItem.addEventListener('click', function() {
                    selectSearchResult(result, title);
                });
                
                searchResults.appendChild(resultItem);
            });
        }

        // Select search result
        function selectSearchResult(result, title) {
            var lat = parseFloat(result.lat);
            var lng = parseFloat(result.lon);
            
            // Update search input
            searchInput.value = title;
            toggleClearButton();
            hideSearchResults();
            
            // Remove existing marker
            if (marker) {
                map.removeLayer(marker);
            }
            
            // Add new marker
            marker = L.marker([lat, lng], {
                draggable: true
            }).addTo(map);
            
            marker.bindPopup('<b>' + title + '</b><br>Lokasi dari pencarian').openPopup();
            
            // Update coordinates
            updateCoordinates(lat, lng);
            
            // Center map on location
            map.setView([lat, lng], 15);
            
            // Add drag event to new marker
            marker.on('dragend', function(e) {
                var position = marker.getLatLng();
                updateCoordinates(position.lat, position.lng);
            });
        }

        // Show search results
        function showSearchResults() {
            searchResults.style.display = 'block';
        }

        // Hide search results
        function hideSearchResults() {
            searchResults.style.display = 'none';
        }

        // Search input events
        searchInput.addEventListener('input', function() {
            toggleClearButton();
            
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(function() {
                searchLocation(searchInput.value);
            }, 500); // Delay 500ms after typing stops
        });

        // Search button click
        searchButton.addEventListener('click', function() {
            searchLocation(searchInput.value);
        });

        // Clear button click
        searchClear.addEventListener('click', function() {
            searchInput.value = '';
            toggleClearButton();
            hideSearchResults();
        });

        // Enter key to search
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                searchLocation(searchInput.value);
            }
        });

        // Hide results when clicking outside
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.search-box-external')) {
                hideSearchResults();
            }
        });

        // Initial clear button state
        toggleClearButton();

        // Jika sudah ada koordinat, tampilkan marker
        <?php if (!empty($currentLatitude) && !empty($currentLongitude)): ?>
            marker = L.marker([defaultLat, defaultLng], {
                draggable: true
            }).addTo(map);

            marker.bindPopup('<b><?php echo $namaDesa; ?></b><br>Lokasi saat ini').openPopup();

            // Event ketika marker di-drag
            marker.on('dragend', function(e) {
                var position = marker.getLatLng();
                updateCoordinates(position.lat, position.lng);
            });
        <?php endif; ?>

        // Event ketika peta diklik
        map.on('click', function(e) {
            var lat = e.latlng.lat;
            var lng = e.latlng.lng;

            // Hapus marker lama jika ada
            if (marker) {
                map.removeLayer(marker);
            }

            // Tambah marker baru
            marker = L.marker([lat, lng], {
                draggable: true
            }).addTo(map);

            marker.bindPopup('<b><?php echo $namaDesa; ?></b><br>Lokasi baru').openPopup();

            // Update koordinat
            updateCoordinates(lat, lng);

            // Event ketika marker di-drag
            marker.on('dragend', function(e) {
                var position = marker.getLatLng();
                updateCoordinates(position.lat, position.lng);
            });
        });

        // Fungsi untuk update koordinat
        function updateCoordinates(lat, lng) {
            // Update display
            document.getElementById('currentLat').textContent = lat.toFixed(6);
            document.getElementById('currentLng').textContent = lng.toFixed(6);

            // Update hidden inputs
            document.getElementById('Latitude').value = lat.toFixed(6);
            document.getElementById('Longitude').value = lng.toFixed(6);
        }

        // Form validation seperti di UserAdd.php
        document.getElementById('koordinatForm').addEventListener('submit', function(e) {
            var noTelepon = document.getElementById('NoTelepon').value.trim();
            var latitude = document.getElementById('Latitude').value;
            var longitude = document.getElementById('Longitude').value;

            console.log('Form submit event triggered');
            console.log('NoTelepon:', noTelepon);
            console.log('Latitude:', latitude);
            console.log('Longitude:', longitude);

            if (!noTelepon) {
                e.preventDefault();
                swal({
                    title: 'Peringatan!',
                    text: 'Nomor telepon harus diisi.',
                    type: 'warning',
                    confirmButtonColor: '#007bff'
                });
                return false;
            }

            if (!latitude || !longitude) {
                e.preventDefault();
                swal({
                    title: 'Peringatan!',
                    text: 'Silakan klik pada peta untuk menentukan lokasi koordinat.',
                    type: 'warning',
                    confirmButtonColor: '#007bff'
                });
                return false;
            }

            // SEMENTARA BYPASS KONFIRMASI UNTUK TESTING
            console.log('Form validation passed, submitting...');
            // Form akan submit secara normal tanpa konfirmasi
            return true;

            // Konfirmasi sebelum simpan (commented sementara)
            /*
            e.preventDefault();
            swal({
                title: 'Konfirmasi',
                text: 'Apakah Anda yakin ingin menyimpan pengaturan ini?',
                type: 'info',
                showCancelButton: true,
                confirmButtonColor: '#007bff',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Simpan!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.value || result === true) {
                    // Debug: log form data
                    console.log('Form akan di-submit');
                    console.log('NoTelepon:', document.getElementById('NoTelepon').value);
                    console.log('Latitude:', document.getElementById('Latitude').value);
                    console.log('Longitude:', document.getElementById('Longitude').value);
                    
                    // Submit form secara normal seperti UserAdd.php
                    document.getElementById('koordinatForm').submit();
                }
            });
            */
        });
    });
</script>