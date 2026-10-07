<?php

namespace App\Http\Controllers;

use App\Models\StockAlmacen;
use Illuminate\Http\Request;
use App\Models\Sucursales;
use App\Models\Productos;

class StockAlmacenController extends Controller
{
    public function index(Request $request)
    {
        $sucursales = Sucursales::where('estadoSucursales', 'Activo')->get();
        $sucursalId = $request->input('sucursal_id');

        $query = Productos::with(['categoria', 'stockAlmacen.sucursal']);

        $productos = $query->get()->map(function ($producto) use ($sucursalId) {
            $stockFiltrado = $producto->stockAlmacen;
            if ($sucursalId) {
                $stockFiltrado = $stockFiltrado->where('sucursalid', (int)$sucursalId);
            }

            $totalStock = $stockFiltrado->sum('stockactualAlmacen');
            $minStock = $stockFiltrado->max('stockminimoAlmacen') ?? 0;

            $producto->stock_calculado = $totalStock;
            $producto->stock_minimo_calculado = $minStock;
            $producto->estado_stock = $totalStock > $minStock ? 'ÓPTIMO' : ($totalStock > 0 ? 'BAJO' : 'AGOTADO');
            $producto->stock_desglose = $stockFiltrado->values();
            return $producto;
        });

        return view('stockAlmacen.index', compact('productos', 'sucursales', 'sucursalId'));
    }

    public function updateMinimos(Request $request)
    {
        $request->validate([
            'producto_id' => 'required|exists:productos,idProductos',
            'minimos'     => 'required|array',
            'minimos.*'   => 'nullable|numeric|min:0'
        ]);

        $productoId = $request->producto_id;

        foreach ($request->minimos as $sucursalId => $minimo) {
            $minimo = $minimo ?? 0;
            
            $stock = StockAlmacen::where('productoid', $productoId)
                        ->where('sucursalid', $sucursalId)
                        ->first();
            
            if ($stock) {
                $stock->stockminimoAlmacen = $minimo;
                
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
                // Si no existe stock para esta sucursal, lo creamos con stock actual en 0
                StockAlmacen::create([
                    'stockactualAlmacen' => 0,
                    'stockminimoAlmacen' => $minimo,
                    'estadoStockAlmacen' => 'Sin stock',
                    'productoid'         => $productoId,
                    'sucursalid'         => $sucursalId
                ]);
            }
        }

        return redirect()->back()->with('success', 'Stocks mínimos actualizados correctamente.');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(StockAlmacen $stockAlmacen)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StockAlmacen $stockAlmacen)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, StockAlmacen $stockAlmacen)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StockAlmacen $stockAlmacen)
    {
        //
    }
}
