{{-- Modal: Nueva Venta --}}
<div class="modal fade" id="modalAgregarVenta" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header bg-primary">
        <div class="d-flex align-items-center gap-2" style="transform: translateY(-8px);">
          <h5 class="modal-title mb-0 text-white">Nueva Venta</h5>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <form action="{{ route('ventas.store') }}" method="POST" id="formNuevaVenta">
        @csrf
        <div class="modal-body p-4">
          <div class="row g-4">
            <div class="col-lg-7">

              {{-- ── PASO 1: CLIENTE ── --}}
              <div class="card border mb-3">
                <div class="card-header py-2 bg-label-primary d-flex align-items-center justify-content-between">
                  <span class="fw-semibold"><i class="bx bx-user me-2"></i>Paso 1 · Cliente</span>
                  <div class="form-check form-switch mb-0">
                    <input class="form-check-input" type="checkbox" id="switchClienteGeneral" checked
                      onchange="toggleCliente(this)">
                    <label class="form-check-label small" for="switchClienteGeneral">Público General</label>
                  </div>
                </div>
                <div class="card-body py-3">

                  {{-- Cliente genérico (por defecto) --}}
                  <div id="seccionClienteGeneral">
                    <div class="d-flex align-items-center gap-3 p-3 rounded bg-label-secondary">
                      <span class="avatar-initial rounded-circle bg-secondary text-white"
                        style="width:44px;height:44px;font-size:20px;display:flex;align-items:center;justify-content:center;">
                        <i class="bx bx-group"></i>
                      </span>
                      <div>
                        <p class="mb-0 fw-semibold">Público General</p>
                        <small class="text-muted">Sin datos de cliente · Ticket simple</small>
                      </div>
                      <span class="badge bg-label-warning ms-auto">Sin identificar</span>
                    </div>
                  </div>

                  {{-- Buscar cliente por DNI --}}
                  <div id="seccionBuscarCliente" style="display:none;">
                    <div class="row g-2 mb-2">
                      <div class="col">
                        <label class="form-label fw-semibold mb-1">DNI del Cliente</label>
                        <div class="input-group">
                          <span class="input-group-text"><i class="bx bx-id-card"></i></span>
                          <input type="text" id="dniInput" class="form-control" placeholder="Ej: 74521836"
                            maxlength="8">
                          <button type="button" class="btn btn-primary" onclick="buscarDNI()" id="btnBuscarDNI">
                            <i class="bx bx-search-alt me-1"></i>Buscar
                          </button>
                        </div>
                        <small class="text-muted">Ingresa el DNI y presiona Buscar para autocompletar</small>
                      </div>
                    </div>

                    {{-- Estado carga --}}
                    <div id="loadingDNI" style="display:none;" class="text-center py-2">
                      <div class="spinner-border spinner-border-sm text-primary" role="status"></div>
                      <span class="ms-2 text-muted small">Consultando...</span>
                    </div>
                    <div id="errorDNI" style="display:none;" class="alert alert-warning py-2 mb-2 mt-1">
                      <i class="bx bx-error-circle me-1"></i><span id="errorDNIMsg"></span>
                    </div>

                    {{-- Resultado --}}
                    <div id="resultadoCliente" style="display:none;">
                      <div class="d-flex align-items-center gap-3 p-3 rounded border border-success">
                        <span class="avatar-initial rounded-circle bg-label-success fw-bold" id="avatarInicialCliente"
                          style="width:44px;height:44px;font-size:18px;display:flex;align-items:center;justify-content:center;"></span>
                        <div class="grow">
                          <p class="mb-0 fw-semibold" id="nombreCompletoCliente"></p>
                          <small class="text-muted">DNI: <span id="dniMostrado"></span></small>
                        </div>
                        <button type="button" class="btn btn-sm btn-label-danger" onclick="limpiarCliente()">
                          <i class="bx bx-x"></i> Quitar
                        </button>
                      </div>
                      <input type="hidden" name="nombreCliente" id="nombreClienteHidden">
                      <input type="hidden" name="apellidoCliente" id="apellidoClienteHidden">
                      <input type="hidden" name="numerodocumentoCliente" id="docClienteHidden">
                    </div>
                  </div>

                </div>
              </div>

              {{-- ── PASO 2: PRODUCTOS ── --}}
              <div class="card border">
                <div class="card-header py-2 bg-label-info">
                  <span class="fw-semibold"><i class="bx bx-package me-2"></i>Paso 2 · Productos</span>
                </div>
                <div class="card-body py-3">

                  <div class="row g-2 align-items-end mb-3">
                    <div class="col-md-5">
                      <label class="form-label fw-semibold mb-1">Producto</label>
                      <select id="productoSelectVenta" class="form-select">
                        <option value="">-- Seleccionar --</option>
                        @foreach ($productos as $p)
                          <option value="{{ $p->idProductos }}" data-precio="{{ $p->precioProductos }}"
                            data-nombre="{{ $p->nombreProductos }}">
                            {{ $p->nombreProductos }}
                          </option>
                        @endforeach
                      </select>
                    </div>
                    <div class="col-md-2">
                      <label class="form-label fw-semibold mb-1">Cant.</label>
                      <input type="number" id="cantidadVentaInput" class="form-control" value="1"
                        min="1" step="1">
                    </div>
                    <div class="col-md-2">
                      <label class="form-label fw-semibold mb-1">Precio</label>
                      <input type="number" id="precioVentaInput" class="form-control" placeholder="0.00"
                        min="0" step="0.01">
                    </div>
                    <div class="col-md-2">
                      <label class="form-label fw-semibold mb-1">Dscto %</label>
                      <input type="number" id="descuentoVentaInput" class="form-control" value="0"
                        min="0" max="100">
                    </div>
                    <div class="col-md-1">
                      <button type="button" class="btn btn-primary w-100" onclick="agregarProductoVenta()"
                        title="Agregar">
                        <i class="bx bx-plus"></i>
                      </button>
                    </div>
                  </div>

                  <div class="table-responsive" style="max-height:220px;overflow-y:auto;">
                    <table class="table table-sm table-hover align-middle mb-0">
                      <thead class="table-light sticky-top">
                        <tr>
                          <th>Producto</th>
                          <th class="text-center">Cant.</th>
                          <th class="text-center">Precio</th>
                          <th class="text-center">Dscto</th>
                          <th class="text-end">Subtotal</th>
                          <th></th>
                        </tr>
                      </thead>
                      <tbody id="tablaProductosVentaBody">
                        <tr id="filaVaciaVenta">
                          <td colspan="6" class="text-center text-muted py-4">
                            <i class="bx bx-cart-alt fs-3 d-block mb-1 opacity-50"></i>
                            Sin productos agregados
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  <div id="productosVentaHidden"></div>
                </div>
              </div>
            </div>

            <div class="col-lg-5">

              {{-- ── PASO 3: MÉTODO DE PAGO ── --}}
              <div class="card border mb-3">
                <div class="card-header py-2 bg-label-success">
                  <span class="fw-semibold"><i class="bx bx-wallet me-2"></i>Paso 3 · Método de Pago</span>
                </div>
                <div class="card-body py-3">
                  <div class="row g-2">
                    <div class="col-6">
                      <input type="radio" class="btn-check" name="metodoVentas" id="metodoEfectivo"
                        value="EFECTIVO" checked>
                      <label class="btn btn-outline-success w-100 d-flex flex-column align-items-center py-3"
                        for="metodoEfectivo">
                        <i class="bx bx-money fs-3 mb-1"></i><span>Efectivo</span>
                      </label>
                    </div>
                    <div class="col-6">
                      <input type="radio" class="btn-check" name="metodoVentas" id="metodoYape" value="YAPE">
                      <label class="btn btn-outline-info w-100 d-flex flex-column align-items-center py-3"
                        for="metodoYape">
                        <i class="bx bx-qr fs-3 mb-1"></i><span>Yape</span>
                      </label>
                    </div>
                    <div class="col-6">
                      <input type="radio" class="btn-check" name="metodoVentas" id="metodoPlin" value="PLIN">
                      <label class="btn btn-outline-primary w-100 d-flex flex-column align-items-center py-3"
                        for="metodoPlin">
                        <i class="bx bx-credit-card fs-3 mb-1"></i><span>Plin</span>
                      </label>
                    </div>
                    <div class="col-6">
                      <input type="radio" class="btn-check" name="metodoVentas" id="metodoTarjeta"
                        value="TARJETA">
                      <label class="btn btn-outline-warning w-100 d-flex flex-column align-items-center py-3"
                        for="metodoTarjeta">
                        <i class="bx bx-credit-card-alt fs-3 mb-1"></i><span>Tarjeta</span>
                      </label>
                    </div>
                  </div>

                  {{-- Vuelto (solo Efectivo) --}}
                  <div id="seccionEfectivo" class="mt-3">
                    <label class="form-label fw-semibold mb-1">Monto recibido (S/)</label>
                    <input type="number" id="montoRecibido" class="form-control form-control-lg" placeholder="0.00"
                      min="0" step="0.01">
                    <div class="d-flex justify-content-between mt-2 px-1">
                      <span class="text-muted small">Vuelto:</span>
                      <span class="fw-bold text-success" id="vueltoCalculado">S/ 0.00</span>
                    </div>
                  </div>
                </div>
              </div>

              {{-- ── RESUMEN ── --}}
              <div class="card border bg-label-secondary">
                <div class="card-body py-3">
                  <h6 class="fw-bold mb-3"><i class="bx bx-calculator me-2"></i>Resumen</h6>
                  <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Subtotal bruto</span>
                    <span id="resumenSubtotal">S/ 0.00</span>
                  </div>
                  <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Descuentos</span>
                    <span class="text-danger" id="resumenDescuento">- S/ 0.00</span>
                  </div>
                  <hr class="my-2">
                  <div class="d-flex justify-content-between">
                    <span class="fw-bold fs-6">TOTAL A PAGAR</span>
                    <span class="fw-bold fs-5 text-success" id="resumenTotal">S/ 0.00</span>
                  </div>
                  <input type="hidden" name="totalVentas" id="totalVentasHidden" value="0">
                  <input type="hidden" name="estadoVentas" value="PAGADO">
                  <input type="hidden" name="fechaCompraVentas" value="{{ now() }}">
                </div>
              </div>

            </div>
          </div>
        </div>

        <div class="modal-footer border-top">
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-success" id="btnRegistrarVenta" disabled>Registrar Venta</button>
        </div>
      </form>

    </div>
  </div>
</div>

<script>
  const productosVentaData = @json($productos);
  let itemsVenta = [];

  // ── Toggle cliente genérico / identificado
  function toggleCliente(checkbox) {
    document.getElementById('seccionClienteGeneral').style.display = checkbox.checked ? '' : 'none';
    document.getElementById('seccionBuscarCliente').style.display = checkbox.checked ? 'none' : '';
    if (checkbox.checked) limpiarCliente();
  }

  // ── Buscar DNI vía API proxy
  async function buscarDNI() {
    const dni = document.getElementById('dniInput').value.trim();
    if (dni.length !== 8) {
      mostrarErrorDNI('El DNI debe tener 8 dígitos.');
      return;
    }

    document.getElementById('loadingDNI').style.display = '';
    document.getElementById('errorDNI').style.display = 'none';
    document.getElementById('resultadoCliente').style.display = 'none';
    document.getElementById('btnBuscarDNI').disabled = true;

    try {
      const res = await fetch('/api/dni/' + dni);
      const data = await res.json();

      if (!res.ok || data.success === false) {
        mostrarErrorDNI(data.message || 'DNI no encontrado. Verifica el número.');
        return;
      }

      const nombre = data.nombreCompleto || ((data.nombres || '') + ' ' + (data.apellidoPaterno || '') + ' ' + (data
        .apellidoMaterno || '')).trim();
      const nombres = data.nombres || nombre.split(' ')[0] || '';
      const apellido = data.apellidoPaterno || '';

      document.getElementById('nombreCompletoCliente').textContent = nombre;
      document.getElementById('dniMostrado').textContent = dni;
      document.getElementById('avatarInicialCliente').textContent = nombre.charAt(0).toUpperCase();
      document.getElementById('nombreClienteHidden').value = nombres;
      document.getElementById('apellidoClienteHidden').value = apellido;
      document.getElementById('docClienteHidden').value = dni;
      document.getElementById('resultadoCliente').style.display = '';

    } catch (e) {
      mostrarErrorDNI('Error de conexión con el servicio.');
    } finally {
      document.getElementById('loadingDNI').style.display = 'none';
      document.getElementById('btnBuscarDNI').disabled = false;
    }
  }

  function mostrarErrorDNI(msg) {
    document.getElementById('errorDNIMsg').textContent = msg;
    document.getElementById('errorDNI').style.display = '';
    document.getElementById('loadingDNI').style.display = 'none';
    document.getElementById('btnBuscarDNI').disabled = false;
  }

  function limpiarCliente() {
    ['resultadoCliente', 'errorDNI'].forEach(id => document.getElementById(id).style.display = 'none');
    ['dniInput', 'nombreClienteHidden', 'apellidoClienteHidden', 'docClienteHidden'].forEach(id => document
      .getElementById(id).value = '');
  }

  // ── Autocompletar precio al elegir producto
  document.getElementById('productoSelectVenta').addEventListener('change', function() {
    const opt = this.options[this.selectedIndex];
    document.getElementById('precioVentaInput').value = opt.dataset.precio || '';
  });

  // Enter en DNI → buscar
  document.getElementById('dniInput').addEventListener('keydown', e => {
    if (e.key === 'Enter') {
      e.preventDefault();
      buscarDNI();
    }
  });

  // ── Agregar producto al carrito
  function agregarProductoVenta() {
    const select = document.getElementById('productoSelectVenta');
    const cantidad = parseFloat(document.getElementById('cantidadVentaInput').value);
    const precio = parseFloat(document.getElementById('precioVentaInput').value);
    const descuento = parseFloat(document.getElementById('descuentoVentaInput').value) || 0;

    if (!select.value || isNaN(cantidad) || cantidad <= 0 || isNaN(precio) || precio < 0) {
      Swal.fire('Atención', 'Completa correctamente los datos del producto.', 'warning');
      return;
    }

    const id = parseInt(select.value);
    const nombre = select.options[select.selectedIndex].dataset.nombre;
    const sub = precio * cantidad * (1 - descuento / 100);
    const existe = itemsVenta.findIndex(p => p.id === id);

    if (existe >= 0) {
      itemsVenta[existe].cantidad += cantidad;
      itemsVenta[existe].precio = precio;
      itemsVenta[existe].descuento = descuento;
      itemsVenta[existe].subtotal = itemsVenta[existe].precio * itemsVenta[existe].cantidad * (1 - descuento / 100);
    } else {
      itemsVenta.push({
        id,
        nombre,
        cantidad,
        precio,
        descuento,
        subtotal: sub
      });
    }

    renderTablaVenta();
    select.value = '';
    document.getElementById('cantidadVentaInput').value = '1';
    document.getElementById('precioVentaInput').value = '';
    document.getElementById('descuentoVentaInput').value = '0';
  }

  function eliminarItemVenta(index) {
    itemsVenta.splice(index, 1);
    renderTablaVenta();
  }

  function renderTablaVenta() {
    const tbody = document.getElementById('tablaProductosVentaBody');
    const hidden = document.getElementById('productosVentaHidden');
    tbody.innerHTML = '';
    hidden.innerHTML = '';

    if (itemsVenta.length === 0) {
      tbody.innerHTML = `<tr><td colspan="6" class="text-center text-muted py-4">
        <i class="bx bx-cart-alt fs-3 d-block mb-1 opacity-50"></i>Sin productos agregados</td></tr>`;
      actualizarResumen(0, 0);
      return;
    }

    let totalBruto = 0,
      totalDesc = 0;
    itemsVenta.forEach((p, i) => {
      totalBruto += p.precio * p.cantidad;
      totalDesc += p.precio * p.cantidad * (p.descuento / 100);
      tbody.innerHTML += `<tr>
        <td class="fw-semibold">${p.nombre}</td>
        <td class="text-center">${p.cantidad}</td>
        <td class="text-center">S/ ${p.precio.toFixed(2)}</td>
        <td class="text-center">${p.descuento > 0 ? '<span class="badge bg-label-warning">' + p.descuento + '%</span>' : '<span class="text-muted">—</span>'}</td>
        <td class="text-end fw-bold text-success">S/ ${p.subtotal.toFixed(2)}</td>
        <td class="text-center"><button type="button" class="btn btn-sm btn-icon btn-danger" onclick="eliminarItemVenta(${i})">
          <i class="bx bx-trash text-white"></i></button></td></tr>`;
      hidden.innerHTML += `
        <input type="hidden" name="productos[${i}][id]"        value="${p.id}">
        <input type="hidden" name="productos[${i}][cantidad]"  value="${p.cantidad}">
        <input type="hidden" name="productos[${i}][precio]"    value="${p.precio}">
        <input type="hidden" name="productos[${i}][descuento]" value="${p.descuento}">`;
    });
    actualizarResumen(totalBruto, totalDesc);
  }

  function actualizarResumen(bruto, desc) {
    const total = bruto - desc;
    document.getElementById('resumenSubtotal').textContent = 'S/ ' + bruto.toFixed(2);
    document.getElementById('resumenDescuento').textContent = '- S/ ' + desc.toFixed(2);
    document.getElementById('resumenTotal').textContent = 'S/ ' + total.toFixed(2);
    document.getElementById('totalVentasHidden').value = total.toFixed(2);
    document.getElementById('btnRegistrarVenta').disabled = itemsVenta.length === 0;
    calcularVuelto();
  }

  // ── Vuelto
  document.getElementById('montoRecibido').addEventListener('input', calcularVuelto);

  function calcularVuelto() {
    const total = parseFloat(document.getElementById('totalVentasHidden').value) || 0;
    const recibido = parseFloat(document.getElementById('montoRecibido').value) || 0;
    const vuelto = recibido - total;
    const el = document.getElementById('vueltoCalculado');
    el.textContent = 'S/ ' + (vuelto >= 0 ? vuelto.toFixed(2) : '0.00');
    el.className = 'fw-bold ' + (vuelto >= 0 ? 'text-success' : 'text-danger');
  }

  // ── Mostrar/ocultar sección efectivo
  document.querySelectorAll('input[name="metodoVentas"]').forEach(r => {
    r.addEventListener('change', function() {
      document.getElementById('seccionEfectivo').style.display = this.value === 'EFECTIVO' ? '' : 'none';
    });
  });

  // ── Limpiar modal al cerrar
  document.getElementById('modalAgregarVenta').addEventListener('hidden.bs.modal', function() {
    itemsVenta = [];
    renderTablaVenta();
    ['dniInput', 'montoRecibido'].forEach(id => document.getElementById(id).value = '');
    const sw = document.getElementById('switchClienteGeneral');
    sw.checked = true;
    toggleCliente(sw);
    document.getElementById('vueltoCalculado').textContent = 'S/ 0.00';
  });
</script>
