{{-- Modal: Editar Estado de Compra --}}
<div class="modal fade" id="modalEditarCompra" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-sm modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title"><i class="bx bx-edit me-2 text-primary"></i>Cambiar Estado</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <form action="" method="POST" id="formEditarCompra">
        @csrf
        @method('PUT')
        <div class="modal-body">
          <p class="text-muted mb-3">
            Factura: <strong id="editNumFactura"></strong>
          </p>
          <div class="mb-3">
            <label class="form-label fw-semibold">Estado <span class="text-danger">*</span></label>
            <select name="estadoCompras" id="editEstado" class="form-select" required>
              <option value="PENDIENTE">PENDIENTE</option>
              <option value="PAGADO">PAGADO</option>
              <option value="ANULADO">ANULADO</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary">
            <i class="bx bx-save me-1"></i>Guardar
          </button>
        </div>
      </form>

    </div>
  </div>
</div>
