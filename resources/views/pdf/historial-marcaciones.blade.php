<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Historial de Asistencias - {{ $miembro->nombre_apellido ?? 'Miembro' }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 10px;
            line-height: 1.3;
            margin: 0;
            padding: 15px;
        }
        .header {
            text-align: center;
            margin-bottom: 15px;
            border-bottom: 2px solid #333;
            padding-bottom: 8px;
        }
        .header h1 {
            margin: 0;
            color: #333;
            font-size: 16px;
        }
        .header .subtitle {
            color: #666;
            font-size: 12px;
            margin: 3px 0;
        }
        .info-miembro {
            background-color: #f8f9fa;
            padding: 12px;
            border-radius: 4px;
            margin-bottom: 15px;
        }
        .info-miembro h3 {
            margin: 0 0 8px 0;
            color: #333;
            font-size: 12px;
        }
        .estadisticas {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            flex-wrap: wrap;
            gap: 5px;
        }
        .estadistica-item {
            text-align: center;
            padding: 8px;
            background-color: #e9ecef;
            border-radius: 4px;
            flex: 1;
            min-width: 80px;
        }
        .estadistica-item h4 {
            margin: 0;
            font-size: 14px;
            color: #333;
        }
        .estadistica-item p {
            margin: 3px 0 0 0;
            color: #666;
            font-size: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
            font-size: 9px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 6px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
            font-size: 9px;
        }
        .badge {
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 8px;
            font-weight: bold;
            display: inline-block;
            margin: 1px;
        }
        .badge-success { background-color: #28a745; color: white; }
        .badge-info { background-color: #17a2b8; color: white; }
        .badge-warning { background-color: #ffc107; color: black; }
        .badge-danger { background-color: #dc3545; color: white; }
        .badge-secondary { background-color: #6c757d; color: white; }
        .badge-primary { background-color: #007bff; color: white; }
        .badge-light { background-color: #f8f9fa; color: #212529; }
        .badge-atraso { background-color: #dc3545; color: white; }
        .badge-salida-anticipada { background-color: #fd7e14; color: white; }
        
        .marcaciones-lista {
            display: flex;
            flex-wrap: wrap;
            gap: 1px;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            color: #666;
            font-size: 8px;
            border-top: 1px solid #ddd;
            padding-top: 8px;
        }
        .info-table {
            width: 100%;
            border: none;
            font-size: 10px;
        }
        .info-table td {
            border: none;
            padding: 1px 3px;
        }
        .estado-completo { background-color: #d4edda; }
        .estado-solo-entrada { background-color: #fff3cd; }
        .estado-solo-salida { background-color: #cce7ff; }
        .estado-falta { background-color: #f8d7da; }
        .estado-permiso { background-color: #e2e3e5; }
        .estado-no-asignado { background-color: #f8f9fa; }
        .observaciones {
            font-size: 8px;
            color: #666;
            font-style: italic;
        }
        .dias-asignados {
            margin: 8px 0;
            padding: 6px;
            background-color: #e7f3ff;
            border-radius: 3px;
            font-size: 9px;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        
        /* Nuevos estilos para atrasos y salidas anticipadas */
        .minutos-cell {
            font-weight: bold;
            text-align: center;
        }
        .atraso-cell { background-color: #ffebee; }
        .salida-anticipada-cell { background-color: #fff3e0; }
        
        .leyenda {
            margin-top: 10px;
            padding: 8px;
            background-color: #f8f9fa;
            border-radius: 4px;
            font-size: 8px;
        }
        .marcacion-entrada { background-color: #d4edda; }
        .marcacion-salida { background-color: #cce7ff; }
        .marcacion-extra { background-color: #f8f9fa; }
    </style>
</head>
<body>
    <div class="header">
        <h1>HISTORIAL DE ASISTENCIAS Y PERMISOS</h1>
        <div class="subtitle">{{ $rangoFechas['titulo'] ?? 'Todo el historial' }}</div>
        <div class="subtitle">Generado: {{ $fechaGeneracion ?? now()->format('d/m/Y H:i:s') }}</div>
    </div>

    <!-- Información del Miembro -->
    <div class="info-miembro">
        <h3>INFORMACIÓN DEL MIEMBRO</h3>
        <table class="info-table">
            <tr>
                <td><strong>Nombre:</strong> {{ $miembro->nombre_apellido ?? 'N/A' }}</td>
                <td><strong>Grado:</strong> {{ $miembro->grado ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td><strong>Cargo:</strong> {{ $miembro->cargo ?? 'N/A' }}</td>
                <td><strong>CI:</strong> {{ $miembro->ci ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td><strong>División:</strong> {{ $miembro->division_o_dependencia ?? 'N/A' }}</td>
                <td><strong>Horario:</strong> 
                    {{ isset($miembro->asignacion->hora_entrada) ? \Carbon\Carbon::parse($miembro->asignacion->hora_entrada)->format('H:i') : 'N/A' }} - 
                    {{ isset($miembro->asignacion->hora_salida) ? \Carbon\Carbon::parse($miembro->asignacion->hora_salida)->format('H:i') : 'N/A' }}
                </td>
            </tr>
        </table>

        <!-- Días Asignados -->
        @if(isset($miembro->diasAsignados) && $miembro->diasAsignados->count() > 0)
        <div class="dias-asignados">
            <strong>Días asignados:</strong> 
            {{ $miembro->diasAsignados->pluck('name')->map(function($dia) {
                return ucfirst($dia);
            })->implode(', ') }}
        </div>
        @endif
    </div>

    <!-- Estadísticas Mejoradas con Atrasos -->
    <div class="estadisticas">
        <div class="estadistica-item">
            <h4>{{ $estadisticas['total_dias'] ?? 0 }}</h4>
            <p>Total días período</p>
        </div>
        <div class="estadistica-item">
            <h4>{{ $estadisticas['dias_asignados'] ?? 0 }}</h4>
            <p>Días asignados</p>
        </div>
        <div class="estadistica-item">
            <h4>{{ $estadisticas['dias_trabajados'] ?? 0 }}</h4>
            <p>Días trabajados</p>
        </div>
        <div class="estadistica-item">
            <h4>{{ $estadisticas['dias_permiso'] ?? 0 }}</h4>
            <p>Días con permiso</p>
        </div>
        <div class="estadistica-item">
            <h4>{{ $estadisticas['dias_falta'] ?? 0 }}</h4>
            <p>Faltas</p>
        </div>
        <div class="estadistica-item">
            <h4>{{ $estadisticas['total_minutos_atraso'] ?? 0 }}</h4>
            <p>Min. atraso total</p>
        </div>
        <div class="estadistica-item">
            <h4>{{ $estadisticas['total_minutos_salida_anticipada'] ?? 0 }}</h4>
            <p>Min. salida anticipada</p>
        </div>
        <div class="estadistica-item">
            <h4>{{ $estadisticas['porcentaje_asistencia'] ?? 0 }}%</h4>
            <p>% Asistencia</p>
        </div>
    </div>

    <!-- Tabla de Asistencias Mejorada con Atrasos -->
    @if(isset($reporteCompleto) && count($reporteCompleto) > 0)
    <table>
        <thead>
            <tr>
                <th width="4%">Nro</th>
                <th width="10%">Fecha</th>
                <th width="8%">Día</th>
                <th width="6%">Asignado</th>
                <th width="8%">Entrada</th>
                <th width="8%">Salida</th>
                <th width="6%">Atraso</th>
                <th width="8%">Sal. Ant.</th>
                <th width="6%">Total</th>
                <th width="12%">Estado</th>
                <th width="24%">Observaciones</th>
            </tr>
        </thead>
        <tbody>
            @php
                $counter = 1;
            @endphp
            @foreach ($reporteCompleto as $fecha => $dia)
                @php
                    // Determinar clase CSS según estado
                    $claseEstado = '';
                    switch($dia['estado']) {
                        case 'completo': $claseEstado = 'estado-completo'; break;
                        case 'solo_entrada': $claseEstado = 'estado-solo-entrada'; break;
                        case 'solo_salida': $claseEstado = 'estado-solo-salida'; break;
                        case 'falta': $claseEstado = 'estado-falta'; break;
                        case 'permiso': $claseEstado = 'estado-permiso'; break;
                        case 'no_asignado': $claseEstado = 'estado-no-asignado'; break;
                    }
                @endphp
                <tr class="{{ $claseEstado }}">
                    <td class="text-center">{{ $counter++ }}</td>
                    <td>{{ $dia['fecha_formato'] ?? 'N/A' }}</td>
                    <td>{{ $dia['dia_semana'] ?? 'N/A' }}</td>
                    <td class="text-center">
                        @if($dia['dia_asignado'])
                            <span class="badge badge-success">SÍ</span>
                        @else
                            <span class="badge badge-light">NO</span>
                        @endif
                    </td>
                    <td class="text-center">
                        @if (!empty($dia['entrada']))
                            <span class="badge badge-success">{{ $dia['entrada'] }}</span>
                        @else
                            <span class="badge badge-danger">--:--</span>
                        @endif
                    </td>
                    <td class="text-center">
                        @if (!empty($dia['salida']))
                            <span class="badge badge-info">{{ $dia['salida'] }}</span>
                        @else
                            <span class="badge badge-warning">--:--</span>
                        @endif
                    </td>
                    <td class="text-center minutos-cell atraso-cell">
                        @if($dia['minutos_atraso'] > 0)
                            <span class="badge badge-atraso">{{ $dia['minutos_atraso'] }} min</span>
                        @else
                            <span class="badge badge-success">0</span>
                        @endif
                    </td>
                    <td class="text-center minutos-cell salida-anticipada-cell">
                        @if($dia['minutos_salida_anticipada'] > 0)
                            <span class="badge badge-salida-anticipada">{{ $dia['minutos_salida_anticipada'] }} min</span>
                        @else
                            <span class="badge badge-success">0</span>
                        @endif
                    </td>
                    <td class="text-center">
                        <span class="badge badge-secondary">{{ $dia['total_marcaciones'] ?? 0 }}</span>
                    </td>
                    <td class="text-center">
                        @php
                            $estadoBadge = '';
                            switch($dia['estado']) {
                                case 'completo':
                                    $estadoBadge = '<span class="badge badge-success">Completo</span>';
                                    break;
                                case 'solo_entrada':
                                    $estadoBadge = '<span class="badge badge-warning">Solo entrada</span>';
                                    break;
                                case 'solo_salida':
                                    $estadoBadge = '<span class="badge badge-info">Solo salida</span>';
                                    break;
                                case 'falta':
                                    $estadoBadge = '<span class="badge badge-danger">Falta</span>';
                                    break;
                                case 'permiso':
                                    $estadoBadge = '<span class="badge badge-primary">Permiso</span>';
                                    break;
                                case 'no_asignado':
                                    $estadoBadge = '<span class="badge badge-light">No asignado</span>';
                                    break;
                                default:
                                    $estadoBadge = '<span class="badge badge-secondary">' . $dia['estado'] . '</span>';
                            }
                        @endphp
                        {!! $estadoBadge !!}
                    </td>
                    <td class="observaciones">
                        {{ $dia['observaciones'] ?? '' }}
                        @if(isset($dia['todas_marcaciones']) && count($dia['todas_marcaciones']) > 0)
                            <br>
                            <div class="marcaciones-lista">
                                @foreach($dia['todas_marcaciones'] as $marcacion)
                                    @php
                                        $claseMarcacion = 'marcacion-extra';
                                        if ($marcacion['tipo'] === 'entrada') $claseMarcacion = 'marcacion-entrada';
                                        if ($marcacion['tipo'] === 'salida') $claseMarcacion = 'marcacion-salida';
                                    @endphp
                                    <span class="badge {{ $claseMarcacion }}" title="{{ $marcacion['tipo'] }}">
                                        {{ $marcacion['hora'] }}
                                    </span>
                                @endforeach
                            </div>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <div style="text-align: center; padding: 15px; background-color: #f8f9fa; border-radius: 4px;">
        <p style="margin: 0; color: #666;">No hay datos de asistencia para el rango de fechas seleccionado.</p>
    </div>
    @endif

    <!-- Leyenda de Estados Mejorada -->
    <div class="leyenda">
        <strong>Leyenda de estados y marcaciones:</strong><br>
        <span class="badge badge-success">Completo</span> - Asistencia completa |
        <span class="badge badge-warning">Solo entrada</span> - Solo registró entrada |
        <span class="badge badge-info">Solo salida</span> - Solo registró salida |
        <span class="badge badge-danger">Falta</span> - No asistió en día asignado |
        <span class="badge badge-primary">Permiso</span> - Con permiso autorizado |
        <span class="badge badge-light">No asignado</span> - No es día de trabajo |
        <span class="badge badge-atraso">Atraso</span> - Minutos de atraso |
        <span class="badge badge-salida-anticipada">Sal. Ant.</span> - Minutos de salida anticipada
        <br>
        <strong>Marcaciones:</strong>
        <span class="badge marcacion-entrada">Entrada</span> -
        <span class="badge marcacion-salida">Salida</span> -
        <span class="badge marcacion-extra">Extra</span>
    </div>

    <div class="footer">
        Sistema de Marcaciones - Generado el {{ $fechaGeneracion ?? now()->format('d/m/Y H:i:s') }}
    </div>
</body>
</html>