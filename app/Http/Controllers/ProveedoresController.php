<?php

namespace App\Http\Controllers;

use App\Models\Proveedores;
use Illuminate\Http\Request;

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
    public function show(Proveedores $proveedores)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Proveedores $proveedores)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Proveedores $proveedores)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Proveedores $proveedores)
    {
        //
    }
}
