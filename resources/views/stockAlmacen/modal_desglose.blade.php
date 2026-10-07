{{-- Modal para desglose --}}
<div class="modal fade" id="modalDesglose" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow">

      <div class="modal-header bg-primary">
        <div class="d-flex align-items-center gap-2" style="transform: translateY(-8px);">
          <h5 class="modal-title mb-0 text-white">Desglose de Stock</h5>
        </div>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body p-4">
        <div class="d-flex flex-column mb-4">
          <span class="text-muted small text-uppercase fw-bold tracking-wider">Producto Seleccionado</span>
          <h6 class="fw-bold mb-0 text-primary fs-5" id="modalProductoNombre">Cargando...</h6>
        </div>

        <div class="table-responsive rounded border">
          <table class="table table-hover table-sm mb-0">
            <thead class="table-light border-bottom">
              <tr>
                <th class="ps-3"><i class="bx bx-store me-1"></i> Sucursal</th>
                <th class="text-center"><i class="bx bx-box me-1"></i> Stock Actual</th>
                <th class="text-center"><i class="bx bx-check-shield me-1"></i> Estado</th>
              </tr>
            </thead>
            <tbody id="tbodyDesglose">
              <!-- Se llena con JS -->
            </tbody>
          </table>
        </div>
      </div>

      <div class="modal-footer">
        <div class="d-flex justify-content-center w-100" style="transform: translateY(8px);">
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
            <i class="bx bx-x me-1"></i> Cerrar
          </button>
        </div>
      </div>

    </div>
  </div>
</div>
