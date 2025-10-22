/**
 * CSP-Compliant Notification Handler using SweetAlert
 * Reads notification data from DOM data attributes
 */

(function() {
    'use strict';
    
    /**
     * Show SweetAlert notification based on data attributes
     */
    function showNotificationFromData() {
        const alertElement = document.getElementById('alert-data');
        if (!alertElement) {
            return;
        }
        
        const title = alertElement.getAttribute('data-title');
        const message = alertElement.getAttribute('data-message');
        const icon = alertElement.getAttribute('data-icon');
        
        if (!title || !message || !icon) {
            return;
        }
        
        // Check if SweetAlert is available
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                title: title,
                text: message,
                icon: icon,
                showConfirmButton: true,
                confirmButtonText: 'OK',
                timer: null,
                timerProgressBar: false
            });
        } else {
            // Fallback with retry mechanism
            let retryCount = 0;
            const maxRetries = 10;
            const retryInterval = 200;
            
            const retryShowAlert = function() {
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        title: title,
                        text: message,
                        icon: icon,
                        showConfirmButton: true,
                        confirmButtonText: 'OK',
                        timer: null,
                        timerProgressBar: false
                    });
                } else if (retryCount < maxRetries) {
                    retryCount++;
                    setTimeout(retryShowAlert, retryInterval);
                } else {
                    // Final fallback to native alert
                    alert(title + ': ' + message);
                }
            };
            
            setTimeout(retryShowAlert, retryInterval);
        }
        
        // Remove the alert data element after showing
        alertElement.remove();
    }
    
    /**
     * Initialize notification system
     */
    function initNotificationSystem() {
        // Show notification if data exists
        showNotificationFromData();
    }
    
    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initNotificationSystem);
    } else {
        initNotificationSystem();
    }
    
})();
