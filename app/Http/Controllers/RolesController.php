<?php

namespace App\Http\Controllers;

use App\Models\Roles;
use Illuminate\Http\Request;

class RolesController extends Controller
{
  public function index()
  {
    $roles = Roles::with('users')->orderBy('idRoles', 'asc')->paginate(9);
    return view('roles.index', compact('roles'));
  }

  public function store(Request $request)
  {
    $request->validate([
      'nameRoles' => 'required|max:100',
    ]);

    Roles::create([
      'nameRoles' => $request->nameRoles
    ]);


    return redirect()->route('roles.index')->with('success', 'Rol creado exitosamente.');
  }

  public function destroy($idRoles)
  {
    try {
      $rol = Roles::findOrFail($idRoles);
      $rol->delete();
      return redirect()->route('roles.index')->with('success', 'Rol eliminado exitosamente.');
    } catch (\Exception $e) {
      return redirect()->route('roles.index')->with('error', 'El rol no se puede eliminar porque tiene usuarios asignados.');
    }
  }
}
