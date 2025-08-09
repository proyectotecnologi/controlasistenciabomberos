@extends('layouts.admin')

@section('content')

<div class="content" style="margin: 20px">
    <h1>Pagina principal</h1>

    <div class="row">
        <div class="col-lg-3">
            <div class="small-box bg-info" style="height: 160px">
                <div class="inner">
                    <?php $contador_de_division = 0; ?>
                    @foreach($divisions as $division)
                    <?php $contador_de_division = $contador_de_division + 1; ?>

                    @endforeach
                    <h3><?= $contador_de_division; ?></h3>
                    <p>Divisiones</p>
                </div>
                <div class="icon">
                    <i class="bi bi-building-check"></i>
                </div>
                <a href="{{url('divisions')}}" class="small-box-footer" style="margin-top: 20px">Más información <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3">
            <div class="small-box bg-success" style="height: 160px">
                <div class="inner">
                    <?php $contador_de_miembro = 0; ?>
                    @foreach($miembros as $miembro)
                    <?php $contador_de_miembro = $contador_de_miembro + 1; ?>

                    @endforeach
                    <h3><?= $contador_de_miembro; ?></h3>
                    <p>Funcionarios Policiales</p>
                </div>
                <div class="icon">
                    <i class="bi bi-person-plus-fill"></i>
                </div>
                <a href="{{url('miembros')}}" class="small-box-footer" style="margin-top: 20px">Más información <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3">
            <div class="small-box bg-warning" style="height: 160px">
                <div class="inner">
                    <?php $contador_de_usuarios = 0; ?>
                    @foreach($usuarios as $usuario)
                    <?php $contador_de_usuarios = $contador_de_usuarios + 1; ?>

                    @endforeach
                    <h3><?= $contador_de_usuarios; ?></h3>
                    <p>Usuarios</p>
                </div>
                <div class="icon">
                    <i class="bi bi-person-vcard"></i>
                </div>
                <a href="{{url('usuarios')}}" class="small-box-footer" style="margin-top: 20px">Más información <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>


        <div class="col-lg-3">
            <div class="small-box bg-primary" style="height: 160px">
                <div class="inner">
                    <?php $contador_de_asistencias = 0; ?>
                    @foreach($asistencias as $asistencia)
                    <?php $contador_de_asistencias = $contador_de_asistencias + 1; ?>

                    @endforeach
                    <h3><?= $contador_de_asistencias; ?></h3>
                    <p>Marcado de Asistencias de Ingreso</p>
                </div>
                <div class="icon">
                <i class="bi bi-clock-fill"></i>
                </div>
                <a href="{{url('asistencias')}}" class="small-box-footer" style="margin-top: 20px">Más información <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>


        <div class="col-lg-3">
            <div class="small-box bg-danger" style="height: 160px">
                <div class="inner">
                    <?php $contador_de_asistenciasalidas = 0; ?>
                    @foreach($asistenciasalidas as $asistenciasalida)
                    <?php $contador_de_asistenciasalidas = $contador_de_asistenciasalidas + 1; ?>

                    @endforeach
                    <h3><?= $contador_de_asistenciasalidas; ?></h3>
                    <p>Marcado de Asistencia de Salidas</p>
                </div>
                <div class="icon">
                <i class="bi bi-clock"></i>
                </div>
                <a href="{{url('asistenciasalidas')}}" class="small-box-footer" style="margin-top: 20px">Más información <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    </div>
</div>

@endsection