@extends('layouts.contentNavbarLayout')

@section('title', 'Compras')

@section('content')

  {{-- Encabezado --}}
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h4 class="fw-bold mb-1">Compras</h4>
      <p class="text-muted mb-0">Gestión y registro de órdenes de compra a proveedores</p>
    </div>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCrearCompra">
      <i class="bx bx-plus me-1"></i> Nueva Compra
    </button>
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

  {{-- Tabla de Compras --}}
  <div class="card">
    <div class="card-header d-flex align-items-center justify-content-between">
      <h5 class="card-title mb-0">Listado de Compras</h5>
      <span class="badge bg-label-primary">{{ $compras->count() }} registros</span>
    </div>
    <div class="card-datatable table-responsive p-3">
      <table id="tablaCompras" class="table table-bordered table-hover w-100">
        <thead class="table-light">
          <tr>
            <th>Comprobante</th>
            <th>Proveedor</th>
            <th>Sucursal</th>
            <th>Fecha Emisión</th>
            <th>Total</th>
            <th>Estado</th>
            <th class="text-center" style="width: 120px;">Acciones</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($compras as $compra)
            <tr>
              <td>{{ $compra->numeroFacturaCompras }}</td>
              <td>{{ $compra->proveedor->nombreProveedores ?? '—' }}</td>
              <td>{{ $compra->sucursal->nombreSucursales ?? '—' }}</td>
              <td>{{ \Carbon\Carbon::parse($compra->fechaEmisionCompras)->format('d/m/Y') }}</td>
              <td class="fw-bold text-success">S/ {{ number_format($compra->totalCompras, 2) }}</td>
              <td>
                @php
                  $badge = match ($compra->estadoCompras) {
                      'PAGADO' => 'bg-label-success',
                      'PENDIENTE' => 'bg-label-warning',
                      'ANULADO' => 'bg-label-danger',
                      default => 'bg-label-secondary',
                  };
                @endphp
                <span class="badge {{ $badge }}">{{ $compra->estadoCompras }}</span>
              </td>
              <td class="text-center">
                <div class="d-flex justify-content-center gap-1">

                  {{-- Ver detalle --}}
                  <a href="{{ route('compras.show', $compra->idCompras) }}" class="btn btn-sm btn-icon btn-info"
                    title="Ver detalles">
                    <i class="bx bx-show" style="color: white;"></i>
                  </a>

                  {{-- Editar Estado Pagar --}}
                  <button type="button" class="btn btn-sm btn-icon btn-success" title="Pagar Compra"
                    onclick="abrirModalEditar({{ json_encode($compra) }})">
                    <i class="bx bx-edit" style="color: white;"></i>
                  </button>

                  {{-- Editar Estado Anular --}}
                  <button type="button" class="btn btn-sm btn-icon btn-danger" title="Anular Compra"
                    onclick="abrirModalAnular({{ json_encode($compra) }})">
                    <i class="bx bx-stop-circle" style="color: white;"></i>
                  </button>
                </div>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>

  @include('compras.modal_create')
  @include('compras.modal_edit')

@endsection

@section('page-script')
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      $('#tablaCompras').DataTable({
        responsive: true,
        autoWidth: false,
        language: {
          url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json',
        },
        columnDefs: [{
          orderable: false,
          targets: 6
        }],
        order: [
          [0, 'desc']
        ],
        pageLength: 10,
        lengthMenu: [
          [5, 10, 25, 50, -1],
          [5, 10, 25, 50, "Todos"]
        ],
      });
      @if ($errors->any())
        @if (old('_method') === 'PUT')
          var modal = new bootstrap.Modal(document.getElementById('modalEditarCompra'));
          modal.show();
        @else
          var modal = new bootstrap.Modal(document.getElementById('modalCrearCompra'));
          modal.show();
        @endif
      @endif

      // Si hay productos seleccionados previamente renderizados
      if (productosSeleccionados.length > 0) {
        renderTablaProductos();
      }

      let script = document.createElement('script');
      script.src = "https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js";
      script.onload = function() {
        $('#modalCrearCompra').on('shown.bs.modal', function() {
          $('#proveedoresidCreate, #sucursalesidCreate, #productoSelect').select2({
            theme: 'bootstrap-5',
            dropdownParent: $('#modalCrearCompra'),
            width: '100%',
            allowClear: true
          });
        });

        $('#productoSelect').on('change', function() {
          const id = $(this).val();
          if (id) {
            const prod = productosData.find(p => p.idProductos == id);
            if (prod && prod.precioProductos) {
              document.getElementById('precioInput').value = prod.precioProductos;
            }
          }
        });
      };
      document.head.appendChild(script);
    });

    const productosData = @json($productos);
    let productosSeleccionados = [];

    const oldProductos = @json(old('productos', []));
    if (oldProductos && oldProductos.length > 0) {
      oldProductos.forEach(op => {
        const prod = productosData.find(p => p.idProductos == op.id);
        if (prod) {
          productosSeleccionados.push({
            id: parseInt(op.id),
            nombre: prod.nombreProductos,
            cantidad: parseFloat(op.cantidad),
            precio: parseFloat(op.precio),
            subtotal: parseFloat(op.cantidad) * parseFloat(op.precio)
          });
        }
      });
    }

    function agregarProducto() {
      const select = document.getElementById('productoSelect');
      const cantidad = parseFloat(document.getElementById('cantidadInput').value);
      const precio = parseFloat(document.getElementById('precioInput').value);

      if (!select.value || isNaN(cantidad) || cantidad <= 0 || isNaN(precio) || precio < 0) {
        Swal.fire('Atención', 'Completa correctamente los datos del producto.', 'warning');
        return;
      }

      const productoId = parseInt(select.value);
      const productoNombre = select.options[select.selectedIndex].text;
      const subtotal = cantidad * precio;

      const existe = productosSeleccionados.findIndex(p => p.id === productoId);
      if (existe >= 0) {
        productosSeleccionados[existe].cantidad += cantidad;
        productosSeleccionados[existe].precio = precio;
        productosSeleccionados[existe].subtotal = productosSeleccionados[existe].cantidad * precio;
      } else {
        productosSeleccionados.push({
          id: productoId,
          nombre: productoNombre,
          cantidad,
          precio,
          subtotal
        });
      }

      renderTablaProductos();
      select.value = '';
      if (window.jQuery) {
        $('#productoSelect').val('').trigger('change.select2');
      }
      document.getElementById('cantidadInput').value = '';
      document.getElementById('precioInput').value = '';
    }

    function eliminarProducto(index) {
      productosSeleccionados.splice(index, 1);
      renderTablaProductos();
    }

    function renderTablaProductos() {
      const tbody = document.getElementById('tablaProductosBody');
      const hidden = document.getElementById('productosHidden');
      tbody.innerHTML = '';
      hidden.innerHTML = '';

      let total = 0;
      productosSeleccionados.forEach((p, i) => {
        total += p.subtotal;
        tbody.innerHTML += `
          <tr>
            <td>${p.nombre}</td>
            <td>${p.cantidad}</td>
            <td>S/ ${p.precio.toFixed(2)}</td>
            <td class="fw-bold">S/ ${p.subtotal.toFixed(2)}</td>
            <td><button type="button" class="btn btn-sm btn-danger btn-icon" onclick="eliminarProducto(${i})"><i class="bx bx-trash text-white"></i></button></td>
          </tr>`;
        hidden.innerHTML += `
          <input type="hidden" name="productos[${i}][id]"       value="${p.id}">
          <input type="hidden" name="productos[${i}][cantidad]"  value="${p.cantidad}">
          <input type="hidden" name="productos[${i}][precio]"    value="${p.precio}">`;
      });

      document.getElementById('totalCalculado').textContent = 'S/ ' + total.toFixed(2);
    }

    // Modal Editar Estado
    function abrirModalEditar(compra) {
      document.getElementById('editEstado').value = compra.estadoCompras;
      document.getElementById('editNumFactura').textContent = compra.numeroFacturaCompras;
      document.getElementById('formEditarCompra').action = '/compras/' + compra.idCompras;

      var modalEl = document.getElementById('modalEditarCompra');
      var modal = bootstrap.Modal.getInstance(modalEl);
      if (!modal) modal = new bootstrap.Modal(modalEl);
      modal.show();
    }

    // Confirmar eliminar 
    function confirmarEliminar(id, factura) {
      Swal.fire({
        title: '¿Eliminar compra?',
        html: 'La compra <strong>' + factura + '</strong> y sus detalles serán eliminados permanentemente.',
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
