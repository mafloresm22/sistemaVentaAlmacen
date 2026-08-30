<?php

namespace App\Http\Controllers;

use App\Models\Marcas;
use Illuminate\Http\Request;

class MarcasController extends Controller
{
  public function index()
  {
    $marcas = Marcas::orderBy('idMarcas', 'asc')->paginate(16);
    return view('marcas.index', compact('marcas'));
  }
  
  public function store(Request $request)
  {
    $validated = $request->validate([
        'nameMarcas' => 'required|string|max:150|unique:marcas,nameMarcas',
    ], [
        'nameMarcas.required' => 'El nombre de la marca es obligatorio.',
        'nameMarcas.unique'   => 'Esta marca ya se encuentra registrada.',
        'nameMarcas.max'      => 'El nombre no puede tener más de 150 caracteres.',
    ]);

    Marcas::create([
        'nameMarcas' => $request->nameMarcas,
    ]);

    return redirect()->route('marcas.index')->with('success', 'Marca creada correctamente.');
  }

  public function buscar(Request $request){
    $marcas = Marcas::orderBy('nameMarcas', 'asc')
    ->where('nameMarcas', 'like', '%'.$request->buscar.'%')
    ->paginate(16);
    return view('marcas.index', compact('marcas'));
  }

  public function update(Request $request, string $idMarcas)
  {
    $validated = $request->validate([
        'nameMarcas' => 'required|string|max:150|unique:marcas,nameMarcas,' . $idMarcas . ',idMarcas',
    ], [
        'nameMarcas.required' => 'El nombre de la marca es obligatorio.',
        'nameMarcas.unique'   => 'Esta marca ya se encuentra registrada.',
        'nameMarcas.max'      => 'El nombre no puede tener más de 150 caracteres.',
    ]);

    $marca = Marcas::findOrFail($idMarcas);
    $marca->update([
        'nameMarcas' => $request->nameMarcas,
    ]);

    return redirect()->route('marcas.index')->with('success', 'Marca actualizada correctamente.');
  }

  public function destroy(string $idMarcas)
  {
    try {
        $marcas = Marcas::findOrFail($idMarcas);
        $marcas->delete();
        return redirect()->route('marcas.index')->with('success', 'Marca eliminada correctamente.');
    } catch (\Exception $e) {
        return redirect()->route('marcas.index')->with('error', 'No se puede eliminar la marca porque está siendo utilizada en el sistema.');
    }
  }
}
