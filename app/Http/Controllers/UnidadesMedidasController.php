<?php

namespace App\Http\Controllers;

use App\Models\UnidadesMedidas;
use Illuminate\Http\Request;

class UnidadesMedidasController extends Controller
{
  public function index()
  {
    $unidades_medidas = UnidadesMedidas::orderBy('idUnidadesMedidas', 'asc')->get();
    return view('unidades_medidas.index', compact('unidades_medidas'));
  }

  public function store(Request $request)
  {
    $validated = $request->validate([
        'nameUnidadesMedidas' => 'required|string|max:100|unique:unidades_medidas,nameUnidadesMedidas',
        'simboloUnMedidas'    => 'required|string|max:10|unique:unidades_medidas,simboloUnMedidas',
    ], [
        'nameUnidadesMedidas.required' => 'El nombre es obligatorio.',
        'nameUnidadesMedidas.unique'   => 'Esta unidad de medida ya se encuentra registrada.',
        'nameUnidadesMedidas.max'      => 'El nombre no puede tener más de 100 caracteres.',
        'simboloUnMedidas.required'    => 'El símbolo es obligatorio.',
        'simboloUnMedidas.unique'      => 'Este símbolo ya se encuentra registrado.',
        'simboloUnMedidas.max'         => 'El símbolo no puede tener más de 10 caracteres.',
    ]);

    UnidadesMedidas::create([
        'nameUnidadesMedidas'       => $request->nameUnidadesMedidas,
        'simboloUnMedidas'          => $request->simboloUnMedidas,
        'permiteDecimalesUnMedidas' => $request->has('permiteDecimalesUnMedidas'),
    ]);

    return redirect()->route('unidades-medidas.index')->with('success', 'Unidad de medida creada correctamente.');
  }

  public function update(Request $request, string $idUnidadesMedidas)
  {
    $validated = $request->validate([
        'nameUnidadesMedidas' => 'required|string|max:100|unique:unidades_medidas,nameUnidadesMedidas,' . $idUnidadesMedidas . ',idUnidadesMedidas',
        'simboloUnMedidas'    => 'required|string|max:10|unique:unidades_medidas,simboloUnMedidas,' . $idUnidadesMedidas . ',idUnidadesMedidas',
    ], [
        'nameUnidadesMedidas.required' => 'El nombre es obligatorio.',
        'nameUnidadesMedidas.unique'   => 'Esta unidad de medida ya se encuentra registrada.',
        'nameUnidadesMedidas.max'      => 'El nombre no puede tener más de 100 caracteres.',
        'simboloUnMedidas.required'    => 'El símbolo es obligatorio.',
        'simboloUnMedidas.unique'      => 'Este símbolo ya se encuentra registrado.',
        'simboloUnMedidas.max'         => 'El símbolo no puede tener más de 10 caracteres.',
    ]);

    $unidad = UnidadesMedidas::findOrFail($idUnidadesMedidas);
    $unidad->update([
        'nameUnidadesMedidas'       => $request->nameUnidadesMedidas,
        'simboloUnMedidas'          => $request->simboloUnMedidas,
        'permiteDecimalesUnMedidas' => $request->has('permiteDecimalesUnMedidas'),
    ]);

    return redirect()->route('unidades-medidas.index')->with('success', 'Unidad de medida actualizada correctamente.');
  }

  public function destroy(string $idUnidadesMedidas)
  {
    try {
        $unidad = UnidadesMedidas::findOrFail($idUnidadesMedidas);
        $unidad->delete();
        return redirect()->route('unidades-medidas.index')->with('success', 'Unidad de medida eliminada correctamente.');
    } catch (\Exception $e) {
        return redirect()->route('unidades-medidas.index')->with('error', 'No se puede eliminar la unidad de medida porque está siendo utilizada en el sistema.');
    }
  }
}
