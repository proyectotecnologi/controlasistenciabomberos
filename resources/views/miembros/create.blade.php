@extends('layouts.admin')

@section('content')

<div class="content" style="margin-left: 20px">
    <h1>Creacion de un nuevo miembro</h1><br>


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
                    <form action="{{url('/miembros')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-9">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">Grado</label><b>*</b>
                                            <input type="text" name="grado" value="{{old('grado')}}" class="form-control" required>
                                            <!--@error('grado')
                                            <small style="color: red;">* Este campo es requerido</small>
                                            @enderror -->
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">Cargo</label><b>*</b>
                                            <input type="text" name="cargo" value="{{old('cargo')}}" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">Nombres Apellidos</label><b>*</b>
                                            <input type="text" name="nombre_apellido" value="{{old('nombre_apellido')}}" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">ci</label><b>*</b>
                                            <input type="text" name="ci" value="{{old('ci')}}" class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">Direccion</label><b>*</b>
                                            <input type="text" name="direccion" value="{{old('direccion')}}" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">Telefono</label><b>*</b>
                                            <input type="number" name="telefono" value="{{old('telefono')}}" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">Fecha de nacimiento</label><b>*</b>
                                            <input type="date" name="fecha_de_nacimiento" value="{{old('fecha_de_nacimiento')}}" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">Genero</label>
                                            <select name="genero" class="form-control" id="">
                                                <option value="Masculino" {{ old ('genero' ) == 'Masculino' ? 'selected' : ''}}>Masculino</option>
                                                <option value="Femenino" {{ old ('genero' ) == 'Femenino' ? 'selected' : ''}}>Femenino</option>
                                                <!--<option value="Masculino">Masculino</option>-->
                                                <!--<option value="Femenino">Femenino</option>-->
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">Email</label><b>*</b>
                                            <input type="email" name="email" value="{{old('email')}}" class="form-control" required>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">Estado</label>
                                            <input type="text" name="estado" value="{{old('estado')}}" class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">Division o Dependencia</label><b>*</b>
                                            <input type="text" name="division_o_dependencia" value="{{old('division_o_dependencia')}}" class="form-control" required>
                                        </div>
                                    </div>
                                    <!--<div class="cold-md-3">
                                        <div class="form-group">
                                            <label for="">Fecha de ingreso</label> <b>*</b>
                                            <input type="date" name="fecha_ingreso" value="{{old('fecha_ingreso')}}" class="form-control" required>
                                        </div>
                                    </div>-->
                                </div>
                            </div>
                            <!--Este era el codigo original para agregar una foto segun los videos de tutorial antes de agregar con la camara -->
                            <!--<div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Fotografia</label>
                                    <input type="file" id="file" name="fotografia" class="form-control"><br>
                                    <center><output id="list"></output></center>
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
                            </div>-->


                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Fotografía</label>
                                    <input type="file" id="file" name="fotografia" class="form-control"><br>

                                    <!-- ✅ Botón para activar la cámara -->
                                    <button type="button" class="btn btn-primary btn-sm mt-2" id="startCamera">Activar Cámara</button>

                                    <!-- Video desactivado inicialmente -->
                                    <video id="video" width="100%" autoplay style="display: none;"></video>
                                    <br>
                                    <button type="button" class="btn btn-success btn-sm mt-2" id="snap" style="display: none;">Tomar Foto</button>

                                    <canvas id="canvas" style="display: none;"></canvas>
                                    <br>
                                    <img id="photo" src="" class="mt-2" width="100%" />

                                    <input type="hidden" name="fotografia_base64" id="fotografia_base64">
                                </div>

                                <center><output id="list"></output></center>

                                <script>
                                    const video = document.getElementById('video');
                                    const canvas = document.getElementById('canvas');
                                    const photo = document.getElementById('photo');
                                    const snap = document.getElementById("snap");
                                    const inputBase64 = document.getElementById("fotografia_base64");
                                    const startCameraBtn = document.getElementById("startCamera");

                                    // ✅ Activar cámara solo cuando se presiona el botón
                                    startCameraBtn.addEventListener("click", function() {
                                        navigator.mediaDevices.getUserMedia({
                                                video: true,
                                                audio: false
                                            })
                                            .then(function(stream) {
                                                video.srcObject = stream;
                                                video.style.display = "block"; // mostrar video
                                                snap.style.display = "inline-block"; // mostrar botón de tomar foto
                                            })
                                            .catch(function(err) {
                                                console.log("No se pudo acceder a la cámara: ", err);
                                            });
                                    });

                                    // ✅ Capturar imagen desde la cámara
                                    snap.addEventListener("click", function() {
                                        canvas.width = video.videoWidth;
                                        canvas.height = video.videoHeight;
                                        canvas.getContext("2d").drawImage(video, 0, 0, canvas.width, canvas.height);
                                        const imgData = canvas.toDataURL("image/png");
                                        photo.src = imgData;
                                        inputBase64.value = imgData;
                                    });

                                    // ✅ Imagen subida manualmente
                                    document.getElementById('file').addEventListener('change', function(evt) {
                                        const files = evt.target.files;
                                        for (let i = 0, f; f = files[i]; i++) {
                                            if (!f.type.match('image.*')) continue;
                                            const reader = new FileReader();
                                            reader.onload = function(e) {
                                                const imgData = e.target.result;
                                                photo.src = imgData;
                                                inputBase64.value = imgData;
                                            };
                                            reader.readAsDataURL(f);
                                        }
                                    }, false);
                                </script>
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


<!-- Botón para activar la cámara 
<button type="button" class="btn btn-primary btn-sm mt-2" id="startCamera">Activar Cámara</button>-->

<!-- Vista previa de cámara -->
<video id="video" width="100%" autoplay style="display: none;"></video>
<br>

<!-- Botón para tomar foto -->
<button type="button" class="btn btn-success btn-sm mt-2" id="snap" style="display: none;">Tomar Foto</button>

<!-- Canvas oculto para procesar imagen -->
<canvas id="canvas" style="display: none;"></canvas>
<br>

<!-- Imagen capturada -->
<img id="photo" src="" class="mt-2" width="100%" />

<!-- Resultado en base64 -->
<input type="hidden" name="fotografia_base64" id="fotografia_base64">

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const video = document.getElementById('video');
        const canvas = document.getElementById('canvas');
        const photo = document.getElementById('photo');
        const snap = document.getElementById("snap");
        const inputBase64 = document.getElementById("fotografia_base64");
        const startCameraBtn = document.getElementById("startCamera");

        // Tamaño deseado de la imagen final
        const WIDTH = 640;
        const HEIGHT = 640;

        let stream; // Guardar el stream para poder detenerlo luego si quieres

        // Activar la cámara solo cuando se presione el botón
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

        // Capturar la foto
        snap.addEventListener("click", function() {
            const context = canvas.getContext('2d');

            canvas.width = WIDTH;
            canvas.height = HEIGHT;

            context.drawImage(video, 0, 0, WIDTH, HEIGHT);

            const dataURL = canvas.toDataURL('image/png');

            photo.src = dataURL;
            inputBase64.value = dataURL;

            // Opcional: detener la cámara después de tomar la foto
            // stream.getTracks().forEach(track => track.stop());
            // video.style.display = "none";
            // snap.style.display = "none";
        });
    });
</script>


@endsection