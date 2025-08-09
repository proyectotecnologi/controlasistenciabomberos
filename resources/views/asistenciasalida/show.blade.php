@extends('layouts.admin')

@section('template_title')
    {{ $asistenciasalida->name ?? __('Show') . " " . __('Asistenciasalida') }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="float-left">
                            <span class="card-title" style="font-size: 1.5em; font-weight: bold;">Detalle de Control de Asistencia Hora de Salida</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary btn-sm" href="{{ route('asistenciasalidas.index') }}">Volver Atras</a>
                        </div>
                    </div>

                    <div class="card-body bg-white card-outline card-primary">
                        
                                <div class="form-group mb-2 mb20">
                                    <strong>Fecha y Hora de Salida:</strong>
                                    {{ $asistenciasalida->fecha_salida }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Motivo de la Salida:</strong>
                                    {{ $asistenciasalida->motivo_salida }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Nombres y Apellidos del Funcionario Policial:</strong>
                                    {{ $asistenciasalida->miembro->nombre_apellido}}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Fecha y Hora que Marco Asistencia Ingreso</strong>
                                    {{ $asistenciasalida->asistencia->fecha}}
                                </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
