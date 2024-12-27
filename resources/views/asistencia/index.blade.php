@extends('layouts.admin')


@section('content')

<div class="content" style="margin-left: 20px">
    <h1>Listado de asistencias</h1>

    @if($message = Session::get('mensaje'))
    <script>
        Swal.fire({
            title: "Registro exitoso",
            text: "{{$message}}",
            icon: "success"
        });
    </script>

    @endif
    <!--<div class="container-fluid">-->
        <div class="row">
            <div class="col-sm-12">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                Listado de asistencias
                            </span>

                            <div class="float-right">
                                <a href="{{ route('asistencias.create') }}" class="btn btn-primary btn-sm float-right" data-placement="left">
                                    <!--   <a href="{{ url('/asistencias/create')}}" class="btn btn-primary btn-sm float-right" data-placement="left">-->
                                    Crear nueva asistencia
                                </a>
                            </div>
                        </div>
                    </div>
                    @if ($message = Session::get('success'))
                    <div class="alert alert-success m-4">
                        <p>{{ $message }}</p>
                    </div>
                    @endif

                    <div class="card-body bg-white">
                        <div class="table-responsive">
                            <table id="example1" class="table table-bordered table-striped table-sm">
                                <thead class="thead">
                                    <tr>
                                        <th>No</th>
                                        <th>Fecha</th>
                                        <th>Nombre y apellido del miembro</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $contador = 0; ?>
                                    @foreach ($asistencias as $asistencia)
                                    <tr>
                                        <td><?php echo $contador = $contador + 1; ?></td>
                                        <td>{{ $asistencia->fecha }}</td>
                                        <td>{{ $asistencia->miembro->nombre_apellido}}</td>
                                        <td style="text-align: center;">
                                            <form action="{{ route('asistencias.destroy', $asistencia->id) }}" method="POST">
                                                <a class="btn btn-sm btn-primary " href="{{ route('asistencias.show', $asistencia->id) }}"><i class="bi bi-eye"></i></a>
                                                <a class="btn btn-sm btn-success" href="{{ route('asistencias.edit', $asistencia->id) }}"><i class="bi bi-pencil"></i></a>
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" onclick="return confirm('¿Esta seguro que desea eliminar este registro?')" class="btn btn-danger btn-sm" onclick="event.preventDefault(); confirm('Are you sure to delete?') ? this.closest('form').submit() : false;"><i class="bi bi-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <!--</div>-->
</div>

<script>
    $(function() {
        $("#example1").DataTable({
            "pageLength": 10,
            "language": {
                "emptyTable": "No hay informacion",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ Asistencias",
                "infoEmpty": "Mostrando 0 a 0 de 0 Division",
                "infoFiltered": "(Filtrado de _MAX_ total Asistencias)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Mostrar _MENU_ Asistencias",
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
@endsection