<?php

namespace App\Http\Controllers;

use App\Models\Asistenciasalida;
use App\Models\Miembro;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\AsistenciasalidaRequest;
use App\Models\Asistencia;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Barryvdh\DomPDF\Facade\Pdf;

class AsistenciasalidaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $asistenciasalidas = Asistenciasalida::paginate();

        return view('asistenciasalida.index', compact('asistenciasalidas'))
            ->with('i', ($request->input('page', 1) - 1) * $asistenciasalidas->perPage());
    }

    public function reportes(Request $request): View
    {
        //$asistenciasalidas = Asistenciasalida::paginate();

        return view('asistenciasalida.reportes');
        //->with('i', ($request->input('page', 1) - 1) * $asistenciasalidas->perPage());
    }

    public function pdf(Request $request)
    {
        $asistenciasalidas = Asistenciasalida::all();
        $pdf = Pdf::loadView('asistenciasalida.pdf', ['asistenciasalidas' => $asistenciasalidas]);
        return $pdf->stream('asistenciasalida.pdf');
        /*$asistenciasalidas = Asistenciasalida::paginate();

        return view('asistenciasalida.pdf', compact('asistenciasalidas'))
            ->with('i', ($request->input('page', 1) - 1) * $asistenciasalidas->perPage());*/
    }

    public function pdf_fechas(Request $request)
    {
        $fi = $request->fi;
        $ff = $request->ff;
        $asistenciasalidas = Asistenciasalida::where('fecha_salida', '>=', $fi)
            ->where('fecha_salida', '<=', $ff)
            ->get();

        //$fechas = request()->all();
        //return response()->json($fechas);
        //$asistencias = Asistencia::paginate();
        $pdf = Pdf::loadView('asistenciasalida.pdf_fechas', ['asistenciasalidas' => $asistenciasalidas]);
        return $pdf->stream('asistenciasalida.pdf_fechas');
        //return view('asistencia.pdf_fechas', ['asistencias' => $asistencias]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $asistenciasalida = new Asistenciasalida();
        $miembros = Miembro::pluck('nombre_apellido', 'id');
        $asistencias = Asistencia::with('miembro')->get()->mapWithKeys(function ($asistencia) {
            return [
                $asistencia->id => $asistencia->fecha . ' ingreso ' . ($asistencia->miembro->nombre_apellido ?? 'Sin nombre')
            ];
        });

        return view('asistenciasalida.create', compact('asistenciasalida', 'miembros', 'asistencias'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AsistenciasalidaRequest $request): RedirectResponse
    {
        Asistenciasalida::create($request->validated());

        return Redirect::route('asistenciasalidas.index')
            ->with('mensaje', 'Se registro a la asistencia hora de salida de la manera correcta');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $asistenciasalida = Asistenciasalida::find($id);

        return view('asistenciasalida.show', compact('asistenciasalida'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $asistenciasalida = Asistenciasalida::find($id);
        $miembros = Miembro::pluck('nombre_apellido', 'id');
        $asistencias = Asistencia::with('miembro')->get()->mapWithKeys(function ($asistencia) {
            return [
                $asistencia->id => $asistencia->fecha . ' - ' . ($asistencia->miembro->nombre_apellido ?? 'Sin nombre')
            ];
        });
        return view('asistenciasalida.edit', compact('asistenciasalida', 'miembros', 'asistencias'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AsistenciasalidaRequest $request, Asistenciasalida $asistenciasalida): RedirectResponse
    {
        $asistenciasalida->update($request->validated());

        return Redirect::route('asistenciasalidas.index')
            ->with('mensaje', 'Se edito la asistencia hora de salida de la manera correcta');
    }

    public function destroy($id): RedirectResponse
    {
        Asistenciasalida::find($id)->delete();

        return Redirect::route('asistenciasalidas.index')
            ->with('mensaje', 'Se elimino el registro de la asistencia de salida de la manera correcta');
    }
}
