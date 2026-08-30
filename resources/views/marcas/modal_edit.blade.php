<div class="modal fade" id="modalEditarMarcas" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form id="formEditarMarcas" action="" method="POST">
        @csrf
        @method('PUT')
        <div class="modal-header bg-warning">
          <h5 class="modal-title text-white" style="transform: translateY(-8px);">Editar Marcas</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="editNombre" class="form-label fw-semibold">
              Nombre <span class="text-danger">*</span>
            </label>
            <input type="text" name="nameMarcas" id="editNombre" class="form-control"
              placeholder="Nombre de la marca" required maxlength="150">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-warning">
            <i class="bx bx-save me-1"></i>Actualizar
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
