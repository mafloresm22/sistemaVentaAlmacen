CREATE TABLE IF NOT EXISTS "Users" (
	"id" serial,
	"name" varchar(100) NOT NULL UNIQUE,
	"password" varchar(255) NOT NULL,
  "rolesid" integer NOT NULL,
	PRIMARY KEY ("id")
);
CREATE TABLE IF NOT EXISTS "Roles" (
	"idRoles" serial,
	"nameRoles" varchar(100) NOT NULL UNIQUE,
	PRIMARY KEY ("idRoles")
);
CREATE TABLE IF NOT EXISTS "Marcas" (
	"idMarcas" serial,
	"nameMarcas" varchar(100) NOT NULL UNIQUE,
	PRIMARY KEY ("idMarcas")
);
CREATE TABLE IF NOT EXISTS "UnidadesMedidas" (
  "idUnidadesMedidas" serial,
  "nameUnidadesMedidas" varchar(100) NOT NULL UNIQUE,
  "simboloUnMedidas" varchar(10) NOT NULL UNIQUE,
  "permiteDecimalesUnMedidas" boolean NOT NULL DEFAULT false,
  PRIMARY KEY ("idUnidadesMedidas")
);
CREATE TABLE IF NOT EXISTS "Categorias" (
	"idCategorias" serial,
	"nombreCategorias" varchar(150) NOT NULL,
	"descripcionCategorias" text NOT NULL,
	"usersid" integer NULL,
	PRIMARY KEY ("idCategorias")
);
CREATE TABLE IF NOT EXISTS "Productos" (
	"idProductos" serial,
	"codigoProducto" varchar(64) NULL UNIQUE,
	"nombreProductos" varchar(150) NOT NULL,
	"descripcionProductos" text,
	"precioProductos" numeric(10,2) NOT NULL,
	"categoriasid" integer NOT NULL,
  "marcasid" integer NOT NULL,
  "unidadesmedidasid" integer NOT NULL,
	"estadoProductos" varchar(50) NOT NULL,
	PRIMARY KEY ("idProductos")
);
CREATE TABLE IF NOT EXISTS "Imagenes" (
	"idimagenes" serial,
	"nombreImagenes" varchar(255) NOT NULL,
	"rutaImagenes" varchar(255) NOT NULL,
	"productosid" integer NOT NULL,
	PRIMARY KEY ("idimagenes")
);
CREATE TABLE IF NOT EXISTS "Clientes" (
	"idClientes" serial,
	"nombreClientes" varchar(120) NOT NULL,
	"apellidosClientes" varchar(125) NOT NULL,
	"tipodocumentoClientes" varchar(80) NOT NULL,
	"numerodocumentoClientes" varchar(20) NOT NULL UNIQUE,
	"correoClientes" varchar(255),
	"celularClientes" varchar(255) NOT NULL UNIQUE,
	"usersid" integer NULL,
	PRIMARY KEY ("idClientes")
);
CREATE TABLE IF NOT EXISTS "Ventas" (
	"idVentas" serial,
	"metodoVentas" varchar(50) NOT NULL,
	"codigoVentas" varchar(50) NOT NULL,
	"totalVentas" numeric(10,2) NOT NULL,
	"fechaCompraVentas" timestamp without time zone NOT NULL,
	"clientesid" integer NOT NULL,
	"estadoVentas" varchar(255) NOT NULL,
	PRIMARY KEY ("idVentas")
);
CREATE TABLE IF NOT EXISTS "detalleVentas" (
	"idDetalleVentas" serial,
	"cantidadDetalleVentas" numeric(10,2) NOT NULL,
	"precioUnitarioDetalleVentas" numeric(10,2) NOT NULL,
	"subtotalDetalleVentas" numeric(10,2) NOT NULL,
	"ventasid" integer NOT NULL,
	"productosid" integer NOT NULL,
	"descuentoDetalleVentas" numeric(10,2) NOT NULL,
	PRIMARY KEY ("idDetalleVentas")
);
CREATE TABLE IF NOT EXISTS "Proveedores" (
	"idProveedores" serial,
	"nombreProveedores" varchar(255) NOT NULL,
	"tipodocumentoProveedores" varchar(255) NOT NULL,
	"numerodocumentoProveedores" varchar(255) NOT NULL,
	"direccionProveedores" varchar(255) NOT NULL,
	"telefonoProveedores" varchar(255) NOT NULL,
	"correoProveedores" varchar(255) NOT NULL,
	"diasEntregaProveedores" integer NULL,
	"calificacionProveedores" numeric(2,1) NULL CHECK ("calificacionProveedores" >= 1.0 AND "calificacionProveedores" <= 5.0),
	PRIMARY KEY ("idProveedores")
);
CREATE TABLE IF NOT EXISTS "Compras" (
	"idCompras" serial,
	"numeroFacturaCompras" varchar(50) NOT NULL,
	"fechaEmisionCompras" timestamp without time zone NOT NULL,
	"totalCompras" numeric(10,2) NOT NULL,
	"estadoCompras" varchar(50) NOT NULL CHECK ("estadoCompras" IN ('PAGADO', 'PENDIENTE', 'ANULADO')),
	"proveedoresid" integer NOT NULL,
	"sucursalesid" integer NOT NULL,
	"usersid" integer NULL,
	PRIMARY KEY ("idCompras")
);
CREATE TABLE IF NOT EXISTS "detalleCompras" (
	"idDetalleCompras" serial,
	"cantidadDetalleCompras" numeric(10,2) NOT NULL,
	"precioUnitarioDetalleCompras" numeric(10,2) NOT NULL,
	"subtotalDetalleCompras" numeric(10,2) NOT NULL,
	"comprasid" integer NOT NULL,
	"productosid" integer NOT NULL,
	PRIMARY KEY ("idDetalleCompras")
);
CREATE TABLE IF NOT EXISTS "Sucursales" (
	"idSucursales" serial,
	"nombreSucursales" varchar(255) NOT NULL,
	"ubicacionSucursales" varchar(255) NOT NULL,
	"estadoSucursales" varchar(255) NOT NULL,
	PRIMARY KEY ("idSucursales")
);
CREATE TABLE IF NOT EXISTS "StockAlmacen" (
	"idStockAlmacen" serial,
	"stockactualStockAlmacen" numeric(10,2) NOT NULL,
	"productosid" integer NOT NULL,
	"sucursalid" integer NOT NULL,
	"estadoStockAlmacen" varchar(255) NOT NULL,
	"stockminimoAlmacen" numeric(10,2) NOT NULL,
	PRIMARY KEY ("idStockAlmacen")
);
CREATE TABLE IF NOT EXISTS "MovimientosInventario" (
	"idMovimientosInventario" serial,
	"tipoMovimientosInventario" varchar(50) NOT NULL CHECK ("tipoMovimientosInventario" IN ('ENTRADA_COMPRA', 'DEVOLUCION_CLIENTE', 'SALIDA_VENTA', 'DEVOLUCION_PROVEEDOR', 'MERMA_ROTURA', 'AJUSTE_INVENTARIO', 'TRANSFERENCIA_ENTRADA', 'TRANSFERENCIA_SALIDA')),
	"cantidadMovimientosInventario" numeric(10,2) NOT NULL,
	"costoUnitarioMovimiento" numeric(10,2) NULL,
	"fechaMovimientosInventario" timestamp without time zone NOT NULL,
	"observacionMovimientosInventario" text,
	"productoid" integer NOT NULL,
	"sucursalid" integer NOT NULL,
	"usersid" integer NULL,
	"proveedoresid" integer NULL,
	"comprasid" integer NULL,
	"ventasid" integer NULL,
	PRIMARY KEY ("idMovimientosInventario")
);
ALTER TABLE "StockAlmacen" ADD CONSTRAINT "uq_stock_producto_sucursal" UNIQUE ("productosid", "sucursalid");
ALTER TABLE "Categorias" ADD CONSTRAINT "Categorias_fk3" FOREIGN KEY ("usersid") REFERENCES "Users"("id") ON DELETE SET NULL;
ALTER TABLE "Productos" ADD CONSTRAINT "Productos_fk4" FOREIGN KEY ("categoriasid") REFERENCES "Categorias"("idCategorias") ON DELETE RESTRICT;
ALTER TABLE "Imagenes" ADD CONSTRAINT "Imagenes_fk3" FOREIGN KEY ("productosid") REFERENCES "Productos"("idProductos") ON DELETE CASCADE;
ALTER TABLE "Clientes" ADD CONSTRAINT "Clientes_fk7" FOREIGN KEY ("usersid") REFERENCES "Users"("id") ON DELETE SET NULL;
ALTER TABLE "Ventas" ADD CONSTRAINT "Ventas_fk3" FOREIGN KEY ("clientesid") REFERENCES "Clientes"("idClientes") ON DELETE RESTRICT;
ALTER TABLE "detalleVentas" ADD CONSTRAINT "detalleVentas_fk4" FOREIGN KEY ("ventasid") REFERENCES "Ventas"("idVentas") ON DELETE CASCADE;
ALTER TABLE "detalleVentas" ADD CONSTRAINT "detalleVentas_fk5" FOREIGN KEY ("productosid") REFERENCES "Productos"("idProductos") ON DELETE RESTRICT;
ALTER TABLE "StockAlmacen" ADD CONSTRAINT "StockAlmacen_fk2" FOREIGN KEY ("productosid") REFERENCES "Productos"("idProductos") ON DELETE RESTRICT;
ALTER TABLE "StockAlmacen" ADD CONSTRAINT "StockAlmacen_fk3" FOREIGN KEY ("sucursalid") REFERENCES "Sucursales"("idSucursales") ON DELETE RESTRICT;
ALTER TABLE "MovimientosInventario" ADD CONSTRAINT "MovimientosInventario_fk5" FOREIGN KEY ("productoid") REFERENCES "Productos"("idProductos") ON DELETE RESTRICT;
ALTER TABLE "MovimientosInventario" ADD CONSTRAINT "MovimientosInventario_fk6" FOREIGN KEY ("sucursalid") REFERENCES "Sucursales"("idSucursales") ON DELETE RESTRICT;
ALTER TABLE "MovimientosInventario" ADD CONSTRAINT "MovimientosInventario_fk7" FOREIGN KEY ("usersid") REFERENCES "Users"("id") ON DELETE SET NULL;
ALTER TABLE "Productos" ADD CONSTRAINT "Productos_fk5" FOREIGN KEY ("marcasid") REFERENCES "Marcas"("idMarcas") ON DELETE SET NULL;
ALTER TABLE "Productos" ADD CONSTRAINT "Productos_fk6" FOREIGN KEY ("unidadesmedidasid") REFERENCES "UnidadesMedidas"("idUnidadesMedidas") ON DELETE SET NULL;
ALTER TABLE "MovimientosInventario" ADD CONSTRAINT "MovimientosInventario_fk8" FOREIGN KEY ("proveedoresid") REFERENCES "Proveedores"("idProveedores") ON DELETE SET NULL;
ALTER TABLE "MovimientosInventario" ADD CONSTRAINT "MovimientosInventario_fk_compras" FOREIGN KEY ("comprasid") REFERENCES "Compras"("idCompras") ON DELETE SET NULL;
ALTER TABLE "MovimientosInventario" ADD CONSTRAINT "MovimientosInventario_fk_ventas" FOREIGN KEY ("ventasid") REFERENCES "Ventas"("idVentas") ON DELETE SET NULL;
ALTER TABLE "Users" ADD CONSTRAINT "Users_fk_roles" FOREIGN KEY ("rolesid") REFERENCES "Roles"("idRoles") ON DELETE SET NULL;
ALTER TABLE "Compras" ADD CONSTRAINT "Compras_fk_proveedores" FOREIGN KEY ("proveedoresid") REFERENCES "Proveedores"("idProveedores") ON DELETE RESTRICT;
ALTER TABLE "Compras" ADD CONSTRAINT "Compras_fk_sucursales" FOREIGN KEY ("sucursalesid") REFERENCES "Sucursales"("idSucursales") ON DELETE RESTRICT;
ALTER TABLE "Compras" ADD CONSTRAINT "Compras_fk_users" FOREIGN KEY ("usersid") REFERENCES "Users"("id") ON DELETE SET NULL;
ALTER TABLE "detalleCompras" ADD CONSTRAINT "detalleCompras_fk_compras" FOREIGN KEY ("comprasid") REFERENCES "Compras"("idCompras") ON DELETE CASCADE;
ALTER TABLE "detalleCompras" ADD CONSTRAINT "detalleCompras_fk_productos" FOREIGN KEY ("productosid") REFERENCES "Productos"("idProductos") ON DELETE RESTRICT;