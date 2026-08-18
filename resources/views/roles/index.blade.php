@extends('layouts.contentNavbarLayout')

@section('title', 'Roles')

@section('content')

  {{-- Encabezado --}}
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h4 class="fw-bold mb-1">Roles del Sistema</h4>
      <p class="text-muted mb-0">Gestiona los roles asignados a los usuarios</p>
    </div>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCrearRol">
      <i class="bx bx-plus me-1"></i> Nuevo Rol
    </button>
  </div>

  {{-- Listado en Cards --}}
  <div class="row g-4 mb-4">
    @forelse ($roles as $rol)
      <div class="col-12 col-md-6 col-lg-4">
        <div class="card h-100 shadow-sm border-0">
          <div class="card-body d-flex flex-column justify-content-between">

            <div class="d-flex align-items-center justify-content-between mb-3">
              <div class="avatar shrink-0 me-3">
                <span class="avatar-initial rounded bg-label-primary">
                  <i class="bx bx-shield-quarter fs-3"></i>
                </span>
              </div>
            </div>

            <div class="mb-3">
              <h5 class="card-title fw-bold text-primary mb-1">
                {{ $rol->nameRoles }}
              </h5>
              <small class="text-muted">Rol registrado en el sistema</small>
            </div>

            <div class="pt-3 border-top d-flex justify-content-between align-items-center">
              <form id="form-delete-{{ $rol->idRoles }}" action="{{ route('roles.destroy', $rol->idRoles) }}" method="POST"
                class="w-100">
                @csrf
                @method('DELETE')
                <button type="button" class="btn btn-outline-danger w-100 d-flex align-items-center justify-content-center"
                  onclick="confirmarEliminar({{ $rol->idRoles }}, '{{ addslashes($rol->nameRoles) }}')">
                  <i class="bx bx-trash me-1"></i> Eliminar Rol
                </button>
              </form>
            </div>

          </div>
        </div>
      </div>
    @empty
      <div class="col-12">
        <div class="card">
          <div class="card-body text-center py-5">
            <i class="bx bx-folder-open display-4 text-muted mb-2"></i>
            <h5>No hay roles registrados</h5>
            <p class="text-muted mb-0">Comienza registrando un nuevo rol utilizando el botón superior.</p>
          </div>
        </div>
      </div>
    @endforelse
  </div>

  <div class="d-flex justify-content-center">
    {{ $roles->links('pagination::bootstrap-5') }}
  </div>

  @include('roles.modal_create')
@endsection

@section('page-script')
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      // Reabrir modal de creación si existen errores de validación
      @if ($errors->any())
        var modal = new bootstrap.Modal(document.getElementById('modalCrearRol'));
        modal.show();
      @endif
          });

    // Confirmación de eliminación con SweetAlert2
    function confirmarEliminar(id, nombre) {
      Swal.fire({
        title: '¿Eliminar rol?',
        html: `El rol <strong>${nombre}</strong> será eliminado permanentemente.`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar',
        customClass: {
          confirmButton: 'btn btn-danger me-3',
          cancelButton: 'btn btn-label-secondary'
        },
        buttonsStyling: false
      }).then((result) => {
        if (result.isConfirmed) {
          document.getElementById('form-delete-' + id).submit();
        }
      });
    }
  </script>
@endsection