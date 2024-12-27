<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de miembros</title>
</head>

<body>
    <br><br>
    <h1>Reporte de miembros</h1>
    <table id="example1" class="table table-bordered table-striped table-sm" border="1">
        <thead>
            <tr>
                <th>Nro</th>
                <th>Grado</th>
                <th>Cargo</th>
                <th>Nombre Apellido</th>
                <th>Telefono</th>
                <th>Email</th>
                <th>Agregado</th>
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
                <td>{{$miembro->fecha_ingreso}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>