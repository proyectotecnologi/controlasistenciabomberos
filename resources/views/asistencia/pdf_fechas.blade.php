<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de asistencias</title>
</head>

<body>
    <br><br>
    <h1>Reporte de asistencias</h1>
    <table id="example1" class="table table-bordered table-striped table-sm" border="1">
        <thead class="thead">
            <tr>
                <th>No</th>
                <th>Fecha y Hora que Marco Asistencia Ingreso</th>
                <th>Nombre y Apellido del Funcionario Policial</th>
            </tr>
        </thead>
        <tbody>
            <?php $contador_de_asistencia = 1;?>
            @foreach ($asistencias as $asistencia)
            <tr>
                <td><?=$contador_de_asistencia++;?></td>
                <td>{{ $asistencia->fecha }}</td>
                <td>{{ $asistencia->miembro->nombre_apellido}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>