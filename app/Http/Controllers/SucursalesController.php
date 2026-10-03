<?php

namespace App\Http\Controllers;

use App\Models\Sucursales;
use Illuminate\Http\Request;

class SucursalesController extends Controller
{
    public function index()
    {
        $sucursales = Sucursales::where('estadoSucursales', 'Activo')->orderBy('idSucursales', 'asc')->get();
        return view('sucursales.index', compact('sucursales'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombreSucursales' => 'required|string|max:150|unique:Sucursales,nombreSucursales',
            'ubicacionSucursales' => 'required|string|max:150',
        ]);

        Sucursales::create([
            'nombreSucursales' => $request->nombreSucursales,
            'ubicacionSucursales' => $request->ubicacionSucursales,
            'estadoSucursales' => 'Activo',
        ]);

        return redirect()->route('sucursales.index')->with('success', 'Sucursal creada correctamente.');
    }

    public function update(Request $request, $idSucursales)
    {
        $request->validate([
            'nombreSucursales' => 'required|string|max:150|unique:Sucursales,nombreSucursales,' . $idSucursales . ',idSucursales',
            'ubicacionSucursales' => 'required|string|max:150',
        ]);

        $sucursal = Sucursales::findOrFail($idSucursales);

        $sucursal->update([
            'nombreSucursales' => $request->nombreSucursales,
            'ubicacionSucursales' => $request->ubicacionSucursales,
        ]);

        return redirect()->route('sucursales.index')->with('success', 'Sucursal actualizada correctamente.');
    }

    public function destroy($idSucursales)
    {
        try {
            $sucursales = Sucursales::findOrFail($idSucursales);

            $sucursales->estadoSucursales = 'Inactivo';
            $sucursales->save();

            return redirect()->route('sucursales.index')->with('success', 'Sucursal eliminada correctamente.');
        } catch (\Exception $e) {
            return redirect()->route('sucursales.index')->with('error', 'Ocurrió un error al intentar eliminar la sucursal.');
        }
    }
}
