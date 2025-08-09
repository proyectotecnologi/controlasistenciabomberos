@extends('layouts.admin')

@section('content')

<div class="content" style="margin-left: 20px">
    <h1>Datos de la Division</h1><br>


    <div class="row">
        <div class="col-md-11">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title"><b>Datos registrados</b></h3>
                </div>
                <div class="card-body" style="display: block;"> <!--aqui nos dice el tamaño de los cajones de texto-->

                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="">Nombre de la division</label>
                                        <input type="text" name="nombre_division" value="{{$division->nombre_division}}" class="form-control" disabled>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">Seccion</label>
                                        <input type="text" name="seccion" value="{{$division->seccion}}" class="form-control" disabled>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Fecha de ingreso</label>
                                        <input type="date" name="fecha_ingreso" value="{{$division->fecha_ingreso}}" class="form-control" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="">Descripcion</label>
                                        <p>{!!$division->descripcion!!}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <a href="{{url('/divisions')}}" class="btn btn-secondary">Volver Atras</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection