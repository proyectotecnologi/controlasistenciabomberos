@extends('layouts.admin')

@section('content')

<div class="content" style="margin-left: 20px">
    <h1>Creacion de un nuevo usuario</h1>

    @if($message = Session::get('mensaje'))
    <script>
        Swal.fire({
            title: "Registro exitoso",
            text: "{{$message}}",
            icon: "success"
        });
    </script>
    @endif


    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title"><b>Llene los datos del Usuario de forma correcta</b></h3>
                </div>

                <div class="card">
                    <div class="card-body" style="display: block;">
                        <form method="POST" action="{{ url('usuarios') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="row mb-3">
                                        <label for="name" class="col-md-4 col-form-label text-md-end">Nombres y apellidos del usuario</label>

                                        <div class="col-md-7">
                                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                            @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="email" class="col-md-4 col-form-label text-md-end">Correo electronico</label>

                                        <div class="col-md-7">
                                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                                            @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="password" class="col-md-4 col-form-label text-md-end">Ingrese contraseña</label>

                                        <div class="col-md-7">
                                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                            @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="password-confirm" class="col-md-4 col-form-label text-md-end">Confirmar contraseña</label>

                                        <div class="col-md-7">
                                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
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
                                </div>
                            </div>
                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <a href="{{url('/usuarios')}}" class="btn btn-secondary">
                                        Cancelar
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        Registrar Usuario
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>


            </div>

        </div>
    </div>
</div>

@endsection