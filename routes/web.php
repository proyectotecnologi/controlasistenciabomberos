<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AsistenciaController;
use App\Http\Controllers\MiembroController;
/*Route::get('/', function () {
    return view(view: 'index');
})->middleware(middleware: 'auth');*/

Route::get('/asistencias/reportes', [AsistenciaController::class, 'reportes'])->name('reportes');
Route::get('/asistencias/pdf', [AsistenciaController::class, 'pdf'])->name('pdf');
Route::get('/asistencias/pdf_fechas', [AsistenciaController::class, 'pdf_fechas'])->name('pdf_fechas');
Route::get('/miembros/reportes', [MiembroController::class, 'reportes'])->name('reportesmiembros');
Route::get('/miembros/pdf', [MiembroController::class, 'pdf'])->name('pdfmiembros');
Route::get('/miembros/pdf_fechas', [MiembroController::class, 'pdf_fechas'])->name('pdf_fechas_miembros');
Route::get('/', [App\Http\Controllers\AdminController::class, 'index'])->name('index');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Auth::routes(['register' => true]);


//Auth::routes(['register' => false]);

//Route::get('/miembros', [App\Http\Controllers\MiembroController::class, 'index']);
//Route::get('/miembros/create', [App\Http\Controllers\MiembroController::class, 'create']);

Route::resource(name: '/miembros', controller: \App\Http\Controllers\MiembroController::class)->middleware('can:miembros'); 

Route::resource(name: '/divisions', controller: \App\Http\Controllers\DivisionController::class)->middleware('can:divisions'); 

Route::resource(name: '/usuarios', controller: \App\Http\Controllers\UserController::class)->middleware('can:usuarios');

Route::resource(name: '/asistencias', controller: \App\Http\Controllers\AsistenciaController::class)->middleware('can:asistencias');


//Route::get('/miembros', function () { return view( view: 'miembros.index');})->middleware( middleware: 'auth');;

/*Route::get('/miembros/create', function () {
    return view(view: 'miembros.create');
})->middleware(middleware: 'auth');;*/
