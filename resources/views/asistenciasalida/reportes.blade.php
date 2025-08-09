@extends('layouts.admin')

@section('template_title')
Asistenciasalidas
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div style="display: flex; justify-content: space-between; align-items: center;">

                        <span id="card_title" style="font-size: 24px; font-weight: bold;">
                            Reporte de las Asistencias Ingreso y Salida
                        </span>
                    </div>
                </div>
                @if ($message = Session::get('success'))
                <div class="alert alert-success m-4">
                    <p>{{ $message }}</p>
                </div>
                @endif

                <div class="card-body bg-white">
                    <div class="row">
                        <div class="col-md-3 col-sm-6 col-12">
                            <div class="info-box" style="height: 92px;">
                                <span class="info-box-icon bg-info">
                                    <a href="{{url('/asistenciasalidas/pdf')}}">
                                        <i class="far "><i class="bi bi-printer"></i></i>
                                    </a>
                                </span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Imprimir reporte</span>
                                    <span class="info-box-number">Asistencia</span>
                                </div>

                            </div>
                        </div>


                        <div class="col-md-6 col-sm-6 col-12">
                            <div class="info-box">
                                <span class="info-box-icon bg-red">
                                    <a href="{{url('/asistenciasalidas/pdf_fechas')}}">
                                        <i class="far "><i class="bi bi-printer"></i></i>
                                    </a>
                                </span>
                                <div class="info-box-content">
                                    <form action="{{url('asistenciasalidas/pdf_fechas')}}" method="get">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label for="">Fecha de inicio</label>
                                                <input type="datetime-local" name="fi" class="form-control">
                                            </div>
                                            <div class="col-md-4">
                                                <label for="">Fecha final</label>
                                                <input type="datetime-local" name="ff" class="form-control">
                                            </div>
                                            <div class="col-md-4">
                                                <div style="height: 37px;"></div>
                                                <button type="submit" class="btn btn-success">Generar reporte</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection