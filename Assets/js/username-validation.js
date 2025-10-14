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
        
        // Make secure request
        const requestData = 'UserNama=' + encodeURIComponent(username);
        
        makeSecureRequest(
            endpoint,
            requestData,
            function(response) {
                // Success callback
                targetElement.innerHTML = response;
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
        // Use event delegation for security
        document.addEventListener('input', function(event) {
            if (event.target && event.target.dataset.validation === 'username') {
                const debouncedValidation = debounce(function() {
                    validateUsername(event.target);
                }, 300); // 300ms debounce
                
                debouncedValidation();
            }
        });
        
        document.addEventListener('keyup', function(event) {
            if (event.target && event.target.dataset.validation === 'username') {
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