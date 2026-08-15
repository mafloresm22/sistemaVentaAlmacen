<div class="modal fade" id="modalCrearCategoria" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form action="{{ route('categorias.store') }}" method="POST">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title"><i class="bx bx-category me-2 text-primary"></i>Nueva Categoría</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="nombreCategorias" class="form-label fw-semibold">
              Nombre <span class="text-danger">*</span>
            </label>
            <input type="text" name="nombreCategorias" id="nombreCategorias"
              class="form-control @error('nombreCategorias') is-invalid @enderror"
              placeholder="Ej: Electrónica, Ropa, Alimentos..." value="{{ old('nombreCategorias') }}" required
              maxlength="150">
            @error('nombreCategorias')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          <div class="mb-3">
            <label for="descripcionCategorias" class="form-label fw-semibold">
              Descripción
            </label>
            <textarea name="descripcionCategorias" id="descripcionCategorias"
              class="form-control @error('descripcionCategorias') is-invalid @enderror" rows="3"
              placeholder="Describe brevemente esta categoría...">{{ old('descripcionCategorias') }}</textarea>
            @error('descripcionCategorias')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary">
            <i class="bx bx-save me-1"></i>Guardar
          </button>
        </div>
      </form>
    </div>
  </div>
</div>