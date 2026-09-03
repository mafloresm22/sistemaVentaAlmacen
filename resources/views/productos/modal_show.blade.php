<!-- Modal Ver Producto -->
<div class="modal fade" id="modalVerProducto" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header bg-success">
        <h5 class="modal-title text-white" style="transform: translateY(-8px);">Detalle del Producto</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <!-- Modal Body -->
      <div class="modal-body">
        <div class="text-center mb-4">
          <h4 id="showNombre" class="fw-bold mb-1">Nombre del Producto</h4>
          <span id="showCategoria" class="badge bg-label-primary mb-3">Categoría</span>
        </div>

        <ul class="list-group list-group-flush mb-4">
          <li class="list-group-item d-flex justify-content-between align-items-center px-0">
            <span class="fw-medium">Código:</span>
            <span id="showCodigo" class="text-muted">---</span>
          </li>
          <li class="list-group-item d-flex justify-content-between align-items-center px-0">
            <span class="fw-medium">Precio:</span>
            <span id="showPrecio" class="text-muted">---</span>
          </li>
          <li class="list-group-item d-flex justify-content-between align-items-center px-0">
            <span class="fw-medium">Estado:</span>
            <span id="showEstado">---</span>
          </li>
          <li class="list-group-item px-0">
            <span class="fw-medium d-block mb-1">Descripción:</span>
            <p id="showDescripcion" class="text-muted mb-0" style="font-size: 0.9rem;">---</p>
          </li>
        </ul>

        <div class="text-center mt-4">
          <h6 class="fw-medium mb-2">Código de Barras</h6>
          <div class="p-3 bg-light rounded d-inline-block">
            <svg id="showBarcodeImage"></svg>
          </div>
        </div>
      </div>

      <!-- Modal Footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
          Cerrar
        </button>
      </div>
    </div>
  </div>
</div>
