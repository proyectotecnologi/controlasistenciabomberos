@extends('layouts.admin')

@section('content')
    <div class="content" style="margin-left: 20px">
        <div class="container-fluid">
            <!-- Encabezado -->
            <div class="row mb-3">
                <div class="col-12">
                    <h1><i class="bi bi-clipboard-x"></i> Historial de Sanciones</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('lista_memorandum') }}">Memorándum</a></li>
                            <li class="breadcrumb-item active">Sanciones de {{ $miembro->nombre_apellido }}</li>
                        </ol>
                    </nav>
                </div>
            </div>

            @if ($message = Session::get('success'))
                <script>
                    Swal.fire({
                        title: "¡Éxito!",
                        text: "{{ $message }}",
                        icon: "success"
                    });
                </script>
            @endif

            @if ($message = Session::get('error'))
                <script>
                    Swal.fire({
                        title: "¡Error!",
                        text: "{{ $message }}",
                        icon: "error"
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
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Estadísticas de Sanciones -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $miembro->sanciones->count() }}</h3>
                            <p>Total Sanciones</p>
                        </div>
                        <div class="icon">
                            <i class="bi bi-clipboard-x"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ $miembro->sanciones->where('tipo', '1')->count() }}</h3>
                            <p>Memorándums Leves</p>
                        </div>
                        <div class="icon">
                            <i class="bi bi-exclamation-triangle"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{ $miembro->sanciones->where('tipo', '2')->count() }}</h3>
                            <p>Memorándums Rudos</p>
                        </div>
                        <div class="icon">
                            <i class="bi bi-exclamation-octagon"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-dark">
                        <div class="inner">
                            <h3>{{ $miembro->sanciones->where('tipo', '3')->count() }}</h3>
                            <p>Sanciones Graves</p>
                        </div>
                        <div class="icon">
                            <i class="bi bi-x-octagon"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabla de Sanciones -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h3 class="card-title"><i class="bi bi-list-check"></i> <b>Historial de Sanciones</b></h3>
                            <div class="card-tools">
                                <a href="{{ route('lista_memorandum') }}" class="btn btn-secondary btn-sm">
                                    <i class="bi bi-arrow-left"></i> Volver
                                </a>
                            </div>
                        </div>

                        <div class="card-body">
                            @if ($miembro->sanciones->isEmpty())
                                <div class="alert alert-info text-center">
                                    <i class="bi bi-info-circle"></i> Este miembro no tiene sanciones registradas.
                                </div>
                            @else
                                <table id="sancionesTable" class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th width="5%">Nro</th>
                                            <th width="15%">Mes</th>
                                            <th width="20%">Tipo de Sanción</th>
                                            <th width="15%">Estado</th>
                                            <th width="20%">Fecha de Envío</th>
                                            <th width="25%">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($miembro->sanciones->sortByDesc('created_at') as $index => $sancion)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>
                                                    <strong>{{ $sancion->mes_formateado }}</strong>
                                                </td>
                                                <td>
                                                    @switch($sancion->tipo)
                                                        @case('1')
                                                            <span class="badge badge-warning p-2">
                                                                <i class="bi bi-exclamation-triangle"></i> Memorándum Leve
                                                            </span>
                                                            @break
                                                        @case('2')
                                                            <span class="badge badge-danger p-2">
                                                                <i class="bi bi-exclamation-octagon"></i> Memorándum Rudo
                                                            </span>
                                                            @break
                                                        @case('3')
                                                            <span class="badge badge-dark p-2">
                                                                <i class="bi bi-x-octagon"></i> Sanción Grave
                                                            </span>
                                                            @break
                                                    @endswitch
                                                </td>
                                                <td>
                                                    @if($sancion->enviado)
                                                        <span class="badge badge-success p-2">
                                                            <i class="bi bi-check-circle"></i> Enviado
                                                        </span>
                                                    @else
                                                        <span class="badge badge-secondary p-2">
                                                            <i class="bi bi-clock"></i> Pendiente
                                                        </span>
                                                    @endif
                                                </td>
                                                <td>
                                                    {{ $sancion->created_at->format('d/m/Y H:i') }}
                                                </td>
                                                <td>
                                                    <div class="btn-group">
                                                        @if($sancion->enviado)
                                                            <form action="{{ route('sanciones.cambiar-estado', $sancion->id) }}" method="POST" class="d-inline">
                                                                @csrf
                                                                @method('PUT')
                                                                <button type="submit" class="btn btn-warning btn-sm" 
                                                                        onclick="return confirm('¿Está seguro de marcar esta sanción como pendiente?')">
                                                                    <i class="bi bi-arrow-counterclockwise"></i> Marcar Pendiente
                                                                </button>
                                                            </form>
                                                        @else
                                                            <form action="{{ route('sanciones.cambiar-estado', $sancion->id) }}" method="POST" class="d-inline">
                                                                @csrf
                                                                @method('PUT')
                                                                <button type="submit" class="btn btn-success btn-sm"
                                                                        onclick="return confirm('¿Está seguro de marcar esta sanción como enviada?')">
                                                                    <i class="bi bi-check-circle"></i> Marcar Enviado
                                                                </button>
                                                            </form>
                                                        @endif
                                                        
                                                        <button type="button" class="btn btn-info btn-sm" 
                                                                data-toggle="modal" 
                                                                data-target="#detalleSancion{{ $sancion->id }}">
                                                            <i class="bi bi-eye"></i> Detalles
                                                        </button>
                                                    </div>

                                                    <!-- Modal para detalles -->
                                                    <div class="modal fade" id="detalleSancion{{ $sancion->id }}" tabindex="-1">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Detalles de Sanción</h5>
                                                                    <button type="button" class="close" data-dismiss="modal">
                                                                        <span>&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <strong>Miembro:</strong><br>
                                                                            {{ $miembro->nombre_apellido }}<br>
                                                                            {{ $miembro->grado }}<br>
                                                                            CI: {{ $miembro->ci }}
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <strong>Sanción:</strong><br>
                                                                            {{ $sancion->tipo_texto }}<br>
                                                                            Mes: {{ $sancion->mes_formateado }}<br>
                                                                            Estado: {{ $sancion->enviado ? 'Enviado' : 'Pendiente' }}
                                                                        </div>
                                                                    </div>
                                                                    
                                                                    @if($sancion->observaciones)
                                                                        <hr>
                                                                        <strong>Observaciones:</strong>
                                                                        <p class="mt-2">{{ $sancion->observaciones }}</p>
                                                                    @endif
                                                                    
                                                                    <hr>
                                                                    <small class="text-muted">
                                                                        <strong>Registrado:</strong> {{ $sancion->created_at->format('d/m/Y H:i') }}<br>
                                                                        <strong>Actualizado:</strong> {{ $sancion->updated_at->format('d/m/Y H:i') }}
                                                                    </small>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                                                </div>
                                                            </div>
                                                        </div>
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

            <!-- Información Adicional -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-outline card-info">
                        <div class="card-header">
                            <h5 class="card-title"><i class="bi bi-info-circle"></i> Información sobre Tipos de Sanciones</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="border rounded p-3 bg-light">
                                        <h6><span class="badge badge-warning p-2">Memorándum Leve</span></h6>
                                        <small class="text-muted">
                                            Aplicado por 1 falta en el mes. Es una amonestación verbal o escrita.
                                        </small>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="border rounded p-3 bg-light">
                                        <h6><span class="badge badge-danger p-2">Memorándum Rudo</span></h6>
                                        <small class="text-muted">
                                            Aplicado por 2 faltas en el mes. Incluye medidas disciplinarias más severas.
                                        </small>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="border rounded p-3 bg-light">
                                        <h6><span class="badge badge-dark p-2">Sanción Grave</span></h6>
                                        <small class="text-muted">
                                            Aplicado por 3 o más faltas. Puede incluir suspensión u otras medidas graves.
                                        </small>
                                    </div>
                                </div>
                            </div>
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

        .badge-warning {
            background-color: #ffc107;
            color: #212529;
        }

        .badge-danger {
            background-color: #dc3545;
        }

        .badge-dark {
            background-color: #343a40;
        }

        .badge-secondary {
            background-color: #6c757d;
        }
    </style>

    <script>
        $(function() {
            $("#sancionesTable").DataTable({
                "pageLength": 10,
                "order": [[0, "desc"]],
                "language": {
                    "emptyTable": "No hay sanciones registradas",
                    "info": "Mostrando _START_ a _END_ de _TOTAL_ sanciones",
                    "infoEmpty": "Mostrando 0 a 0 de 0 sanciones",
                    "infoFiltered": "(Filtrado de _MAX_ total sanciones)",
                    "infoPostFix": "",
                    "thousands": ",",
                    "lengthMenu": "Mostrar _MENU_ sanciones",
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
                                title: 'Historial de Sanciones - {{ $miembro->nombre_apellido }}',
                                message: 'Total sanciones: {{ $miembro->sanciones->count() }}'
                            },
                            {
                                extend: 'csv',
                                title: 'Sanciones_{{ $miembro->ci }}'
                            },
                            {
                                extend: 'excel',
                                title: 'Historial de Sanciones - {{ $miembro->nombre_apellido }}'
                            },
                            {
                                text: 'Imprimir',
                                extend: 'print',
                                title: 'Historial de Sanciones',
                                messageTop: `
                                    <h3>{{ $miembro->nombre_apellido }}</h3>
                                    <p>CI: {{ $miembro->ci }}</p>
                                    <p><strong>Total sanciones:</strong> {{ $miembro->sanciones->count() }}</p>
                                `
                            }
                        ]
                    },
                    {
                        extend: 'colvis',
                        text: 'Visor de columnas'
                    }
                ],
            }).buttons().container().appendTo('#sancionesTable_wrapper .col-md-6:eq(0)');
        });
    </script>
@endsection