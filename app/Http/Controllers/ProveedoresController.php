<?php

namespace App\Http\Controllers;

use App\Models\Proveedores;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class ProveedoresController extends Controller
{
    public function index()
    {
        $proveedores = Proveedores::with('compras')->paginate(12);
        return view('proveedores.index', compact('proveedores'));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombreProveedores'          => 'required|string|max:255|unique:Proveedores,nombreProveedores',
            'tipodocumentoProveedores'   => 'required|string|in:RUC,DNI,CE,Pasaporte',
            'numerodocumentoProveedores' => 'required|string|max:20|unique:Proveedores,numerodocumentoProveedores',
            'direccionProveedores'       => 'required|string|max:255',
            'telefonoProveedores'        => 'required|string|max:20',
            'correoProveedores'          => 'required|email|max:255|unique:Proveedores,correoProveedores',
            'diasEntregaProveedores'     => 'nullable|integer|min:0',
        ], [
            'nombreProveedores.required'          => 'El nombre o razón social es obligatorio.',
            'nombreProveedores.unique'            => 'Ya existe un proveedor registrado con este nombre o razón social.',
            'tipodocumentoProveedores.required'   => 'Debe seleccionar el tipo de documento.',
            'tipodocumentoProveedores.in'         => 'El tipo de documento seleccionado no es válido.',
            'numerodocumentoProveedores.required' => 'El número de documento es obligatorio.',
            'numerodocumentoProveedores.unique'   => 'Este número de documento ya está registrado.',
            'numerodocumentoProveedores.max'      => 'El número de documento es demasiado largo.',
            'direccionProveedores.required'       => 'La dirección es obligatoria.',
            'telefonoProveedores.required'        => 'El teléfono es obligatorio.',
            'telefonoProveedores.max'             => 'El teléfono no debe exceder los 20 caracteres.',
            'correoProveedores.required'          => 'El correo electrónico es obligatorio.',
            'correoProveedores.email'             => 'Ingrese un correo electrónico válido.',
            'correoProveedores.unique'            => 'Este correo electrónico ya está registrado.',
            'diasEntregaProveedores.integer'      => 'Los días de entrega deben ser un número entero.',
            'diasEntregaProveedores.min'          => 'Los días de entrega no pueden ser negativos.',
        ]);

        try {
            Proveedores::create($validated);
            return redirect()->route('proveedores.index')
                             ->with('success', 'Proveedor registrado correctamente.');
        } catch (\Exception $e) {
            return redirect()->back()
                             ->withInput()
                             ->with('error', 'Ocurrió un error al registrar el proveedor: ' . $e->getMessage());
        }
    }

    public function buscar(Request $request)
    {
        $query = Proveedores::with('compras');

        if ($request->wantsJson() || $request->ajax() || $request->has('q') || $request->has('numeroDocumentoProveedores')) {
            if ($request->filled('q')) {
                $q = $request->q;
                $query->where('nombreProveedores', 'like', "%{$q}%")
                      ->orWhere('numeroDocumentoProveedores', 'like', "%{$q}%");
            }

            if ($request->filled('numeroDocumentoProveedores')) {
                $query->where('numeroDocumentoProveedores', 'like', "%{$request->numeroDocumentoProveedores}%");
            }

            $proveedores = $query->limit(12)->get();
            return response()->json($proveedores);
        }

        if ($request->filled('buscar')) {
            $termino = $request->buscar;
            $query->where('nombreProveedores', 'like', "%{$termino}%")
                  ->orWhere('numeroDocumentoProveedores', 'like', "%{$termino}%")
                  ->orWhere('correoProveedores', 'like', "%{$termino}%");
        }

        $proveedores = $query->paginate(12);
        
        return view('proveedores.index', compact('proveedores'));
    }

    public function update(Request $request, $idProveedores)
    {
        $validated = $request->validate([
            'nombreProveedores'          => 'required|string|max:255|unique:Proveedores,nombreProveedores,' . $idProveedores . ',idProveedores',
            'tipodocumentoProveedores'   => 'required|string|in:RUC,DNI,CE,Pasaporte',
            'numeroDocumentoProveedores' => 'required|string|max:20|unique:Proveedores,numeroDocumentoProveedores,' . $idProveedores . ',idProveedores',
            'direccionProveedores'       => 'required|string|max:255',
            'telefonoProveedores'        => 'required|string|max:20',
            'correoProveedores'          => 'required|email|max:255|unique:Proveedores,correoProveedores,' . $idProveedores . ',idProveedores',
            'diasEntregaProveedores'     => 'nullable|integer|min:0',
        ], [
            'nombreProveedores.required'          => 'El nombre o razón social es obligatorio.',
            'nombreProveedores.unique'            => 'Ya existe otro proveedor registrado con este nombre o razón social.',
            'tipodocumentoProveedores.required'   => 'Debe seleccionar el tipo de documento.',
            'tipodocumentoProveedores.in'         => 'El tipo de documento seleccionado no es válido.',
            'numeroDocumentoProveedores.required' => 'El número de documento es obligatorio.',
            'numeroDocumentoProveedores.unique'   => 'Este número de documento ya pertenece a otro proveedor.',
            'numeroDocumentoProveedores.max'      => 'El número de documento es demasiado largo.',
            'direccionProveedores.required'       => 'La dirección es obligatoria.',
            'telefonoProveedores.required'        => 'El teléfono es obligatorio.',
            'telefonoProveedores.max'             => 'El teléfono no debe exceder los 20 caracteres.',
            'correoProveedores.required'          => 'El correo electrónico es obligatorio.',
            'correoProveedores.email'             => 'Ingrese un correo electrónico válido.',
            'correoProveedores.unique'            => 'Este correo electrónico ya está asignado a otro proveedor.',
            'diasEntregaProveedores.integer'      => 'Los días de entrega deben ser un número entero.',
            'diasEntregaProveedores.min'          => 'Los días de entrega no pueden ser negativos.',
        ]);

        try {
            $proveedor = Proveedores::findOrFail($idProveedores);
            $proveedor->update($validated);

            return redirect()->route('proveedores.index')
                            ->with('success', 'Proveedor actualizado correctamente.');
        } catch (\Exception $e) {
            return redirect()->back()
                            ->withInput()
                            ->with('error', 'Ocurrió un error al actualizar el proveedor: ' . $e->getMessage());
        }
    }

    public function destroy($idProveedores)
    {
        try {
            $proveedores = Proveedores::findOrFail($idProveedores);
            $proveedores->delete();
            return redirect()->route('proveedores.index')->with('success', 'Proveedor eliminado correctamente.');
        } catch (QueryException $e) {
            if ($e->getCode() == 23000) {
            return redirect()->route('proveedores.index')->with('error', 'No se puede eliminar el proveedor "' . $proveedores->nombreProveedores . '" porque tiene productos asignados. Reasigne o elimine los productos primero.');
            }
            return redirect()->route('proveedores.index')->with('error', 'Ocurrió un error inesperado al intentar eliminar el proveedor.');
        }
    }
}
