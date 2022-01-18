
const addApplicationButton = document.querySelector('.add-application-button');
const addApplicationForm = document.querySelector('.add-application-form');
const editApplicationForm = document.querySelector('.edit-application-form');

window.applicationSwal = Swal.mixin({
    customClass: {
        confirmButton: 'inline-flex items-center px-4 py-2 mr-3 bg-blue border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest focus:outline-none focus:ring disabled:opacity-25',
        cancelButton: 'inline-flex items-center px-4 py-2 bg-blue border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest focus:outline-none focus:ring disabled:opacity-25',
        title: 'text-xl font-medium',
        container: 'text-left',
        inputLabel: 'text-left'
      }
});

if (addApplicationButton) {
    addApplicationButton.addEventListener('click', () => {
        applicationSwal.fire({
            title: 'Add Application',
            html:addApplicationForm.innerHTML,
            showCloseButton: true,
            showCancelButton: true,
            confirmButtonText: 'Save',
            confirmButtonAriaLabel: 'Save',
            cancelButtonAriaLabel: 'Cancel',
            confirmButtonColor: 'rgba(45, 64, 83, var(--tw-bg-opacity))',
            cancelButtonColor: 'rgba(45, 64, 83, var(--tw-bg-opacity))',
            buttonsStyling: false
          });
    });
}
