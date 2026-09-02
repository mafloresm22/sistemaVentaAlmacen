<!-- Modal Buscar Producto -->
<div class="modal fade" id="modalBuscarProducto" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header bg-info">
        <h5 class="modal-title text-white" style="transform: translateY(-8px);">Buscar Producto</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <!-- Modal Body -->
      <div class="modal-body">

        <!-- Buscador y Filtros -->
        <div class="row g-3 mb-4">
          <div class="col-md-6">
            <label for="buscarProductoInput" class="form-label fw-medium">Buscar por Código o Nombre</label>
            <div class="input-group">
              <span class="input-group-text"><i class="bx bx-search"></i></span>
              <input type="text" id="buscarProductoInput" class="form-control"
                placeholder="Escriba el código o nombre del producto..." oninput="ejecutarBusquedaBackend()" />
            </div>
          </div>

          <div class="col-md-3">
            <label for="filtroCategoriaModal" class="form-label fw-medium">Categoría</label>
            <select id="filtroCategoriaModal" class="form-select" onchange="ejecutarBusquedaBackend()">
              <option value="">-- Todas --</option>
              @foreach ($categorias as $categoria)
                <option value="{{ $categoria->idCategorias }}">{{ $categoria->nombreCategorias }}</option>
              @endforeach
            </select>
          </div>

          <div class="col-md-3">
            <label for="filtroMarcaModal" class="form-label fw-medium">Marca</label>
            <select id="filtroMarcaModal" class="form-select" onchange="ejecutarBusquedaBackend()">
              <option value="">-- Todas --</option>
              @foreach ($marcas as $marca)
                <option value="{{ $marca->idMarcas }}">{{ $marca->nameMarcas }}</option>
              @endforeach
            </select>
          </div>
        </div>

        <!-- Tabla de Resultados -->
        <div class="table-responsive style-scrollbar" style="max-height: 380px;">
          <table class="table table-hover align-middle" id="tablaBuscarProductos">
            <thead class="table-light sticky-top">
              <tr>
                <th>Código</th>
                <th>Producto</th>
                <th>Categoría</th>
                <th>Marca</th>
                <th>Precio</th>
                <th class="text-center">Acción</th>
              </tr>
            </thead>
            <tbody id="tbodyResultadosBusqueda">
              <tr>
                <td colspan="6" class="text-center py-4 text-muted">Ingrese un término para buscar productos...</td>
              </tr>
            </tbody>
          </table>
        </div>

      </div>

      <!-- Modal Footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
      </div>

    </div>
  </div>
</div>

<script>
  let debounceTimer;

  function ejecutarBusquedaBackend() {
    clearTimeout(debounceTimer);
    debounceTimer = setTimeout(() => {
      realizarPeticion();
    }, 300);
  }

  function realizarPeticion() {
    const q = document.getElementById('buscarProductoInput').value;
    const categoriaId = document.getElementById('filtroCategoriaModal').value;
    const marcaId = document.getElementById('filtroMarcaModal').value;
    const tbody = document.getElementById('tbodyResultadosBusqueda');

    tbody.innerHTML = `
      <tr>
        <td colspan="6" class="text-center py-4 text-muted">
          <div class="spinner-border spinner-border-sm text-primary me-2" role="status"></div>
          Buscando productos...
        </td>
      </tr>
    `;

    const params = new URLSearchParams({
      q: q,
      categoria_id: categoriaId,
      marca_id: marcaId
    });

    fetch(`{{ route('productos.buscar') }}?${params.toString()}`)
      .then(response => response.json())
      .then(productos => {
        tbody.innerHTML = '';

        if (productos.length === 0) {
          tbody.innerHTML = `
          <tr>
            <td colspan="6" class="text-center py-4 text-muted">No se encontraron productos coincidentes.</td>
          </tr>
        `;
          return;
        }

        productos.forEach(producto => {
          const nombreCat = producto.categoria ? producto.categoria.nombreCategorias : 'N/A';
          const nombreMarca = producto.marca ? producto.marca.nameMarcas : 'N/A';
          const precio = parseFloat(producto.precioProductos).toFixed(2);

          let imgTag = `
          <div class="avatar avatar-sm me-2">
            <span class="avatar-initial rounded bg-label-secondary"><i class="bx bx-package"></i></span>
          </div>
        `;
          if (producto.imagenes && producto.imagenes.length > 0) {
            imgTag =
              `<img src="${producto.imagenes[0].url}" class="rounded me-2" width="40" height="40" style="object-fit: cover;">`;
          }

          const tr = document.createElement('tr');
          tr.innerHTML = `
          <td><span class="badge bg-label-dark">${producto.codigoProducto ?? ''}</span></td>
          <td>
            <div class="d-flex align-items-center">
              ${imgTag}
              <div>
                <h6 class="mb-0 text-truncate" style="max-width: 200px;">${producto.nombreProductos}</h6>
              </div>
            </div>
          </td>
          <td>${nombreCat}</td>
          <td>${nombreMarca}</td>
          <td><small class="fw-bold text-success">S/ ${precio}</small></td>
          <td class="text-center">
            <button type="button" class="btn btn-sm btn-info text-white"
              onclick="visualizarProducto(${producto.idProductos})">
              <i class="bx bx-show me-1"></i> Visualizar
            </button>
          </td>
        `;
          tbody.appendChild(tr);
        });
      })
      .catch(error => {
        console.error('Error al buscar productos:', error);
        tbody.innerHTML = `
        <tr>
          <td colspan="6" class="text-center py-4 text-danger">Ocurrió un error al cargar los datos.</td>
        </tr>
      `;
      });
  }

  function visualizarProducto(id) {
    // Aquí puedes redirigir, abrir otro modal, o mostrar un offcanvas con el detalle
    console.log('Visualizar producto id:', id);
    // Ejemplo: window.location.href = `/productos/${id}`;
  }

  function seleccionarProducto(id, nombre, precio) {
    const modalEl = document.getElementById('modalBuscarProducto');

    if (window.jQuery) {
      window.$('#modalBuscarProducto').modal('hide');
    } else {
      try {
        const modal = bootstrap.Modal.getInstance(modalEl);
        if (modal) {
          modal.hide();
        } else {
          modalEl.classList.remove('show');
          modalEl.style.display = 'none';
          document.body.classList.remove('modal-open');
          document.body.style.overflow = '';
          const backdrops = document.querySelectorAll('.modal-backdrop');
          backdrops.forEach(b => b.remove());
        }
      } catch (e) {
        console.error("Error al cerrar modal con bootstrap:", e);
        modalEl.classList.remove('show');
        modalEl.style.display = 'none';
        document.body.classList.remove('modal-open');
        document.body.style.overflow = '';
        const backdrops = document.querySelectorAll('.modal-backdrop');
        backdrops.forEach(b => b.remove());
      }
    }
  }
</script>
