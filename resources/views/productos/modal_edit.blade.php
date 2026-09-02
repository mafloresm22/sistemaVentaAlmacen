<!-- Modal Editar Producto -->
<div class="modal fade" id="modalEditarProducto" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <form class="modal-content" id="formEditarProducto" action="" method="POST" enctype="multipart/form-data">
      @csrf
      @method('PUT')

      <!-- Modal Header -->
      <div class="modal-header bg-warning">
        <h5 class="modal-title text-white" style="transform: translateY(-8px);">Editar Producto</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <!-- Modal Body -->
      <div class="modal-body">

        <!-- Fila 1: Código y Nombre del Producto -->
        <div class="row g-3 mb-3">
          <div class="col-md-4">
            <label for="editCodigo" class="form-label fw-medium">
              Código <span class="text-danger">*</span>
            </label>
            <div class="input-group">
              <input type="text" id="editCodigo" name="codigoProducto" class="form-control"
                placeholder="Código de barras" maxlength="64" required />
              <button class="btn btn-outline-secondary" type="button" onclick="generarCodigoInternoEdit()"
                title="Generar código interno">
                <i class="bx bx-barcode"></i>
              </button>
            </div>
          </div>

          <div class="col-md-8">
            <label for="editNombre" class="form-label fw-medium">
              Nombre del Producto <span class="text-danger">*</span>
            </label>
            <input type="text" id="editNombre" name="nombreProductos" class="form-control"
              placeholder="Nombre del producto" maxlength="150" required />
          </div>
        </div>

        <!-- Fila 2: Precio e Imagen -->
        <div class="row g-3 mb-3">
          <div class="col-md-4">
            <label for="editPrecio" class="form-label fw-medium">
              Precio (S/) <span class="text-danger">*</span>
            </label>
            <div class="input-group">
              <span class="input-group-text">S/</span>
              <input type="number" id="editPrecio" name="precioProductos" class="form-control" placeholder="0.00"
                step="0.01" min="0" required />
            </div>
          </div>

          <div class="col-md-8">
            <label for="editImagen" class="form-label fw-medium">
              Imagen del Producto <span class="text-muted">(opcional al editar)</span>
            </label>
            <input type="file" id="editImagen" name="imagen" class="form-control"
              accept="image/png,image/jpeg,image/webp" />
            <div class="form-text">Dejar vacío si no deseas cambiar la imagen actual. Formatos: JPG, PNG, WEBP.</div>
          </div>
        </div>

        <!-- Fila 3: Categoría, Marca, Unidad de Medida -->
        <div class="row g-3 mb-3">
          <div class="col-md-4">
            <label for="editCategoria" class="form-label fw-medium">
              Categoría <span class="text-danger">*</span>
            </label>
            <select id="editCategoria" name="categoriasid" class="form-select" required>
              <option value="">-- Seleccionar --</option>
              @foreach ($categorias as $categoria)
                <option value="{{ $categoria->idCategorias }}">{{ $categoria->nombreCategorias }}</option>
              @endforeach
            </select>
          </div>

          <div class="col-md-4">
            <label for="editMarca" class="form-label fw-medium">
              Marca <span class="text-danger">*</span>
            </label>
            <select id="editMarca" name="marcasid" class="form-select" required>
              <option value="">-- Seleccionar --</option>
              @foreach ($marcas as $marca)
                <option value="{{ $marca->idMarcas }}">{{ $marca->nameMarcas }}</option>
              @endforeach
            </select>
          </div>

          <div class="col-md-4">
            <label for="editUnidad" class="form-label fw-medium">
              Unidad de Medida <span class="text-muted">(opcional)</span>
            </label>
            <select id="editUnidad" name="unidadesmedidasid" class="form-select">
              <option value="">-- Ninguno --</option>
              @foreach ($unidadesMedida as $unidad)
                <option value="{{ $unidad->idUnidadesMedidas }}">
                  {{ $unidad->nameUnidadesMedidas }} ({{ $unidad->simboloUnMedidas }})
                </option>
              @endforeach
            </select>
          </div>
        </div>

        <!-- Fila 4: Estado y Descripción -->
        <div class="row g-3 mb-3">
          <div class="col-md-12">
            <label for="editDescripcion" class="form-label fw-medium">Descripción</label>
            <textarea id="editDescripcion" name="descripcionProductos" rows="3" class="form-control"
              placeholder="Descripción opcional del producto..."></textarea>
          </div>
        </div>
      </div>

      <!-- Modal Footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-warning text-white">Actualizar Producto</button>
      </div>
    </form>
  </div>
</div>
