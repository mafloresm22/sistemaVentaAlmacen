CREATE TABLE IF NOT EXISTS "Users" (
	"id" serial NOT NULL UNIQUE,
	"name" varchar(100) NOT NULL UNIQUE,
	"password" varchar(255) NOT NULL UNIQUE,
  "rolesid" integer NOT NULL,
	PRIMARY KEY ("id")
);
CREATE TABLE IF NOT EXISTS "Roles" (
	"idRoles" serial NOT NULL UNIQUE,
	"nameRoles" varchar(100) NOT NULL UNIQUE,
	PRIMARY KEY ("idRoles")
);
CREATE TABLE IF NOT EXISTS "Marcas" (
	"idMarcas" serial NOT NULL UNIQUE,
	"nameMarcas" varchar(100) NOT NULL UNIQUE,
	PRIMARY KEY ("idMarcas")
);
CREATE TABLE IF NOT EXISTS "UnidadesMedidas" (
	"idUnidadesMedidas" serial NOT NULL UNIQUE,
	"nameUnidadesMedidas" varchar(100) NOT NULL UNIQUE,
	PRIMARY KEY ("idUnidadesMedidas")
);
CREATE TABLE IF NOT EXISTS "Categorias" (
	"idCategorias" serial NOT NULL UNIQUE,
	"nombreCategorias" varchar(150) NOT NULL,
	"descripcionCategorias" text NOT NULL,
	"usersid" integer NOT NULL,
	PRIMARY KEY ("idCategorias")
);
CREATE TABLE IF NOT EXISTS "Productos" (
	"idProductos" serial NOT NULL UNIQUE,
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
	"idimagenes" serial NOT NULL UNIQUE,
	"nombreImagenes" varchar(255) NOT NULL,
	"rutaImagenes" varchar(255) NOT NULL,
	"productosid" integer NOT NULL,
	PRIMARY KEY ("idimagenes")
);
CREATE TABLE IF NOT EXISTS "Clientes" (
	"idClientes" serial NOT NULL UNIQUE,
	"nombreClientes" varchar(120) NOT NULL,
	"apellidosClientes" varchar(125) NOT NULL,
	"tipodocumentoClientes" varchar(80) NOT NULL,
	"numerodocumentoClientes" varchar(20) NOT NULL UNIQUE,
	"correoClientes" varchar(255),
	"celularClientes" varchar(255) NOT NULL UNIQUE,
	"usersid" integer NOT NULL,
	PRIMARY KEY ("idClientes")
);
CREATE TABLE IF NOT EXISTS "Ventas" (
	"idVentas" serial NOT NULL UNIQUE,
	"totalVentas" numeric(10,2) NOT NULL,
	"fechaCompraVentas" timestamp without time zone NOT NULL,
	"clientesid" integer NOT NULL,
	"estadoVentas" varchar(255) NOT NULL,
	"codigoVentas" integer NOT NULL,
	PRIMARY KEY ("idVentas")
);
CREATE TABLE IF NOT EXISTS "detalleVentas" (
	"idDetalleVentas" serial NOT NULL UNIQUE,
	"cantidadDetalleVentas" integer NOT NULL,
	"precioUnitarioDetalleVentas" numeric(10,0) NOT NULL,
	"subtotalDetalleVentas" numeric(10,0) NOT NULL,
	"ventasid" integer NOT NULL,
	"productosid" integer NOT NULL,
	"descuentoDetalleVentas" numeric(10,0) NOT NULL,
	PRIMARY KEY ("idDetalleVentas")
);
CREATE TABLE IF NOT EXISTS "Proveedores" (
	"idProveedores" serial NOT NULL UNIQUE,
	"nombreProveedores" varchar(255) NOT NULL,
	"tipodocumentoProveedores" varchar(255) NOT NULL,
	"numerodocumentoProveedores" varchar(255) NOT NULL,
	"direccionProveedores" varchar(255) NOT NULL,
	"telefonoProveedores" varchar(255) NOT NULL,
	"correoProveedores" varchar(255) NOT NULL,
	PRIMARY KEY ("idProveedores")
);
CREATE TABLE IF NOT EXISTS "Sucursales" (
	"idSucursales" serial NOT NULL UNIQUE,
	"nombreSucursales" varchar(255) NOT NULL,
	"ubicacionSucursales" varchar(255) NOT NULL,
	"estadoSucursales" varchar(255) NOT NULL,
	PRIMARY KEY ("idSucursales")
);
CREATE TABLE IF NOT EXISTS "StockAlmacen" (
	"idStockAlmacen" serial NOT NULL UNIQUE,
	"stockactualStockAlmacen" integer NOT NULL,
	"productosid" integer NOT NULL,
	"sucursalesid" integer NOT NULL,
	"estadoStockAlmacen" varchar(255) NOT NULL,
	"stockminimoAlmacen" integer NOT NULL,
	PRIMARY KEY ("idStockAlmacen")
);
CREATE TABLE IF NOT EXISTS "MovimientosInventario" (
	"idMovimientosInventario" serial NOT NULL UNIQUE,
	"tipoMovimientosInventario" varchar(255) NOT NULL,
	"cantidadMovimientosInventario" integer NOT NULL,
	"fechaMovimientosInventario" date NOT NULL,
	"observacionMovimientosInventario" text,
	"productosid" integer NOT NULL,
	"sucursalesid" integer NOT NULL,
	"userid" integer NOT NULL,
	"proveedoresid" integer NOT NULL,
	PRIMARY KEY ("idMovimientosInventario")
);
ALTER TABLE "Categorias" ADD CONSTRAINT "Categorias_fk3" FOREIGN KEY ("usersid") REFERENCES "Users"("id");
ALTER TABLE "Productos" ADD CONSTRAINT "Productos_fk4" FOREIGN KEY ("categoriasid") REFERENCES "Categorias"("idCategorias");
ALTER TABLE "Imagenes" ADD CONSTRAINT "Imagenes_fk3" FOREIGN KEY ("productosid") REFERENCES "Productos"("idProductos");
ALTER TABLE "Clientes" ADD CONSTRAINT "Clientes_fk7" FOREIGN KEY ("usersid") REFERENCES "Users"("id");
ALTER TABLE "Ventas" ADD CONSTRAINT "Ventas_fk3" FOREIGN KEY ("clientesid") REFERENCES "Clientes"("idClientes");
ALTER TABLE "detalleVentas" ADD CONSTRAINT "detalleVentas_fk4" FOREIGN KEY ("ventasid") REFERENCES "Ventas"("idVentas");
ALTER TABLE "detalleVentas" ADD CONSTRAINT "detalleVentas_fk5" FOREIGN KEY ("productosid") REFERENCES "Productos"("idProductos");
ALTER TABLE "StockAlmacen" ADD CONSTRAINT "StockAlmacen_fk2" FOREIGN KEY ("productosid") REFERENCES "Productos"("idProductos");
ALTER TABLE "StockAlmacen" ADD CONSTRAINT "StockAlmacen_fk3" FOREIGN KEY ("sucursalesid") REFERENCES "Sucursales"("idSucursales");
ALTER TABLE "MovimientosInventario" ADD CONSTRAINT "MovimientosInventario_fk5" FOREIGN KEY ("productosid") REFERENCES "Productos"("idProductos");
ALTER TABLE "MovimientosInventario" ADD CONSTRAINT "MovimientosInventario_fk6" FOREIGN KEY ("sucursalesid") REFERENCES "Sucursales"("idSucursales");
ALTER TABLE "MovimientosInventario" ADD CONSTRAINT "MovimientosInventario_fk7" FOREIGN KEY ("userid") REFERENCES "Users"("id");
ALTER TABLE "MovimientosInventario" ADD CONSTRAINT "MovimientosInventario_fk8" FOREIGN KEY ("proveedoresid") REFERENCES "Proveedores"("idProveedores");