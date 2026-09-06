<!-- Modal Crear Proveedor -->
<div class="modal fade" id="modalCrearProveedor" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <form action="{{ route('proveedores.store') }}" method="POST">
        @csrf

        <!-- Modal Header -->
        <div class="modal-header bg-primary">
          <h5 class="modal-title text-white" style="transform: translateY(-8px);">Nuevo Proveedor</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <!-- Modal Body -->
        <div class="modal-body">
          <div class="row g-3">

            {{-- Nombre del Proveedor --}}
            <div class="col-12">
              <label for="nombreProveedores" class="form-label fw-semibold">
                Nombre o Razón Social <span class="text-danger">*</span>
              </label>
              <input type="text" name="nombreProveedores" id="nombreProveedores"
                class="form-control @error('nombreProveedores') is-invalid @enderror"
                placeholder="Ej: Distribuidora Central S.A.C." value="{{ old('nombreProveedores') }}" required
                maxlength="255">
              @error('nombreProveedores')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            {{-- Tipo de Documento --}}
            <div class="col-12 col-md-4">
              <label for="tipodocumentoProveedores" class="form-label fw-semibold">
                Tipo Documento <span class="text-danger">*</span>
              </label>
              <select name="tipodocumentoProveedores" id="tipodocumentoProveedores"
                class="form-select @error('tipodocumentoProveedores') is-invalid @enderror" required>
                <option value="" disabled selected>Seleccione...</option>
                <option value="RUC" {{ old('tipodocumentoProveedores') == 'RUC' ? 'selected' : '' }}>RUC</option>
                <option value="DNI" {{ old('tipodocumentoProveedores') == 'DNI' ? 'selected' : '' }}>DNI</option>
                <option value="CE" {{ old('tipodocumentoProveedores') == 'CE' ? 'selected' : '' }}>Carné Extranjería
                </option>
                <option value="Pasaporte" {{ old('tipodocumentoProveedores') == 'Pasaporte' ? 'selected' : '' }}>
                  Pasaporte</option>
              </select>
              @error('tipodocumentoProveedores')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            {{-- Número de Documento --}}
            <div class="col-12 col-md-8">
              <label for="numerodocumentoProveedores" class="form-label fw-semibold">
                Número de Documento <span class="text-danger">*</span>
              </label>
              <input type="text" name="numerodocumentoProveedores" id="numerodocumentoProveedores"
                class="form-control @error('numerodocumentoProveedores') is-invalid @enderror"
                placeholder="Seleccione tipo de doc. primero" value="{{ old('numerodocumentoProveedores') }}" required maxlength="255"
                {{ old('tipodocumentoProveedores') ? '' : 'disabled' }}>
              @error('numerodocumentoProveedores')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            {{-- Dirección --}}
            <div class="col-12">
              <label for="direccionProveedores" class="form-label fw-semibold">
                Dirección <span class="text-danger">*</span>
              </label>
              <input type="text" name="direccionProveedores" id="direccionProveedores"
                class="form-control @error('direccionProveedores') is-invalid @enderror"
                placeholder="Ej: Av. Las Flores 123, Lima" value="{{ old('direccionProveedores') }}" required
                maxlength="255">
              @error('direccionProveedores')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            {{-- Teléfono --}}
            <div class="col-4">
              <label for="telefonoProveedores" class="form-label fw-semibold">
                Teléfono <span class="text-danger">*</span>
              </label>
              <input type="text" name="telefonoProveedores" id="telefonoProveedores"
                class="form-control @error('telefonoProveedores') is-invalid @enderror" placeholder="Ej: 987654321"
                value="{{ old('telefonoProveedores') }}" required maxlength="255">
              @error('telefonoProveedores')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            {{-- Correo Electrónico --}}
            <div class="col-4">
              <label for="correoProveedores" class="form-label fw-semibold">
                Correo Electrónico <span class="text-danger">*</span>
              </label>
              <input type="email" name="correoProveedores" id="correoProveedores"
                class="form-control @error('correoProveedores') is-invalid @enderror"
                placeholder="contacto@proveedor.com" value="{{ old('correoProveedores') }}" required maxlength="255">
              @error('correoProveedores')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            {{-- Días de Entrega --}}
            <div class="col-4">
              <label for="diasEntregaProveedores" class="form-label fw-semibold">
                Días de Entrega (Lead Time)
              </label>
              <input type="number" name="diasEntregaProveedores" id="diasEntregaProveedores"
                class="form-control @error('diasEntregaProveedores') is-invalid @enderror" placeholder="Ej: 3"
                value="{{ old('diasEntregaProveedores') }}" min="0">
              @error('diasEntregaProveedores')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>
        </div>

        <!-- Modal Footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary">Guardar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const tipoDocSelect = document.getElementById('tipodocumentoProveedores');
    const numDocInput = document.getElementById('numerodocumentoProveedores');

    function actualizarRestriccionesDocumento() {
      const tipo = tipoDocSelect.value;
      numDocInput.value = '';

      if (!tipo) {
        numDocInput.disabled = true;
        numDocInput.placeholder = 'Seleccione tipo de doc. primero';
        return;
      }

      numDocInput.disabled = false;

      if (tipo === 'DNI') {
        numDocInput.maxLength = 8;
        numDocInput.placeholder = 'Ej: 12345678';
        numDocInput.pattern = '\\d{8}';
        numDocInput.title = 'El DNI debe tener exactamente 8 dígitos';
        numDocInput.oninput = function() {
          this.value = this.value.replace(/[^0-9]/g, '').slice(0, 8);
        };
      } else if (tipo === 'RUC') {
        numDocInput.maxLength = 11;
        numDocInput.placeholder = 'Ej: 20123456789';
        numDocInput.pattern = '\\d{11}';
        numDocInput.title = 'El RUC debe tener exactamente 11 dígitos';
        numDocInput.oninput = function() {
          this.value = this.value.replace(/[^0-9]/g, '').slice(0, 11);
        };
      } else if (tipo === 'CE') {
        numDocInput.maxLength = 12;
        numDocInput.placeholder = 'Ej: 000123456';
        numDocInput.removeAttribute('pattern');
        numDocInput.title = 'Ingrese el Carné de Extranjería';
        numDocInput.oninput = function() {
          this.value = this.value.replace(/[^0-9A-Za-z]/g, '').slice(0, 12);
        };
      } else if (tipo === 'Pasaporte') {
        numDocInput.maxLength = 12;
        numDocInput.placeholder = 'Ej: P1234567';
        numDocInput.removeAttribute('pattern');
        numDocInput.title = 'Ingrese el Pasaporte';
        numDocInput.oninput = function() {
          this.value = this.value.replace(/[^0-9A-Za-z]/g, '').slice(0, 12);
        };
      } else {
        numDocInput.maxLength = 255;
        numDocInput.placeholder = 'Ej: 20123456789';
        numDocInput.removeAttribute('pattern');
        numDocInput.removeAttribute('title');
        numDocInput.oninput = null;
      }
    }

    if (tipoDocSelect && numDocInput) {
      tipoDocSelect.addEventListener('change', actualizarRestriccionesDocumento);
      // Ejecutar al cargar la primera vez si ya hay un valor (por old() al recargar form)
      if (tipoDocSelect.value) {
        const valActual = numDocInput.value; // Guardamos temporalmente si el form falló
        actualizarRestriccionesDocumento();
        numDocInput.value = valActual; // Restauramos
      }
    }
  });
</script>
