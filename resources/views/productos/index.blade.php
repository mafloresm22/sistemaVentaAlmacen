@extends('layouts.contentNavbarLayout')

@section('title', 'Productos')

@section('vendor-style')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection



@section('content')

  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h4 class="fw-bold mb-1">Productos</h4>
      <p class="text-muted mb-0">Gestiona los productos del sistema</p>
    </div>
    <div class="d-flex gap-2">
      <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modalbuscarProducto">
        <i class="bx bx-search me-1"></i> Buscar Producto
      </button>
      <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCrearProducto">
        <i class="bx bx-plus me-1"></i> Nuevo Producto
      </button>
    </div>
  </div>

  <div class="card mb-6">
    <div class="card-widget-separator-wrapper">
      <div class="card-body card-widget-separator">
        <div class="row gy-4 gy-sm-1">
          <div class="col-sm-6 col-lg-3">
            <div class="d-flex justify-content-between align-items-start card-widget-1 border-end pb-4 pb-sm-0">
              <div>
                <p class="mb-1">Productos con Stock Bajo</p>
                <h4 class="mb-1">
                  {{ $productos->where('stockProductos', '<=', 5)->count() }}
                </h4>
              </div>
              <span class="avatar me-sm-6">
                <span class="avatar-initial rounded w-px-44 h-px-44">
                  <i class="icon-base bx bx-store-alt icon-lg text-heading"></i>
                </span>
              </span>
            </div>
            <hr class="d-none d-sm-block d-lg-none me-6">
          </div>
          <div class="col-sm-6 col-lg-3">
            <div class="d-flex justify-content-between align-items-start card-widget-2 border-end pb-4 pb-sm-0">
              <div>
                <p class="mb-1">Productos sin Stock</p>
                <h4 class="mb-1">
                  {{ $productos->where('stockProductos', 0)->count() }}
                </h4>
              </div>
              <span class="avatar p-2 me-lg-6">
                <span class="avatar-initial rounded w-px-44 h-px-44">
                  <i class="icon-base bx bx-laptop icon-lg text-heading"></i>
                </span>
              </span>
            </div>
            <hr class="d-none d-sm-block d-lg-none">
          </div>
          <div class="col-sm-6 col-lg-3">
            <div class="d-flex justify-content-between align-items-start border-end pb-4 pb-sm-0 card-widget-3">
              <div>
                <p class="mb-1">Total de Productos</p>
                <h4 class="mb-1">
                  {{ $productos->where('estadoProductos', 'inactivo')->count() }}
                </h4>
              </div>
              <span class="avatar p-2 me-sm-6">
                <span class="avatar-initial rounded w-px-44 h-px-44">
                  <i class="icon-base bx bx-gift icon-lg text-heading"></i>
                </span>
              </span>
            </div>
          </div>
          <div class="col-sm-6 col-lg-3">
            <div class="d-flex justify-content-between align-items-start">
              <div>
                <p class="mb-1">Por categoría</p>
                <h4 class="mb-1">{{ $productos->count() }}</h4>
                <p class="mb-0"><span class="me-2">Total en catálogo</span></p>
              </div>
              <span class="avatar p-2">
                <span class="avatar-initial rounded w-px-44 h-px-44">
                  <i class="icon-base bx bx-wallet icon-lg text-heading"></i>
                </span>
              </span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="card">
    <div class="card-header d-flex align-items-center justify-content-between">
      <h5 class="card-title mb-0">Listado de Productos</h5>
      <span class="badge bg-label-primary">{{ $productos->count() }} registros</span>
    </div>
    <div class="card-datatable table-responsive p-3">
      <table id="tablaProductos" class="table table-bordered table-hover w-100">
        <thead class="table-light">
          <tr>
            <th>Codigo</th>
            <th>Foto</th>
            <th>Producto</th>
            <th>Precio</th>
            <th>Estado</th>
            <th class="text-center" style="width: 120px;">Acciones</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($productos as $producto)
            <tr>
              <td>{{ $producto->codigoProducto }}</td>
              <td>
                @if ($producto->imagenes->isNotEmpty())
                  <img src="{{ asset('storage/' . $producto->imagenes->first()->rutaImagenes) }}"
                    alt="{{ $producto->nombreProductos }}" width="50" height="50" class="rounded"
                    style="object-fit:cover;">
                @else
                  <span class="badge bg-label-secondary">Sin imagen</span>
                @endif
              </td>
              <td>{{ $producto->nombreProductos }}</td>
              <td>S/ {{ number_format($producto->precioProductos, 2) }}</td>
              <td>
                @if ($producto->estadoProductos === 'activo')
                  <span class="badge bg-label-success">Activo</span>
                @else
                  <span class="badge bg-label-danger">Inactivo</span>
                @endif
              </td>
              <td class="text-center">
                <button type="button" class="btn btn-sm btn-icon btn-warning me-1" title="Editar"
                  onclick="abrirModalEditar(
                    {{ $producto->idProductos }},
                    '{{ addslashes($producto->codigoProducto) }}',
                    '{{ addslashes($producto->nombreProductos) }}',
                    '{{ addslashes($producto->descripcionProductos) }}',
                    '{{ addslashes($producto->precioProductos) }}',
                    {{ $producto->categoriasid }},
                    {{ $producto->marcasid }},
                    {{ $producto->unidadesmedidasid }},
                    '{{ addslashes($producto->estadoProductos) }}'
                  )">
                  <i class="bx bx-edit" style="color: white;"></i>
                </button>

                <form id="form-delete-{{ $producto->idProductos }}"
                  action="{{ route('productos.destroy', $producto->idProductos) }}" method="POST" class="d-inline">
                  @csrf
                  @method('DELETE')
                  <button type="button" class="btn btn-sm btn-icon btn-danger" title="Eliminar"
                    onclick="confirmarEliminar({{ $producto->idProductos }}, '{{ addslashes($producto->nombreProductos) }}')">
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

  @include('productos.modal_create')
  @include('productos.modal_edit')
@endsection

@section('page-script')
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      $('#tablaProductos').DataTable({
        responsive: true,
        autoWidth: false,
        language: {
          url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json',
        },
        columnDefs: [{
            orderable: false,
            targets: 7
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
        var modal = new bootstrap.Modal(document.getElementById('modalCrearProducto'));
        modal.show();
      @endif

      // Cargar Select2 dinámicamente para evitar conflicto de módulos (Vite jQuery)
      let script = document.createElement('script');
      script.src = "https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js";
      script.onload = function() {
        // Inicializar Select2 al abrir el modal de crear producto
        $('#modalCrearProducto').on('shown.bs.modal', function () {
          $('#categoriasidCreate, #marcasidCreate, #unidadesmedidasidCreate').select2({
            theme: 'bootstrap-5',
            dropdownParent: $('#modalCrearProducto'),
            width: '100%',
            allowClear: true
          });
        });
      };
      document.head.appendChild(script);
    });

    // Modal Editar Producto
    function abrirModalEditar(id, codigo, nombre, descripcion, precio, categoriaId, marcaId, unidadId, estado) {
      document.getElementById('editCodigo').value = codigo;
      document.getElementById('editNombre').value = nombre;
      document.getElementById('editDescripcion').value = descripcion;
      document.getElementById('editPrecio').value = precio;
      document.getElementById('editCategoria').value = categoriaId;
      document.getElementById('editMarca').value = marcaId;
      document.getElementById('editUnidad').value = unidadId;
      document.getElementById('editEstado').value = estado;
      document.getElementById('formEditarProducto').action = '/productos/' + id;

      new bootstrap.Modal(document.getElementById('modalEditarProducto')).show();
    }

    function confirmarEliminar(id, nombre) {
      Swal.fire({
        title: '¿Eliminar producto?',
        html: `El producto <strong>${nombre}</strong> será eliminado permanentemente.`,
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

    function generarCodigoInterno() {
      let code = '200' + Math.floor(Math.random() * 1000000000).toString().padStart(9, '0');
      let sum = 0;
      let weightflag = true;
      for (let i = 11; i >= 0; i--) {
        sum += parseInt(code[i]) * (weightflag ? 3 : 1);
        weightflag = !weightflag;
      }
      let checksum = (10 - (sum % 10)) % 10;
      document.getElementById('codigoProductoCreate').value = code + checksum;
    }
  </script>
@endsection
