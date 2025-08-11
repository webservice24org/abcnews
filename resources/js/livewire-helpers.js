// livewire-helpers.js

// Delete confirmation dialog
/*
window.confirmDelete = function (eventName, id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "This action cannot be undone!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#e3342f',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, delete it!',
    }).then((result) => {
        if (result.isConfirmed) {
            window.Livewire.dispatch(eventName, id);  // <-- pass id directly
        }
    });
};
*/

window.confirmDelete = function (eventName, id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "This action cannot be undone!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#e3342f',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, delete it!',
    }).then((result) => {
        if (result.isConfirmed) {
            window.Livewire.dispatch(eventName, id); 
        }
    });
};



// Restore confirmation dialog
window.confirmRestore = function (eventName, id) {
    Swal.fire({
        title: 'Restore this post?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#28a745',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, restore it!',
    }).then((result) => {
        if (result.isConfirmed) {
            window.Livewire.dispatch(eventName, id);
        }
    });
};


// Toast with SweetAlert2
window.showToast = function (type = 'success', message = 'Successfully saved!') {
    Swal.fire({
        toast: true,
        position: 'top-end',
        icon: type,
        title: message,
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
    });
};

 
document.addEventListener("DOMContentLoaded", function () {
    if (window.Livewire) {
        window.Livewire.on('confirm-delete', (id) => {
            confirmDelete('deleteConfirmed', id);
        });

        window.Livewire.on('restoreConfirmed', (id) => {
            confirmRestore('restoreConfirmed', id);
        });

        window.Livewire.on('confirm-force-delete', (id) => {
            confirmForceDelete('forceDeleteConfirmed', id);
        });

        window.Livewire.on('toast', ({ type, message }) => {
            
            showToast(type, message); 
            
        });
    }
});

