<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\AsistenciasalidaRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

use App\Models\Miembro;
use App\Models\Asistenciasalida;

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

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $asistenciasalida = new Asistenciasalida();
        $miembros = Miembro::pluck('nombre_apellido', 'id');
        return view('asistenciasalida.create', compact('asistenciasalida', 'miembros'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AsistenciasalidaRequest $request): RedirectResponse
    {
        Asistenciasalida::create($request->validated());

        return Redirect::route('asistenciasalidas.index')
            ->with('success', 'Asistenciasalida created successfully.');
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
        return view('asistenciasalida.edit', compact('asistenciasalida', 'miembros'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AsistenciasalidaRequest $request, Asistenciasalida $asistenciasalida): RedirectResponse
    {
        $asistenciasalida->update($request->validated());

        return Redirect::route('asistenciasalidas.index')
            ->with('success', 'Asistenciasalida updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        Asistenciasalida::find($id)->delete();

        return Redirect::route('asistenciasalidas.index')
            ->with('success', 'Asistenciasalida deleted successfully');
    }
}
