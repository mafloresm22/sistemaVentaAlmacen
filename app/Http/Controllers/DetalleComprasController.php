<?php

namespace App\Http\Controllers;

use App\Models\DetalleCompras;
use Illuminate\Http\Request;

class DetalleComprasController extends Controller
{
    public function index()
    {
        $detalles = DetalleCompras::with(['compra.proveedor', 'compra.sucursal', 'producto'])
            ->orderBy('idDetalleCompras', 'desc')
            ->get();

        return view('compras.index_detalleCompra', compact('detalles'));
    }

    public function show($idDetalleCompras)
    {
        $detalle = DetalleCompras::with(['compra.proveedor', 'producto'])
            ->findOrFail($idDetalleCompras);

        return response()->json($detalle);
    }
}
