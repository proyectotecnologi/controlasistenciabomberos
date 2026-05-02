@extends('layouts.admin')

@section('content')
    <div class="content" style="margin-left: 20px">
        <h1>Listado de miembros</h1>

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
                        <h3 class="card-title"><b>Miembros registrados</b></h3>
                        <div class="card-tools">
                            <a href="{{ url('/miembros/create') }}" class="btn btn-primary">
                                <i class="bi bi-plus-square-fill"></i> Agregar nuevo miembro
                            </a>
                        </div>
                    </div>

                    <div class="card-body" style="display: block;">

                        <table id="example1" class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Nro</th>
                                    <th>Grado</th>
                                    <th>Cargo</th>
                                    <th>Nombre Apellido</th>
                                    <th>Telefono</th>
                                    <th>Email</th>
                                    <th>Estado</th>
                                    <th>Agregado</th>
                                    <th>Asignar horario</th>
                                    <th>Accion</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $contador = 0; ?>
                                @foreach ($miembros as $miembro)
                                    <tr>
                                        <td><?php echo $contador = $contador + 1; ?></td>
                                        <td>{{ $miembro->grado }}</td>
                                        <td>{{ $miembro->cargo }}</td>
                                        <td>{{ $miembro->nombre_apellido }}</td>
                                        <td>{{ $miembro->telefono }}</td>
                                        <td>{{ $miembro->email }}</td>
                                        <td style="text-align: center">
                                            <button class="btn btn-success btn-sm"
                                                style="border-radius: 20px">Activo</button>
                                        </td>
                                        <td>{{ $miembro->fecha_ingreso }}</td>
             <td>
    <button type="button" class="btn btn-primary btnAsignarHorario" data-toggle="modal" 
            data-target="#modalAsignarHorario" data-id="{{ $miembro->id }}"
            data-entrada="{{ $miembro->asignacion->hora_entrada ?? '' }}"
            data-salida="{{ $miembro->asignacion->hora_salida ?? '' }}"
            data-dias="{{ $miembro->asignacion ? $miembro->asignacion->dias->pluck('name')->toJson() : '[]' }}">
        Asignar horario
    </button>
</td>
                                        <td style="text-align: center;">
                                            <div class="btn-group" role="group" aria-label="Basic example">
                                                <a href="{{ url('miembros', $miembro->id) }}" type="button"
                                                    class="btn btn-info"><i class="bi bi-eye"></i></a>
                                                <a href="{{ route('miembros.edit', $miembro->id) }}" type="button"
                                                    class="btn btn-success"><i class="bi bi-pencil"></i></a>
                                                <!--<a href="" type="button" class="btn btn-danger"><i class="bi bi-trash"></i></a> -->
                                                <form action="{{ url('miembros', $miembro->id) }}" method="post">
                                                    @csrf
                                                    {{ method_field('DELETE') }}
                                                    <button type="submit"
                                                        onclick="return confirm('¿Esta seguro que desea eliminar este registro?')"
                                                        class="btn btn-danger">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
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
                                        "info": "Mostrando _START_ a _END_ de _TOTAL_ Miembros",
                                        "infoEmpty": "Mostrando 0 a 0 de 0 Miembros",
                                        "infoFiltered": "(Filtrado de _MAX_ total Miembros)",
                                        "infoPostFix": "",
                                        "thousands": ",",
                                        "lengthMenu": "Mostrar _MENU_ Miembros",
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
                            /*$(function() {
                              $("#example1").DataTable({
                                "responsive": true,
                                "lengthChange": true,
                                "autoWidth": false,
                                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
                              }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
                            });*/
                        </script>
                    </div>

                </div>

            </div>
        </div>
    </div>


    {{-- MODAL ASIGNAR HORARIO --}}

    {{-- MODAL ASIGNAR HORARIO --}}
    <div class="modal fade" id="modalAsignarHorario" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white">Asignar horario y días</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span>&times;</span>
                    </button>
                </div>

                <form action="{{ url('asignar_horario') }}" method="POST">
                    @csrf

                    <div class="modal-body">

                        <div class="form-group">
                            <label>Hora de entrada</label>
                            <input type="time" class="form-control" id="modal_hora_entrada" name="hora_entrada">
                        </div>

                        <div class="form-group">
                            <label>Hora de salida</label>
                            <input type="time" class="form-control" id="modal_hora_salida" name="hora_salida">
                        </div>

                        <div class="form-group">
                            <label>Días de trabajo</label>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input dia-checkbox" type="checkbox" name="dias[]"
                                            value="lunes" id="lunes">
                                        <label class="form-check-label" for="lunes">Lunes</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input dia-checkbox" type="checkbox" name="dias[]"
                                            value="martes" id="martes">
                                        <label class="form-check-label" for="martes">Martes</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input dia-checkbox" type="checkbox" name="dias[]"
                                            value="miércoles" id="miércoles">
                                        <label class="form-check-label" for="miércoles">Miércoles</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input dia-checkbox" type="checkbox" name="dias[]"
                                            value="jueves" id="jueves">
                                        <label class="form-check-label" for="jueves">Jueves</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input dia-checkbox" type="checkbox" name="dias[]"
                                            value="viernes" id="viernes">
                                        <label class="form-check-label" for="viernes">Viernes</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input dia-checkbox" type="checkbox" name="dias[]"
                                            value="sabado" id="sabado">
                                        <label class="form-check-label" for="sabado">Sábado</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input dia-checkbox" type="checkbox" name="dias[]"
                                            value="domingo" id="domingo">
                                        <label class="form-check-label" for="domingo">Domingo</label>
                                    </div>
                                </div>
                            </div>
                            <small class="text-muted">Selecciona los días en los que el miembro trabajará</small>
                        </div>

                        <input type="hidden" id="modal_miembro_id" name="miembro_id">
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Guardar horario y días
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    @if (session('success'))
        Swal.fire({
            icon: 'success',
            title: '¡Éxito!',
            text: '{{ session('success') }}',
            confirmButtonColor: '#3085d6'
        });
    @elseif (session('error'))
        Swal.fire({
            icon: 'error',
            title: '¡Error!',
            text: '{{ session('error') }}',
            confirmButtonColor: '#d33'
        });
    @endif
</script>

    <script>
        $(document).on('click', '.btnAsignarHorario', function() {
            let id = $(this).data('id');
            let entrada = $(this).data('entrada');
            let salida = $(this).data('salida');
            let dias = $(this).data('dias') || [];

            $("#modal_miembro_id").val(id);

            // Si no hay asignación, que quede vacío
            $("#modal_hora_entrada").val(entrada || "");
            $("#modal_hora_salida").val(salida || "");

            // Limpiar checkboxes anteriores
            $('.dia-checkbox').prop('checked', false);

            // Marcar los días asignados
            if (Array.isArray(dias)) {
                dias.forEach(function(dia) {
                    $('input[name="dias[]"][value="' + dia + '"]').prop('checked', true);
                });
            }
        });
    </script>
    <script>
        $(document).on('click', '.btnAsignarHorario', function() {
            let id = $(this).data('id');
            let entrada = $(this).data('entrada');
            let salida = $(this).data('salida');

            $("#modal_miembro_id").val(id);

            // Si no hay asignación, que quede vacío
            $("#modal_hora_entrada").val(entrada || "");
            $("#modal_hora_salida").val(salida || "");
        });
    </script>
@endsection
