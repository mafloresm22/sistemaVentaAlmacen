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
    @php
      $cardColors = ['bg-primary', 'bg-success', 'bg-info', 'bg-warning', 'bg-danger'];
    @endphp
    @forelse ($roles as $index => $rol)
      @php
        $colorClass = $cardColors[$index % count($cardColors)];
      @endphp
      <div class="col-12 col-md-6 col-lg-4">
        <div class="card h-100 shadow-sm border-0 {{ $colorClass }} transition-all hover-scale">
          <div class="card-body d-flex flex-column justify-content-between">

            <div class="d-flex align-items-center justify-content-between mb-3">
              <div class="avatar shrink-0 me-3">
                <span class="avatar-initial rounded bg-white text-dark shadow-sm">
                  <i class="bx bx-shield-quarter fs-3"></i>
                </span>
              </div>
            </div>

            <div class="mb-3">
              <h5 class="card-title fw-bold mb-1 text-dark">
                {{ $rol->nameRoles }}
              </h5>
            </div>

            <div class="pt-3 border-top border-white-50 d-flex justify-content-between align-items-center mt-auto">
              <form id="form-delete-{{ $rol->idRoles }}" action="{{ route('roles.destroy', $rol->idRoles) }}"
                method="POST" class="w-100">
                @csrf
                @method('DELETE')
                <button type="button"
                  class="btn btn-danger w-100 d-flex align-items-center justify-content-center shadow-sm rounded-pill transition-all"
                  onclick="confirmarEliminar({{ $rol->idRoles }}, '{{ addslashes($rol->nameRoles) }}')">
                  <i class="bx bx-trash me-2"></i> Eliminar Rol
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
    document.addEventListener('DOMContentLoaded', function() {
      @if ($errors->any())
        var modal = new bootstrap.Modal(document.getElementById('modalCrearRol'));
        modal.show();
      @endif
    });

    function confirmarEliminar(id, nombre) {
      Swal.fire({
        title: '¿Eliminar rol?',
        html: `El rol <strong>${nombre}</strong> será eliminado permanentemente.`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
      }).then((result) => {
        if (result.isConfirmed) {
          document.getElementById('form-delete-' + id).submit();
        }
      });
    }
  </script>
@endsection
