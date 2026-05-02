@extends('layouts.admin')

@section('content')
    <div class="content" style="margin-left: 20px">
        <h1>Memorándum</h1>

        @if ($message = Session::get('mensaje'))
            <script>
                Swal.fire({
                    title: "Registro exitoso",
                    text: "{{ $message }}",
                    icon: "success"
                });
            </script>
        @endif

        <!-- Filtro por Mes y Año -->
        <div class="row">
            <div class="col-md-12">
                <div class="card card-outline card-info">
                    <div class="card-header">
                        <h3 class="card-title"><b>Filtrar por Mes y Año</b></h3>
                    </div>
                    <div class="card-body">
                        <form method="GET" action="{{ route('lista_memorandum') }}">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="mes">Mes:</label>
                                        <select class="form-control" id="mes" name="mes">
                                            @foreach ($meses as $key => $nombre)
                                                <option value="{{ $key }}" {{ $mes == $key ? 'selected' : '' }}>
                                                    {{ $nombre }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="anio">Año:</label>
                                        <select class="form-control" id="anio" name="anio">
                                            @foreach ($anios as $a)
                                                <option value="{{ $a }}" {{ $anio == $a ? 'selected' : '' }}>
                                                    {{ $a }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group" style="padding-top: 25px;">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="bi bi-filter"></i> Filtrar
                                        </button>
                                        <a href="{{ route('lista_memorandum') }}" class="btn btn-secondary">
                                            <i class="bi bi-arrow-clockwise"></i> Limpiar
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <h3 class="card-title"><b>Lista de usuario con memorandums</b></h3>
                        @if (request()->has('mes') || request()->has('anio'))
                            <div class="card-tools">
                                <span class="badge badge-info">
                                    Mostrando datos de: {{ $meses[$mes] }} de {{ $anio }}
                                </span>
                            </div>
                        @endif
                    </div>

                    <div class="card-body" style="display: block;">
                        <table id="example1" class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Nro</th>
                                    <th>Grado</th>
                                    <th>Nombre del usuario</th>
                                    <th>Email</th>
                                    <th>Carnet</th>
                                    <th>Faltas</th>
                                    <th>Sancionar</th>
                                    <th>Atrasos</th>
                                    <th>Salidas Ant.</th>
                                    <th>Accion</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($miembros as $index => $miembro)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $miembro->grado }}</td>
                                        <td>{{ $miembro->nombre_apellido }}</td>
                                        <td>{{ $miembro->email }}</td>
                                        <td>{{ $miembro->ci }}</td>

                                        <!-- Columnas de Estadísticas -->
                                        @if (request()->has('mes') || request()->has('anio'))
                                            <td class="text-center">
                                                @if (isset($miembro->estadisticas))
                                                    <span
                                                        class="badge {{ $miembro->estadisticas['total_faltas'] > 0 ? 'bg-danger' : 'bg-success' }}">
                                                        {{ $miembro->estadisticas['total_faltas'] }}
                                                    </span>
                                                @else
                                                    <span class="badge bg-secondary">-</span>
                                                @endif
                                            </td>

                                            <!-- Columna de Sanción -->
                                           <!-- Columna de Sanción -->
<td class="text-center">
    @if(isset($miembro->estadisticas) && $miembro->estadisticas['total_faltas'] > 0)
        @php
            // Usar el mes y año del filtro, no el actual
            $tieneSancion = $miembro->tieneSancionEnMes($mes, $anio);
            $sancionActual = $miembro->sancionEnMes($mes, $anio);
        @endphp
        
        @if($tieneSancion)
            <div class="d-flex flex-column align-items-center">
                <span class="badge bg-success mb-1" title="Sanción enviada - {{ $sancionActual->tipo_texto }}">
                    <i class="bi bi-check-circle"></i> Enviado
                </span>
                <small class="text-muted mb-1">{{ $sancionActual->tipo_texto }}</small>
                
                <!-- Botón para generar PDF -->
                <a href="{{ route('sanciones.generar-pdf', $sancionActual->id) }}" 
                   class="btn btn-outline-danger btn-sm mt-1"
                   target="_blank">
                    <i class="bi bi-file-pdf"></i> Generar PDF
                </a>
            </div>
        @else
            @if($miembro->estadisticas['total_faltas'] == 1)
                <a href="{{ route('sancionar', ['tipo' => 1, 'miembro_id' => $miembro->id, 'mes' => $mes, 'anio' => $anio]) }}" 
                   class="btn btn-warning btn-sm" 
                   onclick="return confirm('¿Está seguro de enviar un memorándum leve para {{ $meses[$mes] }} de {{ $anio }}?')">
                    <i class="bi bi-exclamation-triangle"></i> Memorándum
                </a>
            @elseif($miembro->estadisticas['total_faltas'] == 2)
                <a href="{{ route('sancionar', ['tipo' => 2, 'miembro_id' => $miembro->id, 'mes' => $mes, 'anio' => $anio]) }}" 
                   class="btn btn-danger btn-sm"
                   onclick="return confirm('¿Está seguro de enviar un memorándum moderado para {{ $meses[$mes] }} de {{ $anio }}?')">
                    <i class="bi bi-exclamation-octagon"></i> Memorándum Rudo
                </a>
            @elseif($miembro->estadisticas['total_faltas'] >= 3)
                <a href="{{ route('sancionar', ['tipo' => 3, 'miembro_id' => $miembro->id, 'mes' => $mes, 'anio' => $anio]) }}" 
                   class="btn btn-dark btn-sm"
                   onclick="return confirm('¿Está seguro de enviar un memorándum grave para {{ $meses[$mes] }} de {{ $anio }}?')">
                    <i class="bi bi-x-octagon"></i> Sanción Grave
                </a>
            @endif
        @endif
    @else
        <span class="badge bg-secondary">-</span>
    @endif
</td>

                                            <td class="text-center">
                                                @if (isset($miembro->estadisticas))
                                                    <span
                                                        class="badge {{ $miembro->estadisticas['total_atrasos'] > 0 ? 'bg-warning' : 'bg-success' }}">
                                                        {{ $miembro->estadisticas['total_atrasos'] }}
                                                    </span>
                                                @else
                                                    <span class="badge bg-secondary">-</span>
                                                @endif
                                            </td>

                                            <td class="text-center">
                                                @if (isset($miembro->estadisticas))
                                                    <span
                                                        class="badge {{ $miembro->estadisticas['total_salidas_anticipadas'] > 0 ? 'bg-warning' : 'bg-success' }}">
                                                        {{ $miembro->estadisticas['total_salidas_anticipadas'] }}
                                                    </span>
                                                @else
                                                    <span class="badge bg-secondary">-</span>
                                                @endif
                                            </td>
                                        @else
                                            <td class="text-center">
                                                <span class="badge bg-secondary"
                                                    title="Selecciona un mes y año para ver estadísticas">-</span>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-secondary"
                                                    title="Selecciona un mes y año para ver estadísticas">-</span>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-secondary"
                                                    title="Selecciona un mes y año para ver estadísticas">-</span>
                                            </td>
                                        @endif

                                        <td>
                                            @if ($miembro->asignacion)
                                                <a href="{{ route('historial_asistencia', $miembro->ci) }}"
                                                    class="btn btn-outline-primary btn-sm">
                                                    <i class="bi bi-journal-check"></i> Historial
                                                </a>

                                                <!-- Opcional: Enlace al historial de sanciones -->
                                                @if ($miembro->sanciones->count() > 0)
                                                    <a href="{{ route('sanciones.historial', $miembro->id) }}"
                                                        class="btn btn-outline-info btn-sm mt-1"
                                                        title="Ver historial de sanciones">
                                                        <i class="bi bi-clipboard-x"></i> Sanciones
                                                    </a>
                                                @endif
                                            @else
                                                <span class="badge bg-secondary">Sin asignar</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <!-- Información adicional cuando hay filtro -->
                        @if (request()->has('mes') || request()->has('anio'))
                            <div class="mt-3 p-3 bg-light rounded">
                                <h6><i class="bi bi-info-circle"></i> Información del Reporte:</h6>
                                <small class="text-muted">
                                    • <strong>Período:</strong> {{ $meses[$mes] }} de {{ $anio }}
                                    (del {{ \Carbon\Carbon::create($anio, $mes, 1)->format('d/m/Y') }} al
                                    {{ \Carbon\Carbon::create($anio, $mes, 1)->endOfMonth()->format('d/m/Y') }})<br>
                                    • <strong>Faltas:</strong> Días asignados sin marcaciones ni permisos<br>
                                    • <strong>Atrasos:</strong> Días con llegada después del horario permitido<br>
                                    • <strong>Salidas Ant.:</strong> Días con salida antes del horario permitido<br>
                                    • <strong>Sanciones:</strong> Se aplican específicamente para {{ $meses[$mes] }} de
                                    {{ $anio }}<br>
                                    • <strong>Base de cálculo:</strong> Solo se consideran los días asignados a cada miembro
                                </small>

                                @if (isset($miembros->first()->estadisticas))
                                    <div class="mt-2">
                                        <small class="text-info">
                                            <i class="bi bi-calendar-check"></i>
                                            Ejemplo del primer miembro:
                                            {{ $miembros->first()->estadisticas['dias_asignados_mes'] ?? 0 }} días
                                            asignados,
                                            {{ $miembros->first()->estadisticas['dias_con_marcaciones'] ?? 0 }} días
                                            trabajados,
                                            {{ $miembros->first()->estadisticas['dias_permiso'] ?? 0 }} días con permiso,
                                            {{ $miembros->first()->estadisticas['total_faltas'] ?? 0 }} faltas
                                        </small>
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .badge {
            font-size: 0.85rem;
            padding: 0.4em 0.6em;
        }
    </style>

    <script>
        $(function() {
            $("#example1").DataTable({
                "pageLength": 10,
                "language": {
                    "emptyTable": "No hay informacion",
                    "info": "Mostrando _START_ a _END_ de _TOTAL_ Usuarios",
                    "infoEmpty": "Mostrando 0 a 0 de 0 Usuarios",
                    "infoFiltered": "(Filtrado de _MAX_ total Usuarios)",
                    "infoPostFix": "",
                    "thousands": ",",
                    "lengthMenu": "Mostrar _MENU_ Usuarios",
                    "loadingRecords": "Cargando...",
                    "processing": "Procesando...",
                    "search": "Buscador:",
                    "zeroRecords": "Sin resultados encontrados",
                    "paginate": {
                        "first": "Primero",
                        "last": "Ultimo",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    }
                },
                "responsive": true,
                "lengthChange": true,
                "autoWidth": false,
                buttons: [{
                        extend: 'collection',
                        text: 'Reportes',
                        buttons: [{
                                text: 'Copiar',
                                extend: 'copy',
                            },
                            {
                                extend: 'pdf',
                                title: 'Memorándum de Asistencias - {{ $meses[$mes] ?? 'Actual' }} {{ $anio }}',
                                message: 'Reporte de faltas, atrasos y salidas anticipadas'
                            },
                            {
                                extend: 'csv',
                                title: 'Memorandum_{{ $mes ?? 'actual' }}_{{ $anio }}'
                            },
                            {
                                extend: 'excel',
                                title: 'Memorándum {{ $meses[$mes] ?? 'Actual' }} {{ $anio }}'
                            },
                            {
                                text: 'Imprimir',
                                extend: 'print',
                                title: 'Memorándum de Asistencias',
                                messageTop: 'Período: {{ $meses[$mes] ?? 'Actual' }} de {{ $anio }}'
                            }
                        ]
                    },
                    {
                        extend: 'colvis',
                        text: 'Visor de columnas'
                    }
                ],
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        });
    </script>
@endsection
