@extends('layouts.admin')

@section('content')

<div class="content" style="margin-left: 20px">
    <h1>Actualizar datos del miembro</h1><br>


    @foreach($errors->all() as $error)
    <div class="alert alert-danger">
        <li>{{$error}}</li>
    </div>
    @endforeach


    <div class="row">
        <div class="col-md-11">
            <div class="card card-outline card-success">
                <div class="card-header">
                    <h3 class="card-title"><b>Llene los datos</b></h3>
                </div>
                <div class="card-body" style="display: block;"> <!--aqui nos dice el tamaño de los cajones de texto-->
                    <form action="{{url('/miembros', $miembro->id)}}" method="post" enctype="multipart/form-data">
                        @csrf
                        {{method_field('PATCH')}}
                        <div class="row">
                            <div class="col-md-9">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">Grado</label><b>*</b>
                                            <input type="text" name="grado" value="{{$miembro->grado}}" class="form-control" required>
                                            <!--@error('grado')
                                            <small style="color: red;">* Este campo es requerido</small>
                                            @enderror -->
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">Cargo</label><b>*</b>
                                            <input type="text" name="cargo" value="{{$miembro->cargo}}" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">Nombres Apellidos</label><b>*</b>
                                            <input type="text" name="nombre_apellido" value="{{$miembro->nombre_apellido}}" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">ci</label><b>*</b>
                                            <input type="text" name="ci" value="{{$miembro->ci}}" class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">Direccion</label><b>*</b>
                                            <input type="text" name="direccion" value="{{$miembro->direccion}}" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">Telefono</label><b>*</b>
                                            <input type="number" name="telefono" value="{{$miembro->telefono}}" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">Fecha de nacimiento</label><b>*</b>
                                            <input type="date" name="fecha_de_nacimiento" value="{{$miembro->fecha_de_nacimiento}}" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">Genero</label>
                                            <select name="genero" class="form-control" id="">
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
                                            <label for="">Email</label><b>*</b>
                                            <input type="email" name="email" value="{{$miembro->email}}" class="form-control" required>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">Estado</label>
                                            <input type="text" name="estado" value="{{$miembro->estado}}" class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">Division o Dependencia</label><b>*</b>
                                            <input type="text" name="division_o_dependencia" value="{{$miembro->division_o_dependencia}}" class="form-control" required>
                                        </div>
                                    </div>
                                    <!--<div class="cold-md-3">
                                        <div class="form-group">
                                            <label for="">Fecha de ingreso</label> <b>*</b>
                                            <input type="date" name="fecha_ingreso" value="{{$miembro->fecha_ingreso}}" class="form-control" required>
                                        </div>
                                    </div>-->
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Fotografia</label>
                                    <input type="file" id="file" name="fotografia" class="form-control"><br>
                                    <center>
                                        <output id="list">
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

                                        </output>
                                    </center>
                                    <script>
                                        function archivo(evt) {
                                            var files = evt.target.files; //FileList object
                                            //Obtenemos la imagen del campo "file".
                                            for (var i = 0, f; f = files[i]; i++) {
                                                //Solo adminitimos imagenes.
                                                if (!f.type.match('image.*')) {
                                                    continue;
                                                }
                                                var reader = new FileReader();
                                                reader.onload = (function(theFile) {
                                                    return function(e) {
                                                        //Insertamos la imagen
                                                        document.getElementById("list").innerHTML = ['<img class="thumb thumbnail" src="', e.target.result, '" width="70%" title="', escape(theFile.name), '"/>'].join('');
                                                    };
                                                })(f);
                                                reader.readAsDataURL(f);
                                            }
                                        }
                                        document.getElementById('file').addEventListener('change', archivo, false);
                                    </script>
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


<!--datos de {{$miembro->nombre_apellido}}-->