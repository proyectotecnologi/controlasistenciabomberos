<?php

namespace App\Http\Controllers;

use App\Models\Asignacion;
use Illuminate\Http\Request;
use App\Models\Division;
use App\Models\Miembro;
use App\Models\Tolerancia;

class ToleranciaController extends Controller
{
    public function vista_tolerancia()
    {
        $tolerancia = Tolerancia::findOrFail(1);
        return view('permisos.tolerancia', compact('tolerancia'));
    }


    public function guardar_tolerancia(Request $request)
    {
        // dd($request->all());
        $data = $request->only([
            'atraso_por_minuto',
            'salida_anticipada',
            'tolerancia_maxima_entrada',
            'maximo_salida',
            'antelacion_marcado',
            'antelacion_salida',
        ]);

        $tolerancia = Tolerancia::first();

        if ($tolerancia) {
            $tolerancia->update($data);
        } else {
            Tolerancia::create($data);
        }

        return back()->with('success', 'Configuración de tolerancias guardada correctamente.');
    }
}
