<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Asistencias Ingreso y Salida</title>
</head>

<body>
    <br>
    <h1>Reporte de Asistencias Ingreso y Salida</h1>
    <table id="example1" class="table table-bordered table-striped table-sm" border="1">
        <thead class="thead">
            <tr>
                <th>No</th>
                <th>Fecha y Hora de Ingreso</th>
                <th>Fecha y Hora de Salida</th>
                <th>Motivo Salida</th>
                <th>Grado</th>
                <th>Nombres y Apellidos del Funcionario Policial</th>
                
            </tr>
        </thead>
        <tbody>
            <?php $contador_de_asistencia = 1;?>
            @foreach ($asistenciasalidas as $asistenciasalida)
            <tr>
                <td><?= $contador_de_asistencia++; ?></td>
                <!--<td>{{ $asistenciasalida->asistencia->fecha}}</td>-->
                <td>{{ \Carbon\Carbon::parse($asistenciasalida->asistencia->fecha)->format('d-m-Y H:i:s') }}</td>
                <!--<td>{{ $asistenciasalida->fecha_salida }}</td>-->
                <td>{{ \Carbon\Carbon::parse($asistenciasalida->fecha_salida)->format('d-m-Y H:i:s') }}</td>
                <td>{{ $asistenciasalida->motivo_salida }}</td>
                <td>{{ $asistenciasalida->miembro->grado}}</td>
                <td>{{ $asistenciasalida->miembro->nombre_apellido}}</td>
                 
            </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>