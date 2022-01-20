
const addApplicationButton = document.querySelector('.add-application-button');
const addApplicationForm = document.querySelector('.add-application-form');
const editApplicationForm = document.querySelector('.edit-application-form');

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

if (addApplicationButton) {
    addApplicationButton.addEventListener('click', () => showAddApplicationForm(), false);

        // applicationSwal.fire({
        //     title: 'Add Application',
        //     html:addApplicationForm.innerHTML,
        //     showCloseButton: true,
        //     showCancelButton: true,
        //     confirmButtonText: 'Save',
        //     confirmButtonAriaLabel: 'Save',
        //     cancelButtonAriaLabel: 'Cancel',
        //     confirmButtonColor: 'rgba(45, 64, 83, var(--tw-bg-opacity))',
        //     cancelButtonColor: 'rgba(45, 64, 83, var(--tw-bg-opacity))',
        //     buttonsStyling: false,
        //     preConfirm: function() {
        //         return new Promise((resolve, reject) => {
        //             // get your inputs using their placeholder or maybe add IDs to them
        //             resolve({
        //                 name: addApplicationForm.elements['name'].value
        //             });
        //         })
        //     }
        // }).then((result) => {
        //     console.log('submitting form....');
        //     console.log(result);

        //     if (result.isConfirmed) {
        //         //submit form
        //     }
        // })
    }

const showAddApplicationForm = async () => {
    console.log('sadlfkjaslkdjflkajsd');

    const { value: name } = await applicationSwal.fire({
        title: 'Add Applicaiton',
        input: 'text',
        inputLabel: 'Name',
        inputValue: '',
        showCancelButton: true,
        inputValidator: (value) => {
            if (!value) {
                return 'Please Enter a Name!'
            }
        }
    });

    console.log(name);

    // applicationSwal.fire({
    //     title: 'Add Application',
    //     html:addApplicationForm.innerHTML,
    //     showCloseButton: true,
    //     showCancelButton: true,
    //     confirmButtonText: 'Save',
    //     confirmButtonAriaLabel: 'Save',
    //     cancelButtonAriaLabel: 'Cancel',
        // confirmButtonColor: 'rgba(45, 64, 83, var(--tw-bg-opacity))',
        // cancelButtonColor: 'rgba(45, 64, 83, var(--tw-bg-opacity))',
    //     buttonsStyling: false,
    // }).then((result) => {
    //     console.log('submitting form....');
    //     console.log(result);

    //     if (result.isConfirmed) {
    //         //submit form
    //     }
    // });
}
