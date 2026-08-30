@extends('layouts.contentNavbarLayout')

@section('title', 'Unidades de Medida')

@section('content')

  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h4 class="fw-bold mb-1">Unidades de Medidas</h4>
      <p class="text-muted mb-0">Gestiona las unidades de medidas de productos del sistema</p>
    </div>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCrearUnidadMedida">
      <i class="bx bx-plus me-1"></i> Nueva Unidad de Medida
    </button>
  </div>

  <div class="card">
    <div class="card-header d-flex align-items-center justify-content-between">
      <h5 class="card-title mb-0">Listado de Unidades de Medidas</h5>
      <span class="badge bg-label-primary">{{ $unidades_medidas->count() }} registros</span>
    </div>
    <div class="card-datatable table-responsive p-3">
      <table id="tablaUnidadesMedidas" class="table table-bordered table-hover w-100">
        <thead class="table-light">
          <tr>
            <th>#</th>
            <th>Nombre</th>
            <th>Símbolo</th>
            <th>¿Permite Decimales?</th>
            <th class="text-center" style="width: 120px;">Acciones</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($unidades_medidas as $unidad_medida)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>
                <span class="badge bg-label-success">{{ $unidad_medida->nameUnidadesMedidas }}</span>
              </td>
              <td>{{ $unidad_medida->simboloUnMedidas }}</td>
              <td>{{ $unidad_medida->permiteDecimalesUnMedidas ? 'Sí' : 'No' }}</td>
              <td class="text-center">
                <button type="button" class="btn btn-sm btn-icon btn-warning me-1" title="Editar"
                  onclick="abrirModalEditar(
                                                        {{ $unidad_medida->idUnidadesMedidas }},
                                                        '{{ addslashes($unidad_medida->nameUnidadesMedidas) }}',
                                                        '{{ addslashes($unidad_medida->simboloUnMedidas) }}',
                                                        {{ $unidad_medida->permiteDecimalesUnMedidas }}
                                                        )">
                  <i class="bx bx-edit" style="color: white;"></i>
                </button>

                <form id="form-delete-{{ $unidad_medida->idUnidadesMedidas }}"
                  action="{{ route('unidades-medidas.destroy', $unidad_medida->idUnidadesMedidas) }}" method="POST"
                  class="d-inline">
                  @csrf

                  @method('DELETE')
                  <button type="button" class="btn btn-sm btn-icon btn-danger" title="Eliminar"
                    onclick="confirmarEliminar({{ $unidad_medida->idUnidadesMedidas }}, '{{ addslashes($unidad_medida->nameUnidadesMedidas) }}')">
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

  @include('unidades_medidas.modal_create')
  @include('unidades_medidas.modal_edit')
@endsection

@section('page-script')
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      $('#tablaUnidadesMedidas').DataTable({
        responsive: true,
        autoWidth: false,
        language: {
          url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json',
        },
        columnDefs: [{
            orderable: false,
            targets: 4
          }, // Deshabilitar ordenación en la columna Acciones
        ],
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
        var modalEl = document.getElementById('modalCrearUnidadMedida');
        var modal = new bootstrap.Modal(modalEl);
        modal.show();
      @endif
    });

    // Modal Editar
    function abrirModalEditar(id, nombre, simbolo, permiteDecimales) {
      document.getElementById('editNombre').value = nombre;
      document.getElementById('editSimbolo').value = simbolo;
      document.getElementById('editPermiteDecimales').checked = permiteDecimales == 1 || permiteDecimales == true;
      document.getElementById('formEditarUnidadMedida').action = '/unidades-medidas/' + id;

      var modalEl = document.getElementById('modalEditarUnidadMedida');
      var modal = bootstrap.Modal.getInstance(modalEl);
      if (!modal) {
        modal = new bootstrap.Modal(modalEl);
      }
      modal.show();
    }

    function confirmarEliminar(id, nombre) {
      Swal.fire({
        title: '¿Eliminar unidad de medida?',
        html: `La unidad de medida <strong>${nombre}</strong> será eliminada permanentemente.`,
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
