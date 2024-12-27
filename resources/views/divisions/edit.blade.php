@extends('layouts.admin')

@section('content')

<div class="content" style="margin-left: 20px">
    <h1>Actualizacion de la division</h1><br>


    @foreach($errors->all() as $error)
    <div class="alert alert-danger">
        <li>{{$error}}</li>
    </div>
    @endforeach


    <div class="row">
        <div class="col-md-11">
            <div class="card card-outline card-success">
                <div class="card-header">
                    <h3 class="card-title"><b>Revice los datos</b></h3>
                </div>
                <div class="card-body" style="display: block;"> <!--aqui nos dice el tamaño de los cajones de texto-->
                    <form action="{{url('/divisions', $division->id)}}" method="post">
                        @csrf
                        {{method_field('PATCH')}}
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label for="">Nombre de la division</label><b>*</b>
                                            <input type="text" name="nombre_division" value="{{$division->nombre_division}}" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">Seccion</label><b>*</b>
                                            <input type="text" name="seccion" value="{{$division->seccion}}" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Fecha de ingreso</label><b>*</b>
                                            <input type="date" name="fecha_ingreso" value="{{$division->fecha_ingreso}}" class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">Descripcion</label>
                                            <textarea class="form-control" name="descripcion" id="" cols="30" rows="10">{!!$division->descripcion!!}</textarea>
                                            <script>
                                                CKEDITOR.replace('descripcion');
                                            </script>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <a href="" class="btn btn-secondary">Cancelar</a>
                                    <button type="submit" class="btn btn-success">Actualizar registro</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection