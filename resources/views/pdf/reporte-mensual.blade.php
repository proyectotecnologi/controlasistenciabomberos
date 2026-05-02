<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reporte Mensual de Asistencias</title>
    <style>
        @page {
            margin: 10px;
            size: landscape;
        }
        body { 
            font-family: Arial, sans-serif; 
            font-size: 7px; 
            line-height: 1.1; 
            margin: 0; 
            padding: 5px; 
        }
        .header { 
            text-align: center; 
            margin-bottom: 8px; 
            border-bottom: 2px solid #333; 
            padding-bottom: 4px; 
        }
        .header h1 { 
            margin: 0; 
            color: #333; 
            font-size: 12px; 
        }
        .header .subtitle { 
            color: #666; 
            font-size: 9px; 
            margin: 1px 0; 
        }
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-bottom: 8px; 
            font-size: 6px;
        }
        th, td { 
            border: 1px solid #ddd; 
            padding: 2px; 
            text-align: center; 
            vertical-align: middle;
        }
        th { 
            background-color: #f2f2f2; 
            font-weight: bold; 
            font-size: 6px;
        }
        .fixed-column {
            position: sticky;
            left: 0;
            background-color: white;
            z-index: 10;
            border-right: 2px solid #333;
        }
        .dia-header {
            writing-mode: vertical-rl;
            white-space: nowrap;
            padding: 4px 1px;
            font-size: 5px;
            background-color: #f8f9fa;
        }
        .asistencia-cell {
            font-size: 5px;
            line-height: 1;
            padding: 1px;
        }
        
        /* Estilos para los diferentes estados */
        .completo {
            background-color: #d4edda; /* Verde claro - asistencia completa */
            color: #155724;
        }
        .completo-con-atraso {
            background-color: #ffebee; /* Rojo claro - asistencia con atraso */
            color: #c62828;
            font-weight: bold;
        }
        .solo-entrada {
            background-color: #fff3cd; /* Amarillo - solo entrada */
            color: #856404;
        }
        .solo-entrada-con-atraso {
            background-color: #ffe0b2; /* Naranja - solo entrada con atraso */
            color: #e65100;
            font-weight: bold;
        }
        .solo-salida {
            background-color: #e3f2fd; /* Azul claro - solo salida */
            color: #1565c0;
        }
        .solo-salida-con-anticipada {
            background-color: #ffecb3; /* Amarillo oscuro - solo salida con anticipada */
            color: #ff8f00;
            font-weight: bold;
        }
        .falta {
            background-color: #f8d7da; /* Rojo - falta */
            color: #721c24;
            font-weight: bold;
        }
        .permiso {
            background-color: #e8f5e8; /* Verde muy claro - permiso */
            color: #2e7d32;
            font-weight: bold;
        }
        .no-asignado {
            background-color: #f5f5f5; /* Gris - no asignado */
            color: #616161;
            font-style: italic;
        }

        .estadisticas { 
            display: flex; 
            justify-content: space-between; 
            margin-bottom: 8px; 
            flex-wrap: wrap; 
            gap: 3px;
        }
        .estadistica-item { 
            text-align: center; 
            padding: 4px; 
            background-color: #e9ecef; 
            border-radius: 2px; 
            flex: 1; 
            min-width: 70px; 
        }
        .estadistica-item h4 { 
            margin: 0; 
            font-size: 9px; 
            color: #333; 
        }
        .estadistica-item p { 
            margin: 1px 0 0 0; 
            color: #666; 
            font-size: 7px; 
        }
        .footer { 
            text-align: center; 
            margin-top: 10px; 
            color: #666; 
            font-size: 7px; 
            border-top: 1px solid #ddd; 
            padding-top: 4px; 
        }
        .nombre-cell {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 60px;
        }
        .info-miembro {
            font-size: 5px;
            line-height: 1;
        }
        .leyenda {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            margin: 8px 0;
            gap: 3px;
        }
        .leyenda-item {
            display: flex;
            align-items: center;
            margin: 0 3px;
            font-size: 6px;
        }
        .leyenda-color {
            width: 8px;
            height: 8px;
            margin-right: 2px;
            border: 1px solid #999;
        }
        
        /* Nuevos estilos para estadísticas de atrasos */
        .estadistica-atraso {
            background-color: #ffebee;
        }
        .estadistica-salida-anticipada {
            background-color: #fff3e0;
        }
        .estadistica-dias-atraso {
            background-color: #fce4ec;
        }
        .estadistica-dias-salida-anticipada {
            background-color: #fff8e1;
        }
        
        /* Estilos para columnas de estadísticas */
        .columna-atraso {
            background-color: #ffebee;
            font-weight: bold;
        }
        .columna-salida-anticipada {
            background-color: #fff3e0;
            font-weight: bold;
        }
        .columna-dias-atraso {
            background-color: #fce4ec;
        }
        .columna-dias-salida-anticipada {
            background-color: #fff8e1;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>REPORTE MENSUAL DE ASISTENCIAS - CONTROL DE ATRASOS</h1>
        <div class="subtitle">Período: {{ $estadisticasGenerales['periodo']['desde'] }} - {{ $estadisticasGenerales['periodo']['hasta'] }}</div>
        <div class="subtitle">Generado: {{ $fechaGeneracion }}</div>
    </div>

    <!-- Leyenda Mejorada -->
    <div class="leyenda">
        <div class="leyenda-item">
            <div class="leyenda-color" style="background-color: #d4edda;"></div>
            <span>Asistencia Completa</span>
        </div>
        <div class="leyenda-item">
            <div class="leyenda-color" style="background-color: #ffebee;"></div>
            <span>Completo con Atraso</span>
        </div>
        <div class="leyenda-item">
            <div class="leyenda-color" style="background-color: #fff3cd;"></div>
            <span>Solo Entrada</span>
        </div>
        <div class="leyenda-item">
            <div class="leyenda-color" style="background-color: #ffe0b2;"></div>
            <span>Entrada con Atraso</span>
        </div>
        <div class="leyenda-item">
            <div class="leyenda-color" style="background-color: #e3f2fd;"></div>
            <span>Solo Salida</span>
        </div>
        <div class="leyenda-item">
            <div class="leyenda-color" style="background-color: #ffecb3;"></div>
            <span>Salida Anticipada</span>
        </div>
        <div class="leyenda-item">
            <div class="leyenda-color" style="background-color: #f8d7da;"></div>
            <span>Falta</span>
        </div>
        <div class="leyenda-item">
            <div class="leyenda-color" style="background-color: #e8f5e8;"></div>
            <span>Permiso</span>
        </div>
        <div class="leyenda-item">
            <div class="leyenda-color" style="background-color: #f5f5f5;"></div>
            <span>No Asignado</span>
        </div>
    </div>

    <!-- Estadísticas Generales Mejoradas -->
    <div class="estadisticas">
        <div class="estadistica-item">
            <h4>{{ $estadisticasGenerales['total_miembros'] }}</h4>
            <p>Total Miembros</p>
        </div>
        <div class="estadistica-item">
            <h4>{{ $estadisticasGenerales['total_dias_periodo'] }}</h4>
            <p>Días del Período</p>
        </div>
        <div class="estadistica-item">
            <h4>{{ $estadisticasGenerales['total_dias_asistencia'] }}</h4>
            <p>Días de Asistencia</p>
        </div>
        <div class="estadistica-item">
            <h4>{{ $estadisticasGenerales['total_dias_permiso'] }}</h4>
            <p>Días con Permiso</p>
        </div>
        <div class="estadistica-item">
            <h4>{{ $estadisticasGenerales['total_dias_falta'] }}</h4>
            <p>Días de Falta</p>
        </div>
        <div class="estadistica-item estadistica-atraso">
            <h4>{{ $estadisticasGenerales['total_minutos_atraso'] }}</h4>
            <p>Total Min. Atraso</p>
        </div>
        <div class="estadistica-item estadistica-salida-anticipada">
            <h4>{{ $estadisticasGenerales['total_minutos_salida_anticipada'] }}</h4>
            <p>Total Min. Sal. Ant.</p>
        </div>
        <div class="estadistica-item estadistica-dias-atraso">
            <h4>{{ $estadisticasGenerales['total_dias_con_atraso'] }}</h4>
            <p>Días con Atraso</p>
        </div>
        <div class="estadistica-item estadistica-dias-salida-anticipada">
            <h4>{{ $estadisticasGenerales['total_dias_con_salida_anticipada'] }}</h4>
            <p>Días con Sal. Ant.</p>
        </div>
    </div>

    <!-- Tabla de Reporte Mejorada -->
    <table>
        <thead>
            <tr>
                <!-- Columnas fijas -->
                <th class="fixed-column">Nro</th>
                <th class="fixed-column">Nombre</th>
                <th class="fixed-column">CI</th>
                <th class="fixed-column">Grado</th>
                <th class="fixed-column">Horario</th>
                <th class="fixed-column">Asist.</th>
                <th class="fixed-column">Perm.</th>
                <th class="fixed-column">Falta</th>
                <th class="fixed-column">N/Asig</th>
                <!-- Nuevas columnas de estadísticas -->
                <th class="fixed-column columna-atraso">Min. Atraso</th>
                <th class="fixed-column columna-salida-anticipada">Min. Sal. Ant.</th>
                <th class="fixed-column columna-dias-atraso">Días Atraso</th>
                <th class="fixed-column columna-dias-salida-anticipada">Días Sal. Ant.</th>
                
                <!-- Columnas de días -->
                @foreach($diasPeriodo as $dia)
                <th class="dia-header">
                    {{ $dia['dia'] }}<br>{{ $dia['dia_semana'] }}
                </th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($reporteData as $index => $miembro)
            <tr>
                <!-- Columnas fijas -->
                <td class="fixed-column">{{ $index + 1 }}</td>
                <td class="fixed-column nombre-cell">{{ $miembro['nombre'] }}</td>
                <td class="fixed-column">{{ $miembro['ci'] }}</td>
                <td class="fixed-column">{{ $miembro['grado'] }}</td>
                <td class="fixed-column info-miembro">
                    {{ \Carbon\Carbon::parse($miembro['horario_asignado']['entrada'])->format('H:i') }}<br>
                    {{ \Carbon\Carbon::parse($miembro['horario_asignado']['salida'])->format('H:i') }}
                </td>
                <td class="fixed-column" style="background-color: #d4edda;">{{ $miembro['estadisticas']['dias_asistencia'] }}</td>
                <td class="fixed-column" style="background-color: #e8f5e8;">{{ $miembro['estadisticas']['dias_permiso'] }}</td>
                <td class="fixed-column" style="background-color: #f8d7da;">{{ $miembro['estadisticas']['dias_falta'] }}</td>
                <td class="fixed-column" style="background-color: #f5f5f5;">{{ $miembro['estadisticas']['dias_no_asignados'] }}</td>
                
                <!-- Nuevas columnas de estadísticas individuales -->
                <td class="fixed-column columna-atraso">
                    {{ $miembro['estadisticas']['total_minutos_atraso'] }} min
                </td>
                <td class="fixed-column columna-salida-anticipada">
                    {{ $miembro['estadisticas']['total_minutos_salida_anticipada'] }} min
                </td>
                <td class="fixed-column columna-dias-atraso">
                    {{ $miembro['estadisticas']['total_dias_con_atraso'] }}
                </td>
                <td class="fixed-column columna-dias-salida-anticipada">
                    {{ $miembro['estadisticas']['total_dias_con_salida_anticipada'] }}
                </td>
                
                <!-- Columnas de asistencias por día -->
                @foreach($diasPeriodo as $dia)
                    @php
                        $asistencia = $miembro['asistencias_por_dia'][$dia['fecha']] ?? null;
                        $clase = $asistencia['clase'] ?? 'no-data';
                        $texto = $asistencia['texto'] ?? '--';
                        $motivo = $asistencia['motivo'] ?? '';
                        $minutosAtraso = $asistencia['minutos_atraso'] ?? 0;
                        $minutosSalidaAnticipada = $asistencia['minutos_salida_anticipada'] ?? 0;
                    @endphp
                <td class="asistencia-cell {{ $clase }}" title="
                    @if($minutosAtraso > 0)
                    Atraso: {{ $minutosAtraso }} min
                    @endif
                    @if($minutosSalidaAnticipada > 0)
                    {{ $minutosAtraso > 0 ? ' | ' : '' }}Salida anticipada: {{ $minutosSalidaAnticipada }} min
                    @endif
                    {{ $motivo ? ' | ' . $motivo : '' }}
                ">
                    {{ $texto }}
                </td>
                @endforeach
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Resumen de Tolerancias Aplicadas -->
    <div style="margin-top: 10px; padding: 5px; background-color: #f8f9fa; border-radius: 3px; font-size: 6px;">
        <strong>Configuración de Tolerancias Aplicadas:</strong> 
        Atraso permitido: 10 min | Salida anticipada permitida: 15 min | 
        Tolerancia máxima entrada: 60 min | Tolerancia máxima salida: 60 min
    </div>

    <div class="footer">
        Sistema de Marcaciones - Generado el {{ $fechaGeneracion }} | 
        Reporte incluye control de atrasos y salidas anticipadas
    </div>
</body>
</html>