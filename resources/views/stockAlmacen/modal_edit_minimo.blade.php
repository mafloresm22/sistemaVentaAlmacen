{{-- Modal para editar Stock Mínimo --}}
<div class="modal fade" id="modalEditMinimo" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
  <div class="modal-dialog modal-dialog-centered">
    <form id="formEditMinimo" action="{{ route('stock-almacen.update-minimos') }}" method="POST"
      class="modal-content border-0 shadow">
      @csrf
      <input type="hidden" name="producto_id" id="minimoProductoId">

      <div class="modal-header bg-warning">
        <div class="d-flex align-items-center gap-2" style="transform: translateY(-8px);">
          <h5 class="modal-title mb-0 text-white">Ajustar Stock Mínimo</h5>
        </div>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body p-4">
        <div class="d-flex flex-column mb-4">
          <span class="text-muted small text-uppercase fw-bold tracking-wider">Producto</span>
          <h6 class="fw-bold mb-0 text-warning fs-5" id="minimoProductoNombre">Cargando...</h6>
          <p class="text-muted small mb-0 mt-1">Configura el nivel de stock mínimo aceptable para cada sucursal.</p>
        </div>

        <div class="table-responsive rounded border">
          <table class="table table-hover table-sm mb-0 align-middle">
            <thead class="table-light border-bottom">
              <tr>
                <th class="ps-3"><i class="bx bx-store me-1"></i> Sucursal</th>
                <th class="text-center" style="width: 150px;"><i class="bx bx-down-arrow-circle me-1"></i> Stock Mín.
                </th>
              </tr>
            </thead>
            <tbody id="tbodyMinimos">
              <!-- Se llena con JS -->
            </tbody>
          </table>
        </div>
      </div>

      <div class="modal-footer">
        <div class="d-flex justify-content-between w-100" style="transform: translateY(8px);">
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-warning text-dark fw-semibold">
            <i class="bx bx-save me-1"></i> Guardar Cambios
          </button>
        </div>
      </div>

    </form>
  </div>
</div>
