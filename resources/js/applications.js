
window.applicationSwal = Swal.mixin({
    showCancelButton: true,
    confirmButtonText: 'Save',
    confirmButtonAriaLabel: 'Save',
    cancelButtonAriaLabel: 'Cancel',
    confirmButtonColor: '#2d4053',
    cancelButtonColor: '#2d4053',
    customClass: {
        color: 'rgba(45, 64, 83, var(--tw-bg-opacity))',
        confirmButton: 'inline-flex items-center px-4 py-2 mr-3 bg-blue border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest focus:outline-none focus:ring disabled:opacity-25',
        cancelButton: 'inline-flex items-center px-4 py-2 bg-blue border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest focus:outline-none focus:ring disabled:opacity-25',
        inputLabel: 'block font-medium text-sm text-gray-700',
        input: 'rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full'
      },
      buttonsStyling: false
});

const cancelApplicationForm = document.querySelector('.cancel-create-application-form');
const deleteApplicationForms = document.querySelectorAll('.delete-application-form');

cancelApplicationForm.addEventListener('click', event => {
    event.preventDefault();
    location = '/applications';
})

deleteApplicationForms.forEach(deleteButton => {
    deleteButton.addEventListener('submit', event => {
        event.preventDefault();
        let form = event.target;

        applicationSwal.fire({
            title: 'Delete Application',
            text: "Are you sure you want to delete this application?",
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
});
