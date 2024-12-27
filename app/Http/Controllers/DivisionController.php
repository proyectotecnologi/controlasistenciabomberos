<?php

namespace App\Http\Controllers;

use App\Models\Division;
use Illuminate\Http\Request;

class DivisionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $divisions = Division::all(); //Aqui se esta realizando una consulta con Eloquent de Laravel
        return view('divisions.index', ['divisions' => $divisions]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('divisions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //$miembro = request()->all();
        //return response()->json($miembro);
        $request->validate([
            'nombre_division' => 'required',
            'seccion' => 'required',
            'fecha_ingreso' => 'required',
        ]);

        $division = new Division();
        $division->nombre_division = $request->nombre_division;
        $division->seccion = $request->seccion;
        $division->descripcion = $request->descripcion;
        $division->estado = '1';
        $division->fecha_ingreso = $request->fecha_ingreso;
        $division->save();

        return redirect()->route(route: 'divisions.index')->with('mensaje', 'Se registro a la division de la manera correcta');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $division = Division::findOrFail($id); //Estamos buscando el registro de la base de datos
        return view('divisions.show', ['division' => $division]); //Retornamos en el array
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $division = Division::findOrFail($id); //Estamos buscando el registro de la base de datos
        return view('divisions.edit', ['division' => $division]); //Retornamos en el array
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre_division' => 'required',
            'seccion' => 'required',
            'fecha_ingreso' => 'required',
        ]);

        $division = Division::find($id);
        $division->nombre_division = $request->nombre_division;
        $division->seccion = $request->seccion;
        $division->descripcion = $request->descripcion;
        $division->fecha_ingreso = $request->fecha_ingreso;
        $division->save();

        return redirect()->route(route: 'divisions.index')->with('mensaje', 'Se actualizo a la division de la manera correcta');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Division::destroy($id);
        return redirect()->route(route: 'divisions.index')->with('mensaje', 'Se elimino a la division de la manera correcta');
    }
}
