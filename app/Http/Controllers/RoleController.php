<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;

class RoleController extends Controller
{
    public function index()
    {
        $permisos = Permission::all();
        $roles = Role::all();

        return view('usuarios.roles', compact('permisos', 'roles'));
    }

    public function store(Request $request)
    {
        try {
                 $role = Role::create(['name' => $request->input('name')]); //spatie
        return redirect()->back()->with('success', 'Rol creado con exito');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error:'.$e->getMessage());
        }
    }

    public function update(Request $request, string $id)
    {
        $role = Role::findOrFail($id);
        $role->name = $request->input('name');

        $role->syncPermissions($request->input('permissions', []));
        $role->save();

        return redirect()->route('roles.index')->with('success', 'Rol Actualizado correctamente');
    }

    public function destroy($id)
    {
        try {
            $rol = Role::findOrFail($id);
            $rol->delete();

            return redirect()->back()->with('success', 'Eliminado con exito');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al eliminar el rol' . $e->getMessage());
        }
    }

     public function asignar_rol(Request $request, $id){
        $usuario = User::find($id);
        if($usuario){
            $usuario->syncRoles($request->input('roles'));
            return redirect()->back()->with('success', 'Roles asignado correctamente');
        }
        return redirect()->back()->with('Error', 'Rol no asignado');
    }
}
