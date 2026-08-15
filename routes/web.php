<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\dashboard\Inicio;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CategoriasController;
use App\Http\Controllers\ProductosController;
use App\Http\Controllers\ImagenesController;
use App\Http\Controllers\ClientesController;
use App\Http\Controllers\VentasController;
use App\Http\Controllers\ProveedoresController;
use App\Http\Controllers\SucursalesController;
use App\Http\Controllers\StockAlmacenController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\MarcasController;
use App\Http\Controllers\UnidadesMedidasController;
use App\Http\Controllers\MovimientosInventarioController;
use App\Http\Controllers\DetalleVentasController;



Route::get('/', function () {
  return redirect()->route('login');
});

Route::middleware('guest')->group(function () {
  Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
  Route::post('/login', [LoginController::class, 'login']);
});

// Cierre de sesión (Requiere estar autenticado)
Route::post('/logout', [LoginController::class, 'logout'])
  ->name('logout')
  ->middleware('auth');

Route::middleware(['auth'])->group(function () {

  // Dashboard
  Route::get('/', [Inicio::class, 'index'])->name('inicio');

  // Módulo de Categorias
  Route::get('/categorias', [CategoriasController::class, 'index'])->name('categorias.index');
  Route::post('/categorias', [CategoriasController::class, 'store'])->name('categorias.store');
  Route::put('/categorias/{idCategorias}', [CategoriasController::class, 'update'])->name('categorias.update');
  Route::delete('/categorias/{idCategorias}', [CategoriasController::class, 'destroy'])->name('categorias.destroy');

  // Módulo de Clientes
  Route::get('/clientes', [ClientesController::class, 'index'])->name('clientes.index');
  Route::post('/clientes', [ClientesController::class, 'store'])->name('clientes.store');
  Route::get('/clientes/{idClientes}', [ClientesController::class, 'show'])->name('clientes.show');
  Route::put('/clientes/{idClientes}', [ClientesController::class, 'update'])->name('clientes.update');
  Route::delete('/clientes/{idClientes}', [ClientesController::class, 'destroy'])->name('clientes.destroy');

  // Módulo de Productos
  Route::get('/productos', [ProductosController::class, 'index'])->name('productos.index');
  Route::post('/productos', [ProductosController::class, 'store'])->name('productos.store');
  Route::get('/productos/{idProductos}', [ProductosController::class, 'show'])->name('productos.show');
  Route::put('/productos/{idProductos}', [ProductosController::class, 'update'])->name('productos.update');
  Route::delete('/productos/{idProductos}', [ProductosController::class, 'destroy'])->name('productos.destroy');

  // Modulo de Proveedores
  Route::get('/proveedores', [ProveedoresController::class, 'index'])->name('proveedores.index');
  Route::post('/proveedores', [ProveedoresController::class, 'store'])->name('proveedores.store');
  Route::get('/proveedores/{idProveedores}', [ProveedoresController::class, 'show'])->name('proveedores.show');
  Route::put('/proveedores/{idProveedores}', [ProveedoresController::class, 'update'])->name('proveedores.update');
  Route::delete('/proveedores/{idProveedores}', [ProveedoresController::class, 'destroy'])->name('proveedores.destroy');

  // Módulo de Sucursales
  Route::get('/sucursales', [SucursalesController::class, 'index'])->name('sucursales.index');
  Route::post('/sucursales', [SucursalesController::class, 'store'])->name('sucursales.store');
  Route::get('/sucursales/{idSucursales}', [SucursalesController::class, 'show'])->name('sucursales.show');
  Route::put('/sucursales/{idSucursales}', [SucursalesController::class, 'update'])->name('sucursales.update');
  Route::delete('/sucursales/{idSucursales}', [SucursalesController::class, 'destroy'])->name('sucursales.destroy');

  // Módulo de Stock Almacén
  Route::get('/stock-almacen', [StockAlmacenController::class, 'index'])->name('stock-almacen.index');
  Route::post('/stock-almacen', [StockAlmacenController::class, 'store'])->name('stock-almacen.store');
  Route::get('/stock-almacen/{idStockAlmacen}', [StockAlmacenController::class, 'show'])->name('stock-almacen.show');
  Route::put('/stock-almacen/{idStockAlmacen}', [StockAlmacenController::class, 'update'])->name('stock-almacen.update');
  Route::delete('/stock-almacen/{idStockAlmacen}', [StockAlmacenController::class, 'destroy'])->name('stock-almacen.destroy');

  // Módulo de Movimientos de Inventario
  Route::get('/movimientos-inventario', [MovimientosInventarioController::class, 'index'])->name('movimientos-inventario.index');
  Route::post('/movimientos-inventario', [MovimientosInventarioController::class, 'store'])->name('movimientos-inventario.store');
  Route::get('/movimientos-inventario/{idMovimientosInventario}', [MovimientosInventarioController::class, 'show'])->name('movimientos-inventario.show');
  Route::put('/movimientos-inventario/{idMovimientosInventario}', [MovimientosInventarioController::class, 'update'])->name('movimientos-inventario.update');
  Route::delete('/movimientos-inventario/{idMovimientosInventario}', [MovimientosInventarioController::class, 'destroy'])->name('movimientos-inventario.destroy');

  // Módulo de Ventas
  Route::get('/ventas', [VentasController::class, 'index'])->name('ventas.index');
  Route::post('/ventas', [VentasController::class, 'store'])->name('ventas.store');
  Route::get('/ventas/{idVentas}', [VentasController::class, 'show'])->name('ventas.show');
  Route::put('/ventas/{idVentas}', [VentasController::class, 'update'])->name('ventas.update');
  Route::delete('/ventas/{idVentas}', [VentasController::class, 'destroy'])->name('ventas.destroy');

  // Módulo de Imágenes
  Route::get('/imagenes', [ImagenesController::class, 'index'])->name('imagenes.index');
  Route::post('/imagenes', [ImagenesController::class, 'store'])->name('imagenes.store');
  Route::get('/imagenes/{idImagenes}', [ImagenesController::class, 'show'])->name('imagenes.show');
  Route::put('/imagenes/{idImagenes}', [ImagenesController::class, 'update'])->name('imagenes.update');
  Route::delete('/imagenes/{idImagenes}', [ImagenesController::class, 'destroy'])->name('imagenes.destroy');

  // Módulo de Roles
  Route::get('/roles', [RolesController::class, 'index'])->name('roles.index');
  Route::post('/roles', [RolesController::class, 'store'])->name('roles.store');
  Route::put('/roles/{idRoles}', [RolesController::class, 'update'])->name('roles.update');
  Route::delete('/roles/{idRoles}', [RolesController::class, 'destroy'])->name('roles.destroy');

  // Módulo de Roles
  Route::get('/roles', [RolesController::class, 'index'])->name('roles.index');
  Route::post('/roles', [RolesController::class, 'store'])->name('roles.store');
  Route::put('/roles/{idRoles}', [RolesController::class, 'update'])->name('roles.update');
  Route::delete('/roles/{idRoles}', [RolesController::class, 'destroy'])->name('roles.destroy');

  // Módulo de Marcas
  Route::get('/marcas', [MarcasController::class, 'index'])->name('marcas.index');
  Route::post('/marcas', [MarcasController::class, 'store'])->name('marcas.store');
  Route::put('/marcas/{idMarcas}', [MarcasController::class, 'update'])->name('marcas.update');
  Route::delete('/marcas/{idMarcas}', [MarcasController::class, 'destroy'])->name('marcas.destroy');

  // Módulo de Unidades de Medida
  Route::get('/unidades-medidas', [UnidadesMedidasController::class, 'index'])->name('unidades-medidas.index');
  Route::post('/unidades-medidas', [UnidadesMedidasController::class, 'store'])->name('unidades-medidas.store');
  Route::put('/unidades-medidas/{idUnidadesMedidas}', [UnidadesMedidasController::class, 'update'])->name('unidades-medidas.update');
  Route::delete('/unidades-medidas/{idUnidadesMedidas}', [UnidadesMedidasController::class, 'destroy'])->name('unidades-medidas.destroy');

  // Módulo de Detalle Ventas
  Route::get('/detalle-ventas', [DetalleVentasController::class, 'index'])->name('detalle-ventas.index');
  Route::get('/detalle-ventas/{idDetalleVentas}', [DetalleVentasController::class, 'show'])->name('detalle-ventas.show');
});