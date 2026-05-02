@extends('layouts.admin')

@section('content')
    <div class="content" style="margin-left: 20px">
        <div class="container-fluid">
            <!-- Encabezado -->
            <div class="row mb-3">
                <div class="col-12">
                    <h1><i class="bi bi-calendar-month"></i> Reporte Mensual de Asistencias</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Inicio</a></li>
                            <li class="breadcrumb-item active">Reporte Mensual</li>
                        </ol>
                    </nav>
                </div>
            </div>

            <!-- Filtros -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h3 class="card-title"><i class="bi bi-filter"></i> <b>Seleccionar Período</b></h3>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('reporte.mensual.generar') }}">
                                @csrf
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="fecha_desde">Fecha Desde:</label>
                                            <input type="date" class="form-control" id="fecha_desde" name="fecha_desde" 
                                                   value="{{ $fechaDesde ?? old('fecha_desde') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="fecha_hasta">Fecha Hasta:</label>
                                            <input type="date" class="form-control" id="fecha_hasta" name="fecha_hasta" 
                                                   value="{{ $fechaHasta ?? old('fecha_hasta') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group" style="padding-top: 25px;">
                                            <button type="submit" name="ver_reporte" class="btn btn-primary">
                                                <i class="bi bi-search"></i> Ver Reporte
                                            </button>
                                            <button type="submit" name="generar_pdf" class="btn btn-danger">
                                                <i class="bi bi-file-pdf"></i> Generar PDF
                                            </button>
                                            <button type="button" class="btn btn-secondary" onclick="limpiarFiltros()">
                                                <i class="bi bi-arrow-clockwise"></i> Limpiar
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Información del Período -->
            @if(isset($diasPeriodo))
            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-info">
                        <strong>Período seleccionado:</strong> 
                        {{ \Carbon\Carbon::parse($fechaDesde)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($fechaHasta)->format('d/m/Y') }} 
                        ({{ count($diasPeriodo) }} días)
                    </div>
                </div>
            </div>
            @endif

            <!-- Tabla de Reporte Horizontal -->
            @if(isset($reporteData) && count($reporteData) > 0)
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-outline card-info">
                        <div class="card-header">
                            <h3 class="card-title"><i class="bi bi-table"></i> <b>Reporte de Asistencias</b></h3>
                        </div>
                        <div class="card-body" style="overflow-x: auto;">
                            <table id="tablaReporte" class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th>Nro</th>
                                        <th>Nombre</th>
                                        <th>CI</th>
                                        <th>Grado</th>
                                        <th>División</th>
                                        <th>Días Asist.</th>
                                        <th>Asignación</th>
                                        @foreach($diasPeriodo as $dia)
                                        <th style="writing-mode: vertical-lr; transform: rotate(180deg); white-space: nowrap; font-size: 12px;">
                                            {{ $dia['dia'] }}<br><small>{{ $dia['dia_semana'] }}</small>
                                        </th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($reporteData as $index => $miembro)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $miembro['nombre'] }}</td>
                                        <td>{{ $miembro['ci'] }}</td>
                                        <td>{{ $miembro['grado'] }}</td>
                                        <td>{{ $miembro['division'] }}</td>
                                        <td class="text-center">
                                            <span class="badge badge-primary">{{ $miembro['total_dias_con_marcaciones'] }}</span>
                                        </td>
                                        <td>
                                            {{ \Carbon\Carbon::parse($miembro['horario_asignado']['entrada'])->format('H:i') }} - 
                                            {{ \Carbon\Carbon::parse($miembro['horario_asignado']['salida'])->format('H:i') }}
                                        </td>
                                        @foreach($diasPeriodo as $dia)
                                        <td style="font-size: 11px; text-align: center;">
                                            {{ $miembro['asistencias_por_dia'][$dia['fecha']] ?? '--:-- - --:--' }}
                                        </td>
                                        @endforeach
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            @elseif(isset($reporteData) && count($reporteData) === 0)
            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-warning text-center">
                        <i class="bi bi-exclamation-triangle"></i> No hay datos de asistencia para el período seleccionado.
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>

    <script>
        function limpiarFiltros() {
            document.getElementById('fecha_desde').value = '';
            document.getElementById('fecha_hasta').value = '';
        }

        $(document).ready(function() {
            $('#tablaReporte').DataTable({
                "pageLength": 10,
                "scrollX": true,
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json"
                }
            });
        });
    </script>
@endsection