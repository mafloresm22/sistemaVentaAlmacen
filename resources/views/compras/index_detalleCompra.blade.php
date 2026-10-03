@extends('layouts.contentNavbarLayout')

@section('title', 'Detalle de Compra - ' . $compra->numeroFacturaCompras)

@section('content')

  {{-- Header --}}
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <div class="d-flex align-items-center gap-2 mb-1">
        <h4 class="fw-bold mb-0">Detalle de Compra</h4>
        <span class="badge bg-label-secondary fs-6">{{ $compra->tipoComprobanteCompras ?? 'Factura' }}</span>
        <span class="badge bg-label-primary fs-6">{{ $compra->numeroFacturaCompras }}</span>
      </div>
      <p class="text-muted mb-0">Consulta la información general y el desglose de productos registrados en esta compra.</p>
    </div>
    <a href="{{ route('compras.index') }}" class="btn btn-secondary">
      <i class="bx bx-arrow-back me-1"></i> Volver a Compras
    </a>
  </div>

  {{-- Cards Métricas Rápidas --}}
  <div class="row g-4 mb-4">
    <div class="col-sm-6 col-xl-3">
      <div class="card card-border-shadow-primary h-100">
        <div class="card-body">
          <div class="d-flex align-items-center mb-2">
            <div class="avatar me-3">
              <span class="avatar-initial rounded bg-label-primary">
                <i class="bx bx-file fs-4"></i>
              </span>
            </div>
            <div>
              <small class="text-muted d-block fw-semibold">N° Comprobante</small>
              <h5 class="mb-0 fw-bold">{{ $compra->numeroFacturaCompras }}</h5>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-sm-6 col-xl-3">
      <div class="card card-border-shadow-info h-100">
        <div class="card-body">
          <div class="d-flex align-items-center mb-2">
            <div class="avatar me-3">
              <span class="avatar-initial rounded bg-label-info">
                <i class="bx bx-package fs-4"></i>
              </span>
            </div>
            <div>
              <small class="text-muted d-block fw-semibold">Ítems Comprados</small>
              <h5 class="mb-0 fw-bold">{{ $compra->detalles->count() }} productos</h5>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-sm-6 col-xl-3">
      <div class="card card-border-shadow-warning h-100">
        <div class="card-body">
          <div class="d-flex align-items-center mb-2">
            <div class="avatar me-3">
              <span class="avatar-initial rounded bg-label-warning">
                <i class="bx bx-layer fs-4"></i>
              </span>
            </div>
            <div>
              <small class="text-muted d-block fw-semibold">Total Unidades</small>
              <h5 class="mb-0 fw-bold">{{ number_format($compra->detalles->sum('cantidadDetalleCompras'), 2) }}</h5>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-sm-6 col-xl-3">
      <div class="card card-border-shadow-success h-100">
        <div class="card-body">
          <div class="d-flex align-items-center mb-2">
            <div class="avatar me-3">
              <span class="avatar-initial rounded bg-label-success">
                <i class="bx bx-dollar-circle fs-4"></i>
              </span>
            </div>
            <div>
              <small class="text-muted d-block fw-semibold">Monto Total</small>
              <h5 class="mb-0 fw-bold text-success">S/ {{ number_format($compra->totalCompras, 2) }}</h5>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row g-4">
    {{-- Datos Generales de la Compra --}}
    <div class="col-lg-4">
      <div class="card shadow-sm mb-4">
        <div class="card-header bg-label-primary d-flex align-items-center justify-content-between">
          <h6 class="mb-0 fw-bold"><i class="bx bx-info-circle me-2"></i>Información General</h6>
          @php
            $badgeState = match ($compra->estadoCompras) {
                'PAGADO' => 'bg-success',
                'PENDIENTE' => 'bg-warning',
                'ANULADO' => 'bg-danger',
                default => 'bg-secondary',
            };
          @endphp
          <span class="badge {{ $badgeState }}">{{ $compra->estadoCompras }}</span>
        </div>
        <div class="card-body pt-3">
          <ul class="list-group list-group-flush">
            <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-2">
              <span class="text-muted"><i class="bx bx-receipt me-1"></i> Tipo Comprobante:</span>
              <span class="fw-semibold badge bg-label-secondary">{{ $compra->tipoComprobanteCompras ?? 'Factura' }}</span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-2">
              <span class="text-muted"><i class="bx bx-hash me-1"></i> N° Comprobante:</span>
              <span class="fw-semibold">{{ $compra->numeroFacturaCompras }}</span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-2">
              <span class="text-muted"><i class="bx bx-calendar me-1"></i> Fecha Emisión:</span>
              <span>{{ \Carbon\Carbon::parse($compra->fechaEmisionCompras)->format('d/m/Y H:i') }}</span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-2">
              <span class="text-muted"><i class="bx bx-building me-1"></i> Proveedor:</span>
              <span class="fw-semibold text-primary">{{ $compra->proveedor->nombreProveedores ?? '—' }}</span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-2">
              <span class="text-muted"><i class="bx bx-store me-1"></i> Sucursal:</span>
              <span>{{ $compra->sucursal->nombreSucursales ?? '—' }}</span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-2">
              <span class="text-muted"><i class="bx bx-user me-1"></i> Registrado Por:</span>
              <span>{{ $compra->user->name ?? 'Sistema' }}</span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-2 border-0">
              <span class="text-muted fw-bold">TOTAL COMPRA:</span>
              <span class="fw-bold text-success fs-5">S/ {{ number_format($compra->totalCompras, 2) }}</span>
            </li>
          </ul>
        </div>
      </div>
    </div>

    {{-- Productos Comprados --}}
    <div class="col-lg-8">
      <div class="card shadow-sm mb-4">
        <div class="card-header bg-label-secondary d-flex align-items-center justify-content-between">
          <h6 class="mb-0 fw-bold"><i class="bx bx-list-ul me-2 text-primary"></i>Productos Incluidos en esta Compra</h6>
          <span class="badge bg-label-primary">{{ $compra->detalles->count() }} ítems</span>
        </div>
        <div class="card-datatable table-responsive p-3">
          <table id="tablaDetalleProductos" class="table table-bordered table-hover w-100">
            <thead class="table-light">
              <tr>
                <th style="width: 40px;">#</th>
                <th>Producto</th>
                <th class="text-center">Cantidad</th>
                <th class="text-center">Precio Unitario</th>
                <th class="text-end">Subtotal</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($compra->detalles as $loop_index => $detalle)
                <tr>
                  <td class="text-center fw-semibold text-muted">{{ $loop->iteration }}</td>
                  <td>
                    <div class="d-flex align-items-center gap-2">
                      <div>
                        <span
                          class="fw-semibold text-heading d-block">{{ $detalle->producto->nombreProductos ?? '—' }}</span>
                        @if (!empty($detalle->producto->codigoProducto))
                          <small class="text-muted">Cód: {{ $detalle->producto->codigoProducto }}</small>
                        @endif
                      </div>
                    </div>
                  </td>
                  <td class="text-center">
                    <span class="badge bg-label-secondary fs-7 fw-semibold">
                      {{ number_format($detalle->cantidadDetalleCompras) }}
                    </span>
                  </td>
                  <td class="text-end">S/ {{ number_format($detalle->precioUnitarioDetalleCompras, 2) }}</td>
                  <td class="text-end fw-bold text-success fs-8">
                    S/ {{ number_format($detalle->subtotalDetalleCompras, 2) }}
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="5" class="text-center py-4 text-muted">
                    <i class="bx bx-folder-open display-6 d-block mb-2"></i>
                    No hay productos asociados a esta compra.
                  </td>
                </tr>
              @endforelse
            </tbody>
            <tfoot class="table-light">
              <tr>
                <td colspan="4" class="text-end fw-semibold text-uppercase small text-muted">Total Compra:</td>
                <td class="text-end fw-bold text-success">S/ {{ number_format($compra->totalCompras, 2) }}</td>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>
    </div>
  </div>

@endsection

@section('page-script')
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      $('#tablaDetalleProductos').DataTable({
        responsive: true,
        autoWidth: false,
        language: {
          url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json',
        },
        pageLength: 10,
        lengthMenu: [
          [10, 25, 50, -1],
          [10, 25, 50, "Todos"]
        ],
      });
    });
  </script>
@endsection
