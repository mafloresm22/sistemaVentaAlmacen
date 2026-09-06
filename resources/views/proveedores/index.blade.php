@extends('layouts.contentNavbarLayout')

@section('title', 'Proveedores')

@section('content')

  {{-- Encabezado --}}
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h4 class="fw-bold mb-1">Proveedores</h4>
      <p class="text-muted mb-0">Gestión e información de los proveedores registrados</p>
    </div>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCrearProveedor">
      <i class="bx bx-plus me-1"></i> Nuevo Proveedor
    </button>
  </div>

  {{-- Buscador --}}
  <div class="card mb-4">
    <div class="card-body">
      <form action="{{ route('proveedores.buscar') }}" method="GET" class="d-flex gap-2">
        <input type="text" name="buscar" class="form-control" placeholder="Buscar por nombre, RUC/DNI o correo..."
          value="{{ request('buscar') }}">
        <button type="submit" class="btn btn-primary">
          <i class="bx bx-search me-1"></i>Buscar
        </button>
        @if (request('buscar'))
          <a href="{{ route('proveedores.index') }}" class="btn btn-danger">
            <i class="bx bx-x me-1"></i>Limpiar
          </a>
        @endif
      </form>
    </div>
  </div>

  @php
    $bgStyles = [
        ['bg' => 'bg-label-primary', 'border' => 'border-primary'],
        ['bg' => 'bg-label-success', 'border' => 'border-success'],
        ['bg' => 'bg-label-info', 'border' => 'border-info'],
        ['bg' => 'bg-label-warning', 'border' => 'border-warning'],
        ['bg' => 'bg-label-danger', 'border' => 'border-danger'],
        ['bg' => 'bg-label-dark', 'border' => 'border-dark'],
    ];
  @endphp

  <div class="row g-3 mb-4">
    @forelse ($proveedores as $index => $proveedor)
      @php
        $color = $bgStyles[$index % count($bgStyles)];
      @endphp

      <div class="col-12 col-md-6 col-lg-4 col-xl-3">
        <div class="card h-100 border-start border-3 {{ $color['border'] }} {{ $color['bg'] }} shadow-sm">
          <div class="card-body p-3 d-flex flex-column justify-content-between">

            {{-- Encabezado de Card: Icono, Nombre y Acciones --}}
            <div>
              <div class="d-flex align-items-start mb-3">
                <div class="avatar avatar-sm shrink-0 me-2">
                  <span class="avatar-initial rounded-circle bg-white text-dark shadow-xs">
                    <i class="bx bx-building fs-5"></i>
                  </span>
                </div>
                <div class="overflow-hidden">
                  <h6 class="mb-0 fw-bold text-dark text-truncate" title="{{ $proveedor->nombreProveedores }}">
                    {{ $proveedor->nombreProveedores }}
                  </h6>
                  <small class="text-muted text-truncate d-block">
                    <span class="fw-semibold">{{ $proveedor->tipodocumentoProveedores }}:</span> {{ $proveedor->numerodocumentoProveedores }}
                  </small>
                </div>
              </div>

              {{-- Información Detallada --}}
              <div class="pt-2 border-top border-white border-opacity-50 fs-7">
                <div class="mb-1 text-truncate" title="{{ $proveedor->direccionProveedores }}">
                  <i class="bx bx-map-pin me-1 text-primary"></i> {{ $proveedor->direccionProveedores }}
                </div>
                <div class="mb-1">
                  <i class="bx bx-phone-call me-1 text-success"></i> {{ $proveedor->telefonoProveedores }}
                </div>
                <div class="mb-2 text-truncate" title="{{ $proveedor->correoProveedores }}">
                  <i class="bx bx-envelope me-1 text-info"></i> {{ $proveedor->correoProveedores }}
                </div>
              </div>
            </div>

            {{-- Pie de Card: Días de Entrega y Acciones --}}
            <div class="d-flex align-items-center justify-content-between pt-3 mt-1 border-top border-white border-opacity-50">
              {{-- Días de entrega --}}
              <span class="badge bg-white text-dark shadow-xs fw-normal px-2 py-1" title="Días de entrega">
                <i class="bx bx-time me-1 text-warning"></i> {{ $proveedor->diasEntregaProveedores ?? 'N/A' }} días
              </span>

              {{-- Botones Editar y Eliminar --}}
              <div class="d-flex align-items-center gap-2">
                <button type="button" class="btn btn-icon btn-sm btn-light text-primary shadow-xs"
                  title="Editar proveedor" onclick="abrirModalEditar({{ json_encode($proveedor) }})">
                  <i class="bx bx-edit fs-5"></i>
                </button>
                <form id="form-delete-{{ $proveedor->idProveedores }}"
                  action="{{ route('proveedores.destroy', $proveedor->idProveedores) }}" method="POST" class="m-0">
                  @csrf
                  @method('DELETE')
                  <button type="button" class="btn btn-icon btn-sm btn-light text-danger shadow-xs"
                    title="Eliminar proveedor"
                    onclick="confirmarEliminar({{ $proveedor->idProveedores }}, '{{ addslashes($proveedor->nombreProveedores) }}')">
                    <i class="bx bx-trash fs-5"></i>
                  </button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    @empty
      <div class="col-12">
        <div class="card">
          <div class="card-body text-center py-5">
            <i class="bx bx-folder-open display-4 text-muted mb-2"></i>
            <h5>No hay proveedores registrados</h5>
            <p class="text-muted mb-0">Comienza registrando un nuevo proveedor utilizando el botón superior.</p>
          </div>
        </div>
      </div>
    @endforelse
  </div>

  {{-- Paginación --}}
  <div class="d-flex justify-content-center">
    {{ $proveedores->links('pagination::bootstrap-5') }}
  </div>

  @include('proveedores.modal_create')
  @include('proveedores.modal_edit')

@endsection

@section('page-script')
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      @if ($errors->any())
        var modal = new bootstrap.Modal(document.getElementById('modalCrearProveedor'));
        modal.show();
      @endif
    });

    // Función para abrir modal de edición poblando los campos dinámicamente
    function abrirModalEditar(proveedor) {
      document.getElementById('editNombre').value = proveedor.nombreProveedores;
      document.getElementById('editTipoDoc').value = proveedor.tipodocumentoProveedores;
      document.getElementById('editNumDoc').value = proveedor.numerodocumentoProveedores;
      document.getElementById('editDireccion').value = proveedor.direccionProveedores;
      document.getElementById('editTelefono').value = proveedor.telefonoProveedores;
      document.getElementById('editCorreo').value = proveedor.correoProveedores;
      document.getElementById('editDiasEntrega').value = proveedor.diasEntregaProveedores;

      document.getElementById('formEditarProveedor').action = '/proveedores/' + proveedor.idProveedores;

      var modalEl = document.getElementById('modalEditarProveedor');
      var modal = bootstrap.Modal.getInstance(modalEl);
      if (!modal) {
        modal = new bootstrap.Modal(modalEl);
      }
      modal.show();
    }

    // Confirmación de eliminación con SweetAlert2
    function confirmarEliminar(id, nombre) {
      Swal.fire({
        title: '¿Eliminar proveedor?',
        html: 'El proveedor <strong>' + nombre + '</strong> será eliminado permanentemente.',
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
