
const addApplicationButton = document.querySelector('.add-application-button');
const addApplicationForm = document.querySelector('.add-application-form');
const editApplicationForm = document.querySelector('.edit-application-form');
const deleteApplicationButton = document.querySelector('.edit-application-form');

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

document.addEventListener('click', function(evt) {
    evt.preventDefault();

    applicationSwal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        // confirmButtonColor: '#3085d6',
        // cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        console.log(result);

        if (result.isConfirmed) {
            console.log('firing new one...');

            applicationSwal.fire(
                'Deleted!',
                'Your file has been deleted.',
                'success'
            )
        }
    });
});
