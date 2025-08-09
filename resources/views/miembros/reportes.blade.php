@extends('layouts.admin')

@section('content')

<div class="content" style="margin-left: 20px">
    <h1 style="text-align: center;">Reporte de los Funcionarios Policiales de la Direccion Nacional de Bomberos</h1>

    @if($message = Session::get('mensaje'))
    <script>
        Swal.fire({
            title: "Registro exitoso",
            text: "{{$message}}",
            icon: "success"
        });
    </script>

    @endif

    <div class="card-body bg-white">
        <div class="row">
            <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box" style="height: 92px;">
                    <span class="info-box-icon bg-info">
                        <a href="{{url('/miembros/pdf')}}">
                            <i class="far "><i class="bi bi-printer"></i></i>
                        </a>
                    </span>
                    <div class="info-box-content">
                        <span class="info-box-text">Imprimir reporte</span>
                        <span class="info-box-number">Miembros</span>
                    </div>

                </div>
            </div>

            <div class="col-md-6 col-sm-6 col-12">
                <div class="info-box">
                    <span class="info-box-icon bg-success">
                        <a href="{{url('/miembros/pdf')}}">
                            <i class="far "><i class="bi bi-printer"></i></i>
                        </a>
                    </span>
                    <div class="info-box-content">
                        <form action="{{url('miembros/pdf_fechas')}}" method="get">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="">Fecha de inicio</label>
                                    <input type="date" name="fi" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label for="">Fecha final</label>
                                    <input type="date" name="ff" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <div style="height: 37px;"></div>
                                    <button type="submit" class="btn btn-success">Generar reporte</button>
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