<?php

namespace App\Http\Controllers;

use App\Models\Compras;
use App\Models\DetalleCompras;
use App\Models\Proveedores;
use App\Models\Sucursales;
use App\Models\Productos;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class ComprasController extends Controller
{
    public function index()
    {
        $compras = Compras::with(['proveedor', 'sucursal', 'user'])
            ->orderBy('idCompras', 'desc')
            ->paginate(15);

        $proveedores = Proveedores::orderBy('nombreProveedores', 'asc')->get();
        $sucursales  = Sucursales::orderBy('idSucursales', 'asc')->get();
        $productos   = Productos::orderBy('nombreProductos', 'asc')->get();

        return view('compras.index', compact('compras', 'proveedores', 'sucursales', 'productos'));
    }

    public function store(Request $request)
    {
        $request->validate([
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
            'numeroFacturaCompras.unique' => 'El número de factura ya está registrado.',
            'productos.required'          => 'Debe agregar al menos un producto.',
        ]);

        DB::beginTransaction();
        try {
            $total = 0;
            foreach ($request->productos as $item) {
                $total += $item['cantidad'] * $item['precio'];
            }

            $compra = Compras::create([
                'numeroFacturaCompras' => $request->numeroFacturaCompras,
                'fechaEmisionCompras'  => $request->fechaEmisionCompras,
                'totalCompras'         => $total,
                'estadoCompras'        => $request->estadoCompras,
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
            }

            DB::commit();
            return redirect()->route('compras.index')->with('success', 'Compra registrada correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('compras.index')->with('error', 'Ocurrió un error al registrar la compra.');
        }
    }

    public function show($idCompras)
    {
        $compra = Compras::with(['proveedor', 'sucursal', 'user', 'detalles.producto'])
            ->findOrFail($idCompras);

        return view('compras.show', compact('compra'));
    }

    public function update(Request $request, $idCompras)
    {
        $request->validate([
            'estadoCompras' => 'required|in:PAGADO,PENDIENTE,ANULADO',
        ]);

        $compra = Compras::findOrFail($idCompras);
        $compra->update([
            'estadoCompras' => $request->estadoCompras,
        ]);

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
