<?php

use App\Http\Controllers\AsignarController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AsistenciaController;
use App\Http\Controllers\MiembroController;
use App\Http\Controllers\AsistenciasalidaController;
use App\Http\Controllers\MarcarAsistenciaController;
use App\Http\Controllers\MemorandumController;
use App\Http\Controllers\PdfAsistenciaController;
use App\Http\Controllers\PermisoController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ReporteMensualController;
use App\Http\Controllers\SancionController;
use App\Http\Controllers\ToleranciaController;

/*Route::get('/', function () {
    return view(view: 'index');
})->middleware(middleware: 'auth');*/

Route::get('/asistenciasalidas/reportes', [AsistenciasalidaController::class, 'reportes'])->name('reportes');
Route::get('/asistenciasalidas/pdf', [AsistenciasalidaController::class, 'pdf'])->name('pdf');
Route::get('/asistenciasalidas/pdf_fechas', [AsistenciasalidaController::class, 'pdf_fechas'])->name('pdf_fechas');

Route::resource('/roles', RoleController::class)->names('roles');
Route::post('/usuario-rol/{id}', [RoleController::class, 'asignar_rol'])->name('asignar_rol');

//Route::get('/asistencias/reportes', [AsistenciaController::class, 'reportes'])->name('reportes');
//Route::get('/asistencias/pdf', [AsistenciaController::class, 'pdf'])->name('pdf');
//Route::get('/asistencias/pdf_fechas', [AsistenciaController::class, 'pdf_fechas'])->name('pdf_fechas');
Route::get('/miembros/reportes', [MiembroController::class, 'reportes'])->name('reportesmiembros');
Route::get('/miembros/pdf', [MiembroController::class, 'pdf'])->name('pdfmiembros');
Route::get('/miembros/pdf_fechas', [MiembroController::class, 'pdf_fechas'])->name('pdf_fechas_miembros');
Route::get('/', [App\Http\Controllers\AdminController::class, 'index'])->name('index');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'dashboard'])->name('dashboard');


Auth::routes(['register' => true]);

Route::get('/marcaciones/generar-pdf/{id}', [PdfAsistenciaController::class, 'generarPDF'])
    ->name('generar.pdf.marcaciones');


Route::controller(MarcarAsistenciaController::class)->middleware('auth')->group(function () {
    Route::get('/marcar_asistencia', 'marcar_asistencia')->name('marcar_asistencia');
    Route::get('/marcaciones',  'index')->name('marcaciones.index');
    Route::post('/marcaciones/verificar',  'verificar')->name('marcaciones.verificar');
    Route::post('/marcaciones',  'store')->name('marcaciones.store');
    Route::get('/marcaciones/ultimas',  'ultimas')->name('marcaciones.ultimas');
    Route::get('/marcaciones/hoy',  'hoy')->name('marcaciones.hoy');
});
Route::controller(MarcarAsistenciaController::class)->middleware('auth')->group(function () {
    Route::get('/lista_usuarios_asistencias', 'lista_usuarios_asistencias')->name('lista_usuarios_asistencias');
    Route::get('/historial_asistencia/{id}', 'historial_asistencia')->name('historial_asistencia');
});


// ADMINISTRADOR
Route::controller(PermisoController::class)->middleware('auth')->group(function () {
    Route::get('/lista_permisos', 'lista_permisos')->name('lista_permisos');
    Route::post('/crear_permiso', 'crear_permiso')->name('crear_permiso');
    Route::delete('/eliminar_permiso/{id}', 'eliminar_permiso')->name('eliminar_permiso');
    Route::put('/actualizar_permiso/{id}', 'actualizar_permiso')->name('actualizar_permiso');
});

Route::controller(ToleranciaController::class)->middleware('auth')->group(function () {
    Route::get('/vista_tolerancia', 'vista_tolerancia')->name('vista_tolerancia');
    Route::post('/tolerancias/guardar',  'guardar_tolerancia')->name('guardar_tolerancia');
});

// lista_memorandum
Route::controller(AsignarController::class)->middleware('auth')->group(function () {
    Route::post('/asignar_horario', 'asignar_horario')->name('asignar_horario');
});
Route::controller(MemorandumController::class)->middleware('auth')->group(function () {
    Route::get('/lista_memorandum', 'lista_memorandum')->name('lista_memorandum');
});
// Route::controller(ReporteMensualController::class)->middleware('auth')->group(function () {
//     Route::get('/vistar_reporte_mensual', 'vistar_reporte_mensual')->name('vistar_reporte_mensual');
// });

Route::get('/reportes/mensual', [ReporteMensualController::class, 'vistar_reporte_mensual'])->name('vistar_reporte_mensual');
Route::post('/reportes/mensual/generar', [ReporteMensualController::class, 'generarReporteMensual'])->name('reporte.mensual.generar');



// Rutas de sanciones
Route::get('/sancionar/{tipo}/{miembro_id}', [SancionController::class, 'sancionar'])->name('sancionar');
Route::get('/sanciones/historial/{miembro_id}', [SancionController::class, 'historial'])->name('sanciones.historial');
Route::put('/sanciones/cambiar-estado/{sancion_id}', [SancionController::class, 'cambiarEstado'])->name('sanciones.cambiar-estado');

Route::get('/sanciones/generar-pdf/{sancion_id}', [SancionController::class, 'generarPDF'])->name('sanciones.generar-pdf');
//Auth::routes(['register' => false]);

//Route::get('/miembros', [App\Http\Controllers\MiembroController::class, 'index']);
//Route::get('/miembros/create', [App\Http\Controllers\MiembroController::class, 'create']);

Route::resource(name: '/miembros', controller: \App\Http\Controllers\MiembroController::class)->middleware('can:miembros');

Route::resource(name: '/divisions', controller: \App\Http\Controllers\DivisionController::class)->middleware('can:divisions');

Route::resource(name: '/usuarios', controller: \App\Http\Controllers\UserController::class)->middleware('can:usuarios');

Route::resource(name: '/asistencias', controller: \App\Http\Controllers\AsistenciaController::class)->middleware('can:asistencias');

Route::resource(name: '/asistenciasalidas', controller: \App\Http\Controllers\AsistenciasalidaController::class)->middleware('can:asistenciasalidas');


//Route::get('/miembros', function () { return view( view: 'miembros.index');})->middleware( middleware: 'auth');;

/*Route::get('/miembros/create', function () {
    return view(view: 'miembros.create');
})->middleware(middleware: 'auth');;*/
