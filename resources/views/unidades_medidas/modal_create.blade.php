<div class="modal fade" id="modalCrearUnidadMedida" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title fw-bold text-white" style="transform: translateY(-8px);">Nueva Unidad de Medida</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('unidades-medidas.store') }}" method="POST">
        @csrf
        <div class="modal-body">
          {{-- Nombre --}}
          <div class="mb-3">
            <label for="nameUnidadesMedidas" class="form-label required fw-semibold">Nombre</label>
            <input type="text" class="form-control @error('nameUnidadesMedidas') is-invalid @enderror"
              id="nameUnidadesMedidas" name="nameUnidadesMedidas" value="{{ old('nameUnidadesMedidas') }}" required
              placeholder="Ej: Unidad, Paquete, etc" maxlength="100">
            @error('nameUnidadesMedidas')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          {{-- Símbolo --}}
          <div class="mb-3">
            <label for="simboloUnMedidas" class="form-label required fw-semibold">Símbolo</label>
            <input type="text" class="form-control @error('simboloUnMedidas') is-invalid @enderror"
              id="simboloUnMedidas" name="simboloUnMedidas" value="{{ old('simboloUnMedidas') }}"
              placeholder="Ej: Unid, Pck, etc" required maxlength="10">
            @error('simboloUnMedidas')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          {{-- Permite Decimales --}}
          <div class="mb-3">
            <div class="form-check form-switch mt-3">
              <input class="form-check-input" type="checkbox" id="permiteDecimalesUnMedidas"
                name="permiteDecimalesUnMedidas" value="1" {{ old('permiteDecimalesUnMedidas') ? 'checked' : '' }}>
              <label class="form-check-label fw-semibold" for="permiteDecimalesUnMedidas">¿Permite Decimales?</label>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary">Guardar</button>
        </div>
      </form>
    </div>
  </div>
</div>
