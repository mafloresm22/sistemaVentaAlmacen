<div class="modal fade" id="modalEditarCategoria" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form id="formEditar" action="" method="POST">
        @csrf
        @method('PUT')
        <div class="modal-header">
          <h5 class="modal-title"><i class="bx bx-edit me-2 text-warning"></i>Editar Categoría</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="editNombre" class="form-label fw-semibold">
              Nombre <span class="text-danger">*</span>
            </label>
            <input type="text" name="nombreCategorias" id="editNombre" class="form-control"
              placeholder="Nombre de la categoría" required maxlength="150">
          </div>
          <div class="mb-3">
            <label for="editDescripcion" class="form-label fw-semibold">
              Descripción
            </label>
            <textarea name="descripcionCategorias" id="editDescripcion" class="form-control" rows="3"
              placeholder="Descripción de la categoría"></textarea>
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