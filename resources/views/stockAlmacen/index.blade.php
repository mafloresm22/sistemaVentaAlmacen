@extends('layouts.contentNavbarLayout')

@section('title', 'Stock de Almacén')

@section('content')

  {{-- Encabezado --}}
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h4 class="fw-bold mb-1">Stock de Almacén</h4>
      <p class="text-muted mb-0">Gestión de existencias por producto y sucursal</p>
    </div>
  </div>

  {{-- Alertas --}}
  @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
      <i class="bx bx-check-circle me-2"></i> {{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif
  @if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
      <i class="bx bx-error-circle me-2"></i> {{ session('error') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif

  {{-- Filtro superior --}}
  <div class="card mb-4">
    <div class="card-body">
      <form action="{{ route('stock-almacen.index') }}" method="GET" class="d-flex align-items-center gap-3">
        <label for="sucursal_id" class="fw-semibold mb-0">Filtrar por Sucursal:</label>
        <select name="sucursal_id" id="sucursal_id" class="form-select w-auto" onchange="this.form.submit()">
          <option value="">-- Todas las Sucursales --</option>
          @foreach ($sucursales as $sucursal)
            <option value="{{ $sucursal->idSucursales }}" {{ $sucursalId == $sucursal->idSucursales ? 'selected' : '' }}>
              {{ $sucursal->nombreSucursales }}
            </option>
          @endforeach
        </select>
      </form>
    </div>
  </div>

  {{-- Tabla principal --}}
  <div class="card">
    <div class="card-header d-flex align-items-center justify-content-between">
      <h5 class="card-title mb-0">Listado de Productos en Stock</h5>
    </div>
    <div class="card-datatable table-responsive p-3">
      <table id="tablaStock" class="table table-bordered table-hover w-100">
        <thead class="table-light">
          <tr>
            <th>Producto</th>
            <th>Categoría</th>
            <th class="text-center">Stock Total</th>
            <th class="text-center">Stock Mínimo</th>
            <th class="text-center">Estado</th>
            <th class="text-center" style="width: 120px;">Acciones</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($productos as $producto)
            <tr>
              <td>
                <div class="d-flex flex-column">
                  <span class="fw-semibold text-primary">{{ $producto->nombreProductos }}</span>
                  <small class="text-muted">{{ $producto->codigoProducto }}</small>
                </div>
              </td>
              <td>
                @if ($producto->categoria)
                  <span class="badge bg-label-info">{{ $producto->categoria->nombreCategorias }}</span>
                @else
                  <span class="text-muted">Sin categoría</span>
                @endif
              </td>
              <td class="text-center fw-bold fs-5">
                {{ number_format($producto->stock_calculado, 0) }}
              </td>
              <td class="text-center">
                {{ number_format($producto->stock_minimo_calculado, 0) }}
              </td>
              <td class="text-center">
                @php
                  $badgeClass = match ($producto->estado_stock) {
                      'ÓPTIMO' => 'bg-label-success',
                      'BAJO' => 'bg-label-warning',
                      'AGOTADO' => 'bg-label-danger',
                      default => 'bg-label-secondary',
                  };
                @endphp
                <span class="badge {{ $badgeClass }}">{{ $producto->estado_stock }}</span>
              </td>
              <td class="text-center">
                <div class="d-flex justify-content-center gap-1">
                  <button type="button" class="btn btn-sm btn-icon btn-primary" title="Ver desglose"
                    onclick='verDesglose(@json($producto->nombreProductos), @json($producto->stock_desglose))'>
                    <i class="bx bx-show" style="color: white; font-size: 1.2rem;"></i>
                  </button>
                  <button type="button" class="btn btn-sm btn-icon btn-warning" title="Editar stock mínimo"
                    onclick='abrirEditMinimo({{ $producto->idProductos }}, @json($producto->nombreProductos), @json($sucursales), @json($producto->stockAlmacen))'>
                    <i class="bx bx-edit" style="color: white; font-size: 1.2rem;"></i>
                  </button>
                </div>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>

  @include('stockAlmacen.modal_desglose')
  @include('stockAlmacen.modal_edit_minimo')

@endsection

@section('page-script')
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      $('#tablaStock').DataTable({
        responsive: true,
        autoWidth: false,
        language: {
          url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json',
        },
        columnDefs: [{
          orderable: false,
          targets: 5
        }],
        order: [
          [0, 'asc']
        ],
        pageLength: 10,
        lengthMenu: [
          [10, 25, 50, -1],
          [10, 25, 50, "Todos"]
        ],
      });
    });

    function verDesglose(nombreProducto, desglose) {
      document.getElementById('modalProductoNombre').textContent = nombreProducto;

      const tbody = document.getElementById('tbodyDesglose');
      tbody.innerHTML = '';

      if (!desglose || desglose.length === 0) {
        tbody.innerHTML =
          '<tr><td colspan="3" class="text-center text-muted py-3">No hay stock registrado en ninguna sucursal.</td></tr>';
      } else {
        desglose.forEach(item => {
          const nombreSucursal = item.sucursal ? item.sucursal.nombreSucursales : 'Desconocida';
          const stockActual = Math.round(item.stockactualAlmacen);
          const estado = item.estadoStockAlmacen;

          let badgeClass = 'bg-label-secondary';
          if (estado === 'Optimo' || estado === 'ÓPTIMO') badgeClass = 'bg-label-success';
          if (estado === 'Bajo' || estado === 'BAJO') badgeClass = 'bg-label-warning';
          if (estado === 'Agotado' || estado === 'AGOTADO') badgeClass = 'bg-label-danger';

          tbody.innerHTML += `
            <tr>
              <td>${nombreSucursal}</td>
              <td class="text-center fw-bold">${stockActual}</td>
              <td class="text-center"><span class="badge ${badgeClass}">${estado}</span></td>
            </tr>
          `;
        });
      }

      const modal = new bootstrap.Modal(document.getElementById('modalDesglose'));
      modal.show();
    }

    function abrirEditMinimo(productoId, nombreProducto, todasSucursales, stockExistente) {
      document.getElementById('minimoProductoId').value = productoId;
      document.getElementById('minimoProductoNombre').textContent = nombreProducto;

      const tbody = document.getElementById('tbodyMinimos');
      tbody.innerHTML = '';

      todasSucursales.forEach(suc => {
        const stockRecord = stockExistente.find(s => s.sucursalid === suc.idSucursales);
        const minimoActual = stockRecord ? Math.round(stockRecord.stockminimoAlmacen) : 0;

        tbody.innerHTML += `
          <tr>
            <td class="ps-3">${suc.nombreSucursales}</td>
            <td class="text-center">
              <input type="number" class="form-control form-control-sm text-center" 
                     name="minimos[${suc.idSucursales}]" 
                     value="${minimoActual}" min="0">
            </td>
          </tr>
        `;
      });

      const modal = new bootstrap.Modal(document.getElementById('modalEditMinimo'));
      modal.show();
    }
  </script>
@endsection
