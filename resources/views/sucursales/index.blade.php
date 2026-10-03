@extends('layouts.contentNavbarLayout')

@section('title', 'Sucursales')

@section('content')

  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h4 class="fw-bold mb-1">Sucursales</h4>
      <p class="text-muted mb-0">Gestiona las sucursales del sistema</p>
    </div>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCrearSucursal">
      <i class="bx bx-plus me-1"></i> Nueva Sucursal
    </button>
  </div>


  <div class="card">
    <div class="card-header d-flex align-items-center justify-content-between">
      <h5 class="card-title mb-0">Listado de Sucursales</h5>
      <span class="badge bg-label-primary">{{ $sucursales->count() }} registros</span>
    </div>
    <div class="card-datatable table-responsive p-3">
      <table id="tablaSucursales" class="table table-bordered table-hover w-100">
        <thead class="table-light">
          <tr>
            <th>#</th>
            <th>Sucursal</th>
            <th>Ubicación</th>
            <th>Estado</th>
            <th class="text-center" style="width: 120px;">Acciones</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($sucursales as $sucursal)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>
                <span class="badge bg-label-primary">{{ $sucursal->nombreSucursales }}</span>
              </td>
              <td>{{ $sucursal->ubicacionSucursales }}</td>
              <td>
                <span
                  class="badge {{ $sucursal->estadoSucursales == 'Activo' ? 'bg-label-success' : 'bg-label-danger' }}">
                  {{ $sucursal->estadoSucursales }}
                </span>
              </td>
              <td class="text-center">
                <button type="button" class="btn btn-sm btn-icon btn-warning me-1" title="Editar"
                  onclick="abrirModalEditar(
                                                        {{ $sucursal->idSucursales }},
                                                        '{{ addslashes($sucursal->nombreSucursales) }}',
                                                        '{{ addslashes($sucursal->ubicacionSucursales) }}'
                                                        )">
                  <i class="bx bx-edit" style="color: white;"></i>
                </button>

                <form id="form-delete-{{ $sucursal->idSucursales }}"
                  action="{{ route('sucursales.destroy', $sucursal->idSucursales) }}" method="POST" class="d-inline">
                  @csrf

                  @method('DELETE')
                  <button type="button" class="btn btn-sm btn-icon btn-danger" title="Eliminar"
                    onclick="confirmarEliminar({{ $sucursal->idSucursales }}, '{{ addslashes($sucursal->nombreSucursales) }}')">
                    <i class="bx bx-trash" style="color: white;"></i>
                  </button>
                </form>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>

  @include('sucursales.modal_create')
  @include('sucursales.modal_edit')
@endsection

@section('page-script')
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      $('#tablaSucursales').DataTable({
        responsive: true,
        autoWidth: false,
        language: {
          url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json',
        },
        columnDefs: [{
          orderable: false,
          targets: 3
        }, ],
        order: [
          [0, 'asc']
        ],
        pageLength: 10,
        lengthMenu: [
          [5, 10, 25, 50, -1],
          [5, 10, 25, 50, "Todos"]
        ],
      });

      @if ($errors->any())
        var modal = new bootstrap.Modal(document.getElementById('modalCrearSucursal'));
        modal.show();
      @endif
    });

    // Modal Editar
    function abrirModalEditar(id, nombre, ubicacion) {
      document.getElementById('editNombre').value = nombre;
      document.getElementById('editUbicacion').value = ubicacion;
      document.getElementById('formEditar').action = '/sucursales/' + id;

      new bootstrap.Modal(document.getElementById('modalEditarSucursal')).show();
    }

    function confirmarEliminar(id, nombre) {
      Swal.fire({
        title: '¿Eliminar sucursal?',
        html: `La sucursal <strong>${nombre}</strong> será eliminada permanentemente.`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar',
      }).then((result) => {
        if (result.isConfirmed) {
          document.getElementById('form-delete-' + id).submit();
        }
      });
    }
  </script>
@endsection
