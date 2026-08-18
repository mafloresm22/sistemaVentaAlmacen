<div class="modal fade" id="modalCrearMarca" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title fw-bold text-white" id="modalCrearMarcaTitle"><i
            class="bx bx-purchase-tag-alt me-2"></i>Nueva Marca</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('marcas.store') }}" method="POST" id="form-crear-marca">
        @csrf
        <div class="modal-body">
          {{-- Nombre de la Marca --}}
          <div class="mb-3">
            <label for="nameMarcas" class="form-label required">Nombre de la Marca</label>
            <input type="text" class="form-control @error('nameMarcas') is-invalid @enderror" id="nameMarcas"
              name="nameMarcas" value="{{ old('nameMarcas') }}" placeholder="Ej: Nike, Samsung, Logitech" required>
            @error('nameMarcas')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary" id="btn-guardar-marca">Guardar Marca</button>
        </div>
      </form>
    </div>
  </div>
</div>
