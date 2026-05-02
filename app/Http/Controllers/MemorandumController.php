<?php

namespace App\Http\Controllers;

use App\Models\Miembro;
use App\Models\Marcaciones;
use App\Models\Tolerancia;
use Illuminate\Http\Request;
use Carbon\Carbon;

class MemorandumController extends Controller
{
    public function lista_memorandum(Request $request)
    {
        $miembros = Miembro::with('asignacion', 'diasAsignados')->get();

        // Obtener mes y año del request o usar el actual
        $mes = $request->input('mes', now()->month);
        $anio = $request->input('anio', now()->year);

        // Obtener todos los meses para el select
        $meses = [
            1 => 'Enero',
            2 => 'Febrero',
            3 => 'Marzo',
            4 => 'Abril',
            5 => 'Mayo',
            6 => 'Junio',
            7 => 'Julio',
            8 => 'Agosto',
            9 => 'Septiembre',
            10 => 'Octubre',
            11 => 'Noviembre',
            12 => 'Diciembre'
        ];

        // Obtener años disponibles (últimos 5 años)
        $anios = range(now()->year, now()->year - 4);

        // Si hay filtro, calcular estadísticas para cada miembro
        if ($request->has('mes') || $request->has('anio')) {
            foreach ($miembros as $miembro) {
                $estadisticas = $this->calcularEstadisticasMes($miembro, $mes, $anio);
                $miembro->estadisticas = $estadisticas;
            }
        }

        return view('memorandum.memorandum', compact('miembros', 'meses', 'mes', 'anios', 'anio'));
    }

    private function calcularEstadisticasMes($miembro, $mes, $anio)
    {
        if (!$miembro->asignacion) {
            return [
                'total_faltas' => 0,
                'total_atrasos' => 0,
                'total_salidas_anticipadas' => 0,
                'dias_asignados_mes' => 0,
                'dias_con_marcaciones' => 0,
                'dias_permiso' => 0
            ];
        }

        // Definir rango del mes EXACTO (igual que el PDF)
        $fechaInicio = Carbon::create($anio, $mes, 1)->startOfMonth();
        $fechaFin = Carbon::create($anio, $mes, 1)->endOfMonth();

        \Log::info("Calculando estadísticas para {$miembro->nombre_apellido}");
        \Log::info("Período: {$fechaInicio->format('Y-m-d')} a {$fechaFin->format('Y-m-d')}");

        // Obtener días asignados del miembro
        $diasAsignados = $miembro->diasAsignados->pluck('name')->map(function ($dia) {
            return strtolower($dia);
        })->toArray();

        \Log::info("Días asignados: " . implode(', ', $diasAsignados));

        // Contar días asignados en el mes
        $diasAsignadosMes = 0;
        $fechaTemp = $fechaInicio->copy();

        while ($fechaTemp <= $fechaFin) {
            $diaSemana = strtolower($fechaTemp->translatedFormat('l'));
            if (in_array($diaSemana, $diasAsignados)) {
                $diasAsignadosMes++;
            }
            $fechaTemp->addDay();
        }

        \Log::info("Días asignados en el mes: {$diasAsignadosMes}");

        // Obtener marcaciones del mes
        $marcaciones = Marcaciones::where('carnet', $miembro->ci)
            ->whereBetween('fecha_marcacion', [$fechaInicio, $fechaFin])
            ->orderBy('fecha_marcacion', 'asc')
            ->get()
            ->groupBy(function ($marcacion) {
                return Carbon::parse($marcacion->fecha_marcacion)->format('Y-m-d');
            });

        \Log::info("Días con marcaciones encontradas: " . $marcaciones->count());

        // Obtener permisos del mes
        $permisos = $this->obtenerPermisosMes($miembro, $fechaInicio, $fechaFin);

        $diasConMarcaciones = 0;
        $totalAtrasos = 0;
        $totalSalidasAnticipadas = 0;
        $diasPermiso = 0;

        // Procesar cada día del mes
        $fechaTemp = $fechaInicio->copy();
        while ($fechaTemp <= $fechaFin) {
            $fechaStr = $fechaTemp->format('Y-m-d');
            $diaSemana = strtolower($fechaTemp->translatedFormat('l'));

            // Solo procesar si es día asignado
            if (in_array($diaSemana, $diasAsignados)) {

                // Verificar si tiene permiso
                $tienePermiso = $this->tienePermiso($permisos, $fechaStr);

                if ($tienePermiso) {
                    $diasPermiso++;
                    \Log::info("{$fechaStr}: PERMISO");
                } else if (isset($marcaciones[$fechaStr])) {
                    $diasConMarcaciones++;

                    // Procesar marcaciones del día
                    $resultadoDia = $this->procesarMarcacionesDia(
                        $marcaciones[$fechaStr],
                        $miembro->asignacion->hora_entrada,
                        $miembro->asignacion->hora_salida,
                        $fechaStr
                    );

                    \Log::info("{$fechaStr}: MARCÓ - Atraso: {$resultadoDia['minutos_atraso']}min, Salida Ant: {$resultadoDia['minutos_salida_anticipada']}min");

                    // Contar días con atraso (solo si tiene atraso real)
                    if ($resultadoDia['minutos_atraso'] > 0) {
                        $totalAtrasos++;
                    }

                    // Contar días con salida anticipada (solo si tiene salida anticipada real)
                    if ($resultadoDia['minutos_salida_anticipada'] > 0) {
                        $totalSalidasAnticipadas++;
                    }
                } else {
                    \Log::info("{$fechaStr}: FALTA - Día asignado sin marcaciones ni permisos");
                }
            } else {
                \Log::info("{$fechaStr}: NO ASIGNADO");
            }
            $fechaTemp->addDay();
        }

        // Calcular faltas (días asignados sin marcaciones y sin permiso)
        $diasEsperadosTrabajo = $diasAsignadosMes - $diasPermiso;
        $totalFaltas = max(0, $diasEsperadosTrabajo - $diasConMarcaciones);

        \Log::info("RESUMEN - Faltas: {$totalFaltas}, Atrasos: {$totalAtrasos}, Salidas Ant: {$totalSalidasAnticipadas}");
        \Log::info("Días asignados: {$diasAsignadosMes}, Con marcaciones: {$diasConMarcaciones}, Permisos: {$diasPermiso}");

        return [
            'total_faltas' => $totalFaltas,
            'total_atrasos' => $totalAtrasos,
            'total_salidas_anticipadas' => $totalSalidasAnticipadas,
            'dias_asignados_mes' => $diasAsignadosMes,
            'dias_con_marcaciones' => $diasConMarcaciones,
            'dias_permiso' => $diasPermiso,
            'dias_esperados_trabajo' => $diasEsperadosTrabajo
        ];
    }

    private function procesarMarcacionesDia($marcacionesDia, $horaEntradaAsignada, $horaSalidaAsignada, $fecha)
    {
        $resultado = [
            'minutos_atraso' => 0,
            'minutos_salida_anticipada' => 0
        ];

        if ($marcacionesDia->isEmpty()) {
            return $resultado;
        }

        // Obtener tolerancias
        $tolerancias = Tolerancia::first();
        $minutos_tolerancia_entrada = $this->timeToMinutes($tolerancias->atraso_por_minuto);
        $minutos_tolerancia_salida = $this->timeToMinutes($tolerancias->salida_anticipada);

        // Convertir tolerancias a minutos
        $toleranciaAntesEntrada = $this->timeToMinutes($tolerancias->antelacion_marcado);
        $toleranciaDespuesEntrada = $this->timeToMinutes($tolerancias->tolerancia_maxima_entrada);
        $toleranciaAntesSalida = $this->timeToMinutes($tolerancias->antelacion_salida);
        $toleranciaDespuesSalida = $this->timeToMinutes($tolerancias->maximo_salida);

        // Definir rangos
        $horaEntradaAsignadaObj = Carbon::parse($fecha . ' ' . $horaEntradaAsignada);
        $horaSalidaAsignadaObj = Carbon::parse($fecha . ' ' . $horaSalidaAsignada);

        $rangoMinEntrada = $horaEntradaAsignadaObj->copy()->subMinutes($toleranciaAntesEntrada);
        $rangoMaxEntrada = $horaEntradaAsignadaObj->copy()->addMinutes($toleranciaDespuesEntrada);

        $rangoMinSalida = $horaSalidaAsignadaObj->copy()->subMinutes($toleranciaAntesSalida);
        $rangoMaxSalida = $horaSalidaAsignadaObj->copy()->addMinutes($toleranciaDespuesSalida);

        // Ordenar marcaciones
        $marcacionesOrdenadas = $marcacionesDia->sortBy('fecha_marcacion');

        $entradaEncontrada = false;
        $salidaEncontrada = false;

        foreach ($marcacionesOrdenadas as $marcacion) {
            $horaMarcacion = Carbon::parse($marcacion->fecha_marcacion);

            // Buscar entrada
            if (!$entradaEncontrada && $horaMarcacion->between($rangoMinEntrada, $rangoMaxEntrada)) {
                $entradaEncontrada = true;

                // Calcular atraso
                if ($horaMarcacion->gt($horaEntradaAsignadaObj)) {
                    $diferenciaSegundos = $horaMarcacion->timestamp - $horaEntradaAsignadaObj->timestamp;
                    $minutosAtraso = max(0, round($diferenciaSegundos / 60));

                    if ($minutosAtraso > $minutos_tolerancia_entrada) {
                        $resultado['minutos_atraso'] = $minutosAtraso - $minutos_tolerancia_entrada;
                    }
                }
                continue;
            }

            // Buscar salida (solo si ya se encontró entrada)
            if (
                $entradaEncontrada && !$salidaEncontrada &&
                $horaMarcacion->between($rangoMinSalida, $rangoMaxSalida)
            ) {
                $salidaEncontrada = true;

                // Calcular salida anticipada
                if ($horaMarcacion->lt($horaSalidaAsignadaObj)) {
                    $diferenciaSegundos = $horaSalidaAsignadaObj->timestamp - $horaMarcacion->timestamp;
                    $minutosAnticipados = max(0, round($diferenciaSegundos / 60));

                    if ($minutosAnticipados > $minutos_tolerancia_salida) {
                        $resultado['minutos_salida_anticipada'] = $minutosAnticipados - $minutos_tolerancia_salida;
                    }
                }
                continue;
            }
        }

        return $resultado;
    }

    private function obtenerPermisosMes($miembro, $fechaInicio, $fechaFin)
    {
        // Si tienes modelo de Permisos, implementa esta función
        // Por ahora retornamos array vacío
        return [];
    }

    private function tienePermiso($permisos, $fecha)
    {
        // Si no hay modelo de permisos, siempre retorna false
        if (empty($permisos)) {
            return false;
        }

        $fechaCarbon = Carbon::parse($fecha);
        foreach ($permisos as $permiso) {
            $inicio = Carbon::parse($permiso->fecha_inicio);
            $fin = Carbon::parse($permiso->fecha_fin);

            if ($fechaCarbon->between($inicio, $fin)) {
                return true;
            }
        }

        return false;
    }

    // Función auxiliar para convertir tiempo a minutos
    private function timeToMinutes($time)
    {
        if (is_numeric($time)) {
            return (int) $time;
        }

        $parts = explode(':', $time);
        if (count($parts) >= 2) {
            $hours = intval($parts[0]);
            $minutes = intval($parts[1]);
            $seconds = isset($parts[2]) ? intval($parts[2]) : 0;
            return ($hours * 60) + $minutes + ($seconds > 0 ? 1 : 0);
        }

        return 0;
    }
}
