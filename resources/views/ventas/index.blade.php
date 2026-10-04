@extends('layouts.contentNavbarLayout')

@section('title', 'Ventas')

@section('content')

  {{-- Encabezado --}}
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h4 class="fw-bold mb-1">Ventas</h4>
      <p class="text-muted mb-0">Historial y gestión de ventas realizadas</p>
    </div>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAgregarVenta">
      <i class="bx bx-plus me-1"></i> Nueva Venta
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

  {{-- Tarjetas de resumen --}}
  <div class="row g-4 mb-4">

    {{-- Total de Ventas --}}
    <div class="col-md-3 col-sm-6">
      <div class="card h-100">
        <div class="card-body d-flex justify-content-between align-items-center">
          <div>
            <p class="mb-1 text-muted small">Total Ventas</p>
            <h4 class="mb-0 fw-bold">{{ $totalVentas }}</h4>
          </div>
          <span class="avatar p-2">
            <span class="avatar-initial rounded bg-label-primary w-px-44 h-px-44">
              <i class="icon-base bx bx-receipt icon-lg"></i>
            </span>
          </span>
        </div>
      </div>
    </div>

    {{-- Ventas Pagadas --}}
    <div class="col-md-3 col-sm-6">
      <div class="card h-100">
        <div class="card-body d-flex justify-content-between align-items-center">
          <div>
            <p class="mb-1 text-muted small">Ventas Pagadas</p>
            <h4 class="mb-0 fw-bold">{{ $ventasPagadas }}</h4>
          </div>
          <span class="avatar p-2">
            <span class="avatar-initial rounded bg-label-success w-px-44 h-px-44">
              <i class="icon-base bx bx-check-circle icon-lg"></i>
            </span>
          </span>
        </div>
      </div>
    </div>

    {{-- Ventas Anuladas --}}
    <div class="col-md-3 col-sm-6">
      <div class="card h-100">
        <div class="card-body d-flex justify-content-between align-items-center">
          <div>
            <p class="mb-1 text-muted small">Ventas Anuladas</p>
            <h4 class="mb-0 fw-bold">{{ $ventasAnuladas }}</h4>
          </div>
          <span class="avatar p-2">
            <span class="avatar-initial rounded bg-label-danger w-px-44 h-px-44">
              <i class="icon-base bx bx-x-circle icon-lg"></i>
            </span>
          </span>
        </div>
      </div>
    </div>

    {{-- Ingresos Totales --}}
    <div class="col-md-3 col-sm-6">
      <div class="card h-100">
        <div class="card-body d-flex justify-content-between align-items-center">
          <div>
            <p class="mb-1 text-muted small">Ingresos (Pagado)</p>
            <h4 class="mb-0 fw-bold text-success">S/ {{ number_format($totalIngresos, 2) }}</h4>
          </div>
          <span class="avatar p-2">
            <span class="avatar-initial rounded bg-label-warning w-px-44 h-px-44">
              <i class="icon-base bx bx-dollar-circle icon-lg"></i>
            </span>
          </span>
        </div>
      </div>
    </div>

  </div>

  {{-- Tabla de Ventas --}}
  <div class="card">
    <div class="card-header d-flex align-items-center justify-content-between">
      <h5 class="card-title mb-0">Listado de Ventas</h5>
      <span class="badge bg-label-primary">{{ $totalVentas }} registros</span>
    </div>
    <div class="card-datatable table-responsive p-3">
      <table id="tablaVentas" class="table table-bordered table-hover w-100">
        <thead class="table-light">
          <tr>
            <th>Código</th>
            <th>Cliente</th>
            <th>Método Pago</th>
            <th>Fecha</th>
            <th>Total</th>
            <th>Estado</th>
            <th class="text-center" style="width: 100px;">Acciones</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($ventas as $venta)
            <tr>
              <td>
                <span class="fw-semibold text-primary">{{ $venta->codigoVentas }}</span>
              </td>
              <td>
                @if ($venta->cliente)
                  <div class="d-flex align-items-center gap-2">
                    <span class="avatar-initial rounded-circle bg-label-secondary"
                      style="width:32px;height:32px;display:inline-flex;align-items:center;justify-content:center;font-size:13px;font-weight:700;">
                      {{ strtoupper(substr($venta->cliente->nombreClientes, 0, 1)) }}
                    </span>
                    <div>
                      <span class="fw-semibold d-block" style="line-height:1.2;">
                        {{ $venta->cliente->nombreClientes }} {{ $venta->cliente->apellidoClientes }}
                      </span>
                      <small class="text-muted">{{ $venta->cliente->numerodocumentoClientes }}</small>
                    </div>
                  </div>
                @else
                  <span class="text-muted fst-italic">Público General</span>
                @endif
              </td>
              <td>
                @php
                  $metodoBadge = match (strtoupper($venta->metodoVentas)) {
                      'EFECTIVO' => ['bg-label-success', 'bx-money'],
                      'YAPE' => ['bg-label-info', 'bx-qr'],
                      'PLIN' => ['bg-label-primary', 'bx-credit-card'],
                      'TARJETA' => ['bg-label-warning', 'bx-credit-card-alt'],
                      default => ['bg-label-secondary', 'bx-wallet'],
                  };
                @endphp
                <span class="badge {{ $metodoBadge[0] }}">
                  <i class="bx {{ $metodoBadge[1] }} me-1"></i>{{ $venta->metodoVentas }}
                </span>
              </td>
              <td>{{ \Carbon\Carbon::parse($venta->fechaCompraVentas)->format('d/m/Y H:i') }}</td>
              <td class="fw-bold text-success">S/ {{ number_format($venta->totalVentas, 2) }}</td>
              <td>
                @php
                  $badge = match ($venta->estadoVentas) {
                      'PAGADO' => 'bg-label-success',
                      'PENDIENTE' => 'bg-label-warning',
                      'ANULADO' => 'bg-label-danger',
                      default => 'bg-label-secondary',
                  };
                @endphp
                <span class="badge {{ $badge }}">{{ $venta->estadoVentas }}</span>
              </td>
              <td class="text-center">
                <div class="d-flex justify-content-center gap-1">
                  {{-- Ver detalle --}}
                  <a href="{{ route('ventas.show', $venta->idVentas) }}" class="btn btn-sm btn-icon btn-info"
                    title="Ver detalle">
                    <i class="bx bx-show" style="color:white;"></i>
                  </a>
                  {{-- Anular --}}
                  <button type="button" class="btn btn-sm btn-icon btn-danger" title="Anular venta"
                    onclick="confirmarAnular({{ $venta->idVentas }}, '{{ addslashes($venta->codigoVentas) }}')"
                    {{ $venta->estadoVentas === 'ANULADO' ? 'disabled' : '' }}>
                    <i class="bx bx-block" style="color:white;"></i>
                  </button>
                </div>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>

  @include('ventas.modal_create')

@endsection

@section('page-script')
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      $('#tablaVentas').DataTable({
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
    });

    function confirmarAnular(id, codigo) {
      Swal.fire({
        title: '¿Anular venta?',
        html: 'La venta <strong>' + codigo + '</strong> será marcada como ANULADA.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Sí, anular',
        cancelButtonText: 'Cancelar',
        customClass: {
          confirmButton: 'btn btn-danger me-3',
          cancelButton: 'btn btn-label-secondary'
        },
        buttonsStyling: false
      }).then((result) => {
        if (result.isConfirmed) {
          let form = document.createElement('form');
          form.method = 'POST';
          form.action = '/ventas/' + id;
          form.innerHTML = `
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="_method" value="PUT">
            <input type="hidden" name="estadoVentas" value="ANULADO">
          `;
          document.body.appendChild(form);
          form.submit();
        }
      });
    }
  </script>
@endsection
