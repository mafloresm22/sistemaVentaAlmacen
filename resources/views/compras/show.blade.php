@extends('layouts.contentNavbarLayout')

@section('title', 'Detalle de Compra #' . $compra->idCompras)

@section('content')

  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h4 class="fw-bold mb-1">Detalle de Compra</h4>
      <p class="text-muted mb-0">Factura: <strong>{{ $compra->numeroFacturaCompras }}</strong></p>
    </div>
    <a href="{{ route('compras.index') }}" class="btn btn-label-secondary">
      <i class="bx bx-arrow-back me-1"></i> Volver
    </a>
  </div>

  <div class="row g-4">

    {{-- Info de la compra --}}
    <div class="col-md-5">
      <div class="card shadow-sm h-100">
        <div class="card-header bg-label-primary">
          <h6 class="mb-0 fw-bold"><i class="bx bx-info-circle me-2"></i>Información General</h6>
        </div>
        <div class="card-body">
          <table class="table table-borderless table-sm mb-0">
            <tr>
              <th class="text-muted fw-normal">N° Factura</th>
              <td class="fw-semibold">{{ $compra->numeroFacturaCompras }}</td>
            </tr>
            <tr>
              <th class="text-muted fw-normal">Fecha Emisión</th>
              <td>{{ \Carbon\Carbon::parse($compra->fechaEmisionCompras)->format('d/m/Y H:i') }}</td>
            </tr>
            <tr>
              <th class="text-muted fw-normal">Estado</th>
              <td>
                @php
                  $badge = match($compra->estadoCompras) {
                    'PAGADO'   => 'bg-label-success',
                    'PENDIENTE'=> 'bg-label-warning',
                    'ANULADO'  => 'bg-label-danger',
                    default    => 'bg-label-secondary',
                  };
                @endphp
                <span class="badge {{ $badge }}">{{ $compra->estadoCompras }}</span>
              </td>
            </tr>
            <tr>
              <th class="text-muted fw-normal">Proveedor</th>
              <td>{{ $compra->proveedor->nombreProveedores ?? '—' }}</td>
            </tr>
            <tr>
              <th class="text-muted fw-normal">Sucursal</th>
              <td>{{ $compra->sucursal->nombreSucursales ?? '—' }}</td>
            </tr>
            <tr>
              <th class="text-muted fw-normal">Registrado por</th>
              <td>{{ $compra->user->name ?? '—' }}</td>
            </tr>
            <tr>
              <th class="text-muted fw-normal">Total</th>
              <td class="fw-bold text-success fs-5">S/ {{ number_format($compra->totalCompras, 2) }}</td>
            </tr>
          </table>
        </div>
      </div>
    </div>

    {{-- Detalle de productos --}}
    <div class="col-md-7">
      <div class="card shadow-sm h-100">
        <div class="card-header bg-label-info">
          <h6 class="mb-0 fw-bold"><i class="bx bx-list-ul me-2"></i>Productos Comprados</h6>
        </div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
              <thead class="table-light">
                <tr>
                  <th class="ps-3">Producto</th>
                  <th>Cantidad</th>
                  <th>Precio Unit.</th>
                  <th class="pe-3">Subtotal</th>
                </tr>
              </thead>
              <tbody>
                @forelse ($compra->detalles as $detalle)
                  <tr>
                    <td class="ps-3">{{ $detalle->producto->nombreProductos ?? '—' }}</td>
                    <td>{{ number_format($detalle->cantidadDetalleCompras, 2) }}</td>
                    <td>S/ {{ number_format($detalle->precioUnitarioDetalleCompras, 2) }}</td>
                    <td class="pe-3 fw-bold text-success">S/ {{ number_format($detalle->subtotalDetalleCompras, 2) }}</td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="4" class="text-center py-4 text-muted">Sin productos registrados</td>
                  </tr>
                @endforelse
              </tbody>
              <tfoot class="table-light">
                <tr>
                  <td colspan="3" class="text-end fw-bold pe-2">TOTAL:</td>
                  <td class="pe-3 fw-bold text-success fs-6">S/ {{ number_format($compra->totalCompras, 2) }}</td>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>
      </div>
    </div>

  </div>

@endsection
