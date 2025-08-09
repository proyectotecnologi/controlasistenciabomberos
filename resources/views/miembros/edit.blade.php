@extends('layouts.admin')

@section('content')

<div class="content" style="margin-left: 20px">
    <h1>Actualizar Datos del Funcionario Policial</h1><br>


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
                                            <select name="genero" class="form-control" id="genero">
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

                            <!-- El script que utilizaba sin incluir para fotografia con la camara es este


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
                            </div> -->

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Fotografía</label>

                                    <input type="file" id="file" name="fotografia" class="form-control"><br>

                                    <!-- Botones y video -->
                                    <button type="button" class="btn btn-primary btn-sm mt-2" id="startCamera">Activar Cámara</button>
                                    <video id="video" width="100%" autoplay style="display: none;"></video><br>
                                    <button type="button" class="btn btn-success btn-sm mt-2" id="snap" style="display: none;">Tomar Foto</button>
                                    <canvas id="canvas" style="display: none;"></canvas><br>

                                    <center>
                                        <output id="list">
                                            @if($miembro->fotografia == '')
                                            @if($miembro->genero == 'Masculino')
                                            <img id="photo" src="{{url('images/Hombre.png')}}" width="170px" alt="">
                                            @else
                                            <img id="photo" src="{{url('images/Mujer.png')}}" width="170px" alt="">
                                            @endif
                                            @else
                                            <img id="photo" src="{{asset('storage').'/'.$miembro->fotografia}}" width="170px" alt="">
                                            @endif
                                        </output>
                                    </center>

                                    <input type="hidden" name="fotografia_base64" id="fotografia_base64">
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

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const generoSelect = document.getElementById('genero');
        const photo = document.getElementById('photo');
        const fileInput = document.getElementById('file');
        const inputBase64 = document.getElementById("fotografia_base64");

        generoSelect.addEventListener('change', function() {
            // Solo cambiar si no se ha cargado ni tomado una foto
            if (!fileInput.files.length && !inputBase64.value) {
                if (generoSelect.value === 'Masculino') {
                    photo.src = "{{ url('images/Hombre.png') }}";
                } else if (generoSelect.value === 'Femenino') {
                    photo.src = "{{ url('images/Mujer.png') }}";
                }
            }
        });

        // Manejo de carga manual de archivo
        fileInput.addEventListener('change', function(evt) {
            const files = evt.target.files;
            if (files && files[0] && files[0].type.match('image.*')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    photo.src = e.target.result;
                    inputBase64.value = ''; // Limpiar base64 si viene de archivo
                };
                reader.readAsDataURL(files[0]);
            }
        });

        // Activar cámara y tomar foto
        const video = document.getElementById('video');
        const canvas = document.getElementById('canvas');
        const snap = document.getElementById("snap");
        const startCameraBtn = document.getElementById("startCamera");
        let stream;

        startCameraBtn.addEventListener("click", function() {
            navigator.mediaDevices.getUserMedia({
                    video: true,
                    audio: false
                })
                .then(function(mediaStream) {
                    stream = mediaStream;
                    video.srcObject = stream;
                    video.style.display = "block";
                    snap.style.display = "inline-block";
                })
                .catch(function(err) {
                    console.error("No se pudo acceder a la cámara: ", err);
                });
        });

        snap.addEventListener("click", function() {
            const context = canvas.getContext('2d');
            canvas.width = 640;
            canvas.height = 640;
            context.drawImage(video, 0, 0, canvas.width, canvas.height);
            const dataURL = canvas.toDataURL('image/png');
            photo.src = dataURL;
            inputBase64.value = dataURL;
            if (stream) {
                stream.getTracks().forEach(track => track.stop());
            }
            video.style.display = "none";
            snap.style.display = "none";
        });
    });
</script>


@endsection


<!--datos de {{$miembro->nombre_apellido}}-->