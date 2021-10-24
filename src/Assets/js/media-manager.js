function showNotification(type, message) {
    toastr.options = {
        "closeButton": true,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toast-bottom-right",
        "showDuration": "100",
        "hideDuration": "750",
        "timeOut": "2000",
        "extendedTimeOut": "750",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }

    if (type === 'success') {
        toastr.success(message)
    } else if (type === 'error') {
        toastr.error(message)
    }
}
