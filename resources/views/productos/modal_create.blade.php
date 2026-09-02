<!-- Modal Crear Producto -->
<div class="modal fade" id="modalCrearProducto" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <form class="modal-content" action="{{ route('productos.store') }}" method="POST" enctype="multipart/form-data">
      @csrf

      <!-- Modal Header -->
      <div class="modal-header bg-primary">
        <h5 class="modal-title text-white" style="transform: translateY(-8px);">Crear Nuevo Producto</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <!-- Modal Body -->
      <div class="modal-body">

        <!-- Fila 1: Código y Nombre del Producto -->
        <div class="row g-3 mb-3">
          <div class="col-md-4">
            <label for="codigoProductoCreate" class="form-label fw-medium">
              Código <span class="text-danger">*</span>
            </label>
            <div class="input-group">
              <input type="text" id="codigoProductoCreate" name="codigoProducto"
                class="form-control @error('codigoProducto') is-invalid @enderror" placeholder="Escanee o vacío"
                maxlength="64" value="{{ old('codigoProducto') }}" required />
              <button class="btn btn-outline-secondary" type="button" onclick="generarCodigoInterno()"
                title="Generar código interno">
                <i class="bx bx-barcode"></i>
              </button>
            </div>
            @error('codigoProducto')
              <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
          </div>

          <div class="col-md-8">
            <label for="nombreProductosCreate" class="form-label fw-medium">
              Nombre del Producto <span class="text-danger">*</span>
            </label>
            <input type="text" id="nombreProductosCreate" name="nombreProductos"
              class="form-control @error('nombreProductos') is-invalid @enderror"
              placeholder="Ej: ASUS Vivobook 16 Laptop" maxlength="150" value="{{ old('nombreProductos') }}" required />
            @error('nombreProductos')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
        </div>
        <!-- Fila 2: Precio -->
        <div class="row g-3 mb-3">
          <div class="col-md-4">
            <label for="precioProductosCreate" class="form-label fw-medium">
              Precio (S/) <span class="text-danger">*</span>
            </label>
            <div class="input-group">
              <span class="input-group-text">S/</span>
              <input type="number" id="precioProductosCreate" name="precioProductos"
                class="form-control @error('precioProductos') is-invalid @enderror" placeholder="0.00" step="0.01"
                min="0" value="{{ old('precioProductos') }}" required />
              @error('precioProductos')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>

          <div class="col-md-8">
            <label for="imagenCreate" class="form-label fw-medium">
              Imagen del Producto <span class="text-danger">*</span>
            </label>
            <input type="file" id="imagenCreate" name="imagen"
              class="form-control @error('imagen') is-invalid @enderror" accept="image/png,image/jpeg,image/webp"
              required />
            @error('imagen')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <div class="form-text">Formatos: JPG, PNG, WEBP. Máx. 2 MB.</div>
          </div>
        </div>

        <!-- Fila 3: Categoría, Marca, Unidad de Medida -->
        <div class="row g-3 mb-3">
          <div class="col-md-4">
            <label for="categoriasidCreate" class="form-label fw-medium">
              Categoría <span class="text-danger">*</span>
            </label>
            <select id="categoriasidCreate" name="categoriasid"
              class="form-select select2 @error('categoriasid') is-invalid @enderror"
              data-placeholder="-- Seleccionar --" required>
              <option value=""></option>
              @foreach ($categorias as $categoria)
                <option value="{{ $categoria->idCategorias }}"
                  {{ old('categoriasid') == $categoria->idCategorias ? 'selected' : '' }}>
                  {{ $categoria->nombreCategorias }}
                </option>
              @endforeach
            </select>
            @error('categoriasid')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="col-md-4">
            <label for="marcasidCreate" class="form-label fw-medium">
              Marca <span class="text-danger">*</span>
            </label>
            <select id="marcasidCreate" name="marcasid"
              class="form-select select2 @error('marcasid') is-invalid @enderror" data-placeholder="-- Seleccionar --"
              required>
              <option value=""></option>
              @foreach ($marcas as $marca)
                <option value="{{ $marca->idMarcas }}" {{ old('marcasid') == $marca->idMarcas ? 'selected' : '' }}>
                  {{ $marca->nameMarcas }}
                </option>
              @endforeach
            </select>
            @error('marcasid')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="col-md-4">
            <label for="unidadesmedidasidCreate" class="form-label fw-medium">
              Unidad de Medida <span class="text-muted">(opcional)</span>
            </label>
            <select id="unidadesmedidasidCreate" name="unidadesmedidasid"
              class="form-select select2 @error('unidadesmedidasid') is-invalid @enderror"
              data-placeholder="-- Ninguno --">
              <option value=""></option>
              @foreach ($unidadesMedida as $unidad)
                <option value="{{ $unidad->idUnidadesMedidas }}"
                  {{ old('unidadesmedidasid') == $unidad->idUnidadesMedidas ? 'selected' : '' }}>
                  {{ $unidad->nameUnidadesMedidas }} ({{ $unidad->simboloUnMedidas }})
                </option>
              @endforeach
            </select>
            @error('unidadesmedidasid')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
        </div>

        <!-- Fila 4: Descripción -->
        <div class="mb-3">
          <label for="descripcionProductosCreate" class="form-label fw-medium">Descripción</label>
          <textarea id="descripcionProductosCreate" name="descripcionProductos" rows="3"
            class="form-control @error('descripcionProductos') is-invalid @enderror"
            placeholder="Descripción opcional del producto...">{{ old('descripcionProductos') }}</textarea>
          @error('descripcionProductos')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-primary">Guardar Producto</button>
      </div>
    </form>
  </div>
</div>
