<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Miembro;
use App\Models\Marcaciones;
use App\Models\Permiso;
use App\Models\Tolerancia;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class ReporteMensualController extends Controller
{
    public function vistar_reporte_mensual(){
        return view('marcaciones.vista_mensual');
    }

    public function generarReporteMensual(Request $request)
    {
        $request->validate([
            'fecha_desde' => 'required|date',
            'fecha_hasta' => 'required|date|after_or_equal:fecha_desde'
        ]);

        $fechaDesde = $request->fecha_desde;
        $fechaHasta = $request->fecha_hasta;

        // Generar array de días del período
        $diasPeriodo = $this->generarDiasPeriodo($fechaDesde, $fechaHasta);

        // Obtener todos los miembros con asignación y sus relaciones
        $miembros = Miembro::with(['asignacion', 'diasAsignados', 'permisos'])
            ->whereHas('asignacion')
            ->get();

        $reporteData = [];

        foreach ($miembros as $miembro) {
            $reporteData[] = $this->procesarMiembroCompleto($miembro, $fechaDesde, $fechaHasta, $diasPeriodo);
        }

        // No filtrar - mostrar todos los miembros
        // Ordenar por nombre
        usort($reporteData, function($a, $b) {
            return strcmp($a['nombre'], $b['nombre']);
        });

        // Estadísticas generales mejoradas
        $estadisticasGenerales = $this->calcularEstadisticasGenerales($reporteData, $diasPeriodo);

        if ($request->has('generar_pdf')) {
            return $this->generarPDF($reporteData, $estadisticasGenerales, $fechaDesde, $fechaHasta, $diasPeriodo);
        }

        return view('marcaciones.vista_mensual', compact('reporteData', 'estadisticasGenerales', 'fechaDesde', 'fechaHasta', 'diasPeriodo'));
    }

    private function generarDiasPeriodo($fechaDesde, $fechaHasta)
    {
        $dias = [];
        $fechaInicio = Carbon::parse($fechaDesde);
        $fechaFin = Carbon::parse($fechaHasta);

        while ($fechaInicio <= $fechaFin) {
            $dias[] = [
                'fecha' => $fechaInicio->format('Y-m-d'),
                'dia' => $fechaInicio->format('d'),
                'dia_semana' => $fechaInicio->translatedFormat('D'),
                'dia_semana_completo' => $fechaInicio->translatedFormat('l'),
                'mes' => $fechaInicio->translatedFormat('M'),
                'formato_completo' => $fechaInicio->translatedFormat('d M')
            ];
            $fechaInicio->addDay();
        }

        return $dias;
    }

    private function procesarMiembroCompleto($miembro, $fechaDesde, $fechaHasta, $diasPeriodo)
    {
        // Obtener marcaciones del miembro en el período
        $marcaciones = Marcaciones::where('carnet', $miembro->ci)
            ->whereBetween('fecha_marcacion', [$fechaDesde . ' 00:00:00', $fechaHasta . ' 23:59:59'])
            ->orderBy('fecha_marcacion')
            ->get();

        // Obtener permisos en el período
        $permisos = $this->obtenerPermisosEnPeriodo($miembro, $fechaDesde, $fechaHasta);

        // Obtener días asignados del miembro
        $diasAsignados = $miembro->diasAsignados->pluck('name')->map(function($dia) {
            return strtolower($dia);
        })->toArray();

        // Procesar marcaciones por día
        $marcacionesPorDia = $marcaciones->groupBy(function($marcacion) {
            return Carbon::parse($marcacion->fecha_marcacion)->format('Y-m-d');
        });

        // Procesar cada día del período
        $asistenciasPorDia = [];
        $estadisticas = [
            'dias_asistencia' => 0,
            'dias_permiso' => 0,
            'dias_falta' => 0,
            'dias_no_asignados' => 0,
            'total_minutos_atraso' => 0,
            'total_minutos_salida_anticipada' => 0,
            'total_dias_con_atraso' => 0,
            'total_dias_con_salida_anticipada' => 0
        ];

        foreach ($diasPeriodo as $dia) {
            $fecha = $dia['fecha'];
            $diaSemana = strtolower($dia['dia_semana_completo']);
            
            // Verificar si es día asignado
            $esDiaAsignado = in_array($diaSemana, $diasAsignados);
            
            // Verificar si tiene permiso
            $permiso = $this->obtenerPermisoParaFecha($permisos, $fecha);
            
            // Obtener marcaciones del día
            $marcacionesDia = $marcacionesPorDia[$fecha] ?? collect();
            
            if ($permiso) {
                // Tiene permiso
                $asistenciasPorDia[$fecha] = [
                    'tipo' => 'permiso',
                    'texto' => 'PERMISO',
                    'motivo' => $permiso->motivo,
                    'clase' => 'permiso',
                    'minutos_atraso' => 0,
                    'minutos_salida_anticipada' => 0
                ];
                $estadisticas['dias_permiso']++;
            } elseif (!$esDiaAsignado) {
                // No es día asignado
                $asistenciasPorDia[$fecha] = [
                    'tipo' => 'no_asignado',
                    'texto' => 'N/ASIG',
                    'clase' => 'no-asignado',
                    'minutos_atraso' => 0,
                    'minutos_salida_anticipada' => 0
                ];
                $estadisticas['dias_no_asignados']++;
            } elseif ($marcacionesDia->count() > 0) {
                // Tiene marcaciones - procesar asistencia con tolerancias
                $asistencia = $this->procesarAsistenciaDiaConTolerancias($marcacionesDia, $miembro, $fecha);
                
                // Acumular estadísticas de atrasos
                $estadisticas['total_minutos_atraso'] += $asistencia['minutos_atraso'];
                $estadisticas['total_minutos_salida_anticipada'] += $asistencia['minutos_salida_anticipada'];
                
                if ($asistencia['minutos_atraso'] > 0) {
                    $estadisticas['total_dias_con_atraso']++;
                }
                if ($asistencia['minutos_salida_anticipada'] > 0) {
                    $estadisticas['total_dias_con_salida_anticipada']++;
                }
                
                if ($asistencia['entrada'] && $asistencia['salida']) {
                    $texto = $asistencia['entrada'];
                    if ($asistencia['minutos_atraso'] > 0) {
                        $texto .= ' ⏰' . $asistencia['minutos_atraso'];
                    }
                    $texto .= ' - ' . $asistencia['salida'];
                    if ($asistencia['minutos_salida_anticipada'] > 0) {
                        $texto .= ' 🚪' . $asistencia['minutos_salida_anticipada'];
                    }
                    
                    $asistenciasPorDia[$fecha] = [
                        'tipo' => 'completo',
                        'texto' => $texto,
                        'clase' => $asistencia['minutos_atraso'] > 0 ? 'completo-con-atraso' : 'completo',
                        'minutos_atraso' => $asistencia['minutos_atraso'],
                        'minutos_salida_anticipada' => $asistencia['minutos_salida_anticipada']
                    ];
                    $estadisticas['dias_asistencia']++;
                } elseif ($asistencia['entrada']) {
                    $texto = $asistencia['entrada'];
                    if ($asistencia['minutos_atraso'] > 0) {
                        $texto .= ' ⏰' . $asistencia['minutos_atraso'];
                    }
                    $texto .= ' - --:--';
                    
                    $asistenciasPorDia[$fecha] = [
                        'tipo' => 'solo_entrada',
                        'texto' => $texto,
                        'clase' => $asistencia['minutos_atraso'] > 0 ? 'solo-entrada-con-atraso' : 'solo-entrada',
                        'minutos_atraso' => $asistencia['minutos_atraso'],
                        'minutos_salida_anticipada' => 0
                    ];
                    $estadisticas['dias_asistencia']++;
                } elseif ($asistencia['salida']) {
                    $texto = '--:-- - ' . $asistencia['salida'];
                    if ($asistencia['minutos_salida_anticipada'] > 0) {
                        $texto .= ' 🚪' . $asistencia['minutos_salida_anticipada'];
                    }
                    
                    $asistenciasPorDia[$fecha] = [
                        'tipo' => 'solo_salida',
                        'texto' => $texto,
                        'clase' => $asistencia['minutos_salida_anticipada'] > 0 ? 'solo-salida-con-anticipada' : 'solo-salida',
                        'minutos_atraso' => 0,
                        'minutos_salida_anticipada' => $asistencia['minutos_salida_anticipada']
                    ];
                    $estadisticas['dias_asistencia']++;
                } else {
                    $asistenciasPorDia[$fecha] = [
                        'tipo' => 'falta',
                        'texto' => 'FALTA',
                        'clase' => 'falta',
                        'minutos_atraso' => 0,
                        'minutos_salida_anticipada' => 0
                    ];
                    $estadisticas['dias_falta']++;
                }
            } else {
                // Día asignado pero sin marcaciones - falta
                $asistenciasPorDia[$fecha] = [
                    'tipo' => 'falta',
                    'texto' => 'FALTA',
                    'clase' => 'falta',
                    'minutos_atraso' => 0,
                    'minutos_salida_anticipada' => 0
                ];
                $estadisticas['dias_falta']++;
            }
        }

        return [
            'id' => $miembro->id,
            'ci' => $miembro->ci,
            'nombre' => $miembro->nombre_apellido,
            'grado' => $miembro->grado,
            'cargo' => $miembro->cargo,
            'division' => $miembro->division_o_dependencia,
            'horario_asignado' => [
                'entrada' => $miembro->asignacion->hora_entrada,
                'salida' => $miembro->asignacion->hora_salida
            ],
            'dias_asignados' => $miembro->diasAsignados->pluck('name')->map(function($dia) {
                return ucfirst(substr($dia, 0, 3));
            })->implode(', '),
            'estadisticas' => $estadisticas,
            'asistencias_por_dia' => $asistenciasPorDia
        ];
    }

    private function obtenerPermisosEnPeriodo($miembro, $fechaDesde, $fechaHasta)
    {
        return $miembro->permisos()
            ->where(function($query) use ($fechaDesde, $fechaHasta) {
                $query->whereBetween('desde', [$fechaDesde, $fechaHasta])
                      ->orWhereBetween('hasta', [$fechaDesde, $fechaHasta])
                      ->orWhere(function($q) use ($fechaDesde, $fechaHasta) {
                          $q->where('desde', '<=', $fechaDesde)
                            ->where('hasta', '>=', $fechaHasta);
                      });
            })
            ->get();
    }

    private function obtenerPermisoParaFecha($permisos, $fecha)
    {
        foreach ($permisos as $permiso) {
            $fechaCarbon = Carbon::parse($fecha);
            $desde = Carbon::parse($permiso->desde);
            $hasta = Carbon::parse($permiso->hasta);
            
            if ($fechaCarbon->between($desde, $hasta)) {
                return $permiso;
            }
        }
        
        return null;
    }

    private function procesarAsistenciaDiaConTolerancias($marcacionesDia, $miembro, $fecha)
    {
        if ($marcacionesDia->isEmpty()) {
            return [
                'entrada' => null,
                'salida' => null,
                'minutos_atraso' => 0,
                'minutos_salida_anticipada' => 0
            ];
        }

        // Obtener tolerancias
        $tolerancias = Tolerancia::first();
        
        $horaEntradaAsignada = Carbon::parse($miembro->asignacion->hora_entrada);
        $horaSalidaAsignada = Carbon::parse($miembro->asignacion->hora_salida);

        // Convertir tolerancias a minutos
        $minutos_tolerancia_entrada = $this->timeToMinutes($tolerancias->atraso_por_minuto);
        $minutos_tolerancia_salida = $this->timeToMinutes($tolerancias->salida_anticipada);

        $toleranciaAntesEntrada = $this->timeToMinutes($tolerancias->antelacion_marcado);
        $toleranciaDespuesEntrada = $this->timeToMinutes($tolerancias->tolerancia_maxima_entrada);
        $toleranciaAntesSalida = $this->timeToMinutes($tolerancias->antelacion_salida);
        $toleranciaDespuesSalida = $this->timeToMinutes($tolerancias->maximo_salida);

        // Definir rangos exactos
        $horaEntradaAsignadaObj = Carbon::parse($fecha . ' ' . $horaEntradaAsignada->format('H:i:s'));
        $horaSalidaAsignadaObj = Carbon::parse($fecha . ' ' . $horaSalidaAsignada->format('H:i:s'));

        $rangoMinEntrada = $horaEntradaAsignadaObj->copy()->subMinutes($toleranciaAntesEntrada);
        $rangoMaxEntrada = $horaEntradaAsignadaObj->copy()->addMinutes($toleranciaDespuesEntrada);
        
        $rangoMinSalida = $horaSalidaAsignadaObj->copy()->subMinutes($toleranciaAntesSalida);
        $rangoMaxSalida = $horaSalidaAsignadaObj->copy()->addMinutes($toleranciaDespuesSalida);

        $marcacionesOrdenadas = $marcacionesDia->sortBy('fecha_marcacion');

        $entrada = null;
        $salida = null;
        $minutosAtraso = 0;
        $minutosSalidaAnticipada = 0;

        foreach ($marcacionesOrdenadas as $marcacion) {
            $horaMarcacion = Carbon::parse($marcacion->fecha_marcacion);
            $hora = $horaMarcacion->format('H:i');

            // Verificar entrada
            if (!$entrada) {
                if ($horaMarcacion->between($rangoMinEntrada, $rangoMaxEntrada)) {
                    $entrada = $hora;

                    // CALCULAR MINUTOS DE ATRASO - ENFOQUE ROBUSTO
                    if ($horaMarcacion->gt($horaEntradaAsignadaObj)) {
                        $diferenciaSegundos = $horaMarcacion->timestamp - $horaEntradaAsignadaObj->timestamp;
                        $minutosAtrasoTotal = max(0, round($diferenciaSegundos / 60));
                        
                        if ($minutosAtrasoTotal > $minutos_tolerancia_entrada) {
                            $minutosAtraso = $minutosAtrasoTotal - $minutos_tolerancia_entrada;
                        }
                    }
                    continue;
                }
            }

            // Verificar salida
            if ($entrada && !$salida) {
                $horaEntrada = Carbon::parse($fecha . ' ' . $entrada);
                if ($horaMarcacion->between($rangoMinSalida, $rangoMaxSalida) && 
                    $horaMarcacion->gt($horaEntrada)) {
                    $salida = $hora;

                    // CALCULAR MINUTOS DE SALIDA ANTICIPADA - ENFOQUE ROBUSTO
                    if ($horaMarcacion->lt($horaSalidaAsignadaObj)) {
                        $diferenciaSegundos = $horaSalidaAsignadaObj->timestamp - $horaMarcacion->timestamp;
                        $minutosAnticipadosTotal = max(0, round($diferenciaSegundos / 60));
                        
                        if ($minutosAnticipadosTotal > $minutos_tolerancia_salida) {
                            $minutosSalidaAnticipada = $minutosAnticipadosTotal - $minutos_tolerancia_salida;
                        }
                    }
                    continue;
                }
            }
        }

        return [
            'entrada' => $entrada,
            'salida' => $salida,
            'minutos_atraso' => $minutosAtraso,
            'minutos_salida_anticipada' => $minutosSalidaAnticipada
        ];
    }

    private function calcularEstadisticasGenerales($reporteData, $diasPeriodo)
    {
        $totalDiasAsistencia = 0;
        $totalDiasPermiso = 0;
        $totalDiasFalta = 0;
        $totalDiasNoAsignados = 0;
        $totalMinutosAtraso = 0;
        $totalMinutosSalidaAnticipada = 0;
        $totalDiasConAtraso = 0;
        $totalDiasConSalidaAnticipada = 0;

        foreach ($reporteData as $miembro) {
            $totalDiasAsistencia += $miembro['estadisticas']['dias_asistencia'];
            $totalDiasPermiso += $miembro['estadisticas']['dias_permiso'];
            $totalDiasFalta += $miembro['estadisticas']['dias_falta'];
            $totalDiasNoAsignados += $miembro['estadisticas']['dias_no_asignados'];
            $totalMinutosAtraso += $miembro['estadisticas']['total_minutos_atraso'];
            $totalMinutosSalidaAnticipada += $miembro['estadisticas']['total_minutos_salida_anticipada'];
            $totalDiasConAtraso += $miembro['estadisticas']['total_dias_con_atraso'];
            $totalDiasConSalidaAnticipada += $miembro['estadisticas']['total_dias_con_salida_anticipada'];
        }

        return [
            'total_miembros' => count($reporteData),
            'total_dias_periodo' => count($diasPeriodo),
            'total_dias_asistencia' => $totalDiasAsistencia,
            'total_dias_permiso' => $totalDiasPermiso,
            'total_dias_falta' => $totalDiasFalta,
            'total_dias_no_asignados' => $totalDiasNoAsignados,
            'total_minutos_atraso' => $totalMinutosAtraso,
            'total_minutos_salida_anticipada' => $totalMinutosSalidaAnticipada,
            'total_dias_con_atraso' => $totalDiasConAtraso,
            'total_dias_con_salida_anticipada' => $totalDiasConSalidaAnticipada,
            'periodo' => [
                'desde' => Carbon::parse($diasPeriodo[0]['fecha'])->format('d/m/Y'),
                'hasta' => Carbon::parse(end($diasPeriodo)['fecha'])->format('d/m/Y')
            ]
        ];
    }

    // Función auxiliar para convertir tiempo HH:MM:SS a minutos
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

    private function generarPDF($reporteData, $estadisticasGenerales, $fechaDesde, $fechaHasta, $diasPeriodo)
    {
        $pdf = Pdf::loadView('pdf.reporte-mensual', [
            'reporteData' => $reporteData,
            'estadisticasGenerales' => $estadisticasGenerales,
            'fechaGeneracion' => now()->format('d/m/Y H:i:s'),
            'fechaDesde' => $fechaDesde,
            'fechaHasta' => $fechaHasta,
            'diasPeriodo' => $diasPeriodo
        ])->setPaper('a4', 'landscape');

        $nombreArchivo = "reporte_mensual_{$fechaDesde}_a_{$fechaHasta}.pdf";
        
        return $pdf->download($nombreArchivo);
    }
}