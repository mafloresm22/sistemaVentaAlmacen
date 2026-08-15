@extends('layouts/contentNavbarLayout')

@section('title', 'Categorías')

@section('content')

  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h4 class="fw-bold mb-1">Categorías</h4>
      <p class="text-muted mb-0">Gestiona las categorías de productos del sistema</p>
    </div>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCrearCategoria">
      <i class="bx bx-plus me-1"></i> Nueva Categoría
    </button>
  </div>


  <div class="card">
    <div class="card-header d-flex align-items-center justify-content-between">
      <h5 class="card-title mb-0">Listado de Categorías</h5>
      <span class="badge bg-label-primary">{{ $categorias->count() }} registros</span>
    </div>
    <div class="card-datatable table-responsive p-3">
      <table id="tablaCategorias" class="table table-bordered table-hover w-100">
        <thead class="table-light">
          <tr>
            <th>#</th>
            <th>Categoría</th>
            <th>Descripción</th>
            <th class="text-center" style="width: 120px;">Acciones</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($categorias as $categoria)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>
                <span class="badge bg-label-info">{{ $categoria->nombreCategorias }}</span>
              </td>
              <td>{{ $categoria->descripcionCategorias }}</td>
              <td class="text-center">
                <button type="button" class="btn btn-sm btn-icon btn-warning me-1" title="Editar" onclick="abrirModalEditar(
                                                        {{ $categoria->idCategorias }},
                                                        '{{ addslashes($categoria->nombreCategorias) }}',
                                                        '{{ addslashes($categoria->descripcionCategorias) }}'
                                                        )">
                  <i class="bx bx-edit" style="color: white;"></i>
                </button>

                <form id="form-delete-{{ $categoria->idCategorias }}"
                  action="{{ route('categorias.destroy', $categoria->idCategorias) }}" method="POST" class="d-inline">
                  @csrf

                  @method('DELETE')
                  <button type="button" class="btn btn-sm btn-icon btn-danger" title="Eliminar"
                    onclick="confirmarEliminar({{ $categoria->idCategorias }}, '{{ addslashes($categoria->nombreCategorias) }}')">
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

  @include('categorias.modal_create')
  @include('categorias.modal_edit')
@endsection

@section('page-script')
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      $('#tablaCategorias').DataTable({
        responsive: true,
        autoWidth: false,
        language: {
          url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json',
        },
        columnDefs: [
          { orderable: false, targets: 3 }, // Deshabilitar ordenación en la columna Acciones
        ],
        order: [[0, 'asc']],
        pageLength: 10,
        lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Todos"]],
      });

      @if ($errors->any())
        var modal = new bootstrap.Modal(document.getElementById('modalCrearCategoria'));
        modal.show();
      @endif
        });

    // Modal Editar
    function abrirModalEditar(id, nombre, descripcion) {
      document.getElementById('editNombre').value = nombre;
      document.getElementById('editDescripcion').value = descripcion;
      document.getElementById('formEditar').action = '/categorias/' + id;

      new bootstrap.Modal(document.getElementById('modalEditarCategoria')).show();
    }

    // Confirmación de eliminación con SweetAlert2
    function confirmarEliminar(id, nombre) {
      Swal.fire({
        title: '¿Eliminar categoría?',
        html: `La categoría <strong>${nombre}</strong> será eliminada permanentemente.`,
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