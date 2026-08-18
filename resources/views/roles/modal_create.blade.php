<div class="modal fade" id="modalCrearRol" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form action="{{ route('roles.store') }}" method="POST">
        @csrf
        <div class="modal-header bg-primary">
          <h5 class="modal-title text-white"><i class="bx bx-category me-2"></i>Nuevo Rol</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="nameRoles" class="form-label fw-semibold">
              Nombre <span class="text-danger">*</span>
            </label>
            <input type="text" name="nameRoles" id="nameRoles"
              class="form-control @error('nameRoles') is-invalid @enderror" value="{{ old('nameRoles') }}" required
              maxlength="150">
            @error('nameRoles')
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
