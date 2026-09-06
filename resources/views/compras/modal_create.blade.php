{{-- Modal: Crear Compra --}}
<div class="modal fade" id="modalCrearCompra" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title"><i class="bx bx-cart-add me-2 text-primary"></i>Nueva Compra</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <form action="{{ route('compras.store') }}" method="POST" id="formCrearCompra">
        @csrf
        <div class="modal-body">

          <div class="row g-3 mb-4">
            {{-- Número de Factura --}}
            <div class="col-md-4">
              <label class="form-label fw-semibold">N° Factura <span class="text-danger">*</span></label>
              <input type="text" name="numeroFacturaCompras" class="form-control @error('numeroFacturaCompras') is-invalid @enderror"
                placeholder="Ej: F001-00001" value="{{ old('numeroFacturaCompras') }}" required>
              @error('numeroFacturaCompras')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            {{-- Fecha de Emisión --}}
            <div class="col-md-4">
              <label class="form-label fw-semibold">Fecha de Emisión <span class="text-danger">*</span></label>
              <input type="datetime-local" name="fechaEmisionCompras" class="form-control @error('fechaEmisionCompras') is-invalid @enderror"
                value="{{ old('fechaEmisionCompras') }}" required>
              @error('fechaEmisionCompras')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            {{-- Estado --}}
            <div class="col-md-4">
              <label class="form-label fw-semibold">Estado <span class="text-danger">*</span></label>
              <select name="estadoCompras" class="form-select @error('estadoCompras') is-invalid @enderror" required>
                <option value="PENDIENTE" {{ old('estadoCompras') == 'PENDIENTE' ? 'selected' : '' }}>PENDIENTE</option>
                <option value="PAGADO"    {{ old('estadoCompras') == 'PAGADO'    ? 'selected' : '' }}>PAGADO</option>
                <option value="ANULADO"   {{ old('estadoCompras') == 'ANULADO'   ? 'selected' : '' }}>ANULADO</option>
              </select>
              @error('estadoCompras')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            {{-- Proveedor --}}
            <div class="col-md-6">
              <label class="form-label fw-semibold">Proveedor <span class="text-danger">*</span></label>
              <select name="proveedoresid" class="form-select @error('proveedoresid') is-invalid @enderror" required>
                <option value="">— Seleccionar proveedor —</option>
                @foreach ($proveedores as $prov)
                  <option value="{{ $prov->idProveedores }}" {{ old('proveedoresid') == $prov->idProveedores ? 'selected' : '' }}>
                    {{ $prov->nombreProveedores }}
                  </option>
                @endforeach
              </select>
              @error('proveedoresid')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            {{-- Sucursal --}}
            <div class="col-md-6">
              <label class="form-label fw-semibold">Sucursal <span class="text-danger">*</span></label>
              <select name="sucursalesid" class="form-select @error('sucursalesid') is-invalid @enderror" required>
                <option value="">— Seleccionar sucursal —</option>
                @foreach ($sucursales as $suc)
                  <option value="{{ $suc->idSucursales }}" {{ old('sucursalesid') == $suc->idSucursales ? 'selected' : '' }}>
                    {{ $suc->nombreSucursales ?? 'Sucursal ' . $suc->idSucursales }}
                  </option>
                @endforeach
              </select>
              @error('sucursalesid')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>

          {{-- Separador --}}
          <hr class="my-2">
          <h6 class="fw-bold mb-3"><i class="bx bx-list-ul me-1 text-primary"></i>Detalle de Productos</h6>

          {{-- Agregar producto --}}
          <div class="row g-2 align-items-end mb-3">
            <div class="col-md-5">
              <label class="form-label fw-semibold">Producto</label>
              <select id="productoSelect" class="form-select">
                <option value="">— Seleccionar producto —</option>
                @foreach ($productos as $prod)
                  <option value="{{ $prod->idProductos }}">{{ $prod->nombreProductos }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-2">
              <label class="form-label fw-semibold">Cantidad</label>
              <input type="number" id="cantidadInput" class="form-control" placeholder="0" min="0.01" step="0.01">
            </div>
            <div class="col-md-3">
              <label class="form-label fw-semibold">Precio Unitario (S/)</label>
              <input type="number" id="precioInput" class="form-control" placeholder="0.00" min="0" step="0.01">
            </div>
            <div class="col-md-2">
              <button type="button" class="btn btn-success w-100" onclick="agregarProducto()">
                <i class="bx bx-plus me-1"></i>Agregar
              </button>
            </div>
          </div>

          @error('productos')
            <div class="alert alert-danger py-2 mb-2">{{ $message }}</div>
          @enderror

          {{-- Tabla de productos seleccionados --}}
          <div class="table-responsive">
            <table class="table table-bordered table-sm align-middle">
              <thead class="table-light">
                <tr>
                  <th>Producto</th>
                  <th>Cantidad</th>
                  <th>Precio Unit.</th>
                  <th>Subtotal</th>
                  <th></th>
                </tr>
              </thead>
              <tbody id="tablaProductosBody">
                <tr id="filaVacia">
                  <td colspan="5" class="text-center text-muted py-3">
                    <i class="bx bx-box me-1"></i>Agrega productos a la compra
                  </td>
                </tr>
              </tbody>
              <tfoot>
                <tr>
                  <td colspan="3" class="text-end fw-bold">TOTAL:</td>
                  <td colspan="2" class="fw-bold text-success" id="totalCalculado">S/ 0.00</td>
                </tr>
              </tfoot>
            </table>
          </div>

          {{-- Hidden inputs generados por JS --}}
          <div id="productosHidden"></div>

        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary">
            <i class="bx bx-save me-1"></i>Registrar Compra
          </button>
        </div>
      </form>

    </div>
  </div>
</div>
