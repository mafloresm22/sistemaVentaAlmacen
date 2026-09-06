<?php

namespace App\Http\Controllers;

use App\Models\DetalleCompras;
use Illuminate\Http\Request;

class DetalleComprasController extends Controller
{
    public function index()
    {
        $detalles = DetalleCompras::with(['compra', 'producto'])
            ->orderBy('idDetalleCompras', 'desc')
            ->paginate(20);

        return view('detalle_compras.index', compact('detalles'));
    }

    public function show($idDetalleCompras)
    {
        $detalle = DetalleCompras::with(['compra.proveedor', 'producto'])
            ->findOrFail($idDetalleCompras);

        return response()->json($detalle);
    }
}
