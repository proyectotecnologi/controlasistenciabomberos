<?php

namespace App\Http\Controllers;

use App\Models\Asignacion;
use Illuminate\Http\Request;
use App\Models\Division;
use App\Models\Miembro;
use App\Models\User;
use App\Models\Asistencia;
use App\Models\Asistenciasalida;
use App\Models\Dia;

class AsignarController extends Controller
{
    public function asignar_horario(Request $request)
    {
        try {
            $request->validate([
                'miembro_id'    => 'required|exists:miembros,id',
                'hora_entrada'  => 'required',
                'hora_salida'   => 'required',
                'dias'          => 'required|array|min:1',
                'dias.*'        => 'in:lunes,martes,miércoles,jueves,viernes,sabado,domingo',
            ]);
            // dd($request->dias);

            // Buscar si ya tiene asignación
            $asignacion = Asignacion::where('miembro_id', $request->miembro_id)->first();

            if ($asignacion) {
                // Si existe → actualizar
                $asignacion->update([
                    'hora_entrada' => $request->hora_entrada,
                    'hora_salida'  => $request->hora_salida,
                ]);

                // Eliminar días existentes
                $asignacion->dias()->delete();
            } else {
                // Si no existe → crear
                $asignacion = Asignacion::create([
                    'miembro_id'   => $request->miembro_id,
                    'hora_entrada' => $request->hora_entrada,
                    'hora_salida'  => $request->hora_salida,
                ]);
            }

            // Crear los nuevos días
            foreach ($request->dias as $dia) {
                Dia::create([
                    'name' => $dia,
                    'asignacion_horario_id' => $asignacion->id,
                ]);
            }

            return back()->with('success', 'Horario y días asignados correctamente');
        } catch (\Exception $e) {
            return back()->with('error', 'Error:' . $e->getMessage());
        }
    }
}
