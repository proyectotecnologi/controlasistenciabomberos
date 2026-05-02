<?php

namespace App\Http\Controllers;

use App\Models\Miembro;
use App\Models\Permiso;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;

class PermisoController extends Controller
{
    public function lista_permisos()
    {
        $miembros = Miembro::all();
        $permisos = Permiso::all();
        return view('permisos.lista_permisos', compact('permisos', 'miembros'));
    }

    public function crear_permiso(Request $request)
    {
        try {
            $request->validate([
                'miembro_id' => 'required|integer|exists:miembros,id',
                'desde' => 'required|date',
                'hasta' => 'required|date',
                'motivo' => 'required|string|in:permiso,comision,salud,enfermedad,familiar,duelo,estudio,capacitacion,vacacion,tramite,judicial,otros',
                'descripcion' => 'nullable|string' // puede ser opcional
            ]);

            Permiso::create([
                'desde' => $request->desde,
                'hasta' => $request->hasta,
                'motivo' => $request->motivo,
                'descripcion' => $request->descripcion,
                'miembro_id' => $request->miembro_id,
            ]);

            return redirect()->back()->with('success', 'Permiso creado con éxito');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function actualizar_permiso(Request $request, $id)
    {
        $permiso = Permiso::findOrFail($id);

        // Validar los datos
        $request->validate([
            'miembro_id' => 'required|integer|exists:miembros,id',
            'desde' => 'required|date',
            'hasta' => 'required|date',
            'motivo' => 'required|string|in:permiso,comision,salud,enfermedad,familiar,duelo,estudio,capacitacion,vacacion,tramite,judicial,otros',
            'descripcion' => 'required|string'
        ]);

        $permiso->miembro_id = $request->miembro_id;
        $permiso->desde = $request->desde;
        $permiso->hasta = $request->hasta;
        $permiso->motivo = $request->motivo;
        $permiso->descripcion = $request->descripcion;

        $permiso->save();

         return redirect()->back()->with('success', 'Permiso actualizado correctamente');
     }

    public function eliminar_permiso($id)
    {
        try {
            $permiso = Permiso::findOrFail($id);
            $permiso->delete();

            return redirect()->back()->with('success', 'Permiso eliminado con éxito');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
}
