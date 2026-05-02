<?php

namespace App\Http\Controllers;

use App\Models\Miembro;
use App\Models\Marcaciones;
use App\Models\Tolerancia;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
//use Illuminate\Support\Facades\Storage;
//use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
// use Barryvdh\DomPDF\Facade\Pdf;


class MarcarAsistenciaController extends Controller
{
    public function marcar_asistencia()
    {
        return view('marcaciones.marcarciones');
    }


    public function verificar(Request $request)
    {
        $request->validate([
            'ci' => 'required'
        ]);

        $miembro = Miembro::where('ci', $request->ci)->first();

        if (!$miembro) {
            return response()->json([
                'success' => false,
                'message' => 'CI no encontrado en el sistema. Verifique el número ingresado.'
            ], 404);
        }

        if ($miembro->estado != 1) {
            return response()->json([
                'success' => false,
                'message' => 'El miembro no está activo en el sistema.'
            ], 403);
        }

        return response()->json([
            'success' => true,
            'miembro' => $miembro
        ]);
    }

    /**
     * Registrar marcación
     */
    public function store(Request $request)
    {
        $request->validate([
            'ci' => 'required|exists:miembros,ci',
            'fecha_marcacion' => 'required'
        ]);

        try {
            $marcacion = new Marcaciones();
            $marcacion->carnet = $request->ci;
            $marcacion->fecha_marcacion = $request->fecha_marcacion;
            $marcacion->save();

            $miembro = Miembro::where('ci', $request->ci)->first();
            $hora = Carbon::parse($request->fecha_marcacion)->format('H:i:s');

            return response()->json([
                'success' => true,
                'message' => 'Marcación registrada correctamente a las ' . $hora,
                'miembro' => $miembro->nombre_apellido
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al registrar: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener últimas marcaciones
     */
    public function ultimas()
    {
        try {
            $marcaciones = Marcaciones::orderBy('fecha_marcacion', 'desc')
                ->take(10)
                ->get();

            $resultado = [];

            foreach ($marcaciones as $marcacion) {
                $miembro = Miembro::where('ci', $marcacion->carnet)->first();

                $foto = null;
                if ($miembro && $miembro->fotografia) {
                    // ← CORREGIDO: Quitar espacios en blanco
                    $foto = asset('storage/' . $miembro->fotografia);
                }

                $resultado[] = [
                    'nombre' => $miembro ? $miembro->nombre_apellido : 'Desconocido',
                    'ci' => $marcacion->carnet,
                    'hora' => Carbon::parse($marcacion->fecha_marcacion)->format('H:i:s'),
                    'fecha_completa' => Carbon::parse($marcacion->fecha_marcacion)->format('d/m/Y H:i:s'),
                    'foto' => $foto
                ];
            }

            return response()->json($resultado);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ], 500);
        }
    }

    /**
     * Obtener marcaciones de hoy
     */
    public function hoy()
    {
        try {
            $hoy = Carbon::today();

            $marcaciones = Marcaciones::whereDate('fecha_marcacion', $hoy)
                ->orderBy('fecha_marcacion', 'asc')
                ->get();

            $resultado = [];

            foreach ($marcaciones as $marcacion) {
                $miembro = Miembro::where('ci', $marcacion->carnet)->first();

                $foto = null;
                if ($miembro && $miembro->fotografia) {
                    // ← CORREGIDO: Quitar espacios
                    $foto = asset('storage/' . $miembro->fotografia);
                }

                $resultado[] = [
                    'ci' => $marcacion->carnet,
                    'nombre' => $miembro ? $miembro->nombre_apellido : 'Desconocido',
                    'grado' => $miembro ? $miembro->grado : '-',
                    'hora' => Carbon::parse($marcacion->fecha_marcacion)->format('H:i:s'),
                    'fecha_completa' => Carbon::parse($marcacion->fecha_marcacion)->format('d/m/Y H:i:s'),
                    'foto' => $foto
                ];
            }

            return response()->json($resultado);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ], 500);
        }
    }


    /////////////////////////////////////

    public function lista_usuarios_asistencias()
    {
        $miembros = Miembro::with('asignacion')->get();
        // dd($miembros);
        return view('marcaciones.usuarioAsistencia', compact('miembros'));
    }

    public function historial_asistencia($id)
    {
        $miembro = Miembro::with('asignacion')
            ->where('ci', $id)->first();

        if (!$miembro) {
            return redirect()->back()->with('error', 'Miembro no encontrado');
        }

        // Obtener las horas asignadas del miembro
        $horaEntradaAsignada = Carbon::parse($miembro->asignacion->hora_entrada);
        $horaSalidaAsignada = Carbon::parse($miembro->asignacion->hora_salida);

        // Obtener marcaciones agrupadas por fecha
        $marcaciones = Marcaciones::where('carnet', $id)
            ->orderBy('fecha_marcacion', 'asc')
            ->get()
            ->groupBy(function ($marcacion) {
                return Carbon::parse($marcacion->fecha_marcacion)->format('Y-m-d');
            })
            ->map(function ($marcacionesDia, $fecha) use ($horaEntradaAsignada, $horaSalidaAsignada) {
                $fechaCarbon = Carbon::parse($fecha);

                // Procesar las marcaciones del día para identificar entradas y salidas
                $marcacionesProcesadas = $this->procesarMarcacionesDia(
                    $marcacionesDia,
                    $horaEntradaAsignada,
                    $horaSalidaAsignada
                );

              

                // AGREGAR LOS CAMPOS DE ATRASO AQUÍ
                return [
                    'fecha' => $fecha,
                    'dia_texto' => $fechaCarbon->translatedFormat('l'),
                    'fecha_formato' => $fechaCarbon->translatedFormat('d \d\e F \d\e Y'),
                    'total_marcaciones' => $marcacionesDia->count(),
                    'entrada' => $marcacionesProcesadas['entrada'] ?? null,
                    'salida' => $marcacionesProcesadas['salida'] ?? null,
                    'marcaciones_extra' => $marcacionesProcesadas['marcaciones_extra'] ?? [],
                    'todas_marcaciones' => $marcacionesProcesadas['todas_marcaciones'] ?? [],
                    // NUEVOS CAMPOS PARA ATRASO
                    'minutos_atraso' => $marcacionesProcesadas['minutos_atraso'] ?? 0,
                    'minutos_salida_anticipada' => $marcacionesProcesadas['minutos_salida_anticipada'] ?? 0,
                    // Mantener compatibilidad con la tabla original
                    'marcaciones' => $marcacionesProcesadas['todas_marcaciones'] ?? []
                ];
            });

        return view('marcaciones.historialAsistencias', compact('miembro', 'marcaciones'));
    }


    private function procesarMarcacionesDia($marcacionesDia, $horaEntradaAsignada, $horaSalidaAsignada)
    {
        $resultado = [
            'entrada' => null,
            'salida' => null,
            'marcaciones_extra' => [],
            'todas_marcaciones' => [],
            'minutos_atraso' => 0,
            'minutos_salida_anticipada' => 0
        ];

        $tolerancias = Tolerancia::first();
        // dd($tolerancias);

        // DEBUG: Verificar tolerancias
        $debugTolerancias = [
            'atraso_por_minuto' => $tolerancias->atraso_por_minuto,
            'salida_anticipada' => $tolerancias->salida_anticipada,
            'tolerancia_maxima_entrada' => $tolerancias->tolerancia_maxima_entrada,
            'antelacion_marcado' => $tolerancias->antelacion_marcado
        ];

        $atraso_por_minuto = $tolerancias->atraso_por_minuto;
        $salida_anticipada = $tolerancias->salida_anticipada;

        // Convertir TODAS las tolerancias a minutos
        $minutos_tolerancia_entrada = $this->timeToMinutes($atraso_por_minuto);
        $minutos_tolerancia_salida = $this->timeToMinutes($salida_anticipada);

        // DEBUG: Verificar conversiones
        $debugConversiones = [
            'atraso_por_minuto_original' => $atraso_por_minuto,
            'atraso_por_minuto_en_minutos' => $minutos_tolerancia_entrada,
            'salida_anticipada_original' => $salida_anticipada,
            'salida_anticipada_en_minutos' => $minutos_tolerancia_salida
        ];

        $toleranciaAntesEntrada = $this->timeToMinutes($tolerancias->antelacion_marcado);
        $toleranciaDespuesEntrada = $this->timeToMinutes($tolerancias->tolerancia_maxima_entrada);
        $toleranciaAntesSalida = $this->timeToMinutes($tolerancias->antelacion_salida);
        $toleranciaDespuesSalida = $this->timeToMinutes($tolerancias->maximo_salida);

        // Definir rangos exactos
        $fechaBase = $marcacionesDia->first() ? Carbon::parse($marcacionesDia->first()->fecha_marcacion)->format('Y-m-d') : now()->format('Y-m-d');

        $horaEntradaAsignadaObj = Carbon::parse($fechaBase . ' ' . $horaEntradaAsignada->format('H:i:s'));
        $horaSalidaAsignadaObj = Carbon::parse($fechaBase . ' ' . $horaSalidaAsignada->format('H:i:s'));

        // DEBUG: Verificar rangos
        $debugRangos = [
            'hora_entrada_asignada' => $horaEntradaAsignadaObj->format('Y-m-d H:i:s'),
            'rango_min_entrada' => $horaEntradaAsignadaObj->copy()->subMinutes($toleranciaAntesEntrada)->format('Y-m-d H:i:s'),
            'rango_max_entrada' => $horaEntradaAsignadaObj->copy()->addMinutes($toleranciaDespuesEntrada)->format('Y-m-d H:i:s'),
            'minutos_tolerancia_entrada' => $minutos_tolerancia_entrada
        ];

        // Ahora usar las variables convertidas a minutos (números enteros)
        $rangoMinEntrada = $horaEntradaAsignadaObj->copy()->subMinutes($toleranciaAntesEntrada);
        $rangoMaxEntrada = $horaEntradaAsignadaObj->copy()->addMinutes($toleranciaDespuesEntrada);

        $rangoMinSalida = $horaSalidaAsignadaObj->copy()->subMinutes($toleranciaAntesSalida);
        $rangoMaxSalida = $horaSalidaAsignadaObj->copy()->addMinutes($toleranciaDespuesSalida);

        // Ordenar marcaciones por hora
        $marcacionesOrdenadas = $marcacionesDia->sortBy('fecha_marcacion');

        foreach ($marcacionesOrdenadas as $marcacion) {
            $horaMarcacion = Carbon::parse($marcacion->fecha_marcacion);
            $hora = $horaMarcacion->format('H:i:s');

            $datosMarcacion = [
                'hora' => $hora,
                'fecha_completa' => $marcacion->fecha_marcacion,
                'tipo' => 'extra'
            ];

            // VERIFICAR ENTRADA - Solo si está dentro del rango de entrada
            if (!$resultado['entrada']) {
                if ($horaMarcacion->between($rangoMinEntrada, $rangoMaxEntrada)) {
                    $datosMarcacion['tipo'] = 'entrada';

                    // DEBUG ESPECÍFICO PARA EL CÁLCULO DE ATRASO
                    $debugAtraso = [
                        'hora_marcacion' => $horaMarcacion->format('H:i:s'),
                        'hora_entrada_asignada' => $horaEntradaAsignadaObj->format('H:i:s'),
                        'es_mayor' => $horaMarcacion->gt($horaEntradaAsignadaObj),
                        'minutos_diferencia' => $horaMarcacion->diffInMinutes($horaEntradaAsignadaObj),
                        'minutos_tolerancia_entrada' => $minutos_tolerancia_entrada,
                        'atraso_calculado' => 0
                    ];

                    // CALCULAR MINUTOS DE ATRASO - ENFOQUE ROBUSTO
                    if ($horaMarcacion->gt($horaEntradaAsignadaObj)) {
                        // Calcular diferencia en segundos y convertir a minutos
                        $diferenciaSegundos = $horaMarcacion->timestamp - $horaEntradaAsignadaObj->timestamp;
                        $minutosAtraso = max(0, round($diferenciaSegundos / 60)); // Asegurar que sea positivo

                        $debugAtraso['minutos_diferencia'] = $minutosAtraso;
                        $debugAtraso['diferencia_segundos'] = $diferenciaSegundos;

                        // Solo considerar atraso si supera la tolerancia
                        if ($minutosAtraso > $minutos_tolerancia_entrada) {
                            $resultado['minutos_atraso'] = $minutosAtraso - $minutos_tolerancia_entrada;
                            $debugAtraso['atraso_calculado'] = $resultado['minutos_atraso'];
                        } else {
                            $resultado['minutos_atraso'] = 0;
                            $debugAtraso['atraso_calculado'] = 0;
                        }
                    } else {
                        $resultado['minutos_atraso'] = 0;
                        $debugAtraso['atraso_calculado'] = 0;
                    }

                    $resultado['entrada'] = $datosMarcacion;
                    continue;
                }
            }

            // VERIFICAR SALIDA - Solo si está dentro del rango de salida Y después de la entrada
            if ($resultado['entrada'] && !$resultado['salida']) {
                $horaEntrada = Carbon::parse($resultado['entrada']['fecha_completa']);

                if (
                    $horaMarcacion->between($rangoMinSalida, $rangoMaxSalida) &&
                    $horaMarcacion->gt($horaEntrada)
                ) {
                    $datosMarcacion['tipo'] = 'salida';

                    // CALCULAR MINUTOS DE SALIDA ANTICIPADA
// CALCULAR MINUTOS DE SALIDA ANTICIPADA - ENFOQUE ROBUSTO
if ($horaMarcacion->lt($horaSalidaAsignadaObj)) {
    // Calcular diferencia en segundos y convertir a minutos
    $diferenciaSegundos = $horaSalidaAsignadaObj->timestamp - $horaMarcacion->timestamp;
    $minutosAnticipados = max(0, round($diferenciaSegundos / 60)); // Asegurar que sea positivo

    // DEBUG: Para verificar el cálculo (puedes remover después)
    $debugSalida = [
        'hora_salida_asignada' => $horaSalidaAsignadaObj->format('H:i:s'),
        'hora_marcacion_salida' => $horaMarcacion->format('H:i:s'),
        'minutos_anticipados' => $minutosAnticipados,
        'minutos_tolerancia_salida' => $minutos_tolerancia_salida,
        'salida_anticipada_calculada' => 0
    ];

    // Solo considerar salida anticipada si supera la tolerancia
    if ($minutosAnticipados > $minutos_tolerancia_salida) {
        $resultado['minutos_salida_anticipada'] = $minutosAnticipados - $minutos_tolerancia_salida;
        $debugSalida['salida_anticipada_calculada'] = $resultado['minutos_salida_anticipada'];
    } else {
        $resultado['minutos_salida_anticipada'] = 0;
        $debugSalida['salida_anticipada_calculada'] = 0;
    }

    // DEBUG: Para probar (remover después de verificar)
    // if ($fechaBase === '2025-11-20') { // Cambia por una fecha con salida anticipada
    //     dd($debugSalida);
    // }
} else {
    $resultado['minutos_salida_anticipada'] = 0;
}
                    $resultado['salida'] = $datosMarcacion;
                    continue;
                }
            }

            // Si ya tenemos entrada y salida, verificar si es una marcación intermedia
            if ($resultado['entrada'] && $resultado['salida']) {
                $horaEntradaObj = Carbon::parse($resultado['entrada']['fecha_completa']);
                $horaSalidaObj = Carbon::parse($resultado['salida']['fecha_completa']);

                if ($horaMarcacion->between($horaEntradaObj, $horaSalidaObj)) {
                    $datosMarcacion['tipo'] = 'intermedia';
                }
            }

            // Si no es entrada ni salida válida, es una marcación extra
            $resultado['marcaciones_extra'][] = $datosMarcacion;
        }

        // Agrupar todas las marcaciones para mostrar en la vista
        $todasMarcaciones = collect([]);

        if ($resultado['entrada']) {
            $todasMarcaciones->push($resultado['entrada']);
        }

        if ($resultado['salida']) {
            $todasMarcaciones->push($resultado['salida']);
        }

        // Agregar marcaciones extra
        $marcacionesExtraFiltradas = collect($resultado['marcaciones_extra'])->filter(function ($marcacion) use ($resultado) {
            if ($resultado['entrada'] && $marcacion['fecha_completa'] === $resultado['entrada']['fecha_completa']) {
                return false;
            }
            if ($resultado['salida'] && $marcacion['fecha_completa'] === $resultado['salida']['fecha_completa']) {
                return false;
            }
            return true;
        });

        $todasMarcaciones = $todasMarcaciones->merge($marcacionesExtraFiltradas);

        // Ordenar por hora
        $resultado['todas_marcaciones'] = $todasMarcaciones->sortBy('fecha_completa')->values()->toArray();

        return $resultado;
    }

    // Función auxiliar para convertir tiempo HH:MM:SS a minutos
    private function timeToMinutes($time)
    {
        // Si ya es un número, retornarlo directamente
        if (is_numeric($time)) {
            return (int) $time;
        }

        // Si es string en formato tiempo, convertirlo
        $parts = explode(':', $time);

        if (count($parts) >= 2) {
            $hours = intval($parts[0]);
            $minutes = intval($parts[1]);
            $seconds = isset($parts[2]) ? intval($parts[2]) : 0;

            return ($hours * 60) + $minutes + ($seconds > 0 ? 1 : 0);
        }

        // Si no se puede convertir, retornar 0
        return 0;
    }

    





    //PDF GENERA PDF








}
