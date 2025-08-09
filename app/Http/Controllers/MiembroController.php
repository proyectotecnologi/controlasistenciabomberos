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
use Illuminate\Support\Str;

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
      $miembros = Miembro::where('fecha_ingreso', '>=', $fi)
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


      // Estas 2 filas reemplazamos por todo ese otro if y elseif
      /*if ($request->hasFile(key: 'fotografia')) {
         $miembro->fotografia = $request->file(key: 'fotografia')->store(path: 'fotografias miembros', options: 'public');
      }*/

      if ($request->has('fotografia_base64') && $request->fotografia_base64 !== '') {
         $base64 = $request->input('fotografia_base64');

         if (preg_match('/^data:image\/(\w+);base64,/', $base64, $type)) {
            $image = substr($base64, strpos($base64, ',') + 1);
            $image = base64_decode($image);
            $extension = strtolower($type[1]); // jpg, png, etc.
            //$fileName = 'foto_' . time() . '.' . $extension;
            $fileName = Str::random(40) . '.' . $extension;
            $path = public_path('storage/fotografias_miembros/' . $fileName);

            // Asegúrate de que el directorio exista
            if (!file_exists(dirname($path))) {
               mkdir(dirname($path), 0755, true);
            }

            file_put_contents($path, $image);

            // Guardar solo el path relativo al storage
            $miembro->fotografia = 'fotografias_miembros/' . $fileName;
         }
      }

      // 2. Si se sube archivo manualmente
      elseif ($request->hasFile(key: 'fotografia')) {
         $miembro->fotografia = $request->file(key: 'fotografia')->store(path: 'fotografias_miembros', options: 'public');
      }

      //$miembro->fotografia = $request->fotografia;
      //$miembro->fecha_ingreso = $request->fecha_ingreso;
      $miembro->fecha_ingreso = date($format = 'Y-m-d');
      $miembro->save();

      return redirect()->route(route: 'miembros.index')->with('mensaje', 'Se registro al funcionario policial de la manera correcta');
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

      /* El Script original con el que agregaba imagen sin tomar una fotografia desde la camara era esta: 

      if ($request->hasFile(key: 'fotografia')) {
         Storage::delete(paths: 'public/' . $miembro->fotografia);
         $miembro->fotografia = $request->file(key: 'fotografia')->store(path: 'fotografias miembros', options: 'public');
      }*/

      if ($request->filled('fotografia_base64')) {
         // Si viene desde la cámara (base64)
         if ($miembro->fotografia && Storage::exists('public/' . $miembro->fotografia)) {
            Storage::delete('public/' . $miembro->fotografia);
         }

         $image = str_replace('data:image/png;base64,', '', $request->fotografia_base64);
         $image = str_replace(' ', '+', $image);
         $imageName = 'fotografias_miembros/' . Str::random(40) . '.png';
         Storage::disk('public')->put($imageName, base64_decode($image));
         $miembro->fotografia = $imageName;
      } elseif ($request->hasFile('fotografia')) {
         // Si se subió una imagen desde la computadora
         if ($miembro->fotografia && Storage::exists('public/' . $miembro->fotografia)) {
            Storage::delete('public/' . $miembro->fotografia);
         }

         $file = $request->file('fotografia');
         $imageName = 'fotografias_miembros/' . Str::random(40) . '.' . $file->getClientOriginalExtension();
         Storage::disk('public')->put($imageName, file_get_contents($file));
         $miembro->fotografia = $imageName;
      } else {
         // Si no se subió una nueva imagen y la fotografía actual es una predeterminada, actualizar según el género
         if (in_array($miembro->fotografia, ['images/Mujer.png', 'images/Hombre.png'])) {
            $miembro->fotografia = $request->genero == 'Femenino' ? 'images/Mujer.png' : 'images/Hombre.png';
         }
      }
      $miembro->save();
      return redirect()->route(route: 'miembros.index')->with('mensaje', 'Se actualizo datos de funcionario policial de la manera correcta');
   }

   public function destroy($id)
   {
      $miembro = Miembro::find($id);
      Storage::delete(paths: 'public/' . $miembro->fotografia);
      Miembro::destroy($id);
      return redirect()->route(route: 'miembros.index')->with('mensaje', 'Se elimino datos del funcionario policial de la manera correcta');
   }
}
