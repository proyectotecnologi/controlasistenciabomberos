<?php

namespace App\Http\Controllers;

use App\Models\Asignacion;
use App\Models\Miembro;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
//use Illuminate\Support\Facades\Storage;
//use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;


class MiembroController extends Controller
{
   public function index()
   {
      $m = Miembro::all();

      $miembros = Miembro::with('asignacion')->get();
      // dd($miembros);
      return view('miembros.index', compact('miembros'));
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
      $request->validate([
         'grado' => 'required',
         'cargo' => 'required',
         'nombre_apellido' => 'required',
         'ci' => 'required|unique:miembros,ci',
         'direccion' => 'required',
         'telefono' => 'required',
         'fecha_de_nacimiento' => 'required',
         'email' => 'required|email|unique:users,email',
         'division_o_dependencia' => 'required',
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
      $miembro->estado = $request->estado ? 1 : 0;
      $miembro->division_o_dependencia = $request->division_o_dependencia;
      $miembro->fecha_ingreso = date('Y-m-d');

      // ============= GUARDAR FOTOGRAFÍA =============
      $fotografiaPath = null;

      // 1. Si viene imagen en base64 (desde cámara web)
      if ($request->has('fotografia_base64') && $request->fotografia_base64 !== '') {
         $base64 = $request->input('fotografia_base64');

         if (preg_match('/^data:image\/(\w+);base64,/', $base64, $type)) {
            $image = substr($base64, strpos($base64, ',') + 1);
            $image = base64_decode($image);
            $extension = strtolower($type[1]);
            $fileName = Str::random(40) . '.' . $extension;

            // Guardar en storage/app/public/fotografias_usuarios/
            $path = storage_path('app/public/fotografias_usuarios/' . $fileName);

            if (!file_exists(dirname($path))) {
               mkdir(dirname($path), 0755, true);
            }

            file_put_contents($path, $image);
            $fotografiaPath = 'fotografias_usuarios/' . $fileName;
         }
      }
      // 2. Si se sube archivo manualmente
      elseif ($request->hasFile('fotografia')) {
         $fotografiaPath = $request->file('fotografia')->store('fotografias_usuarios', 'public');
      }

      $miembro->fotografia = $fotografiaPath;
      $miembro->save();

      // ============= CREAR USUARIO REUTILIZANDO LA MISMA FOTO =============
      $user = User::create([
         'name' => $request->nombre_apellido,
         'email' => $request->email,
         'password' => Hash::make($request->ci),
         'fotografia' => $fotografiaPath, // Misma foto del miembro
         'fecha_ingreso' => date('Y-m-d'),
         'estado' => 1,
      ]);

      $user->assignRole('Funcionario');

      return redirect()->route('miembros.index')
         ->with('mensaje', 'Se registró al funcionario policial de manera correcta');
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
      ]);

      $miembro = Miembro::findOrFail($id);

      $miembro->grado = $request->grado;
      $miembro->cargo = $request->cargo;
      $miembro->nombre_apellido = $request->nombre_apellido;
      $miembro->ci = $request->ci;
      $miembro->direccion = $request->direccion;
      $miembro->telefono = $request->telefono;
      $miembro->fecha_de_nacimiento = $request->fecha_de_nacimiento;
      $miembro->genero = $request->genero;
      $miembro->email = $request->email;
      $miembro->estado = $request->estado ? 1 : 0;
      $miembro->division_o_dependencia = $request->division_o_dependencia;

      // =================== FOTOGRAFÍA ===================
      $fotografiaPath = $miembro->fotografia;

      if ($request->filled('fotografia_base64')) {
         // Si hay foto anterior, borrarla
         if ($fotografiaPath && Storage::exists('public/' . $fotografiaPath)) {
            Storage::delete('public/' . $fotografiaPath);
         }

         $base64 = $request->fotografia_base64;
         if (preg_match('/^data:image\/(\w+);base64,/', $base64, $type)) {
            $image = substr($base64, strpos($base64, ',') + 1);
            $image = base64_decode($image);
            $extension = strtolower($type[1]);
            $fileName = 'fotografias_usuarios/' . Str::random(40) . '.' . $extension;
            Storage::disk('public')->put($fileName, $image);
            $fotografiaPath = $fileName;
         }
      } elseif ($request->hasFile('fotografia')) {
         if ($fotografiaPath && Storage::exists('public/' . $fotografiaPath)) {
            Storage::delete('public/' . $fotografiaPath);
         }

         $file = $request->file('fotografia');
         $fileName = 'fotografias_usuarios/' . Str::random(40) . '.' . $file->getClientOriginalExtension();
         Storage::disk('public')->put($fileName, file_get_contents($file));
         $fotografiaPath = $fileName;
      }

      $miembro->fotografia = $fotografiaPath;
      $miembro->save();

      return redirect()->route('miembros.index')
         ->with('mensaje', 'Se actualizaron los datos del funcionario correctamente');
   }


   // public function destroy($id)
   // {
   //    $miembro = Miembro::find($id);
   //    Storage::delete(paths: 'public/' . $miembro->fotografia);
   //    Miembro::destroy($id);
   //    return redirect()->route(route: 'miembros.index')->with('mensaje', 'Se elimino datos del funcionario policial de la manera correcta');
   // }

   public function destroy($id)
   {
      $miembro = Miembro::findOrFail($id);

      if ($miembro->fotografia && Storage::exists('public/' . $miembro->fotografia)) {
         Storage::delete('public/' . $miembro->fotografia);
      }

      $user = User::where('email', $miembro->email)->first();
      if ($user) {
         if ($user->fotografia && Storage::exists('public/' . $user->fotografia)) {
            Storage::delete('public/' . $user->fotografia);
         }
         $user->delete();
      }

      $miembro->delete();

      return redirect()->route('miembros.index')
         ->with('mensaje', 'Se eliminaron los datos del funcionario policial y su usuario asociado correctamente');
   }
}
