<?php

namespace App\Http\Controllers;

use App\Models\Productos;
use App\Models\Categorias;
use App\Models\Marcas;
use App\Models\UnidadesMedidas;
use Illuminate\Http\Request;

class ProductosController extends Controller
{
    public function index()
    {
        $categorias = Categorias::all();
        $marcas = Marcas::all();
        $unidadesMedida = UnidadesMedidas::all();
        $productos = Productos::with(['categoria', 'marca', 'unidadMedida', 'imagenes', 'stockAlmacen'])
            ->orderBy('nombreProductos')
            ->get();

        return view('productos.index', compact('productos', 'categorias', 'marcas', 'unidadesMedida'));
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
    public function show(Productos $productos)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Productos $productos)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Productos $productos)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Productos $productos)
    {
        //
    }
}
