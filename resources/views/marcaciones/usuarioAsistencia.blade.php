@extends('layouts.admin')

@section('content')
    <div class="content" style="margin-left: 20px">
        <h1>Historial de asistencias</h1>

        @if ($message = Session::get('mensaje'))
            <script>
                Swal.fire({
                    title: "Registro exitoso",
                    text: "{{ $message }}",
                    icon: "success"
                });
            </script>
        @endif


        <div class="row">
            <div class="col-md-12">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <h3 class="card-title"><b>Lista de usuario</b></h3>
                        {{-- <div class="card-tools">
                            <a href="{{ url('/usuarios/create') }}" class="btn btn-primary">
                                <i class="bi bi-plus-square-fill"></i> Agregar nuevo usuario
                            </a>
                        </div> --}}
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
                                        <td>
                                            @if ($miembro->asignacion)
                                                <a href="{{ route('historial_asistencia', $miembro->ci) }}"
                                                    class="btn btn-outline-primary btn-sm" id="openCamera">
                                                    <i class="bi bi-journal-check"></i> Historial de Asistencias
                                                </a>
                                            @else
                                            <span class="badge bg-secondary">Sin asignar</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>

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
                                            orientacion: 'landscape',
                                            buttons: [{
                                                text: 'Copiar',
                                                extend: 'copy',
                                            }, {
                                                extend: 'pdf'
                                            }, {
                                                extend: 'csv'
                                            }, {
                                                extend: 'excel'
                                            }, {
                                                text: 'Imprimir',
                                                extend: 'print'
                                            }]
                                        },
                                        {
                                            extend: 'colvis',
                                            text: 'Visor de columnas',
                                            collectionLayout: 'fixed three-column'
                                        }
                                    ],
                                }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
                            });
                        </script>
                    </div>

                </div>

            </div>
        </div>
    </div>
@endsection
