<?php

namespace App\Http\Controllers;

use App\Models\Productos;
use App\Models\Categorias;
use App\Models\Marcas;
use App\Models\UnidadesMedidas;
use App\Models\Imagenes;
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

    public function store(Request $request)
    {
        $validated = $request->validate([
            'codigoProducto' => 'nullable|string|max:64',
            'nombreProductos' => 'required|string|max:150',
            'precioProductos' => 'required|numeric|min:0',
            'categoriasid' => 'required|integer',
            'marcasid' => 'required|integer',
            'unidadesmedidasid' => 'nullable|integer',
            'descripcionProductos' => 'nullable|string',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $producto = Productos::create($validated);

        if ($request->hasFile('imagen')) {
            $path = $request->file('imagen')->store('productos', 'supabase');

            if ($path === false) {
                $producto->delete();
                return redirect()->route('productos.index')
                    ->withErrors(['imagen' => 'No se pudo subir la imagen al servidor. Intente nuevamente.']);
            }

            Imagenes::create([
                'nombreImagenes' => $request->file('imagen')->getClientOriginalName(),
                'rutaImagenes'   => $path,
                'productosid'    => $producto->idProductos,
            ]);
        }

        return redirect()->route('productos.index')->with('success', 'Producto creado exitosamente.');
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
