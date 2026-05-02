@extends('layouts.admin')

@section('content')
    <div class="content" style="margin-left: 20px">
        <div class="container-fluid">
            <!-- Encabezado -->
            <div class="row mb-3">
                <div class="col-12">
                    <h1><i class="bi bi-clock-history"></i> Historial de Marcaciones</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/miembros') }}">Miembros</a></li>
                            <li class="breadcrumb-item active">Historial de {{ $miembro->nombre_apellido }}</li>
                        </ol>
                    </nav>
                </div>
            </div>

            @if ($message = Session::get('mensaje'))
                <script>
                    Swal.fire({
                        title: "¡Éxito!",
                        text: "{{ $message }}",
                        icon: "success"
                    });
                </script>
            @endif

            <!-- Información del Miembro -->
            <div class="row">
                <div class="col-12">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col-md-2 text-center">
                                    @if ($miembro->fotografia)
                                        <img src="{{ asset('storage/' . $miembro->fotografia) }}"
                                            class="img-thumbnail rounded-circle"
                                            style="width: 100px; height: 100px; object-fit: cover;" alt="Foto">
                                    @else
                                        <img src="{{ asset('assets/img/avatar-default.png') }}"
                                            class="img-thumbnail rounded-circle"
                                            style="width: 100px; height: 100px; object-fit: cover;" alt="Sin foto">
                                    @endif
                                </div>
                                <div class="col-md-10">
                                    <h3 class="mb-1"><b>{{ $miembro->nombre_apellido }}</b></h3>
                                    <p class="mb-1"><strong>Grado:</strong> {{ $miembro->grado }}</p>
                                    <p class="mb-1"><strong>Cargo:</strong> {{ $miembro->cargo }}</p>
                                    <p class="mb-1"><strong>CI:</strong> {{ $miembro->ci }}</p>
                                    <p class="mb-0"><strong>División:</strong> {{ $miembro->division_o_dependencia }}</p>
                                    <p class="mb-0"><strong>Hora entrada asignada:</strong>
                                        {{ $miembro->asignacion->hora_entrada }}</p>
                                    <p class="mb-0"><strong>Hora salida asignada:</strong>
                                        {{ $miembro->asignacion->hora_salida }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filtros de Fecha -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-outline card-info">
                        <div class="card-header">
                            <h3 class="card-title"><i class="bi bi-filter"></i> <b>Filtrar por Rango de Fechas</b></h3>
                        </div>
                        <div class="card-body">
                            <form id="filtroForm" method="GET" action="{{ url()->current() }}">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="fecha_desde">Fecha Desde:</label>
                                            <input type="date" class="form-control" id="fecha_desde" name="fecha_desde"
                                                value="{{ request('fecha_desde') }}" max="{{ date('Y-m-d') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="fecha_hasta">Fecha Hasta:</label>
                                            <input type="date" class="form-control" id="fecha_hasta" name="fecha_hasta"
                                                value="{{ request('fecha_hasta') }}" max="{{ date('Y-m-d') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group" style="padding-top: 25px;">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="bi bi-search"></i> Filtrar
                                            </button>
                                            <button type="button" class="btn btn-secondary" onclick="limpiarFiltros()">
                                                <i class="bi bi-arrow-clockwise"></i> Limpiar
                                            </button>
                                            <button type="button" class="btn btn-danger" onclick="generarPDF()">
                                                <i class="bi bi-file-pdf"></i> Generar PDF
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Estadísticas ACTUALIZADAS -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $marcaciones->count() }}</h3>
                            <p>Días con marcaciones</p>
                        </div>
                        <div class="icon">
                            <i class="bi bi-calendar-check"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $marcaciones->sum('total_marcaciones') }}</h3>
                            <p>Total de marcaciones</p>
                        </div>
                        <div class="icon">
                            <i class="bi bi-clock"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3 id="total-minutos-atraso">
                                {{ $marcaciones->sum('minutos_atraso') ?? 0 }}
                            </h3>
                            <p>Total minutos atraso</p>
                        </div>
                        <div class="icon">
                            <i class="bi bi-alarm"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3 id="total-minutos-salida">
                                {{ $marcaciones->sum('minutos_salida_anticipada') ?? 0 }}
                            </h3>
                            <p>Total minutos salida anticipada</p>
                        </div>
                        <div class="icon">
                            <i class="bi bi-door-open"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabla de Marcaciones Mejorada -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h3 class="card-title"><i class="bi bi-table"></i> <b>Marcaciones por Día</b></h3>
                            <div class="card-tools">
                                <a href="{{ url('/miembros') }}" class="btn btn-secondary btn-sm">
                                    <i class="bi bi-arrow-left"></i> Volver
                                </a>
                            </div>
                        </div>

                        <div class="card-body">
                            @if ($marcaciones->isEmpty())
                                <div class="alert alert-info text-center">
                                    <i class="bi bi-info-circle"></i> No hay marcaciones registradas para este miembro.
                                </div>
                            @else
                                <table id="example1" class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th width="5%">Nro</th>
                                            <th width="12%">Día</th>
                                            <th width="15%">Fecha</th>
                                            <th width="10%" class="text-center">Entrada</th>
                                            <th width="10%" class="text-center">Salida</th>
                                            <th width="8%" class="text-center">Atraso</th>
                                            <th width="8%" class="text-center">Sal. Ant.</th>
                                            <th width="8%" class="text-center">Total</th>
                                            <th width="24%">Todas las Marcaciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $contador = 0; ?>
                                        @foreach ($marcaciones as $marcacionDia)
                                            @php
                                                $minutosAtraso = $marcacionDia['minutos_atraso'] ?? 0;
                                                $minutosSalidaAnticipada = $marcacionDia['minutos_salida_anticipada'] ?? 0;
                                                
                                                // Determinar clases para atraso y salida anticipada
                                                $claseAtraso = $minutosAtraso > 0 ? 'badge-danger' : 'badge-success';
                                                $claseSalida = $minutosSalidaAnticipada > 0 ? 'badge-warning' : 'badge-success';
                                                $textoAtraso = $minutosAtraso > 0 ? $minutosAtraso . ' min' : 'A tiempo';
                                                $textoSalida = $minutosSalidaAnticipada > 0 ? $minutosSalidaAnticipada . ' min' : 'Correcto';
                                            @endphp
                                            <tr>
                                                <td>{{ ++$contador }}</td>
                                                <td>
                                                    <span class="badge badge-primary">
                                                        {{ $marcacionDia['dia_texto'] }}
                                                    </span>
                                                </td>
                                                <td>{{ $marcacionDia['fecha_formato'] }}</td>
                                                
                                                <!-- Columna Entrada -->
                                                <td class="text-center">
                                                    @if ($marcacionDia['entrada'])
                                                        <span class="badge badge-success" style="font-size: 0.9rem;">
                                                            {{ $marcacionDia['entrada']['hora'] }}
                                                        </span>
                                                    @else
                                                        <span class="badge badge-danger" style="font-size: 0.9rem;">
                                                            Sin entrada
                                                        </span>
                                                    @endif
                                                </td>
                                                
                                                <!-- Columna Salida -->
                                                <td class="text-center">
                                                    @if ($marcacionDia['salida'])
                                                        <span class="badge badge-info" style="font-size: 0.9rem;">
                                                            {{ $marcacionDia['salida']['hora'] }}
                                                        </span>
                                                    @else
                                                        <span class="badge badge-warning" style="font-size: 0.9rem;">
                                                            Sin salida
                                                        </span>
                                                    @endif
                                                </td>
                                                
                                                <!-- Columna Atraso -->
                                                <td class="text-center">
                                                    <span class="badge {{ $claseAtraso }} p-2" style="font-size: 0.8rem;"
                                                        title="{{ $minutosAtraso > 0 ? 'Minutos de atraso: ' . $minutosAtraso : 'Llegó a tiempo' }}">
                                                        <i class="bi {{ $minutosAtraso > 0 ? 'bi-clock-history' : 'bi-check-circle' }}"></i>
                                                        {{ $textoAtraso }}
                                                    </span>
                                                </td>
                                                
                                                <!-- Columna Salida Anticipada -->
                                                <td class="text-center">
                                                    <span class="badge {{ $claseSalida }} p-2" style="font-size: 0.8rem;"
                                                        title="{{ $minutosSalidaAnticipada > 0 ? 'Minutos de salida anticipada: ' . $minutosSalidaAnticipada : 'Salió en horario correcto' }}">
                                                        <i class="bi {{ $minutosSalidaAnticipada > 0 ? 'bi-door-open' : 'bi-check-circle' }}"></i>
                                                        {{ $textoSalida }}
                                                    </span>
                                                </td>
                                                
                                                <!-- Columna Total Marcaciones -->
                                                <td class="text-center">
                                                    <span class="badge badge-secondary" style="font-size: 1rem;">
                                                        {{ $marcacionDia['total_marcaciones'] }}
                                                    </span>
                                                </td>
                                                
                                                <!-- Columna Todas las Marcaciones -->
                                                <td>
                                                    <div class="row">
                                                        @if (isset($marcacionDia['todas_marcaciones']) && count($marcacionDia['todas_marcaciones']) > 0)
                                                            @foreach ($marcacionDia['todas_marcaciones'] as $index => $marcacion)
                                                                @php
                                                                    $badgeClass = 'secondary';
                                                                    $iconClass = 'bi-clock';
                                                                    $tooltip = '';

                                                                    if ($marcacion['tipo'] === 'entrada') {
                                                                        $badgeClass = 'success';
                                                                        $iconClass = 'bi-box-arrow-in-right';
                                                                        $tooltip = 'Entrada detectada';
                                                                    } elseif ($marcacion['tipo'] === 'entrada_auto') {
                                                                        $badgeClass = 'success';
                                                                        $iconClass = 'bi-box-arrow-in-right';
                                                                        $tooltip = 'Entrada (primera marcación)';
                                                                    } elseif ($marcacion['tipo'] === 'salida') {
                                                                        $badgeClass = 'info';
                                                                        $iconClass = 'bi-box-arrow-right';
                                                                        $tooltip = 'Salida detectada';
                                                                    } elseif ($marcacion['tipo'] === 'salida_auto') {
                                                                        $badgeClass = 'info';
                                                                        $iconClass = 'bi-box-arrow-right';
                                                                        $tooltip = 'Salida (última marcación)';
                                                                    } elseif ($marcacion['tipo'] === 'intermedia') {
                                                                        $badgeClass = 'warning';
                                                                        $iconClass = 'bi-dot';
                                                                        $tooltip = 'Marcación intermedia';
                                                                    } else {
                                                                        $badgeClass = 'secondary';
                                                                        $iconClass = 'bi-clock';
                                                                        $tooltip = 'Marcación adicional';
                                                                    }
                                                                @endphp
                                                                <div class="col-md-6 mb-1">
                                                                    <span class="badge badge-{{ $badgeClass }} p-1"
                                                                        style="font-size: 0.7rem; cursor: help;"
                                                                        title="{{ $tooltip }}">
                                                                        <i class="bi {{ $iconClass }}"></i>
                                                                        {{ $marcacion['hora'] }}
                                                                        @if (in_array($marcacion['tipo'], ['entrada_auto', 'salida_auto']))
                                                                            <small>(auto)</small>
                                                                        @endif
                                                                    </span>
                                                                </div>
                                                            @endforeach
                                                        @else
                                                            <div class="col-12">
                                                                <span class="text-muted">No hay marcaciones</span>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .small-box {
            border-radius: 0.25rem;
            box-shadow: 0 0 1px rgba(0, 0, 0, .125), 0 1px 3px rgba(0, 0, 0, .2);
            display: block;
            margin-bottom: 20px;
            position: relative;
        }

        .small-box>.inner {
            padding: 10px;
        }

        .small-box .icon {
            color: rgba(0, 0, 0, .15);
            z-index: 0;
        }

        .small-box .icon>i {
            font-size: 70px;
            position: absolute;
            right: 15px;
            top: 15px;
            transition: all .3s linear;
        }

        .small-box:hover .icon>i {
            font-size: 80px;
        }

        .small-box h3 {
            font-size: 2.2rem;
            font-weight: 700;
            margin: 0 0 10px;
            padding: 0;
            white-space: nowrap;
        }

        .badge-success {
            background-color: #28a745;
        }

        .badge-info {
            background-color: #17a2b8;
        }

        .badge-warning {
            background-color: #ffc107;
            color: #212529;
        }

        .badge-secondary {
            background-color: #6c757d;
        }

        .badge-danger {
            background-color: #dc3545;
        }

        /* Estilos para tooltips mejorados */
        [title] {
            position: relative;
        }

        [title]:hover::after {
            content: attr(title);
            position: absolute;
            bottom: 100%;
            left: 50%;
            transform: translateX(-50%);
            background: #333;
            color: white;
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 12px;
            white-space: nowrap;
            z-index: 1000;
        }
    </style>

    <script>
        $(function() {
            $("#example1").DataTable({
                "pageLength": 10,
                "order": [
                    [0, "desc"]
                ],
                "language": {
                    "emptyTable": "No hay marcaciones registradas",
                    "info": "Mostrando _START_ a _END_ de _TOTAL_ días",
                    "infoEmpty": "Mostrando 0 a 0 de 0 días",
                    "infoFiltered": "(Filtrado de _MAX_ total días)",
                    "infoPostFix": "",
                    "thousands": ",",
                    "lengthMenu": "Mostrar _MENU_ días",
                    "loadingRecords": "Cargando...",
                    "processing": "Procesando...",
                    "search": "Buscar:",
                    "zeroRecords": "Sin resultados encontrados",
                    "paginate": {
                        "first": "Primero",
                        "last": "Último",
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
                                title: 'Historial de Marcaciones - {{ $miembro->nombre_apellido }}',
                                message: `Total minutos atraso: {{ $marcaciones->sum('minutos_atraso') ?? 0 }}\nTotal minutos salida anticipada: {{ $marcaciones->sum('minutos_salida_anticipada') ?? 0 }}`
                            },
                            {
                                extend: 'csv',
                                title: 'Historial_Marcaciones_{{ $miembro->ci }}'
                            },
                            {
                                extend: 'excel',
                                title: 'Historial de Marcaciones - {{ $miembro->nombre_apellido }}',
                                message: `Total minutos atraso: {{ $marcaciones->sum('minutos_atraso') ?? 0 }}\nTotal minutos salida anticipada: {{ $marcaciones->sum('minutos_salida_anticipada') ?? 0 }}`
                            },
                            {
                                text: 'Imprimir',
                                extend: 'print',
                                title: 'Historial de Marcaciones',
                                messageTop: `
                                    <h3>{{ $miembro->nombre_apellido }}</h3>
                                    <p>CI: {{ $miembro->ci }}</p>
                                    <p><strong>Total minutos atraso:</strong> {{ $marcaciones->sum('minutos_atraso') ?? 0 }}</p>
                                    <p><strong>Total minutos salida anticipada:</strong> {{ $marcaciones->sum('minutos_salida_anticipada') ?? 0 }}</p>
                                `
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

        function limpiarFiltros() {
            document.getElementById('fecha_desde').value = '';
            document.getElementById('fecha_hasta').value = '';
            document.getElementById('filtroForm').submit();
        }

        function generarPDF() {
            const fechaDesde = document.getElementById('fecha_desde').value;
            const fechaHasta = document.getElementById('fecha_hasta').value;
            
            let url = "{{ route('generar.pdf.marcaciones', $miembro->id) }}";
            let params = [];
            
            if (fechaDesde) {
                params.push(`fecha_desde=${fechaDesde}`);
            }
            if (fechaHasta) {
                params.push(`fecha_hasta=${fechaHasta}`);
            }
            
            if (params.length > 0) {
                url += '?' + params.join('&');
            }
            
            window.open(url, '_blank');
        }

        // Actualizar estadísticas en tiempo real si hay filtros
        document.addEventListener('DOMContentLoaded', function() {
            const totalAtraso = {{ $marcaciones->sum('minutos_atraso') ?? 0 }};
            const totalSalida = {{ $marcaciones->sum('minutos_salida_anticipada') ?? 0 }};
            
            document.getElementById('total-minutos-atraso').textContent = totalAtraso;
            document.getElementById('total-minutos-salida').textContent = totalSalida;
        });
    </script>
@endsection