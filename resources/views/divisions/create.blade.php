@extends('layouts.admin')

@section('content')

<div class="content" style="margin-left: 20px">
    <h1>Creacion de una nueva division</h1><br>


    @foreach($errors->all() as $error)
    <div class="alert alert-danger">
        <li>{{$error}}</li>
    </div>
    @endforeach


    <div class="row">
        <div class="col-md-11">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title"><b>Llene los datos</b></h3>
                </div>
                <div class="card-body" style="display: block;"> <!--aqui nos dice el tamaño de los cajones de texto-->
                    <form action="{{url('/divisions')}}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label for="">Nombre de la division</label><b>*</b>
                                            <input type="text" name="nombre_division" value="{{old('nombre_division')}}" class="form-control" required>
                                            <!--@error('grado')
                                            <small style="color: red;">* Este campo es requerido</small>
                                            @enderror -->
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">Seccion</label><b>*</b>
                                            <input type="text" name="seccion" value="{{old('seccion')}}" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Fecha de ingreso</label><b>*</b>
                                            <input type="date" name="fecha_ingreso" value="{{old('fecha_ingreso')}}" class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">Descripcion</label>
                                           <textarea class="form-control" name="descripcion" id="" cols="30" rows="10"></textarea>
                                           <script>
                                            CKEDITOR.replace( 'descripcion' );
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
                                    <button type="submit" class="btn btn-primary">Guardar registro</button>
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