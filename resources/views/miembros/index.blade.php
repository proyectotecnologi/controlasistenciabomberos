@extends('layouts.admin')

@section('content')

<div class="content" style="margin-left: 20px">
  <h1>Listado de miembros</h1>

  @if($message = Session::get('mensaje'))
  <script>
    Swal.fire({
      title: "Registro exitoso",
      text: "{{$message}}",
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
            <a href="{{url('/miembros/create')}}" class="btn btn-primary">
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
                <th>Accion</th>
              </tr>
            </thead>
            <tbody>
              <?php $contador = 0; ?>
              @foreach($miembros as $miembro)
              <tr>
                <td><?php echo $contador = $contador + 1; ?></td>
                <td>{{$miembro->grado}}</td>
                <td>{{$miembro->cargo}}</td>
                <td>{{$miembro->nombre_apellido}}</td>
                <td>{{$miembro->telefono}}</td>
                <td>{{$miembro->email}}</td>
                <td style="text-align: center">
                  <button class="btn btn-success btn-sm" style="border-radius: 20px">Activo</button>
                </td>
                <td>{{$miembro->fecha_ingreso}}</td>
                <td style="text-align: center;">
                  <div class="btn-group" role="group" aria-label="Basic example">
                    <a href="{{url('miembros', $miembro->id)}}" type="button" class="btn btn-info"><i class="bi bi-eye"></i></a>
                    <a href="{{route('miembros.edit', $miembro->id)}}" type="button" class="btn btn-success"><i class="bi bi-pencil"></i></a>
                    <!--<a href="" type="button" class="btn btn-danger"><i class="bi bi-trash"></i></a> -->
                    <form action="{{url('miembros', $miembro->id)}}" method="post">
                      @csrf
                      {{method_field('DELETE')}}
                      <button type="submit" onclick="return confirm('¿Esta seguro que desea eliminar este registro?')" class="btn btn-danger">
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

@endsection