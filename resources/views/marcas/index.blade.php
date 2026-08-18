@extends('layouts.contentNavbarLayout')

@section('title', 'Marcas')

@section('content')

  {{-- Encabezado --}}
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h4 class="fw-bold mb-1">Marcas de Productos</h4>
      <p class="text-muted mb-0">Administra las marcas registradas en el inventario</p>
    </div>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCrearMarca">
      <i class="bx bx-plus me-1"></i> Nueva Marca
    </button>
  </div>

  @php
    $bgStyles = [
        ['bg' => 'bg-label-primary', 'border' => 'border-primary', 'btn' => 'btn-primary'],
        ['bg' => 'bg-label-success', 'border' => 'border-success', 'btn' => 'btn-success'],
        ['bg' => 'bg-label-info', 'border' => 'border-info', 'btn' => 'btn-info'],
        ['bg' => 'bg-label-warning', 'border' => 'border-warning', 'btn' => 'btn-warning'],
        ['bg' => 'bg-label-danger', 'border' => 'border-danger', 'btn' => 'btn-danger'],
        ['bg' => 'bg-label-dark', 'border' => 'border-dark', 'btn' => 'btn-dark'],
    ];
  @endphp

  <div class="row g-3 mb-4">
    @forelse ($marcas as $index => $marca)
      @php
        $color = $bgStyles[$index % count($bgStyles)];
      @endphp

      <div class="col-12 col-sm-6 col-md-4 col-lg-3">
        {{-- Card con fondo suave y borde fino elegante --}}
        <div class="card h-100 border-start border-3 {{ $color['border'] }} {{ $color['bg'] }} shadow-sm">
          <div class="card-body p-3 d-flex align-items-center justify-content-between">

            {{-- Icono y Nombre de la Marca --}}
            <div class="d-flex align-items-center me-2 overflow-hidden">
              <div class="avatar avatar-sm shrink-0 me-3">
                <span class="avatar-initial rounded-circle bg-white text-dark shadow-xs">
                  <i class="bx bx-purchase-tag-alt fs-5"></i>
                </span>
              </div>
              <h6 class="mb-0 fw-bold text-dark text-truncate" title="{{ $marca->nameMarcas }}">
                {{ $marca->nameMarcas }}
              </h6>
            </div>

            {{-- Botón de Acción Editar y Eliminar --}}
            <div class="d-flex align-items-center gap-1">
              <button type="button" class="btn btn-icon btn-sm btn-white text-primary shadow-xs" title="Editar marca"
                data-bs-toggle="modal" data-bs-target="#modalEditarMarca{{ $marca->idMarcas }}">
                <i class="bx bx-edit fs-6"></i>
              </button>
              <form id="form-delete-{{ $marca->idMarcas }}" action="{{ route('marcas.destroy', $marca->idMarcas) }}"
                method="POST">
                @csrf
                @method('DELETE')
                <button type="button" class="btn btn-icon btn-sm btn-white text-danger shadow-xs" title="Eliminar marca"
                  onclick="confirmarEliminar({{ $marca->idMarcas }}, '{{ addslashes($marca->nameMarcas) }}')">
                  <i class="bx bx-trash fs-6"></i>
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
            <h5>No hay marcas registradas</h5>
            <p class="text-muted mb-0">Comienza registrando una nueva marca utilizando el botón superior.</p>
          </div>
        </div>
      </div>
    @endforelse
  </div>

  {{-- Paginación --}}
  <div class="d-flex justify-content-center">
    {{ $marcas->links('pagination::bootstrap-5') }}
  </div>

  @include('marcas.modal_create')
  @include('marcas.modal_edit')

@endsection

@section('page-script')
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      @if ($errors->any())
        var modal = new bootstrap.Modal(document.getElementById('modalCrearMarca'));
        modal.show();
      @endif
    });

    // Confirmación de eliminación con SweetAlert2
    function confirmarEliminar(id, nombre) {
      Swal.fire({
        title: '¿Eliminar marca?',
        html: 'La marca <strong>' + nombre + '</strong> será eliminada permanentemente.',
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
