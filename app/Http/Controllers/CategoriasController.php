<?php

namespace App\Http\Controllers;

use App\Models\Categorias;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class CategoriasController extends Controller
{
    public function index()
    {
        $categorias = Categorias::with('user')->orderBy('idCategorias', 'asc')->get();
        return view('categorias.index', compact('categorias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombreCategorias' => 'required|string|max:150',
            'descripcionCategorias' => 'nullable|string',
        ]);

        Categorias::create([
            'nombreCategorias' => $request->nombreCategorias,
            'descripcionCategorias' => $request->descripcionCategorias ?: 'Ninguno',
            'usersid' => auth()->id(),
        ]);

        return redirect()->route('categorias.index')->with('success', 'Categoría creada correctamente.');
    }

    public function update(Request $request, $idCategorias)
    {
        $request->validate([
            'nombreCategorias' => 'required|string|max:150',
            'descripcionCategorias' => 'nullable|string',
        ]);

        $categorias = Categorias::findOrFail($idCategorias);
        $categorias->update([
            'nombreCategorias' => $request->nombreCategorias,
            'descripcionCategorias' => $request->descripcionCategorias ?: 'Ninguno',
        ]);

        return redirect()->route('categorias.index')->with('success', 'Categoría actualizada correctamente.');
    }

    public function destroy($idCategorias)
    {
        $categorias = Categorias::findOrFail($idCategorias);
        try {
            $categorias->delete();
            return redirect()->route('categorias.index')->with('success', 'Categoría eliminada correctamente.');
        } catch (QueryException $e) {
            if ($e->getCode() == 23000) {
                return redirect()->route('categorias.index')->with('error', 'No se puede eliminar la categoría "' . $categorias->nombreCategorias . '" porque tiene productos asignados. Reasigne o elimine los productos primero.');
            }
            return redirect()->route('categorias.index')->with('error', 'Ocurrió un error inesperado al intentar eliminar la categoría.');
        }
    }
}
