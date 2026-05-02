<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Miembro;
use App\Models\Marcaciones;
use App\Models\Permiso;
use App\Models\Tolerancia;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class PdfAsistenciaController extends Controller
{
    public function generarPDF($id, Request $request)
    {
        \Log::info('=== INICIANDO GENERACIÓN PDF ===');
        \Log::info('ID recibido: ' . $id);

        try {
            // Obtener el miembro por ID con todas las relaciones
            $miembro = Miembro::with(['asignacion', 'diasAsignados', 'permisos'])->find($id);

            if (!$miembro) {
                \Log::error('Miembro no encontrado con ID: ' . $id);
                return response()->json(['error' => 'Miembro no encontrado'], 404);
            }

            \Log::info('Miembro encontrado: ' . $miembro->nombre_apellido);

            // Obtener fechas del filtro
            $fechaDesde = $request->get('fecha_desde');
            $fechaHasta = $request->get('fecha_hasta');

            \Log::info('Fechas desde: ' . $fechaDesde . ', hasta: ' . $fechaHasta);

            // Obtener marcaciones con filtros
            $query = Marcaciones::where('carnet', $miembro->ci)
                ->orderBy('fecha_marcacion', 'asc');

            if ($fechaDesde) {
                $query->whereDate('fecha_marcacion', '>=', $fechaDesde);
            }

            if ($fechaHasta) {
                $query->whereDate('fecha_marcacion', '<=', $fechaHasta);
            }

            $marcacionesRaw = $query->get();
            \Log::info('Marcaciones encontradas: ' . $marcacionesRaw->count());

            // Obtener permisos en el período
            $permisos = $this->obtenerPermisosEnPeriodo($miembro, $fechaDesde, $fechaHasta);

            // Generar días del período
            $diasPeriodo = $this->generarDiasPeriodo($fechaDesde, $fechaHasta);

            // Procesar las marcaciones con permisos y días asignados
            $reporteCompleto = $this->procesarReporteCompleto($miembro, $marcacionesRaw, $permisos, $diasPeriodo, $fechaDesde, $fechaHasta);

            // Estadísticas
            $estadisticas = $this->calcularEstadisticas($reporteCompleto);

            // Fechas para el título
            $rangoFechas = $this->generarRangoFechas($fechaDesde, $fechaHasta);

            \Log::info('Preparando datos para PDF');

            // Datos para la vista
            $data = [
                'miembro' => $miembro,
                'reporteCompleto' => $reporteCompleto,
                'estadisticas' => $estadisticas,
                'rangoFechas' => $rangoFechas,
                'diasPeriodo' => $diasPeriodo,
                'fechaGeneracion' => now()->format('d/m/Y H:i:s')
            ];

            \Log::info('Generando PDF con DomPDF');

            // Generar PDF
            $pdf = Pdf::loadView('pdf.historial-marcaciones', $data);

            \Log::info('PDF generado exitosamente');

            // Nombre del archivo
            $nombreArchivo = "historial_marcaciones_{$miembro->ci}_{$rangoFechas['nombre_archivo']}.pdf";

            return $pdf->download($nombreArchivo);

        } catch (\Exception $e) {
            \Log::error('Error generando PDF: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            return response()->json(['error' => $e->getMessage()], 500);
        }
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

    private function procesarReporteCompleto($miembro, $marcacionesRaw, $permisos, $diasPeriodo, $fechaDesde, $fechaHasta)
    {
        $reporte = [];
        
        // Obtener días asignados del miembro
        $diasAsignados = $miembro->diasAsignados->pluck('name')->map(function($dia) {
            return strtolower($dia);
        })->toArray();

        // Procesar marcaciones por día
        $marcacionesPorDia = $marcacionesRaw->groupBy(function($marcacion) {
            return Carbon::parse($marcacion->fecha_marcacion)->format('Y-m-d');
        });

        foreach ($diasPeriodo as $diaInfo) {
            $fecha = $diaInfo['fecha'];
            $diaSemana = strtolower($diaInfo['dia_semana_completo']);
            
            // Verificar si es día asignado
            $esDiaAsignado = in_array($diaSemana, $diasAsignados);
            
            // Verificar si tiene permiso
            $permiso = $this->obtenerPermisoParaFecha($permisos, $fecha);
            
            // Obtener marcaciones del día
            $marcacionesDia = $marcacionesPorDia[$fecha] ?? collect();
            
            // Procesar asistencia con tolerancias
            $asistencia = $this->procesarAsistenciaDiaConTolerancias($marcacionesDia, $miembro, $fecha);
            
            // Determinar estado
            $estado = $this->determinarEstado($asistencia, $permiso, $esDiaAsignado);

            $reporte[$fecha] = [
                'fecha' => $fecha,
                'fecha_formato' => Carbon::parse($fecha)->translatedFormat('d \d\e F \d\e Y'),
                'dia_semana' => $diaInfo['dia_semana_completo'],
                'dia_asignado' => $esDiaAsignado,
                'permiso' => $permiso,
                'entrada' => $asistencia['entrada'],
                'salida' => $asistencia['salida'],
                'marcaciones_extra' => $asistencia['marcaciones_extra'],
                'todas_marcaciones' => $asistencia['todas_marcaciones'],
                'total_marcaciones' => $asistencia['total_marcaciones'],
                'minutos_atraso' => $asistencia['minutos_atraso'],
                'minutos_salida_anticipada' => $asistencia['minutos_salida_anticipada'],
                'estado' => $estado,
                'observaciones' => $this->generarObservaciones($estado, $permiso, $esDiaAsignado, $asistencia)
            ];
        }

        return $reporte;
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
                'marcaciones_extra' => [],
                'todas_marcaciones' => [],
                'total_marcaciones' => 0,
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
        $marcacionesExtra = [];
        $todasMarcaciones = [];
        $minutosAtraso = 0;
        $minutosSalidaAnticipada = 0;

        foreach ($marcacionesOrdenadas as $marcacion) {
            $horaMarcacion = Carbon::parse($marcacion->fecha_marcacion);
            $hora = $horaMarcacion->format('H:i:s');

            $datosMarcacion = [
                'hora' => $hora,
                'tipo' => 'extra'
            ];

            // Verificar entrada
            if (!$entrada) {
                if ($horaMarcacion->between($rangoMinEntrada, $rangoMaxEntrada)) {
                    $datosMarcacion['tipo'] = 'entrada';
                    $entrada = $hora;

                    // CALCULAR MINUTOS DE ATRASO - ENFOQUE ROBUSTO
                    if ($horaMarcacion->gt($horaEntradaAsignadaObj)) {
                        $diferenciaSegundos = $horaMarcacion->timestamp - $horaEntradaAsignadaObj->timestamp;
                        $minutosAtrasoTotal = max(0, round($diferenciaSegundos / 60));
                        
                        if ($minutosAtrasoTotal > $minutos_tolerancia_entrada) {
                            $minutosAtraso = $minutosAtrasoTotal - $minutos_tolerancia_entrada;
                        }
                    }

                    $todasMarcaciones[] = $datosMarcacion;
                    continue;
                }
            }

            // Verificar salida
            if ($entrada && !$salida) {
                $horaEntrada = Carbon::parse($fecha . ' ' . $entrada);
                if ($horaMarcacion->between($rangoMinSalida, $rangoMaxSalida) && 
                    $horaMarcacion->gt($horaEntrada)) {
                    $datosMarcacion['tipo'] = 'salida';
                    $salida = $hora;

                    // CALCULAR MINUTOS DE SALIDA ANTICIPADA - ENFOQUE ROBUSTO
                    if ($horaMarcacion->lt($horaSalidaAsignadaObj)) {
                        $diferenciaSegundos = $horaSalidaAsignadaObj->timestamp - $horaMarcacion->timestamp;
                        $minutosAnticipadosTotal = max(0, round($diferenciaSegundos / 60));
                        
                        if ($minutosAnticipadosTotal > $minutos_tolerancia_salida) {
                            $minutosSalidaAnticipada = $minutosAnticipadosTotal - $minutos_tolerancia_salida;
                        }
                    }

                    $todasMarcaciones[] = $datosMarcacion;
                    continue;
                }
            }

            // Marcación extra
            $marcacionesExtra[] = $hora;
            $todasMarcaciones[] = $datosMarcacion;
        }

        return [
            'entrada' => $entrada,
            'salida' => $salida,
            'marcaciones_extra' => $marcacionesExtra,
            'todas_marcaciones' => $todasMarcaciones,
            'total_marcaciones' => $marcacionesDia->count(),
            'minutos_atraso' => $minutosAtraso,
            'minutos_salida_anticipada' => $minutosSalidaAnticipada
        ];
    }

    private function determinarEstado($asistencia, $permiso, $esDiaAsignado)
    {
        if ($permiso) {
            return 'permiso';
        }

        if (!$esDiaAsignado) {
            return 'no_asignado';
        }

        if ($asistencia['entrada'] && $asistencia['salida']) {
            return 'completo';
        } elseif ($asistencia['entrada']) {
            return 'solo_entrada';
        } elseif ($asistencia['salida']) {
            return 'solo_salida';
        } else {
            return 'falta';
        }
    }

    private function generarObservaciones($estado, $permiso, $esDiaAsignado, $asistencia)
    {
        $observaciones = [];

        switch ($estado) {
            case 'permiso':
                $observaciones[] = $permiso ? "Permiso: " . $permiso->motivo . ($permiso->descripcion ? " - " . $permiso->descripcion : "") : "";
                break;
            case 'no_asignado':
                $observaciones[] = "Día no asignado";
                break;
            case 'falta':
                if ($esDiaAsignado) {
                    $observaciones[] = "Falta";
                }
                break;
            case 'solo_entrada':
                $observaciones[] = "Solo registró entrada";
                break;
            case 'solo_salida':
                $observaciones[] = "Solo registró salida";
                break;
            case 'completo':
                $observaciones[] = "Asistencia completa";
                break;
        }

        // Agregar información de atrasos
        if ($asistencia['minutos_atraso'] > 0) {
            $observaciones[] = "Atraso: " . $asistencia['minutos_atraso'] . " min";
        }

        // Agregar información de salida anticipada
        if ($asistencia['minutos_salida_anticipada'] > 0) {
            $observaciones[] = "Salida anticipada: " . $asistencia['minutos_salida_anticipada'] . " min";
        }

        return implode(' | ', array_filter($observaciones));
    }

    private function calcularEstadisticas($reporteCompleto)
    {
        $totalDias = count($reporteCompleto);
        $diasAsignados = 0;
        $diasTrabajados = 0;
        $diasPermiso = 0;
        $diasFalta = 0;
        $totalMarcaciones = 0;
        $totalMinutosAtraso = 0;
        $totalMinutosSalidaAnticipada = 0;

        foreach ($reporteCompleto as $dia) {
            if ($dia['dia_asignado']) {
                $diasAsignados++;
            }
            
            if ($dia['estado'] === 'completo' || $dia['estado'] === 'solo_entrada' || $dia['estado'] === 'solo_salida') {
                $diasTrabajados++;
            }
            
            if ($dia['estado'] === 'permiso') {
                $diasPermiso++;
            }
            
            if ($dia['estado'] === 'falta') {
                $diasFalta++;
            }
            
            $totalMarcaciones += $dia['total_marcaciones'];
            $totalMinutosAtraso += $dia['minutos_atraso'];
            $totalMinutosSalidaAnticipada += $dia['minutos_salida_anticipada'];
        }

        return [
            'total_dias' => $totalDias,
            'dias_asignados' => $diasAsignados,
            'dias_trabajados' => $diasTrabajados,
            'dias_permiso' => $diasPermiso,
            'dias_falta' => $diasFalta,
            'total_marcaciones' => $totalMarcaciones,
            'total_minutos_atraso' => $totalMinutosAtraso,
            'total_minutos_salida_anticipada' => $totalMinutosSalidaAnticipada,
            'porcentaje_asistencia' => $diasAsignados > 0 ? round(($diasTrabajados / $diasAsignados) * 100, 1) : 0
        ];
    }

    private function generarRangoFechas($fechaDesde, $fechaHasta)
    {
        if ($fechaDesde && $fechaHasta) {
            $desde = Carbon::parse($fechaDesde)->format('d/m/Y');
            $hasta = Carbon::parse($fechaHasta)->format('d/m/Y');
            return [
                'titulo' => "Del $desde al $hasta",
                'nombre_archivo' => "{$fechaDesde}_a_{$fechaHasta}"
            ];
        } else {
            return [
                'titulo' => "Todo el historial",
                'nombre_archivo' => "completo"
            ];
        }
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
}