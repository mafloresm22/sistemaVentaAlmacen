import './bootstrap';
import Swal from 'sweetalert2';

// Expose Swal globally for use in blade templates
window.Swal = Swal;

/*
  Add custom scripts here
*/
import.meta.glob([
  '../assets/img/**',
  // '../assets/json/**',
  '../assets/vendor/fonts/**'
]);
