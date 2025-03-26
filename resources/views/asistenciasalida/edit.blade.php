@extends('layouts.admin')



@section('content')
    <section class="content container-fluid">
        <div class="">
            <div class="col-md-8">

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">Editar la Asistencia de Salida</span>
                    </div>
                    <div class="card-body bg-white card-outline card-primary">
                        <form method="POST" action="{{ route('asistenciasalidas.update', $asistenciasalida->id) }}"  role="form" enctype="multipart/form-data">
                            {{ method_field('PATCH') }}
                            @csrf

                            @include('asistenciasalida.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
