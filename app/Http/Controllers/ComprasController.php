<?php

namespace App\Http\Controllers;

use App\Models\Compras;
use App\Models\DetalleCompras;
use App\Models\Proveedores;
use App\Models\Sucursales;
use App\Models\Productos;
use App\Models\StockAlmacen;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class ComprasController extends Controller
{
    public function index()
    {
        $compras = Compras::with(['proveedor', 'sucursal', 'user'])
            ->orderBy('idCompras', 'desc')
            ->get();

        $proveedores = Proveedores::orderBy('nombreProveedores', 'asc')->get();
        $sucursales  = Sucursales::where('estadoSucursales', 'Activo')->orderBy('idSucursales', 'asc')->get();
        $productos   = Productos::orderBy('nombreProductos', 'asc')->get();

        return view('compras.index', compact('compras', 'proveedores', 'sucursales', 'productos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tipoComprobanteCompras' => 'nullable|string|max:50',
            'numeroFacturaCompras'  => 'required|string|max:50|unique:compras,numeroFacturaCompras',
            'fechaEmisionCompras'   => 'required|date',
            'estadoCompras'         => 'required|in:PAGADO,PENDIENTE,ANULADO',
            'proveedoresid'         => 'required|exists:proveedores,idProveedores',
            'sucursalesid'          => 'required|exists:sucursales,idSucursales',
            'productos'             => 'required|array|min:1',
            'productos.*.id'        => 'required|exists:productos,idProductos',
            'productos.*.cantidad'  => 'required|numeric|min:0.01',
            'productos.*.precio'    => 'required|numeric|min:0',
        ], [
            'numeroFacturaCompras.unique' => 'El número de comprobante/factura ya está registrado.',
            'productos.required'          => 'Debe agregar al menos un producto.',
        ]);

        DB::beginTransaction();
        try {
            $total = 0;
            foreach ($request->productos as $item) {
                $total += $item['cantidad'] * $item['precio'];
            }

            $compra = Compras::create([
                'tipoComprobanteCompras' => $request->tipoComprobanteCompras ?? 'Factura',
                'numeroFacturaCompras' => $request->numeroFacturaCompras,
                'fechaEmisionCompras'  => $request->fechaEmisionCompras,
                'totalCompras'         => $total,
                'estadoCompras'        => $request->estadoCompras ?? 'PENDIENTE',
                'proveedoresid'        => $request->proveedoresid,
                'sucursalesid'         => $request->sucursalesid,
                'usersid'              => auth()->id(),
            ]);

            foreach ($request->productos as $item) {
                $subtotal = $item['cantidad'] * $item['precio'];
                DetalleCompras::create([
                    'cantidadDetalleCompras'       => $item['cantidad'],
                    'precioUnitarioDetalleCompras' => $item['precio'],
                    'subtotalDetalleCompras'        => $subtotal,
                    'comprasid'                     => $compra->idCompras,
                    'productosid'                   => $item['id'],
                ]);

                // Actualizar o crear stock en el almacén solo si el estado es PAGADO
                if (($request->estadoCompras ?? 'PENDIENTE') === 'PAGADO') {
                    $stock = StockAlmacen::where('productoid', $item['id'])
                        ->where('sucursalid', $request->sucursalesid)
                        ->first();

                    if ($stock) {
                        $stock->stockactualAlmacen += $item['cantidad'];
                        
                        // Actualizar estado del stock
                        if ($stock->stockactualAlmacen <= 0) {
                            $stock->estadoStockAlmacen = 'Sin stock';
                        } elseif ($stock->stockactualAlmacen <= $stock->stockminimoAlmacen) {
                            $stock->estadoStockAlmacen = 'Bajo stock';
                        } else {
                            $stock->estadoStockAlmacen = 'En stock';
                        }
                        $stock->save();
                    } else {
                        StockAlmacen::create([
                            'stockactualAlmacen' => $item['cantidad'],
                            'stockminimoAlmacen' => 0,
                            'estadoStockAlmacen' => 'En stock',
                            'productoid'         => $item['id'],
                            'sucursalid'         => $request->sucursalesid,
                        ]);
                    }
                }
            }

            DB::commit();
            return redirect()->route('compras.index')->with('success', 'Compra registrada correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('compras.index')->with('error', 'Ocurrió un error al registrar la compra: ' . $e->getMessage());
        }
    }

    public function show($idCompras)
    {
        $compra = Compras::with(['proveedor', 'sucursal', 'user', 'detalles.producto'])
            ->findOrFail($idCompras);

        return view('compras.index_detalleCompra', compact('compra'));
    }

    public function update(Request $request, $idCompras)
    {
        $request->validate([
            'estadoCompras' => 'required|in:PAGADO,PENDIENTE,ANULADO',
        ]);

        $compra = Compras::with('detalles')->findOrFail($idCompras);
        $oldState = $compra->estadoCompras;
        $newState = $request->estadoCompras;
        
        $compra->update([
            'estadoCompras' => $newState,
        ]);

        // Si cambia a PAGADO y no estaba pagado antes, sumamos stock
        if ($newState === 'PAGADO' && $oldState !== 'PAGADO') {
            foreach ($compra->detalles as $detalle) {
                $stock = StockAlmacen::where('productoid', $detalle->productosid)
                    ->where('sucursalid', $compra->sucursalesid)
                    ->first();

                if ($stock) {
                    $stock->stockactualAlmacen += $detalle->cantidadDetalleCompras;
                } else {
                    $stock = StockAlmacen::create([
                        'stockactualAlmacen' => $detalle->cantidadDetalleCompras,
                        'stockminimoAlmacen' => 0,
                        'estadoStockAlmacen' => 'En stock',
                        'productoid'         => $detalle->productosid,
                        'sucursalid'         => $compra->sucursalesid,
                    ]);
                }
                
                // Actualizar estado del stock
                if ($stock->stockactualAlmacen <= 0) {
                    $stock->estadoStockAlmacen = 'Sin stock';
                } elseif ($stock->stockactualAlmacen <= $stock->stockminimoAlmacen) {
                    $stock->estadoStockAlmacen = 'Bajo stock';
                } else {
                    $stock->estadoStockAlmacen = 'En stock';
                }
                $stock->save();
            }
        }
        
        // Si cambia a ANULADO y estaba PAGADO (es decir, ya se había sumado el stock), restamos stock
        if ($newState === 'ANULADO' && $oldState === 'PAGADO') {
            foreach ($compra->detalles as $detalle) {
                $stock = \App\Models\StockAlmacen::where('productoid', $detalle->productosid)
                    ->where('sucursalid', $compra->sucursalesid)
                    ->first();

                if ($stock) {
                    $stock->stockactualAlmacen -= $detalle->cantidadDetalleCompras;
                    if ($stock->stockactualAlmacen < 0) {
                        $stock->stockactualAlmacen = 0;
                    }
                    
                    // Actualizar estado del stock
                    if ($stock->stockactualAlmacen <= 0) {
                        $stock->estadoStockAlmacen = 'Sin stock';
                    } elseif ($stock->stockactualAlmacen <= $stock->stockminimoAlmacen) {
                        $stock->estadoStockAlmacen = 'Bajo stock';
                    } else {
                        $stock->estadoStockAlmacen = 'En stock';
                    }
                    $stock->save();
                }
            }
        }

        return redirect()->route('compras.index')->with('success', 'Estado de la compra actualizado correctamente.');
    }

    public function destroy($idCompras)
    {
        try {
            $compra = Compras::findOrFail($idCompras);
            $compra->detalles()->delete();
            $compra->delete();
            return redirect()->route('compras.index')->with('success', 'Compra eliminada correctamente.');
        } catch (QueryException $e) {
            return redirect()->route('compras.index')->with('error', 'Ocurrió un error al eliminar la compra.');
        }
    }
}
