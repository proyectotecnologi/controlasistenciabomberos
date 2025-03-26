@extends('layouts.admin')

@section('content')
<section class="content container-fluid">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                    <div class="float-left">
                        <span class="card-title" style="font-size: 1.5em; font-weight: bold;">Detalle del Control de Asistencia Hora de Ingreso</span>
                    </div>
                    <div class="float-right">
                        <a class="btn btn-primary btn-sm" href="{{ route('asistencias.index') }}">Volver atras</a>
                    </div>
                </div>

                <div class="card-body bg-white card-outline card-primary">

                    <div class="form-group mb-2 mb20">
                        <strong>Fecha:</strong>
                        {{ $asistencia->fecha }}
                    </div>
                    <div class="form-group mb-2 mb20">
                        <strong>Nombre y Apellido del Funcionario Policial: </strong>
                        {{ $asistencia->miembro->nombre_apellido}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection