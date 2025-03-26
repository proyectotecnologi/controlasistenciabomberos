@extends('layouts.admin')


@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-8">

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">Control de Asistencia de Salida</span>
                    </div>
                    <div class="card-body bg-white card-outline card-primary">
                        <form method="POST" action="{{ route('asistenciasalidas.store') }}"  role="form" enctype="multipart/form-data">
                            @csrf

                            @include('asistenciasalida.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
