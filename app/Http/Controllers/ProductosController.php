<?php

namespace App\Http\Controllers;

use App\Models\Productos;
use App\Models\Categorias;
use App\Models\Marcas;
use App\Models\UnidadesMedidas;
use App\Models\Imagenes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\QueryException;

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

    public function buscar(Request $request)
    {
        $query = Productos::with(['categoria', 'marca', 'unidadMedida', 'imagenes']);

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($sub) use ($q) {
                $sub->where('codigoProducto', 'like', "%{$q}%")
                    ->orWhere('nombreProductos', 'like', "%{$q}%");
            });
        }

        if ($request->filled('categoria_id')) {
            $query->where('categoriasid', $request->categoria_id);
        }

        if ($request->filled('marca_id')) {
            $query->where('marcasid', $request->marca_id);
        }

        $productos = $query->limit(20)->get();

        return response()->json($productos);
    }

    public function update(Request $request, $idProductos)
    {
        $producto = Productos::findOrFail($idProductos);
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

        $producto->update($validated);

        if ($request->hasFile('imagen')) {
            $path = $request->file('imagen')->store('productos', 'supabase');

            if ($path !== false) {
                $imagenActual = Imagenes::where('productosid', $producto->idProductos)->first();
                
                if ($imagenActual) {
                    $imagenActual->update([
                        'nombreImagenes' => $request->file('imagen')->getClientOriginalName(),
                        'rutaImagenes'   => $path,
                    ]);
                } else {
                    Imagenes::create([
                        'nombreImagenes' => $request->file('imagen')->getClientOriginalName(),
                        'rutaImagenes'   => $path,
                        'productosid'    => $producto->idProductos,
                    ]);
                }
            } else {
                return redirect()->route('productos.index')
                    ->withErrors(['imagen' => 'No se pudo subir la nueva imagen al servidor.']);
            }
        }

        return redirect()->route('productos.index')->with('success', 'Producto actualizado exitosamente.');
    }

    public function destroy($idProductos)
    {
        try {
            $producto = Productos::findOrFail($idProductos);
            
            $producto->estadoProductos = 'Inactivo';
            $producto->save();

            return redirect()->route('productos.index')->with('success', 'Producto inactivado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->route('productos.index')->with('error', 'Ocurrió un error al intentar inactivar el producto.');
        }
    }
}
