<?php

namespace App\Http\Controllers;

use App\Models\Asistencia;
use App\Models\Miembro;
use App\Models\Marcaciones; // ← IMPORTANTE: AGREGAR ESTA LÍNEA
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Models\Division;
use App\Models\Asistenciasalida;

class HomeController extends Controller
{
    public function dashboard()
    {

        $divisions = Division::all();
        $miembros = Miembro::all();
        $usuarios = User::all();
        $asistencias = Asistencia::all();
        $asistenciasalidas = Asistenciasalida::all();

        return view('index', compact(
            'divisions',
            'miembros',
            'usuarios',
            'asistencias','asistenciasalidas'
        )); // Tu nombre de vista original
    }

    
}