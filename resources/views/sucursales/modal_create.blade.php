<div class="modal fade" id="modalCrearSucursal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form action="{{ route('sucursales.store') }}" method="POST">
        @csrf
        <div class="modal-header bg-primary">
          <h5 class="modal-title text-white" style="transform: translateY(-8px);">Nueva Sucursal</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="nombreSucursales" class="form-label fw-semibold">
              Nombre <span class="text-danger">*</span>
            </label>
            <input type="text" name="nombreSucursales" id="nombreSucursales"
              class="form-control @error('nombreSucursales') is-invalid @enderror" placeholder="Ej: Sucursal 1"
              value="{{ old('nombreSucursales') }}" required maxlength="150">
            @error('nombreSucursales')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          <div class="mb-3">
            <label for="ubicacionSucursales" class="form-label fw-semibold">
              Ubicación <span class="text-danger">*</span>
            </label>
            <input type="text" name="ubicacionSucursales" id="ubicacionSucursales"
              class="form-control @error('ubicacionSucursales') is-invalid @enderror" placeholder="Ej: Centro, Norte"
              value="{{ old('ubicacionSucursales') }}" required maxlength="150">
            @error('ubicacionSucursales')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
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
