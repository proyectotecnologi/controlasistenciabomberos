<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Division;
use App\Models\Miembro;
use App\Models\User;
use App\Models\Asistencia;
use App\Models\Asistenciasalida;

class AdminController extends Controller
{
    public function index()
    {
        $divisions = Division::all();
        $miembros = Miembro::all();
        $usuarios = User::all();
        $asistencias = Asistencia::all();
        $asistenciasalidas = Asistenciasalida::all();
        return view('index', ['divisions' => $divisions, 'miembros' => $miembros, 'usuarios' => $usuarios, 'asistencias'=>$asistencias, 'asistenciasalidas'=>$asistenciasalidas]);
    }
}
