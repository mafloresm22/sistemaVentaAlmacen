<?php

namespace App\Http\Controllers;

use App\Models\Marcas;
use Illuminate\Http\Request;

class MarcasController extends Controller
{
  public function index()
  {
    $marcas = Marcas::orderBy('idMarcas', 'asc')->paginate(9);
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
  public function show(Marcas $marcas)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Marcas $marcas)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, Marcas $marcas)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Marcas $marcas)
  {
    //
  }
}
