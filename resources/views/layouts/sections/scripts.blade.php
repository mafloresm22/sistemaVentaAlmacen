<!-- BEGIN: Vendor JS-->

@vite(['resources/assets/vendor/libs/jquery/jquery.js', 'resources/assets/vendor/libs/popper/popper.js', 'resources/assets/vendor/js/bootstrap.js'])

@vite(['resources/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js', 'resources/assets/vendor/js/menu.js'])

<!-- DataTables + SweetAlert2 (CDN) -->
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js" defer></script>
<script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js" defer></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js" defer></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js" defer></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap5.min.js" defer></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11" defer></script>

@yield('vendor-script')
<!-- END: Page Vendor JS-->
<!-- BEGIN: Theme JS-->
@vite(['resources/assets/js/main.js'])

<!-- END: Theme JS-->
<!-- Pricing Modal JS-->
@stack('pricing-script')
<!-- END: Pricing Modal JS-->
<!-- BEGIN: Page JS-->
@yield('page-script')
<!-- END: Page JS-->

<!-- app JS -->
@vite(['resources/js/app.js'])
<!-- END: app JS-->

<!-- SweetAlert2 Global Handlers and Helpers -->
<script>
  document.addEventListener('DOMContentLoaded', function () {
    // Función helper global reutilizable
    window.showAlert = function (icon, title, text, timer = 2500) {
      Swal.fire({
        icon: icon,
        title: title,
        text: text,
        timer: timer,
        showConfirmButton: icon === 'error',
        confirmButtonColor: '#696cff'
      });
    };

    // Lanzar alertas automáticas de sesiones flash de Laravel
    @if (session('success'))
      showAlert('success', '¡Operación Exitosa!', "{!! addslashes(session('success')) !!}");
    @endif

    @if (session('error'))
      showAlert('error', '¡Ocurrió un Error!', "{!! addslashes(session('error')) !!}", 4000);
    @endif

    @if (session('warning'))
      showAlert('warning', '¡Atención!', "{!! addslashes(session('warning')) !!}", 3500);
    @endif
  });
</script>
