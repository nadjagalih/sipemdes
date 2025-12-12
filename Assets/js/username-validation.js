/**
 * Secure Username Validation System
 * Uses data attributes and event delegation
 * CSP-compliant implementation
 */

(function() {
    'use strict';
    
    /**
     * Secure AJAX request handler
     */
    function makeSecureRequest(url, data, successCallback, errorCallback) {
        const xhr = new XMLHttpRequest();
        xhr.open('POST', url, true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    successCallback(xhr.responseText);
                } else {
                    errorCallback(`HTTP ${xhr.status}: ${xhr.statusText}`);
                }
            }
        };
        
        xhr.onerror = function() {
            errorCallback('Network connection error');
        };
        
        xhr.ontimeout = function() {
            errorCallback('Request timeout');
        };
        
        xhr.timeout = 10000; // 10 second timeout
        xhr.send(data);
    }
    
    /**
     * Username validation handler
     */
    function validateUsername(inputElement) {
        const endpoint = inputElement.dataset.validationEndpoint;
        const targetId = inputElement.dataset.validationTarget;
        const paramName = inputElement.dataset.validationParam || 'UserName';
        const targetElement = document.getElementById(targetId);
        
        if (!endpoint || !targetElement) {
            console.error('Validation configuration incomplete');
            return;
        }
        
        const username = inputElement.value.trim();
        
        // Clear validation if empty
        if (username.length === 0) {
            targetElement.innerHTML = '';
            return;
        }
        
        // Minimum length check
        if (username.length < 3) {
            targetElement.innerHTML = '<span style="color: orange;">Username minimal 3 karakter</span>';
            return;
        }
        
        // Show loading state
        targetElement.innerHTML = '<span style="color: blue; font-weight: bold;">🔄 Memeriksa ketersediaan...</span>';
        
        // Make secure request with configurable parameter name
        const requestData = paramName + '=' + encodeURIComponent(username);
        
        makeSecureRequest(
            endpoint,
            requestData,
            function(response) {
                // Success callback
                targetElement.innerHTML = response;
                
                // Initialize dropdowns after dynamic content is loaded
                setTimeout(function() {
                    // Try to initialize dropdowns with or without Select2
                    try {
                        if (typeof $ !== 'undefined' && $.fn.select2) {
                            // Safely destroy existing instances
                            try { $('#Akses').select2('destroy'); } catch(e) {}
                            try { $('#UnitKerja').select2('destroy'); } catch(e) {}
                            try { $('#IdKecamatan').select2('destroy'); } catch(e) {}
                            try { $('#Status').select2('destroy'); } catch(e) {}
                            
                            // Re-initialize with error handling
                            setTimeout(function() {
                                try {
                                    if ($('#Akses').length) {
                                        $('#Akses').select2({
                                            placeholder: "Pilih Hak Akses",
                                            allowClear: true,
                                            width: '100%'
                                        });
                                    }
                                    
                                    if ($('#UnitKerja').length) {
                                        $('#UnitKerja').select2({
                                            placeholder: "Pilih Unit Kerja",
                                            allowClear: true,
                                            width: '100%'
                                        });
                                    }
                                    
                                    if ($('#IdKecamatan').length) {
                                        $('#IdKecamatan').select2({
                                            placeholder: "Pilih Kecamatan",
                                            allowClear: true,
                                            width: '100%'
                                        });
                                    }
                                    
                                    if ($('#Status').length) {
                                        $('#Status').select2({
                                            placeholder: "Pilih Status",
                                            allowClear: true,
                                            width: '100%'
                                        });
                                    }
                                } catch(e) {
                                    console.log('Select2 initialization error:', e);
                                }
                            }, 200);
                        }
                    } catch(e) {
                        console.log('Dropdown initialization error:', e);
                    }
                }, 100);
            },
            function(error) {
                // Error callback
                targetElement.innerHTML = `<span style="color: red;">❌ ${error}</span>`;
            }
        );
    }
    
    /**
     * Debounce function to prevent excessive requests
     */
    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = function() {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }
    
    /**
     * Initialize validation system
     */
    function initValidationSystem() {
        // Use event delegation for security - supports multiple validation types
        document.addEventListener('input', function(event) {
            if (event.target && 
                (event.target.dataset.validation === 'username' || 
                 event.target.dataset.validation === 'username-kecamatan')) {
                const debouncedValidation = debounce(function() {
                    validateUsername(event.target);
                }, 300); // 300ms debounce
                
                debouncedValidation();
            }
        });
        
        document.addEventListener('keyup', function(event) {
            if (event.target && 
                (event.target.dataset.validation === 'username' || 
                 event.target.dataset.validation === 'username-kecamatan')) {
                const debouncedValidation = debounce(function() {
                    validateUsername(event.target);
                }, 300);
                
                debouncedValidation();
            }
        });
    }
    
    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initValidationSystem);
    } else {
        initValidationSystem();
    }
    
})();