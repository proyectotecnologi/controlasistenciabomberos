<?php

namespace App\Http\Controllers;

use App\Models\Miembro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
//use Illuminate\Support\Facades\Storage;
//use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Barryvdh\DomPDF\Facade\Pdf;

class MiembroController extends Controller
{
   public function index()
   {
      $miembros = Miembro::all();
      return view('miembros.index', ['miembros' => $miembros]);
   }

   public function reportes(request $request): View
   {
      return view('miembros.reportes');
   }

   public function pdf(request $request) 
   {
      $miembros = Miembro::all();
      $pdf = Pdf::loadView('miembros.pdf', ['miembros' => $miembros]);
      return $pdf->stream('miembros.pdf');
   }

   public function pdf_fechas(request $request) 
   {
      $fi = $request->fi;
      $ff = $request->ff;
      $miembros = Miembro::where('fecha_ingreso','>=', $fi)
      ->where('fecha_ingreso', '<=', $ff)
      ->get();

      //$fechas = request()->all();
      //return response()->json($fechas);
      //$asistencias = Asistencia::paginate();
      $pdf = Pdf::loadView('miembros.pdf_fechas', ['miembros' => $miembros]);
      return $pdf->stream('miembros.pdf_fechas');
      //return view('asistencia.pdf_fechas', ['asistencias' => $asistencias]);
   }

   public function create()
   {
      return view('miembros.create');
   }

   public function store(Request $request)
   {
      //$miembro = request()->all();
      //return response()->json($miembro);
      $request->validate([
         'grado' => 'required',
         'cargo' => 'required',
         'nombre_apellido' => 'required',
         'ci' => 'required',
         'direccion' => 'required',
         'telefono' => 'required',
         'fecha_de_nacimiento' => 'required',
         'email' => 'required',
         'division_o_dependencia' => 'required',
         //'fecha_ingreso' => 'required',
      ]);


      $miembro = new Miembro();

      $miembro->grado = $request->grado;
      $miembro->cargo = $request->cargo;
      $miembro->nombre_apellido = $request->nombre_apellido;
      $miembro->ci = $request->ci;
      $miembro->direccion = $request->direccion;
      $miembro->telefono = $request->telefono;
      $miembro->fecha_de_nacimiento = $request->fecha_de_nacimiento;
      $miembro->genero = $request->genero;
      $miembro->email = $request->email;
      $miembro->estado = $request->estado;
      $miembro->division_o_dependencia = $request->division_o_dependencia;

      if ($request->hasFile(key: 'fotografia')) {
         $miembro->fotografia = $request->file(key: 'fotografia')->store(path: 'fotografias miembros', options: 'public');
      }
      //$miembro->fotografia = $request->fotografia;
      //$miembro->fecha_ingreso = $request->fecha_ingreso;
      $miembro->fecha_ingreso = date($format = 'Y-m-d');
      $miembro->save();

      return redirect()->route(route: 'miembros.index')->with('mensaje', 'Se registro al miembro de la manera correcta');
   }

   public function show($id)
   {
      $miembro = Miembro::findOrFail($id);
      //return response()->json($miembro);
      return view('miembros.show', ['miembro' => $miembro]);
   }

   public function edit($id)
   {
      $miembro = Miembro::findOrFail($id);
      return view('miembros.edit', ['miembro' => $miembro]);
   }

   public function update(Request $request, $id)
   {

      $request->validate([
         'grado' => 'required',
         'cargo' => 'required',
         'nombre_apellido' => 'required',
         'ci' => 'required',
         'direccion' => 'required',
         'telefono' => 'required',
         'fecha_de_nacimiento' => 'required',
         'email' => 'required',
         'division_o_dependencia' => 'required',
        //'fecha_ingreso' => 'required',
      ]);

      $miembro = Miembro::find($id);

      $miembro->grado = $request->grado;
      $miembro->cargo = $request->cargo;
      $miembro->nombre_apellido = $request->nombre_apellido;
      $miembro->ci = $request->ci;
      $miembro->direccion = $request->direccion;
      $miembro->telefono = $request->telefono;
      $miembro->fecha_de_nacimiento = $request->fecha_de_nacimiento;
      $miembro->genero = $request->genero;
      $miembro->email = $request->email;
      //$miembro->estado = $request->estado;
      $miembro->division_o_dependencia = $request->division_o_dependencia;

      if ($request->hasFile(key: 'fotografia')) {
         Storage::delete(paths: 'public/' . $miembro->fotografia);
         $miembro->fotografia = $request->file(key: 'fotografia')->store(path: 'fotografias miembros', options: 'public');
      }

      $miembro->save();

      return redirect()->route(route: 'miembros.index')->with('mensaje', 'Se actualizo al miembro de la manera correcta');
   }

   public function destroy($id)
   {
      $miembro = Miembro::find($id);
      Storage::delete(paths: 'public/' . $miembro->fotografia);
      Miembro::destroy($id);
      return redirect()->route(route: 'miembros.index')->with('mensaje', 'Se elimino al miembro de la manera correcta');
   }
}
