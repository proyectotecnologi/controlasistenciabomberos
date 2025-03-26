<?php

namespace App\Http\Controllers;

use App\Models\Asistencia;
use App\Models\Miembro;
use App\Models\Asistenciasalida;


use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\AsistenciaRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Barryvdh\DomPDF\Facade\Pdf;


class AsistenciaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         /*$asistencias = Asistencia::paginate();
        return view('asistencia.index', compact('asistencias'))
            ->with('i', ($request->input('page', 1) - 1) * $asistencias->perPage());*/
           $asistencias = Asistencia::all();
            return view('asistencia.index', ['asistencias' => $asistencias]);
    }


    public function reportes(Request $request): View
    {
        return view('asistencia.reportes');
    }

    public function pdf(Request $request)
    {
        $asistencias = Asistencia::all();
        $asistenciasalidas = Asistenciasalida::pluck('fecha_salida', 'motivo_salida', 'id');
        $pdf = Pdf::loadView('asistencia.pdf', ['asistencias' => $asistencias, 'asistenciasalidas' => $asistenciasalidas]);
        return $pdf->stream('asistencia.pdf');
    }

    public function pdf_fechas(Request $request)
    {
        $fi = $request->fi;
        $ff = $request->ff;
        $asistencias = Asistencia::where('fecha','>=', $fi)
        ->where('fecha', '<=', $ff)
        ->get();

        //$fechas = request()->all();
        //return response()->json($fechas);
        //$asistencias = Asistencia::paginate();
        $pdf = Pdf::loadView('asistencia.pdf_fechas', ['asistencias' => $asistencias]);
        return $pdf->stream('asistencia.pdf_fechas');
        //return view('asistencia.pdf_fechas', ['asistencias' => $asistencias]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $asistencia = new Asistencia();
        $miembros = Miembro::pluck('nombre_apellido', 'id');
        return view('asistencia.create', compact('asistencia', 'miembros'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AsistenciaRequest $request): RedirectResponse
    {
        Asistencia::create($request->validated());

        return Redirect::route('asistencias.index')
        ->with('mensaje', 'Se registro a la asistencia de la manera correcta');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $asistencia = Asistencia::find($id);

        return view('asistencia.show', compact('asistencia'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $asistencia = Asistencia::find($id);
        $miembros = Miembro::pluck('nombre_apellido', 'id');
        return view('asistencia.edit', compact('asistencia', 'miembros'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AsistenciaRequest $request, Asistencia $asistencia): RedirectResponse
    {
        $asistencia->update($request->validated());
        return Redirect::route('asistencias.index')
        ->with('mensaje', 'Se actualizo a la asistencia de la manera correcta');
    }

    public function destroy($id): RedirectResponse
    {
        Asistencia::find($id)->delete();
        return Redirect::route('asistencias.index')
        ->with('mensaje', 'Se elimino al miembro de la manera correcta');
    }
}
