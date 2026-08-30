<div class="modal fade" id="modalEditarUnidadMedida" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header bg-warning">
        <h5 class="modal-title fw-bold text-white" style="transform: translateY(-8px);">Editar Unidad de Medida</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="formEditarUnidadMedida" action="" method="POST">
        @csrf
        @method('PUT')
        <div class="modal-body">
          {{-- Nombre --}}
          <div class="mb-3">
            <label for="editNombre" class="form-label required fw-semibold">Nombre</label>
            <input type="text" class="form-control @error('nameUnidadesMedidas') is-invalid @enderror"
              id="editNombre" name="nameUnidadesMedidas" required maxlength="100">
            @error('nameUnidadesMedidas')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          {{-- Símbolo --}}
          <div class="mb-3">
            <label for="editSimbolo" class="form-label required fw-semibold">Símbolo</label>
            <input type="text" class="form-control @error('simboloUnMedidas') is-invalid @enderror" id="editSimbolo"
              name="simboloUnMedidas" required maxlength="10">
            @error('simboloUnMedidas')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          {{-- Permite Decimales --}}
          <div class="mb-3">
            <div class="form-check form-switch mt-3">
              <input class="form-check-input" type="checkbox" id="editPermiteDecimales" name="permiteDecimalesUnMedidas"
                value="1">
              <label class="form-check-label fw-semibold" for="editPermiteDecimales">¿Permite Decimales?</label>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-warning">Actualizar</button>
        </div>
      </form>
    </div>
  </div>
</div>
