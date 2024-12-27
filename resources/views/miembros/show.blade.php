@extends('layouts.admin')

@section('content')

<div class="content" style="margin-left: 20px">
    <h1>Datos del miembro registrado</h1><br>


    <div class="row">
        <div class="col-md-11">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title"><b>Datos registrados</b></h3>
                </div>
                <div class="card-body" style="display: block;"> <!--aqui nos dice el tamaño de los cajones de texto-->
                    <div class="row">
                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">Grado</label>
                                        <input type="text" name="grado" value="{{$miembro->grado}}" class="form-control" disabled>
                                        <!--@error('grado')
                                            <small style="color: red;">* Este campo es requerido</small>
                                            @enderror -->
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">Cargo</label>
                                        <input type="text" name="cargo" value="{{$miembro->cargo}}" class="form-control" disabled>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">Nombres Apellidos</label>
                                        <input type="text" name="nombre_apellido" value="{{$miembro->nombre_apellido}}" class="form-control" disabled>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">ci</label>
                                        <input type="text" name="ci" value="{{$miembro->ci}}" class="form-control" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">Direccion</label>
                                        <input type="text" name="direccion" value="{{$miembro->direccion}}" class="form-control" disabled>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">Telefono</label>
                                        <input type="number" name="telefono" value="{{$miembro->telefono}}" class="form-control" disabled>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">Fecha de nacimiento</label>
                                        <input type="date" name="fecha_de_nacimiento" value="{{$miembro->fecha_de_nacimiento}}" class="form-control" disabled>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">Genero</label>
                                        <select name="genero" class="form-control" id="" disabled>
                                            @if($miembro->genero == 'Masculino')
                                            <option value="Masculino">Masculino</option>
                                            <option value="Femenino">Femenino</option>
                                            @else
                                            <option value="Femenino">Femenino</option>
                                            <option value="Masculino">Masculino</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">Email</label>
                                        <input type="email" name="email" value="{{$miembro->email}}" class="form-control" disabled>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">Estado</label>
                                        <input type="text" name="estado" value="{{$miembro->estado}}" class="form-control" disabled>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">Division o Dependencia</label>
                                        <input type="text" name="division_o_dependencia" value="{{$miembro->division_o_dependencia}}" class="form-control" disabled>
                                    </div>
                                </div>
                                <!--<div class="cold-md-3">
                                    <div class="form-group">
                                        <label for="">Fecha de ingreso</label>
                                        <input type="date" name="fecha_ingreso" value="{{$miembro->fecha_ingreso}}" class="form-control" disabled>
                                    </div>
                                </div>-->
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">Fotografia</label><br><br>
                                @if($miembro->fotografia == '')
                                @if($miembro->genero == 'Masculino')
                                <img src="{{url('images/Hombre.png')}}" width="170px" alt="">
                                @else
                                <img src="{{url('images/Mujer.png')}}" width="170px" alt="">
                                @endif
                                @else
                                <center>
                                    <img src="{{asset('storage').'/'.$miembro->fotografia}}" width="170px" alt="">
                                </center>
                                @endif
                                <!--<center><output id="list"></output></center>-->
                            </div>
                        </div>
                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <a href="{{url('/miembros')}}" class="btn btn-danger">
                                    Cancelar
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection