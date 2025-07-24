import './bootstrap';
// Basic JavaScript for Asset Management System

// Auto-hide flash messages after 5 seconds
document.addEventListener('DOMContentLoaded', function() {
    const flashMessages = document.querySelectorAll('.bg-green-100, .bg-red-100');
    
    flashMessages.forEach(function(message) {
        setTimeout(function() {
            message.style.transition = 'opacity 0.5s ease-out';
            message.style.opacity = '0';
            setTimeout(function() {
                message.remove();
            }, 500);
        }, 5000);
    });
});

// Confirmation dialogs
window.confirmAction = function(message) {
    return confirm(message || 'Are you sure you want to perform this action?');
};