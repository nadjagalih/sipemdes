<?php
// Include safe helpers and CSP handler
require_once __DIR__ . '/../../helpers/safe_helpers.php';
require_once __DIR__ . '/../../Module/Security/CSPHandler.php';

// Set CSP headers
CSPHandler::setCSPHeaders();

include "../App/Control/FunctionDesaEdit.php";
?>

<!-- Bootstrap CSS -->
<link href="../Assets/argon/argon.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@300;400;500;700&display=swap" rel="stylesheet">
<link href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" rel="stylesheet">

<!-- jQuery -->
<script <?php echo CSPHandler::scriptNonce(); ?> src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" 
      integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" 
      crossorigin=""
      onerror="console.error('Failed to load Leaflet CSS')"/>
<script <?php echo CSPHandler::scriptNonce(); ?> 
        src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
        crossorigin=""
        onload="console.log('Leaflet JS loaded successfully')"
        onerror="console.error('Failed to load Leaflet JS')"></script>

<!-- SweetAlert -->
<script <?php echo CSPHandler::scriptNonce(); ?> src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<style>
    /* Map Container Styles */
    .map-container {
        height: 400px;
        border-radius: 0.5rem;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        border: 1px solid #e7eaec;
        background: #f8f9fa;
    }

    #koordinatMap {
        height: 100%;
        width: 100%;
    }

    .coordinate-info {
        background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
        padding: 15px;
        border-radius: 10px;
        border: 1px solid #2196f3;
        margin-bottom: 15px;
    }

    .coordinate-display {
        font-family: 'Courier New', monospace;
        font-size: 0.9rem;
        color: #1976d2;
        font-weight: 600;
    }

    /* Search Styles */
    .search-section {
        background: linear-gradient(135deg, #e3f2fd 0%, #f8f9fa 100%);
        border-bottom: 1px solid #dee2e6;
        padding: 15px;
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

    .search-no-results {
        padding: 20px;
        text-align: center;
        color: #6c757d;
        font-style: italic;
        font-size: 13px;
    }
</style>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Data Desa</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="">Dashboard</a>
            </li>
            <li class="breadcrumb-item">
                <a>Setting</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Desa</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2">

    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="container-fluid">
        <form action="../App/Model/ExcDesa?Act=Edit" method="POST" id="desaEditForm" enctype="multipart/form-data">
            <div class="row">
                <div class="col-lg-5">
                    <div class="ibox">
                        <div class="ibox-title">
                            <h5>Form Edit Desa</h5>
                            <div class="ibox-tools">
                                <a class="collapse-link">
                                    <i class="fa fa-chevron-up"></i>
                                </a>
                                <a class="close-link">
                                    <i class="fa fa-times"></i>
                                </a>
                            </div>
                        </div>
                        <div class="ibox-content">
                            <input type="hidden" name="IdDesa" id="IdDesa" value="<?php echo $EditIdDesa; ?>">
                            
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label">Kode Desa</label>
                                <div class="col-lg-8">
                                    <input type="text" name="KodeDesa" id="KodeDesa" value="<?php echo $EditKodeDesa; ?>" class="form-control" required autocomplete="off">
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label">Nama Desa</label>
                                <div class="col-lg-8">
                                    <input type="text" name="Desa" id="Desa" value="<?php echo $EditNamaDesa; ?>" class="form-control" required autocomplete="off">
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label">Kecamatan</label>
                                <div class="col-lg-8">
                                    <?php include "../App/Control/FunctionSelectKecamatan.php"; ?>
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label">Kabupaten</label>
                                <div class="col-lg-8">
                                    <?php include "../App/Control/FunctionSelectKabupaten.php"; ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label">
                                    <i class="fas fa-phone"></i>
                                    No. Telepon
                                </label>
                                <div class="col-lg-8">
                                    <input type="text" 
                                        class="form-control" 
                                        name="NoTelepon" 
                                        id="NoTelepon" 
                                        value="<?php echo htmlspecialchars($EditNoTelepon); ?>" 
                                        placeholder="Contoh: 0341-123456 / 08123456789" 
                                        required
                                        autocomplete="off">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label">
                                    <i class="fas fa-map-marker-alt"></i>
                                    Alamat Desa
                                </label>
                                <div class="col-lg-8">
                                    <textarea 
                                        class="form-control" 
                                        name="AlamatDesa" 
                                        id="AlamatDesa" 
                                        rows="3" 
                                        placeholder="Masukkan alamat lengkap desa..." 
                                        required
                                        autocomplete="off"><?php echo htmlspecialchars($EditAlamatDesa); ?></textarea>
                                </div>
                            </div>

                            <div class="coordinate-info">
                                <h6 style="margin-bottom: 0.75rem; color: #1976d2;">
                                    <i class="fas fa-crosshairs"></i>
                                    Koordinat Saat Ini
                                </h6>
                                <div class="coordinate-display">
                                    <div>Latitude: <span id="currentLat"><?php echo $EditLatitude ?: 'Belum diset'; ?></span></div>
                                    <div>Longitude: <span id="currentLng"><?php echo $EditLongitude ?: 'Belum diset'; ?></span></div>
                                </div>
                            </div>

                            <input type="hidden" name="Latitude" id="Latitude" value="<?php echo $EditLatitude; ?>">
                            <input type="hidden" name="Longitude" id="Longitude" value="<?php echo $EditLongitude; ?>">

                            <div class="form-group row">
                                <div class="col-lg-offset-2 col-lg-10">
                                    <button class="btn btn-primary" type="submit" name="Edit" id="Edit">
                                        <i class="fas fa-save"></i> Update Data
                                    </button>
                                    <a href="?pg=DesaView" class="btn btn-secondary">
                                        <i class="fas fa-arrow-left"></i> Batal
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-7">
                    <div class="ibox">
                        <div class="ibox-title">
                            <h5>Pilih Lokasi pada Peta</h5>
                        </div>
                        
                        <!-- Search Bar -->
                        <div class="search-section">
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
                                <div id="koordinatMap" style="height: 400px; width: 100%; min-height: 400px; background: #f0f0f0; border: 2px solid #ddd;">
                                    <div id="mapStatus" style="padding: 20px; text-align: center; color: #666;">
                                        📍 Memuat peta...
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Map Script -->
<script <?php echo CSPHandler::scriptNonce(); ?>>
    // Global variables
    var map = null;
    var marker = null;
    var isMapInitialized = false;

    // Update coordinates function
    function updateCoordinates(lat, lng) {
        try {
            document.getElementById('currentLat').textContent = lat.toFixed(6);
            document.getElementById('currentLng').textContent = lng.toFixed(6);
            document.getElementById('Latitude').value = lat.toFixed(6);
            document.getElementById('Longitude').value = lng.toFixed(6);
            console.log('📍 Coordinates updated:', lat.toFixed(6), lng.toFixed(6));
        } catch (error) {
            console.error('❌ Error updating coordinates:', error);
        }
    }

    // Simple map initialization
    function initMap() {
        try {
            console.log('🗺️ Starting map initialization...');
            
            if (typeof L === 'undefined') {
                console.error('❌ Leaflet not loaded');
                return;
            }
            
            var lat = <?php echo !empty($EditLatitude) && is_numeric($EditLatitude) ? $EditLatitude : '-8.055'; ?>;
            var lng = <?php echo !empty($EditLongitude) && is_numeric($EditLongitude) ? $EditLongitude : '111.715'; ?>;
            
            console.log('📍 Using coordinates:', lat, lng);
            
            map = L.map('koordinatMap').setView([lat, lng], 13);
            
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);
            
            // Add existing marker if coordinates exist
            <?php if (!empty($EditLatitude) && !empty($EditLongitude)): ?>
            marker = L.marker([lat, lng], {draggable: true}).addTo(map);
            marker.bindPopup('<b><?php echo addslashes($EditNamaDesa ?? 'Desa'); ?></b><br>Lokasi saat ini').openPopup();
            marker.on('dragend', function(e) {
                updateCoordinates(marker.getLatLng().lat, marker.getLatLng().lng);
            });
            <?php endif; ?>
            
            // Map click event
            map.on('click', function(e) {
                if (marker) map.removeLayer(marker);
                marker = L.marker([e.latlng.lat, e.latlng.lng], {draggable: true}).addTo(map);
                marker.bindPopup('<b><?php echo addslashes($EditNamaDesa ?? 'Desa'); ?></b><br>Lokasi baru').openPopup();
                marker.on('dragend', function(e) {
                    updateCoordinates(marker.getLatLng().lat, marker.getLatLng().lng);
                });
                updateCoordinates(e.latlng.lat, e.latlng.lng);
            });
            
            isMapInitialized = true;
            console.log('✅ Map initialized successfully');
            
        } catch (error) {
            console.error('❌ Map initialization error:', error);
        }
    }

    // Search functionality
    var searchInput = document.getElementById('searchInput');
    var searchButton = document.getElementById('searchButton');
    var searchClear = document.getElementById('searchClear');
    var searchResults = document.getElementById('searchResults');
    var searchTimeout = null;

    // Show/hide clear button
    function toggleClearButton() {
        if (searchClear && searchInput) {
            searchClear.style.display = searchInput.value.length > 0 ? 'block' : 'none';
        }
    }

    // Search function
    function searchLocation(query) {
        if (query.length < 3) {
            hideSearchResults();
            return;
        }

        showSearchResults();
        searchResults.innerHTML = '<div class="search-loading"><i class="fas fa-spinner fa-spin"></i> Mencari lokasi...</div>';

        var nominatimUrl = 'https://nominatim.openstreetmap.org/search?' +
            'format=json' +
            '&q=' + encodeURIComponent(query) +
            '&countrycodes=id' +
            '&limit=8' +
            '&addressdetails=1';

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
            
            var title = result.display_name.split(',')[0];
            var description = result.display_name.split(',').slice(1, 3).join(',');
            
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
        
        searchInput.value = title;
        toggleClearButton();
        hideSearchResults();
        
        if (marker) {
            map.removeLayer(marker);
        }
        
        marker = L.marker([lat, lng], {
            draggable: true
        }).addTo(map);
        
        marker.bindPopup('<b>' + title + '</b><br>Lokasi dari pencarian').openPopup();
        
        updateCoordinates(lat, lng);
        map.setView([lat, lng], 15);
        
        marker.on('dragend', function(e) {
            var position = marker.getLatLng();
            updateCoordinates(position.lat, position.lng);
        });
    }

    // Show/hide search results
    function showSearchResults() {
        if (searchResults) {
            searchResults.style.display = 'block';
        }
    }

    function hideSearchResults() {
        if (searchResults) {
            searchResults.style.display = 'none';
        }
    }

    // Initialize on document ready
    document.addEventListener('DOMContentLoaded', function() {
        console.log('🚀 DOM loaded, preparing map...');
        
        // Wait for Leaflet to load
        var checkLeaflet = function() {
            if (typeof L !== 'undefined') {
                console.log('✅ Leaflet detected, initializing map...');
                setTimeout(initMap, 500);
            } else {
                console.log('⏳ Waiting for Leaflet...');
                setTimeout(checkLeaflet, 100);
            }
        };
        
        checkLeaflet();

        // Setup search events if elements exist
        if (searchInput) {
            searchInput.addEventListener('input', function() {
                toggleClearButton();
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(function() {
                    searchLocation(searchInput.value);
                }, 500);
            });

            searchInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    searchLocation(searchInput.value);
                }
            });
        }

        if (searchButton) {
            searchButton.addEventListener('click', function() {
                searchLocation(searchInput.value);
            });
        }

        if (searchClear) {
            searchClear.addEventListener('click', function() {
                searchInput.value = '';
                toggleClearButton();
                hideSearchResults();
            });
        }

        document.addEventListener('click', function(e) {
            if (!e.target.closest('.search-box-external')) {
                hideSearchResults();
            }
        });

        toggleClearButton();

        // Setup form validation
        setTimeout(function() {
            var form = document.getElementById('desaEditForm');
            if (form) {
                form.addEventListener('submit', function(e) {
                    var namaDesa = document.getElementById('Desa').value.trim();
                    var kodeDesa = document.getElementById('KodeDesa').value.trim();

                    if (!namaDesa || !kodeDesa) {
                        e.preventDefault();
                        swal({
                            title: 'Peringatan!',
                            text: 'Nama Desa dan Kode Desa harus diisi.',
                            type: 'warning',
                            confirmButtonColor: '#007bff'
                        });
                        return false;
                    }
                    return true;
                });
            }
        }, 1000);
    });
</script>