<?php

namespace App\Http\Controllers;

use App\Models\Ventas;
use App\Models\Clientes;
use App\Models\Productos;
use Illuminate\Http\Request;

class VentasController extends Controller
{
    public function index()
    {
        $ventas = Ventas::with(['cliente'])
            ->orderBy('idVentas', 'desc')
            ->get();

        $totalVentas    = $ventas->count();
        $ventasPagadas  = $ventas->where('estadoVentas', 'PAGADO')->count();
        $ventasAnuladas = $ventas->where('estadoVentas', 'ANULADO')->count();
        $totalIngresos  = $ventas->where('estadoVentas', 'PAGADO')->sum('totalVentas');

        $productos = Productos::where('estadoProductos', 'Activo')
            ->orderBy('nombreProductos', 'asc')
            ->get();

        return view('ventas.index', compact(
            'ventas',
            'totalVentas',
            'ventasPagadas',
            'ventasAnuladas',
            'totalIngresos',
            'productos'
        ));
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Ventas $ventas)
    {
        //
    }

    public function update(Request $request, Ventas $ventas)
    {
        //
    }

    public function destroy(Ventas $ventas)
    {
        //
    }
}
