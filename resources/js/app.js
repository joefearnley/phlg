require('./bootstrap');
import Swal from 'sweetalert2';
// import 'sweetalert2/src/sweetalert2.scss'
import Alpine from 'alpinejs';

window.Swal = Swal;

window.Alpine = Alpine;
Alpine.start();

require('./applications');
require('./messages');
